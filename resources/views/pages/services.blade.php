@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    <!-- Header -->
    <div class="max-w-3xl space-y-3" data-motion="scrollReveal">
        <x-ui.badge tone="brand" size="sm">خدمات تخصصی مهندسی</x-ui.badge>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-heading tracking-tight">
            راهکارهای فنی و مهندسی نرم‌افزار
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            ارائه خدمات جامع مهندسی نرم‌افزار از فاز مشاوره و معماری تا توسعه فول‌استک، رابط‌های سه‌بعدی و مقیاس‌پذیری زیرساخت.
        </p>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-motion="scrollReveal">
        <!-- Service 1 -->
        <x-ui.card interactive="true" class="p-8 flex flex-col justify-between space-y-6" data-motion="cardHover">
            <div class="space-y-4">
                <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center">
                    <x-ui.icon name="cpu" size="lg" />
                </div>
                <h3 class="text-lg font-bold text-content-heading">معماری و توسعه بک‌اند (Backend)</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    طراحی API‌های پایدار بر بستر Laravel و PHP مدرن، معماری مایکروسرویس، بهینه‌سازی دیتابیس MySQL و کشینگ هوشمند Redis.
                </p>
            </div>
            <div class="pt-4 border-t border-edge flex items-center justify-between">
                <x-ui.badge tone="neutral" size="sm">Laravel 11 & MySQL</x-ui.badge>
                <a href="{{ route('contact.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                    <span>مشاوره فنی</span>
                    <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                    <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                </a>
            </div>
        </x-ui.card>

        <!-- Service 2 -->
        <x-ui.card interactive="true" class="p-8 flex flex-col justify-between space-y-6" data-motion="cardHover">
            <div class="space-y-4">
                <div class="w-12 h-12 rounded-xl bg-brand-secondary/15 text-brand-secondary flex items-center justify-center">
                    <x-ui.icon name="layout-dashboard" size="lg" />
                </div>
                <h3 class="text-lg font-bold text-content-heading">فرانت‌اند تعاملی و SPA</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    پیاده‌سازی رابط‌های کاربری مدرن با Tailwind CSS، Alpine.js، React و Vue با پشتیبانی بدون نقص از زبان‌های دوطرفه (RTL/LTR) و دارک‌مود.
                </p>
            </div>
            <div class="pt-4 border-t border-edge flex items-center justify-between">
                <x-ui.badge tone="neutral" size="sm">Tailwind & Alpine</x-ui.badge>
                <a href="{{ route('contact.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                    <span>مشاوره فنی</span>
                    <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                    <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                </a>
            </div>
        </x-ui.card>

        <!-- Service 3 -->
        <x-ui.card interactive="true" class="p-8 flex flex-col justify-between space-y-6" data-motion="cardHover">
            <div class="space-y-4">
                <div class="w-12 h-12 rounded-xl bg-brand-accent/15 text-brand-accent flex items-center justify-center">
                    <x-ui.icon name="sparkles" size="lg" />
                </div>
                <h3 class="text-lg font-bold text-content-heading">گرافیک وب سه‌بعدی (Three.js & WebGL)</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    خلق صحنه‌های تعاملی سه‌بعدی شتاب‌یافته روی مرورگر با Three.js و انیمیشن‌های دقیق GSAP هماهنگ با استانداردهای کارایی سخت‌افزار موبایل.
                </p>
            </div>
            <div class="pt-4 border-t border-edge flex items-center justify-between">
                <x-ui.badge tone="accent" size="sm">Three.js & GSAP</x-ui.badge>
                <a href="{{ route('contact.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                    <span>مشاوره فنی</span>
                    <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                    <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                </a>
            </div>
        </x-ui.card>

        <!-- Service 4 -->
        <x-ui.card interactive="true" class="p-8 flex flex-col justify-between space-y-6" data-motion="cardHover">
            <div class="space-y-4">
                <div class="w-12 h-12 rounded-xl bg-status-warning/15 text-status-warning flex items-center justify-center">
                    <x-ui.icon name="zap" size="lg" />
                </div>
                <h3 class="text-lg font-bold text-content-heading">بهینه‌سازی کارایی و سرعت (Performance)</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    تحلیل گلوگاه‌ها، پروفایلینگ کوئری‌ها، بهینه‌سازی Core Web Vitals و افزایش راندمان مصرف منابع سرور تا چند برابر.
                </p>
            </div>
            <div class="pt-4 border-t border-edge flex items-center justify-between">
                <x-ui.badge tone="warning" size="sm">Web Vitals & Cache</x-ui.badge>
                <a href="{{ route('contact.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                    <span>مشاوره فنی</span>
                    <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                    <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                </a>
            </div>
        </x-ui.card>

        <!-- Service 5 -->
        <x-ui.card interactive="true" class="p-8 flex flex-col justify-between space-y-6" data-motion="cardHover">
            <div class="space-y-4">
                <div class="w-12 h-12 rounded-xl bg-status-success/15 text-status-success flex items-center justify-center">
                    <x-ui.icon name="shield" size="lg" />
                </div>
                <h3 class="text-lg font-bold text-content-heading">امنیت و ممیزی کد (Code Audit)</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    بررسی آسیب‌پذیری‌های امنیتی، پیاده‌سازی متدهای احراز هویت دوعاملی، کنترل سطح دسترسی RBAC و هدرهای امنیتی سخت‌گیرانه.
                </p>
            </div>
            <div class="pt-4 border-t border-edge flex items-center justify-between">
                <x-ui.badge tone="success" size="sm">OWASP & Guardrails</x-ui.badge>
                <a href="{{ route('contact.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                    <span>مشاوره فنی</span>
                    <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                    <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                </a>
            </div>
        </x-ui.card>

        <!-- Service 6 -->
        <x-ui.card interactive="true" class="p-8 flex flex-col justify-between space-y-6" data-motion="cardHover">
            <div class="space-y-4">
                <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center">
                    <x-ui.icon name="server" size="lg" />
                </div>
                <h3 class="text-lg font-bold text-content-heading">استقرار و DevOps برای هاست و سرور ابری</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    راه‌اندازی خطوط استقرار خودکار، پکیج‌های بیلد بدون وابستگی به نود روی سرور تولیدی، مانیتورینگ خطا و بکاپ‌های زمان‌بندی‌شده.
                </p>
            </div>
            <div class="pt-4 border-t border-edge flex items-center justify-between">
                <x-ui.badge tone="brand" size="sm">cPanel & Cloud CI/CD</x-ui.badge>
                <a href="{{ route('contact.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                    <span>مشاوره فنی</span>
                    <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                    <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                </a>
            </div>
        </x-ui.card>
    </div>

    <!-- CTA Section -->
    <x-ui.card class="p-8 sm:p-12 text-center space-y-6 bg-gradient-to-r from-brand/10 via-surface to-brand-secondary/10">
        <div class="space-y-2 max-w-xl mx-auto">
            <h2 class="text-2xl font-bold text-content-heading">نیاز به راهکاری سفارشی برای کسب‌وکار خود دارید؟</h2>
            <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
                می‌توانید همین حالا مشخصات پروژه را برآورد کنید یا یک جلسه مشاوره رایگان با امیرمحمد بحرلو رزرو نمایید.
            </p>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <x-ui.button as="a" href="{{ route('estimator.index', ['locale' => $locale]) }}" variant="accent" size="md" iconTrailing="arrow-left">
                محاسبه آنلاین هزینه پروژه
            </x-ui.button>
            <x-ui.button as="a" href="{{ route('booking.index', ['locale' => $locale]) }}" variant="outline" size="md">
                رزرو وقت مشاوره آنلاین
            </x-ui.button>
        </div>
    </x-ui.card>
</div>
@endsection
