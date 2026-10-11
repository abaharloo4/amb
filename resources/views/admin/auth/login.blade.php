<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ورود به پنل مدیریت | {{ config('app.name', 'AMB') }}</title>

    <!-- Theme & Locale Preload -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('amb_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-canvas text-content-primary antialiased min-h-screen flex items-center justify-center p-4 selection:bg-brand selection:text-white">
    <x-ui.sprite />

    <div class="w-full max-w-md">
        <!-- Logo / Brand Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand to-brand-glow p-[1px] shadow-glow">
                    <div class="w-full h-full bg-surface-base rounded-2xl flex items-center justify-center transition-transform group-hover:scale-105">
                        <x-ui.icon name="shield" class="w-6 h-6 text-brand" />
                    </div>
                </div>
            </a>
            <h1 class="mt-4 text-2xl font-bold tracking-tight text-content-primary">
                ورود به سامانه مدیریت
            </h1>
            <p class="mt-1 text-sm text-content-secondary">
                امیرمحمد بحرلو | پنل اختصاصی مدیریت پرتال
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-surface-card border border-border-subtle/60 rounded-3xl p-7 shadow-2xl backdrop-blur-xl relative overflow-hidden">
            <!-- Ambient Card Glow -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>

            @if (session('status'))
                <div class="mb-5 p-3.5 rounded-xl bg-success/10 border border-success/20 text-success text-sm flex items-center gap-2">
                    <x-ui.icon name="check-circle" class="w-5 h-5 flex-shrink-0" />
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 p-3.5 rounded-xl bg-danger/10 border border-danger/20 text-danger text-sm flex items-center gap-2">
                    <x-ui.icon name="alert-triangle" class="w-5 h-5 flex-shrink-0" />
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-danger/10 border border-danger/20 text-danger text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-content-secondary mb-1.5">
                        پست الکترونیکی
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-content-tertiary">
                            <x-ui.icon name="mail" class="w-4 h-4" />
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            dir="ltr"
                            placeholder="admin@abaharlou.ir"
                            class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-2 focus:ring-brand/20 text-content-primary placeholder-content-tertiary text-sm ps-10 pe-4 py-2.5 transition-all outline-none"
                        />
                    </div>
                </div>

                <!-- Password Field -->
                <div x-data="{ show: false }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-content-secondary">
                            کلمه عبور
                        </label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-content-tertiary">
                            <x-ui.icon name="lock" class="w-4 h-4" />
                        </span>
                        <input
                            id="password"
                            :type="show ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="current-password"
                            dir="ltr"
                            placeholder="••••••••••••"
                            class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-2 focus:ring-brand/20 text-content-primary placeholder-content-tertiary text-sm ps-10 pe-10 py-2.5 transition-all outline-none"
                        />
                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute inset-y-0 end-0 flex items-center pe-3 text-content-tertiary hover:text-content-primary transition-colors focus:outline-none"
                            aria-label="نمایش رمز"
                        >
                            <x-ui.icon :name="'eye'" class="w-4 h-4" x-show="!show" />
                            <x-ui.icon :name="'eye-off'" class="w-4 h-4" x-show="show" style="display: none;" />
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-border-subtle bg-surface-subtle text-brand focus:ring-brand/30 w-4 h-4"
                        >
                        <span class="text-content-secondary text-xs">مرا به خاطر بسپار</span>
                    </label>

                    <span class="text-xs text-content-tertiary">
                        ورود امن SSL 256-bit
                    </span>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-brand to-brand-glow text-white font-medium text-sm shadow-glow hover:opacity-95 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
                >
                    <x-ui.icon name="log-in" class="w-4 h-4" />
                    <span>ورود به حساب کاربری</span>
                </button>
            </form>
        </div>

        <!-- Back to site & Theme Switcher -->
        <div class="mt-6 flex items-center justify-between text-xs text-content-tertiary px-2">
            <a href="/" class="hover:text-content-primary transition-colors flex items-center gap-1.5">
                <x-ui.icon name="arrow-right" class="w-3.5 h-3.5 rtl:rotate-180" />
                <span>بازگشت به صفحه اصلی</span>
            </a>
            <div class="flex items-center gap-3">
                <x-ui.theme-toggle />
            </div>
        </div>
    </div>
</body>
</html>
