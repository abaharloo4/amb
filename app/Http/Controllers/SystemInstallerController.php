<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class SystemInstallerController extends Controller
{
    /**
     * Web Installer for shared hosting (ParsPack cPanel)
     */
    public function install(Request $request)
    {
        $lockFile = storage_path('installed.lock');

        if (File::exists($lockFile)) {
            return response()->json([
                'status' => 'already_installed',
                'message' => 'سیستم قبلاً نصب شده است. فایل storage/installed.lock وجود دارد.',
            ], 403);
        }

        // Verify security token using hash_equals and app key or explicit INSTALL_TOKEN
        $expectedToken = config('app.install_token', env('INSTALL_TOKEN', config('app.key')));
        $token = (string) $request->input('token');

        if (empty($token) || empty($expectedToken) || ! hash_equals((string) $expectedToken, $token)) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'توکن امنیتی نامعتبر است (?token=...).',
            ], 401);
        }

        try {
            // Run migrations and seeds
            Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = Artisan::output();

            Artisan::call('db:seed', ['--force' => true]);
            $seedOutput = Artisan::output();

            Artisan::call('storage:link');
            $linkOutput = Artisan::output();

            // Create lock file
            File::put($lockFile, 'Installed on ' . now()->toIso8601String());

            return response()->json([
                'status' => 'success',
                'message' => 'نصب و راه‌اندازی با موفقیت به اتمام رسید.',
                'log' => [
                    'migrate' => $migrateOutput,
                    'seed' => $seedOutput,
                    'storage_link' => $linkOutput,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Web Updater for shared hosting migrations and cache clearing
     */
    public function update(Request $request)
    {
        $expectedToken = config('app.install_token', env('INSTALL_TOKEN', config('app.key')));
        $token = (string) $request->input('token');

        if (empty($token) || empty($expectedToken) || ! hash_equals((string) $expectedToken, $token)) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'توکن امنیتی نامعتبر است (?token=...).',
            ], 401);
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = Artisan::output();

            Artisan::call('optimize:clear');
            $cacheOutput = Artisan::output();

            return response()->json([
                'status' => 'success',
                'message' => 'به‌روزرسانی با موفقیت انجام شد.',
                'log' => [
                    'migrate' => $migrateOutput,
                    'cache' => $cacheOutput,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
