@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    <!-- Header -->
    <div class="space-y-4" data-motion="scrollReveal">
        <x-ui.badge tone="brand" size="sm">سوابق حرفه‌ای و تخصص</x-ui.badge>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-heading tracking-tight">
            رزومه و مشخصات فنی
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            امیرمحمد بحرلو؛ توسعه‌دهنده ارشد و معمار نرم‌افزار با سابقه طراحی و هدایت پلتفرم‌های مقیاس‌پذیر و رابط‌های وب پیشرفته.
        </p>
    </div>

    <!-- Skills Categories -->
    <div class="space-y-6" data-motion="scrollReveal">
        <div class="flex items-center gap-2 border-b border-edge pb-3">
            <x-ui.icon name="cpu" size="md" class="text-brand" />
            <h2 class="text-xl font-bold text-content-heading">مهارت‌های کلیدی و تخصص‌ها</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-ui.card interactive="true" class="p-6 space-y-3" data-motion="cardHover">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-brand">توسعه بک‌اند و معماری داده</h3>
                    <x-ui.badge tone="brand" size="sm">Core</x-ui.badge>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    PHP 8.x, Laravel Framework, MySQL, MariaDB, SQLite, Redis, RESTful APIs, Clean Architecture, CQRS, SOLID Principles.
                </p>
            </x-ui.card>

            <x-ui.card interactive="true" class="p-6 space-y-3" data-motion="cardHover">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-brand-secondary">توسعه فرانت‌اند و گرافیک وب</h3>
                    <x-ui.badge tone="accent" size="sm">Creative</x-ui.badge>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    JavaScript ESNext, TypeScript, Three.js, GSAP, Tailwind CSS, Alpine.js, Blade Components, Responsive & Mobile First.
                </p>
            </x-ui.card>

            <x-ui.card interactive="true" class="p-6 space-y-3" data-motion="cardHover">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-brand-accent">ابزارها و مهندسی نرم‌افزار</h3>
                    <x-ui.badge tone="warning" size="sm">DevOps</x-ui.badge>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    Git, GitHub Actions, Docker, PHPUnit, Automated Testing, Vite, Webpack, Postman, Linux CLI.
                </p>
            </x-ui.card>

            <x-ui.card interactive="true" class="p-6 space-y-3" data-motion="cardHover">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-status-success">طراحی سیستم و امنیت</h3>
                    <x-ui.badge tone="success" size="sm">Security</x-ui.badge>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    High-Concurrency Scaling, Queue Workers, Rate Limiting, OWASP Top 10 Mitigation, RBAC & Permissions.
                </p>
            </x-ui.card>
        </div>
    </div>

    <!-- Timeline Experience -->
    <div class="space-y-6" data-motion="scrollReveal">
        <div class="flex items-center gap-2 border-b border-edge pb-3">
            <x-ui.icon name="calendar" size="md" class="text-brand" />
            <h2 class="text-xl font-bold text-content-heading">سوابق کاری و فعالیت‌های شاخص</h2>
        </div>

        <div class="space-y-6 border-s-2 border-edge ps-6 relative">
            <x-ui.card class="p-6 relative space-y-3">
                <span class="absolute -start-[31px] top-6 w-3 h-3 rounded-full bg-brand-accent ring-4 ring-primary"></span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-xs text-content-secondary">
                    <span class="font-bold text-content-heading text-sm">توسعه‌دهنده ارشد و معمار نرم‌افزار (فریلنس و قراردادی)</span>
                    <x-ui.badge tone="accent" size="sm">۱۴۰۰ - اکنون</x-ui.badge>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    طراحی و پیاده‌سازی سیستم‌های اتوماسیون سازمانی، پلتفرم‌های تعاملی با Three.js، درگاه‌های پرداخت و داشبوردهای تحلیلی با بار ترافیکی بالا.
                </p>
            </x-ui.card>

            <x-ui.card class="p-6 relative space-y-3">
                <span class="absolute -start-[31px] top-6 w-3 h-3 rounded-full bg-brand ring-4 ring-primary"></span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-xs text-content-secondary">
                    <span class="font-bold text-content-heading text-sm">توسعه‌دهنده فول‌استک وب</span>
                    <x-ui.badge tone="neutral" size="sm">۱۳۹۸ - ۱۴۰۰</x-ui.badge>
                </div>
                <p class="text-xs text-content-secondary leading-relaxed">
                    توسعه فروشگاه‌های اینترنتی و پرتال‌های خدماتی بر بستر لاراول و فرانت‌اند مدرن، بهینه‌سازی دیتابیس و کاهش زمان لود صفحات.
                </p>
            </x-ui.card>
        </div>
    </div>
</div>
@endsection
