<?php
declare(strict_types=1);

/**
 * AMB host probe - diagnostics for cPanel hosting (no SSH required).
 *
 * Usage:
 *  1. Set PROBE_TOKEN below to a long random value.
 *  2. Upload this single file to a temporary directory on the target domain.
 *  3. Open  https://your-domain/probe.php?token=YOUR_TOKEN  (add &format=json for JSON).
 *  4. Copy the results into deployment.md section 1.
 *  5. DELETE this file (use the Delete button at the bottom, or File Manager).
 *
 * Notes:
 *  - Never prints environment variables, passwords or phpinfo().
 *  - Database credentials typed into the optional DB test are used once in memory only.
 *  - Outbound tests are limited to the fixed allowlist in OUTBOUND_HOSTS.
 *  - Verify the Melipayamak host against the provider documentation before relying on it.
 */

const PROBE_TOKEN = 'CHANGE_ME_TO_A_LONG_RANDOM_VALUE';
const MIN_PHP = '8.2.0';
const RECOMMENDED_PHP = '8.3.0';
const OUTBOUND_HOSTS = ['api.github.com' => 443, 'rest.payamak-panel.com' => 443];

header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

if (str_starts_with(PROBE_TOKEN, 'CHANGE_ME') || strlen(PROBE_TOKEN) < 16) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Set PROBE_TOKEN inside probe.php to a random value of at least 16 characters.');
}
if (!hash_equals(PROBE_TOKEN, (string) ($_GET['token'] ?? ''))) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Not found');
}

/** @var list<array{group:string,label:string,value:string,status:string,note:string}> $rows */
$rows = [];
function add(array &$rows, string $group, string $label, string $value, string $status = 'info', string $note = ''): void
{
    $rows[] = ['group' => $group, 'label' => $label, 'value' => $value, 'status' => $status, 'note' => $note];
}
function fn_enabled(string $name): bool
{
    $disabled = array_map('trim', explode(',', (string) ini_get('disable_functions')));
    return function_exists($name) && !in_array($name, $disabled, true);
}
function bytes(string $v): int
{
    $v = trim($v);
    if ($v === '' || $v === '-1') {
        return -1;
    }
    $n = (int) $v;
    return match (strtolower(substr($v, -1))) {
        'g' => $n * 1024 ** 3,
        'm' => $n * 1024 ** 2,
        'k' => $n * 1024,
        default => $n,
    };
}

// Self-delete action
$deleted = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $deleted = @unlink(__FILE__);
}

// ---- PHP ----
add($rows, 'PHP', 'PHP version', PHP_VERSION, version_compare(PHP_VERSION, MIN_PHP, '>=') ? (version_compare(PHP_VERSION, RECOMMENDED_PHP, '>=') ? 'ok' : 'warn') : 'fail', 'minimum ' . MIN_PHP . ', recommended ' . RECOMMENDED_PHP . ' (final minimum depends on the chosen Laravel version)');
add($rows, 'PHP', 'SAPI', PHP_SAPI, 'info');
add($rows, 'PHP', 'PHP_BINARY', (string) PHP_BINARY, 'info', 'Under FPM/LSAPI this is not the CLI binary. Copy the CLI path for cron from cPanel MultiPHP (for example /opt/cpanel/ea-phpXX/root/usr/bin/php).');
add($rows, 'PHP', 'Server software', (string) ($_SERVER['SERVER_SOFTWARE'] ?? 'unknown'), 'info');
add($rows, 'PHP', 'Document root', (string) ($_SERVER['DOCUMENT_ROOT'] ?? 'unknown'), 'info');
add($rows, 'PHP', 'Probe directory', __DIR__, 'info');
add($rows, 'PHP', 'HTTPS detected', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') ? 'yes' : 'no', 'info');
add($rows, 'PHP', 'Timezone (PHP)', date_default_timezone_get(), 'info', 'Laravel stores UTC; display timezone is set in app config.');

// ---- Extensions ----
$required = ['ctype', 'curl', 'dom', 'fileinfo', 'filter', 'hash', 'iconv', 'json', 'libxml', 'mbstring', 'openssl', 'pcre', 'pdo', 'pdo_mysql', 'session', 'tokenizer', 'xml', 'zip'];
foreach ($required as $ext) {
    add($rows, 'Extensions (required)', $ext, extension_loaded($ext) ? 'loaded' : 'missing', extension_loaded($ext) ? 'ok' : 'fail');
}
foreach (['intl' => 'Persian calendar via IntlDateFormatter (else a light Jalali library)', 'bcmath' => 'optional', 'opcache' => 'performance', 'exif' => 'optional', 'sodium' => 'optional'] as $ext => $why) {
    add($rows, 'Extensions (recommended)', $ext, extension_loaded($ext) ? 'loaded' : 'missing', extension_loaded($ext) ? 'ok' : 'warn', $why);
}

// ---- ini ----
$mem = bytes((string) ini_get('memory_limit'));
add($rows, 'PHP ini', 'memory_limit', (string) ini_get('memory_limit'), ($mem === -1 || $mem >= 256 * 1024 ** 2) ? 'ok' : 'warn', 'recommended at least 256M');
add($rows, 'PHP ini', 'max_execution_time', (string) ini_get('max_execution_time'), 'info', 'Cron CLI is usually unlimited; web requests are limited.');
add($rows, 'PHP ini', 'upload_max_filesize', (string) ini_get('upload_max_filesize'), bytes((string) ini_get('upload_max_filesize')) >= 8 * 1024 ** 2 ? 'ok' : 'warn', 'recommended at least 8M for images and release zip');
add($rows, 'PHP ini', 'post_max_size', (string) ini_get('post_max_size'), bytes((string) ini_get('post_max_size')) >= 8 * 1024 ** 2 ? 'ok' : 'warn');
add($rows, 'PHP ini', 'max_input_vars', (string) ini_get('max_input_vars'), 'info');
add($rows, 'PHP ini', 'allow_url_fopen', (string) ini_get('allow_url_fopen'), 'info');
add($rows, 'PHP ini', 'open_basedir', (string) (ini_get('open_basedir') ?: '(none)'), 'info', 'If set, the application must live inside the allowed paths.');
add($rows, 'PHP ini', 'disable_functions', (string) (ini_get('disable_functions') ?: '(none)'), 'info');
add($rows, 'PHP ini', 'opcache.enable', (string) (ini_get('opcache.enable') ?: '0'), 'info');

// ---- Functions / filesystem ----
foreach (['symlink' => 'storage link (else direct public disk or a serving route)', 'exec' => 'mysqldump / shell tasks (optional)', 'shell_exec' => 'optional', 'proc_open' => 'optional', 'mail' => 'optional (SMTP is preferred)'] as $fn => $why) {
    add($rows, 'Functions', $fn, fn_enabled($fn) ? 'enabled' : 'disabled', 'info', $why);
}
add($rows, 'Filesystem', 'Probe dir writable', is_writable(__DIR__) ? 'yes' : 'no', is_writable(__DIR__) ? 'ok' : 'warn');
add($rows, 'Filesystem', 'Temp dir writable', is_writable(sys_get_temp_dir()) ? 'yes' : 'no', is_writable(sys_get_temp_dir()) ? 'ok' : 'warn', sys_get_temp_dir());
add($rows, 'Filesystem', 'Session save path writable', is_writable((string) session_save_path() ?: sys_get_temp_dir()) ? 'yes' : 'no', 'info', (string) (session_save_path() ?: '(default)'));
$free = fn_enabled('disk_free_space') ? @disk_free_space(__DIR__) : false;
add($rows, 'Filesystem', 'Free disk space', $free === false ? 'unknown' : round($free / 1024 ** 3, 2) . ' GB', 'info');
if (fn_enabled('symlink') && is_writable(__DIR__)) {
    $target = __FILE__;
    $link = __DIR__ . '/.amb_probe_link_' . bin2hex(random_bytes(4));
    $ok = @symlink($target, $link) && is_link($link);
    @unlink($link);
    add($rows, 'Filesystem', 'Symlink creation works', $ok ? 'yes' : 'no', $ok ? 'ok' : 'warn');
}
if (is_writable(__DIR__)) {
    $tmp = __DIR__ . '/.amb_probe_' . bin2hex(random_bytes(4));
    $ok = @file_put_contents($tmp, 'x') === 1 && @file_get_contents($tmp) === 'x';
    @unlink($tmp);
    add($rows, 'Filesystem', 'Write/read/delete a file', $ok ? 'yes' : 'no', $ok ? 'ok' : 'fail');
}

// ---- Images ----
if (function_exists('gd_info')) {
    $gd = gd_info();
    add($rows, 'Images', 'GD', 'loaded (' . ($gd['GD Version'] ?? '?') . ')', 'ok');
    add($rows, 'Images', 'GD WebP', !empty($gd['WebP Support']) ? 'yes' : 'no', !empty($gd['WebP Support']) ? 'ok' : 'warn');
    add($rows, 'Images', 'GD AVIF', !empty($gd['AVIF Support']) ? 'yes' : 'no', 'info', 'AVIF is optional');
    add($rows, 'Images', 'GD JPEG/PNG', (!empty($gd['JPEG Support']) && !empty($gd['PNG Support'])) ? 'yes' : 'no', (!empty($gd['JPEG Support']) && !empty($gd['PNG Support'])) ? 'ok' : 'fail');
} else {
    add($rows, 'Images', 'GD', 'missing', class_exists('Imagick') ? 'info' : 'fail', 'GD or Imagick is required for media processing');
}
if (class_exists('Imagick')) {
    try {
        $fmts = (new Imagick())->queryFormats();
        add($rows, 'Images', 'Imagick', 'loaded', 'ok', 'WEBP: ' . (in_array('WEBP', $fmts, true) ? 'yes' : 'no') . ', AVIF: ' . (in_array('AVIF', $fmts, true) ? 'yes' : 'no'));
    } catch (Throwable $e) {
        add($rows, 'Images', 'Imagick', 'error', 'warn', $e->getMessage());
    }
}

// ---- Intl / Persian calendar ----
if (class_exists('IntlDateFormatter')) {
    try {
        $f = new IntlDateFormatter('fa_IR@calendar=persian', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Asia/Tehran', IntlDateFormatter::TRADITIONAL);
        $out = $f->format(new DateTimeImmutable('2026-10-11 12:00:00', new DateTimeZone('UTC')));
        add($rows, 'Intl', 'Persian calendar format', (string) $out, $out ? 'ok' : 'warn', 'Expected a Persian-calendar date for 2026-10-11 (19 Mehr 1405). Decides ADR 7 (Intl vs Jalali library).');
    } catch (Throwable $e) {
        add($rows, 'Intl', 'Persian calendar format', 'error', 'warn', $e->getMessage());
    }
}

// ---- Apache / LiteSpeed ----
if (function_exists('apache_get_modules')) {
    $mods = apache_get_modules();
    foreach (['mod_rewrite', 'mod_headers', 'mod_deflate', 'mod_expires'] as $m) {
        add($rows, 'Web server', $m, in_array($m, $mods, true) ? 'loaded' : 'not listed', $m === 'mod_rewrite' ? (in_array($m, $mods, true) ? 'ok' : 'warn') : 'info');
    }
} else {
    add($rows, 'Web server', 'Modules', 'cannot list in this SAPI', 'info', 'Test .htaccess rewrite and headers manually after upload.');
}

// ---- Outbound connectivity (fixed allowlist) ----
foreach (OUTBOUND_HOSTS as $host => $port) {
    if (!fn_enabled('fsockopen')) {
        add($rows, 'Outbound', "$host:$port", 'fsockopen disabled', 'warn');
        continue;
    }
    $start = microtime(true);
    $errno = 0;
    $errstr = '';
    $fp = @fsockopen('ssl://' . $host, $port, $errno, $errstr, 5);
    $ms = (int) round((microtime(true) - $start) * 1000);
    if ($fp) {
        fclose($fp);
        add($rows, 'Outbound', "$host:$port", "reachable ({$ms} ms)", 'ok');
    } else {
        add($rows, 'Outbound', "$host:$port", "blocked/unreachable ({$errno})", 'warn', $errstr . ' - use cached snapshots / disable the feature if this stays blocked');
    }
}

// ---- mysqldump availability (fixed command) ----
if (fn_enabled('shell_exec')) {
    $p = trim((string) @shell_exec('command -v mysqldump 2>/dev/null'));
    add($rows, 'Backup', 'mysqldump binary', $p !== '' ? $p : 'not found', $p !== '' ? 'ok' : 'warn', 'If missing: PHP dump or manual cPanel export before updates');
} else {
    add($rows, 'Backup', 'mysqldump binary', 'cannot check (shell_exec disabled)', 'info');
}

// ---- Optional DB test (POST; credentials are not stored) ----
$dbReport = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'db') {
    $host = (string) ($_POST['host'] ?? 'localhost');
    $port = (int) ($_POST['port'] ?? 3306);
    $name = (string) ($_POST['name'] ?? '');
    $user = (string) ($_POST['user'] ?? '');
    $pass = (string) ($_POST['pass'] ?? '');
    $dbReport = [];
    if (!preg_match('/^[A-Za-z0-9._-]{1,190}$/', $host) || $port < 1 || $port > 65535) {
        $dbReport[] = ['Input', 'invalid host or port', 'fail', ''];
    } else {
        try {
            $pdo = new PDO("mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
            ]);
            $ver = (string) $pdo->query('SELECT VERSION()')->fetchColumn();
            $dbReport[] = ['Connection', 'connected', 'ok', ''];
            $dbReport[] = ['Server version', $ver, 'info', stripos($ver, 'mariadb') !== false ? 'MariaDB' : 'MySQL'];
            $dbReport[] = ['Default collation', (string) $pdo->query('SELECT @@collation_database')->fetchColumn(), 'info', 'utf8mb4_unicode_ci is used by the project'];
            $dbReport[] = ['sql_mode', (string) $pdo->query('SELECT @@sql_mode')->fetchColumn(), 'info', ''];
            $dbReport[] = ['max_allowed_packet', (string) $pdo->query('SELECT @@max_allowed_packet')->fetchColumn(), 'info', ''];
            $persian = (string) $pdo->query("SELECT 'سلام دنیا'")->fetchColumn();
            $dbReport[] = ['Persian round trip (utf8mb4)', $persian, $persian === 'سلام دنیا' ? 'ok' : 'fail', ''];
            // Generated column + unique test on a TEMPORARY table (no permanent changes)
            try {
                $pdo->exec("CREATE TEMPORARY TABLE amb_probe_slots (id INT AUTO_INCREMENT PRIMARY KEY, starts_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, slot_lock DATETIME GENERATED ALWAYS AS (IF(status IN ('pending','confirmed'), starts_at, NULL)) STORED, UNIQUE KEY u_slot (slot_lock)) ENGINE=InnoDB");
                $pdo->exec("INSERT INTO amb_probe_slots (starts_at, status) VALUES ('2026-01-01 10:00:00','cancelled'),('2026-01-01 10:00:00','cancelled'),('2026-01-01 10:00:00','confirmed')");
                $dup = false;
                try {
                    $pdo->exec("INSERT INTO amb_probe_slots (starts_at, status) VALUES ('2026-01-01 10:00:00','pending')");
                } catch (PDOException $e) {
                    $dup = true;
                }
                $dbReport[] = ['Generated column slot_lock + UNIQUE', $dup ? 'works (duplicate active slot rejected)' : 'duplicate was NOT rejected', $dup ? 'ok' : 'fail', 'Decides the booking lock design (database.md section 12)'];
            } catch (Throwable $e) {
                $dbReport[] = ['Generated column slot_lock + UNIQUE', 'not supported', 'warn', 'Use the appointment_slots helper table instead'];
            }
        } catch (Throwable $e) {
            $dbReport[] = ['Connection', 'failed', 'fail', preg_replace('/(password|pass)=\S+/i', '$1=***', $e->getMessage()) ?? 'error'];
        }
    }
}

// ---- Cron hint ----
add($rows, 'Cron', 'Suggested command', '* * * * * /PATH/TO/PHP-CLI /home/USER/amb/artisan schedule:run >> /dev/null 2>&1', 'info', 'Replace PATH/TO/PHP-CLI with the CLI path shown in cPanel (Cron Jobs / MultiPHP). Confirm the minimum interval cPanel allows.');

// ---- JSON output ----
if (($_GET['format'] ?? '') === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['generated_at' => gmdate('c'), 'rows' => $rows, 'db' => $dbReport], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

header('Content-Type: text/html; charset=utf-8');
$counts = ['ok' => 0, 'warn' => 0, 'fail' => 0, 'info' => 0];
foreach ($rows as $r) {
    $counts[$r['status']]++;
}
$e = static fn (string $s): string => htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$tokenQ = '?token=' . rawurlencode((string) $_GET['token']);
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>AMB host probe</title>
<style>
body{font:15px/1.6 system-ui,sans-serif;margin:24px;background:#F4F7F6;color:#1F1F1F}
h1{color:#18424E}h2{margin-top:28px;color:#18424E}
table{border-collapse:collapse;width:100%;background:#fff}
td,th{border:1px solid #d5dedc;padding:6px 10px;text-align:start;vertical-align:top}
.ok{color:#1B7A47;font-weight:600}.warn{color:#8F5F00;font-weight:600}.fail{color:#C2362B;font-weight:600}.info{color:#4B5B5F}
code{word-break:break-all}
.box{background:#fff;border:1px solid #d5dedc;padding:12px;margin-top:16px}
input{padding:6px;margin:4px 0;width:260px}button{padding:8px 14px}
</style>
</head>
<body>
<h1>AMB host probe</h1>
<p>OK: <span class="ok"><?= $counts['ok'] ?></span> | WARN: <span class="warn"><?= $counts['warn'] ?></span> | FAIL: <span class="fail"><?= $counts['fail'] ?></span> | INFO: <?= $counts['info'] ?>
 | <a href="<?= $e($tokenQ . '&format=json') ?>">JSON</a></p>
<?php if ($deleted !== null): ?>
<p class="<?= $deleted ? 'ok' : 'fail' ?>"><?= $deleted ? 'probe.php was deleted.' : 'Could not delete probe.php. Delete it manually with File Manager.' ?></p>
<?php endif; ?>
<?php
$group = '';
foreach ($rows as $r):
    if ($r['group'] !== $group):
        if ($group !== '') { echo '</table>'; }
        $group = $r['group'];
        echo '<h2>' . $e($group) . '</h2><table><tr><th>Check</th><th>Value</th><th>Status</th><th>Note</th></tr>';
    endif;
    echo '<tr><td>' . $e($r['label']) . '</td><td><code>' . $e($r['value']) . '</code></td><td class="' . $e($r['status']) . '">' . strtoupper($e($r['status'])) . '</td><td>' . $e($r['note']) . '</td></tr>';
endforeach;
if ($group !== '') { echo '</table>'; }
?>
<h2>Database test (optional)</h2>
<div class="box">
<form method="post" action="<?= $e($tokenQ) ?>" autocomplete="off">
<input type="hidden" name="action" value="db">
<label>Host <input name="host" value="localhost"></label><br>
<label>Port <input name="port" value="3306"></label><br>
<label>Database <input name="name"></label><br>
<label>User <input name="user"></label><br>
<label>Password <input name="pass" type="password"></label><br>
<button type="submit">Run DB test</button>
<p class="info">Credentials are used once in memory and are not stored or logged. The generated-column test uses a TEMPORARY table only.</p>
</form>
<?php if ($dbReport !== null): ?>
<table><tr><th>Check</th><th>Value</th><th>Status</th><th>Note</th></tr>
<?php foreach ($dbReport as [$l, $v, $s, $n]): ?>
<tr><td><?= $e($l) ?></td><td><code><?= $e($v) ?></code></td><td class="<?= $e($s) ?>"><?= strtoupper($e($s)) ?></td><td><?= $e($n) ?></td></tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</div>
<h2>Cleanup</h2>
<div class="box">
<form method="post" action="<?= $e($tokenQ) ?>" onsubmit="return confirm('Delete probe.php now?');">
<input type="hidden" name="action" value="delete">
<button type="submit">Delete probe.php</button>
</form>
</div>
</body>
</html>
