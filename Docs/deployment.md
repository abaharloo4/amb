# Deployment — AMB Personal Portfolio

وضعیت: پیش‌نویس Phase 0 | نسخه: 0.1
هدف: استقرار روی هاست ابری پارس‌پک با cPanel، **بدون SSH و بدون Node.js**، با Cron.
اصل: هر قابلیتی که محدودیت هاست اجازه اجرایش را نمی‌دهد، مستند می‌شود و به‌عنوان «آماده تحویل» معرفی نمی‌شود.

## 1. واقعیت‌های هاست (باید با تشخیص محیط پر شوند)

| مورد | مقدار | منبع |
|---|---|---|
| نسخه PHP (و امکان انتخاب در MultiPHP) | | probe |
| مسیر باینری PHP برای Cron (مثلاً `/opt/cpanel/ea-phpXX/root/usr/bin/php`) | | cPanel / probe |
| Extensionها: `mbstring, intl, gd/imagick, pdo_mysql, fileinfo, zip, openssl, curl, xml, ctype, tokenizer, bcmath` | | probe |
| MySQL/MariaDB نسخه و موتور/Collation | | probe |
| `memory_limit`، `max_execution_time`، `upload_max_filesize`، `post_max_size` | | probe |
| توابع غیرفعال (`exec`, `proc_open`, `symlink`, ...) | | probe |
| امکان تغییر Document Root | | cPanel |
| امکان Symlink | | probe |
| دسترسی خروجی به سرویس‌ها (ملی‌پیامک، GitHub، SMTP) | | probe |
| Cron: حداقل فاصله و تعداد مجاز | | cPanel |
| Git Version Control / Terminal داخل cPanel | وجود ندارد/بررسی شود | cPanel |
| SSL (AutoSSL / Let's Encrypt) | | cPanel |
| سقف فضا، تعداد Inode، سقف پردازش هم‌زمان | | پشتیبانی هاست |

### اسکریپت تشخیص محیط
یک فایل واحد `probe.php` (خارج از Git، با توکن در Query، فقط خواندنی، بدون نمایش Secret) خروجی جدول بالا را نشان می‌دهد. پس از استفاده فوراً حذف می‌شود (چک‌لیست `security.md`). پیش از Phase 3 اجرا و نتیجه در همین فایل ثبت می‌شود؛ تصمیمات وابسته (Intl یا Jalali، روش Backup، ساختار Document Root) بر اساس آن بسته می‌شوند.

## 2. ساختار استقرار

### گزینه A (ترجیحی): Document Root روی `public`
- برای دامنه/ساب‌دامنه‌ای که cPanel اجازه تغییر Document Root می‌دهد.
- کل پروژه در `/home/USER/amb/` و Document Root دامنه `/home/USER/amb/public`.
- ساده‌ترین و امن‌ترین حالت.

### گزینه B: پروژه خارج از `public_html`
- اگر Document Root دامنه اصلی قابل تغییر نیست:
  - اپلیکیشن در `/home/USER/amb/` (خارج از وب).
  - محتوای `public/` در `/home/USER/public_html/`.
  - فایل `public_html/index.php` با مسیرهای تنظیم‌شده به `/home/USER/amb/` (`require __DIR__.'/../amb/vendor/autoload.php'` و غیره).
  - `storage` link: اگر Symlink مجاز نیست، فایل‌های عمومی آپلود در `public_html/storage` مستقیم نوشته می‌شوند (تنظیم Disk جداگانه) یا Route کنترل‌شده آن‌ها را سرو می‌کند.
- Installer مسیرها را از Config می‌خواند، نه hardcode.

### گزینه C (آخرین راه، با هشدار): همه چیز داخل `public_html`
- فقط اگر A و B ممکن نیستند. نیازمند `.htaccess` سخت‌گیرانه برای مسدودسازی `.env`, `vendor`, `storage`, `app`, `database`, `.git` و بازنویسی ریشه به `public/`.
- ریسک امنیتی بالاتر؛ در `debug_log.md` ثبت و بعد از استقرار با تست دسترسی هر مسیر حساس تأیید شود.

انتخاب نهایی در Phase 0 پس از تشخیص محیط ثبت می‌شود.

## 3. Build و بسته Release (روی سیستم توسعه)

پیش‌نیاز سیستم توسعه: PHP هم‌نسخه با هاست، Composer، Node.js.

ترتیب (اسکریپت `npm run release` همه را خودکار می‌کند؛ مستقل از سیستم‌عامل):

1. `composer install --no-dev --optimize-autoloader --classmap-authoritative`
2. `npm ci` سپس `npm run icons && npm run build`
3. اجرای Lint، تست‌ها و `composer audit` / `npm audit`؛ شکست = توقف Release
4. بسته zip شامل: `app, bootstrap, config, database, lang, public (با build), resources/views, routes, storage (ساختار خالی), vendor, artisan, composer.json/lock, .env.example, version.json`
5. استثنا: `.env`, `.git`, `node_modules`, `tests`, `docs` (مستندات اختیاری), `storage/logs/*`, فایل‌های `*.map` (اختیاری), `.github`
6. تولید `checksums.sha256` و `version.json` (نسخه، تاریخ، commit)

نکته: تغییر `APP_KEY` فقط یک بار (در نصب اولیه) و با دقت؛ تولید کلید روی سیستم توسعه: `php artisan key:generate --show` و قرار دادن در `.env` روی هاست.

## 4. نصب اولیه

1. ساخت دیتابیس و کاربر MySQL در cPanel (MySQL Databases) با رمز قوی.
2. انتخاب نسخه PHP مناسب در MultiPHP Manager و فعال‌سازی Extensionهای لازم.
3. آپلود بسته zip با File Manager/FTP و Extract در مسیر مقصد (ساختار A/B/C).
4. ساخت `.env` از `.env.example` (با File Manager): `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, `APP_KEY`، اطلاعات DB، `INSTALLER_TOKEN`، تنظیمات ایمیل و ملی‌پیامک (در صورت وجود).
5. تنظیم مجوزها (فایل 644، پوشه 755، `.env` محدود، `storage` و `bootstrap/cache` قابل نوشتن).
6. باز کردن `/_install?token=...`:
   - بررسی الزامات (PHP، Extensionها، مجوزها، اتصال DB).
   - اجرای migration و Seeder اولیه (نقش‌ها، مجوزها، تنظیمات پایه، داده Demo علامت‌گذاری‌شده).
   - ساخت حساب مدیر اولیه با رمز انتخابی.
   - ساخت لینک `storage` (یا جایگزین).
   - `config/route/view/event cache`.
   - ایجاد فایل قفل و غیرفعال‌شدن مسیر.
7. تنظیم Cron (بخش 6).
8. فعال‌سازی SSL (AutoSSL/Let's Encrypt) و ریدایرکت به HTTPS؛ سپس HSTS پس از تأیید.
9. بررسی `robots.txt`، `sitemap.xml`، صفحه 404، دسترسی مسیرهای حساس.
10. حذف `probe.php` و هر فایل موقت.

## 5. به‌روزرسانی (Updater)

جریان:
1. پیش از Release: Backup دیتابیس و `storage/app` (بخش 8) و ثبت نسخه فعلی.
2. فعال‌سازی حالت تعمیر (Maintenance) با فایل پرچم.
3. آپلود بسته جدید در پوشه موازی (مثلاً `amb_next/`) و Extract.
4. انتقال `.env` و `storage` (آپلودها) به نسخه جدید.
5. اجرای Updater (`/_update`، توکن‌دار، فقط Admin): بررسی الزامات، migration، پاک‌سازی/ساخت کش.
6. جابه‌جایی: تغییر نام پوشه‌ها (`amb` به `amb_prev`، `amb_next` به `amb`) یا تغییر Document Root/Symlink در صورت امکان.
7. تست دودی (بخش 10)، خروج از حالت تعمیر.
8. نگهداری نسخه قبلی حداقل تا تأیید پایداری.

قواعد migration برای Rollback‌پذیری:
- الگوی Expand/Contract: ابتدا افزودن ستون/جدول (سازگار با کد قدیم)، سپس مهاجرت داده، و حذف فقط در Release بعدی.
- هر migration متد `down()` معنادار دارد؛ migrationهای مخرب نیاز به Backup تأییدشده دارند.
- Updater بدون تأیید «Backup گرفته شد» اجرا نمی‌شود.

## 6. Cron و Queue

دستور (مسیر PHP از probe/cPanel):

```
* * * * * /opt/cpanel/ea-phpXX/root/usr/bin/php /home/USER/amb/artisan schedule:run >> /dev/null 2>&1
```

Scheduler شامل:
- `queue:work --stop-when-empty --max-time=50` (هر دقیقه).
- یادآوری جلسه‌ها، ارسال اعلان‌های در صف.
- کش GitHub (با Fallback آخرین Snapshot موفق).
- پاک‌سازی: نشست‌های قدیمی، لاگ‌ها، توکن‌های منقضی، رسانه‌های بی‌استفاده.
- تولید/به‌روزرسانی Sitemap در صورت نیاز.
- Backup خودکار سبک (در صورت امکان؛ بخش 8).

اگر Cron هر دقیقه ممکن نیست: فاصله به 5 دقیقه افزایش و ارسال اعلان فوری (مثل اعلان درخواست جدید) هم‌زمان با درخواست به‌صورت sync کوتاه با Timeout و ثبت وضعیت در `notification_deliveries` انجام می‌شود؛ این محدودیت در مستندات ثبت شود.

## 7. تنظیمات PHP و سرور

- `.user.ini` یا MultiPHP INI Editor: `memory_limit` (حداقل 256M در صورت امکان)، `upload_max_filesize`، `post_max_size`، `max_execution_time`.
- OPcache فعال (اگر هاست اجازه می‌دهد).
- `.htaccess` در `public`: Rewrite به `index.php`، فشرده‌سازی، کش مرورگر برای Assetهای Build (Hash در نام)، رد دسترسی به فایل‌های مخفی، هدرهای امنیتی (در صورت عدم تنظیم از Laravel Middleware).
- ایمیل: ساخت صندوق ایمیل در cPanel برای SMTP؛ تنظیم SPF، DKIM، DMARC در DNS.
- تنظیمات ایمیل و ملی‌پیامک فقط از `.env`.

## 8. Backup و بازیابی

| مورد | روش | تناوب | نگهداری |
|---|---|---|---|
| دیتابیس | cPanel Backup/phpMyAdmin Export یا Dump PHP (در صورت نبود `mysqldump`) | روزانه (Cron) + قبل از هر Update | 14 روزانه + 8 هفتگی (پیشنهاد) |
| فایل‌های آپلود (`storage/app/public`) | cPanel Backup / zip | هفتگی + قبل از Update | 4 هفته |
| `.env` | کپی امن خارج از سرور (مثلاً مدیر رمز) | پس از هر تغییر | |
| نسخه Release | بسته zip + `checksums` | هر Release | حداقل 3 نسخه |

- Backup باید خارج از وب و ترجیحاً خارج از همان حساب هاست ذخیره شود.
- بازیابی آزمایشی حداقل یک بار قبل از انتشار نهایی (چک‌لیست `security.md`).
- اگر `mysqldump`/`exec` در دسترس نیست، روش جایگزین (Export دستی cPanel قبل از Update و Dump PHP صفحه‌بندی‌شده برای جدول‌های کلیدی) در Phase 3 پیاده و مستند شود.

## 9. Rollback

1. فعال‌سازی حالت تعمیر.
2. بازگرداندن پوشه نسخه قبلی (تغییر نام پوشه‌ها یا بازگرداندن Document Root/Symlink).
3. اگر migration روی داده اثر مخرب داشته: بازیابی Backup دیتابیس قبل از Update؛ در غیر این صورت (الگوی Expand/Contract) نیازی به بازیابی نیست.
4. پاک‌سازی کش (از Updater یا حذف فایل‌های کش در `bootstrap/cache` و `storage/framework`).
5. تست دودی، خروج از حالت تعمیر.
6. ثبت رخداد در `debug_log.md` و اصلاح Release.

## 10. تست دودی پس از استقرار

| # | بررسی |
|---|---|
| 1 | `/fa` و `/en` بدون خطا؛ جهت RTL/LTR درست |
| 2 | تم روشن/تاریک و ذخیره ترجیح |
| 3 | Hero سه‌بعدی بارگذاری یا Fallback درست |
| 4 | ورود مدیر، ایجاد/ویرایش/انتشار یک محتوا |
| 5 | آپلود تصویر و نسخه‌های Responsive |
| 6 | ثبت یک درخواست همکاری آزمایشی، کد پیگیری، اعلان به مدیر |
| 7 | رزرو آزمایشی و جلوگیری از رزرو هم‌زمان |
| 8 | ایمیل و (در صورت فعال) پیامک آزمایشی |
| 9 | Cron اجرا شده (آخرین اجرا در پنل) |
| 10 | `sitemap.xml`, `robots.txt`, Canonical, Hreflang |
| 11 | صفحه 404 واقعی با Status 404 |
| 12 | دسترسی `.env`, `vendor`, `storage`, `.git` مسدود |
| 13 | Console بدون خطای جدی؛ بدون درخواست ناموفق |
| 14 | Lighthouse موبایل: LCP، CLS، INP در حد هدف |

## 11. محیط Staging

- ساب‌دامنه `staging.abaharlou.ir` با دیتابیس و `.env` جدا، Basic Auth و `noindex`.
- هر Release ابتدا روی Staging نصب/به‌روز و تست دودی می‌شود.
- داده Staging شامل PII واقعی نباشد.

## 12. جدول محدودیت هاست و قابلیت‌ها

| قابلیت | وابستگی هاست | اگر نبود |
|---|---|---|
| Queue | Cron | اعلان همگام کوتاه + وضعیت ارسال (بخش 6) |
| تاریخ شمسی | افزونه `intl` | کتابخانه سبک Jalali |
| پردازش تصویر | GD یا Imagick (WebP/AVIF) | فقط JPEG/PNG/WebP بر اساس پشتیبانی |
| Symlink `storage` | `symlink()` مجاز | Disk عمومی مستقیم در `public` یا Route سرو فایل |
| Backup DB خودکار | `mysqldump`/`exec` | Dump PHP یا Export دستی |
| GitHub Activity | دسترسی خروجی | Snapshot قبلی/بخش مخفی |
| ملی‌پیامک | دسترسی خروجی + حساب | Adapter غیرفعال و ثبت وضعیت |
| ایمیل | SMTP هاست | سرویس SMTP خارجی |
| 2FA مدیر | وابستگی TOTP | رمز قوی + محدودیت IP اختیاری |

## 13. چک‌لیست تحویل

- [ ] جدول بخش 1 با داده واقعی پر شده است.
- [ ] ساختار A/B/C انتخاب و تست امنیتی دسترسی مسیرها انجام شده است.
- [ ] بسته Release با `checksums` تولید و روی Staging نصب شده است.
- [ ] Installer/Updater تست و پس از نصب قفل می‌شود.
- [ ] Cron و Queue تأیید شده‌اند.
- [ ] SSL، HTTPS، SPF/DKIM/DMARC برقرار است.
- [ ] Backup و بازیابی آزمایشی انجام شده است.
- [ ] Rollback یک بار آزمایش شده است.
- [ ] چک‌لیست `security.md` کامل است.
- [ ] تست دودی بخش 10 سبز است.
