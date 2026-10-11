@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    <!-- Header -->
    <div class="space-y-4">
        <span class="text-xs font-bold text-brand uppercase tracking-wider">سوابق حرفه‌ای</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-primary tracking-tight">
            رزومه و مشخصات فنی
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            امیرمحمد بحرلو؛ توسعه‌دهنده ارشد و معمار نرم‌افزار با سابقه رهبری فنی تیم‌ها و تحویل محصولات پرمخاطب.
        </p>
    </div>

    <!-- Skills Categories -->
    <div class="space-y-6" data-motion="scrollReveal">
        <h2 class="text-xl font-bold text-content-primary flex items-center gap-2">
            <x-ui.icon name="cpu" class="w-5 h-5 text-brand" />
            <span>مهارت‌های کلیدی و تخصص‌ها</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-5 rounded-2xl bg-surface-card border border-border-subtle space-y-2 transition-all hover:border-brand/40 hover:shadow-card-hover" data-motion="cardHover">
                <h3 class="text-sm font-bold text-brand">توسعه بک‌اند و معماری داده</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    PHP 8.x, Laravel Framework, MySQL, MariaDB, SQLite, Redis, RESTful APIs, Clean Architecture, CQRS, SOLID Principles.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-card border border-border-subtle space-y-2 transition-all hover:border-accent/40 hover:shadow-card-hover" data-motion="cardHover">
                <h3 class="text-sm font-bold text-accent">توسعه فرانت‌اند و گرافیک وب</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    JavaScript ESNext, TypeScript, Three.js, GSAP, Tailwind CSS, Alpine.js, Blade Components, Responsive & Mobile First.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-card border border-border-subtle space-y-2 transition-all hover:border-brand-glow/40 hover:shadow-card-hover" data-motion="cardHover">
                <h3 class="text-sm font-bold text-brand-glow">ابزارها و مهندسی نرم‌افزار</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    Git, GitHub Actions, Docker, PHPUnit, Automated Testing, Vite, Webpack, Postman, Linux CLI.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-card border border-border-subtle space-y-2 transition-all hover:border-success/40 hover:shadow-card-hover" data-motion="cardHover">
                <h3 class="text-sm font-bold text-success">طراحی سیستم و امنیت</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    High-Concurrency Scaling, Queue Workers, Rate Limiting, OWASP Top 10 Mitigation, RBAC & Permissions.
                </p>
            </div>
        </div>
    </div>

    <!-- Timeline Experience -->
    <div class="space-y-6" data-motion="scrollReveal">
        <h2 class="text-xl font-bold text-content-primary flex items-center gap-2">
            <x-ui.icon name="calendar" class="w-5 h-5 text-brand" />
            <span>سوابق کاری و فعالیت‌های شاخص</span>
        </h2>

        <div class="space-y-6 border-s-2 border-border-subtle ps-6 relative">
            <div class="relative space-y-2 group">
                <span class="absolute -start-[31px] top-1.5 w-3 h-3 rounded-full bg-brand border-2 border-surface-base group-hover:scale-125 transition-transform"></span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs text-content-tertiary">
                    <span class="font-bold text-content-primary text-sm group-hover:text-brand transition-colors">توسعه‌دهنده ارشد و معمار نرم‌افزار (فریلنس و قراردادی)</span>
                    <span>۱۴۰۰ - اکنون</span>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    طراحی و پیاده‌سازی سیستم‌های اتوماسیون سازمانی، پلتفرم‌های تعاملی با Three.js، درگاه‌های پرداخت و داشبوردهای تحلیلی با بار ترافیکی بالا.
                </p>
            </div>

            <div class="relative space-y-2 group">
                <span class="absolute -start-[31px] top-1.5 w-3 h-3 rounded-full bg-border-subtle border-2 border-surface-base group-hover:scale-125 transition-transform"></span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs text-content-tertiary">
                    <span class="font-bold text-content-primary text-sm group-hover:text-brand transition-colors">توسعه‌دهنده فول‌استک وب</span>
                    <span>۱۳۹۸ - ۱۴۰۰</span>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    توسعه فروشگاه‌های اینترنتی و پرتال‌های خدماتی بر بستر لاراول و فرانت‌اند مدرن، بهینه‌سازی دیتابیس و کاهش زمان لود صفحات.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
