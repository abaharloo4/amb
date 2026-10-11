@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    <!-- Header -->
    <div class="max-w-3xl space-y-3">
        <span class="text-xs font-bold text-brand uppercase tracking-wider">خدمات تخصصی</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-primary tracking-tight">
            راهکارهای فنی و مهندسی نرم‌افزار
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            ارائه خدمات جامع مهندسی نرم‌افزار از فاز مشاوره و معماری تا توسعه فول‌استک و مقیاس‌پذیری زیرساخت.
        </p>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-all shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center">
                <x-ui.icon name="cpu" class="w-6 h-6" />
            </div>
            <h3 class="text-lg font-bold text-content-primary">معماری و توسعه بک‌اند (Backend)</h3>
            <p class="text-xs text-content-secondary leading-relaxed">
                طراحی API‌های پایدار بر بستر Laravel و PHP مدرن، معماری مایکروسرویس، بهینه‌سازی دیتابیس MySQL و کشینگ هوشمند Redis.
            </p>
        </div>

        <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-all shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-accent/10 text-accent flex items-center justify-center">
                <x-ui.icon name="layout-dashboard" class="w-6 h-6" />
            </div>
            <h3 class="text-lg font-bold text-content-primary">فرانت‌اند تعاملی و SPA</h3>
            <p class="text-xs text-content-secondary leading-relaxed">
                پیاده‌سازی رابط‌های کاربری مدرن با Tailwind CSS، Alpine.js، React و Vue با پشتیبانی بدون نقص از زبان‌های دوطرفه (RTL/LTR) و دارک‌مود.
            </p>
        </div>

        <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-all shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-brand-glow/10 text-brand-glow flex items-center justify-center">
                <x-ui.icon name="sparkles" class="w-6 h-6" />
            </div>
            <h3 class="text-lg font-bold text-content-primary">گرافیک وب سه‌بعدی (Three.js & WebGL)</h3>
            <p class="text-xs text-content-secondary leading-relaxed">
                خلق صحنه‌های تعاملی سه‌بعدی شتاب‌یافته روی مرورگر با Three.js و انیمیشن‌های دقیق GSAP هماهنگ با استانداردهای کارایی سخت‌افزار موبایل.
            </p>
        </div>

        <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-all shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-warning/10 text-warning flex items-center justify-center">
                <x-ui.icon name="zap" class="w-6 h-6" />
            </div>
            <h3 class="text-lg font-bold text-content-primary">بهینه‌سازی کارایی و سرعت (Performance)</h3>
            <p class="text-xs text-content-secondary leading-relaxed">
                تحلیل گلوگاه‌ها، پروفایلینگ کوئری‌ها، بهینه‌سازی Core Web Vitals و افزایش راندمان مصرف منابع سرور تا چند برابر.
            </p>
        </div>

        <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-all shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-success/10 text-success flex items-center justify-center">
                <x-ui.icon name="shield" class="w-6 h-6" />
            </div>
            <h3 class="text-lg font-bold text-content-primary">امنیت و ممیزی کد (Code Audit)</h3>
            <p class="text-xs text-content-secondary leading-relaxed">
                بررسی آسیب‌پذیری‌های امنیتی، پیاده‌سازی متدهای احراز هویت دوعاملی، کنترل سطح دسترسی RBAC و هدرهای امنیتی سخت‌گیرانه.
            </p>
        </div>

        <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-all shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center">
                <x-ui.icon name="server" class="w-6 h-6" />
            </div>
            <h3 class="text-lg font-bold text-content-primary">استقرار و DevOps برای هاست اشتراکی و ابری</h3>
            <p class="text-xs text-content-secondary leading-relaxed">
                راه‌اندازی خطوط استقرار خودکار، پکیج‌های بیلد بدون وابستگی به نود روی سرور تولیدی، مانیتورینگ خطا و بکاپ‌های زمان‌بندی‌شده.
            </p>
        </div>
    </div>
</div>
@endsection
