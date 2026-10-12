@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-10">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-content-secondary" data-motion="scrollReveal">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-brand transition-colors">خانه</a>
        <span>/</span>
        <a href="{{ route('portfolio.index', ['locale' => $locale]) }}" class="hover:text-brand transition-colors">نمونه‌کارها</a>
        <span>/</span>
        <span class="text-content-heading font-medium truncate">{{ $trans?->title ?? $project->slug }}</span>
    </nav>

    <!-- Header -->
    <div class="space-y-4" data-motion="scrollReveal">
        <div class="flex items-center gap-3">
            @if ($project->is_demo)
                <x-ui.badge tone="warning" size="sm">محتوای نمونه (Demo Showcase)</x-ui.badge>
            @else
                <x-ui.badge tone="accent" size="sm">کیس‌استادی زنده</x-ui.badge>
            @endif
            <span class="text-xs font-mono text-content-secondary uppercase tracking-wider">Architecture Case Study</span>
        </div>

        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-heading tracking-tight">
            {{ $trans?->title ?? $project->slug }}
        </h1>

        <p class="text-sm sm:text-base text-content-secondary leading-relaxed border-s-2 border-brand ps-4">
            {{ $trans?->summary ?? 'بررسی جامع اهداف، چالش‌های فنی و دستاوردهای پروژه.' }}
        </p>
    </div>

    <!-- Tech Stack Pill Group -->
    <x-ui.card class="p-6 flex flex-wrap items-center gap-3" data-motion="scrollReveal">
        <span class="text-xs font-bold text-content-heading">تکنولوژی‌های کلیدی:</span>
        @foreach ($project->technologies as $tech)
            <x-ui.badge tone="brand" size="md">
                {{ $tech->name }}
            </x-ui.badge>
        @endforeach
    </x-ui.card>

    <!-- Case Study Body Content -->
    <div class="space-y-6 text-sm text-content-secondary leading-relaxed border-t border-edge pt-8" data-motion="scrollReveal">
        @if ($trans?->body)
            <div class="prose max-w-none text-content-secondary">
                {!! nl2br(e($trans->body)) !!}
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-ui.card class="p-6 space-y-3">
                    <h3 class="text-base font-bold text-content-heading flex items-center gap-2">
                        <x-ui.icon name="shield" size="sm" class="text-brand-accent" />
                        <span>چالش‌های پروژه</span>
                    </h3>
                    <p class="text-xs text-content-secondary leading-relaxed">
                        طراحی ساختاری با توان پاسخگویی به درخواست‌های هم‌زمان بالا و تضمین تأخیر زیر ۵۰ میلی‌ثانیه در تمامی نقاط پایانی سیستم.
                    </p>
                </x-ui.card>

                <x-ui.card class="p-6 space-y-3">
                    <h3 class="text-base font-bold text-content-heading flex items-center gap-2">
                        <x-ui.icon name="zap" size="sm" class="text-brand" />
                        <span>راهکارهای مهندسی</span>
                    </h3>
                    <p class="text-xs text-content-secondary leading-relaxed">
                        پیاده‌سازی معماری تمیز و بهره‌گیری از صف‌های توزیع‌شده، کشینگ هوشمند Redis و بهینه‌سازی کوئری‌های دیتابیس به همراه تست‌های خودکار پیوسته.
                    </p>
                </x-ui.card>
            </div>
        @endif
    </div>

    <!-- Actions / Links -->
    <div class="pt-8 border-t border-edge flex items-center justify-between">
        <a href="{{ route('portfolio.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-content-secondary hover:text-brand transition-colors">
            <x-ui.icon name="arrow-right" size="sm" class="rtl:block ltr:hidden" />
            <x-ui.icon name="arrow-left" size="sm" class="ltr:block rtl:hidden" />
            <span>بازگشت به همه پروژه‌ها</span>
        </a>

        <x-ui.button as="a" href="{{ route('contact.index', ['locale' => $locale]) }}" variant="accent" size="md" iconTrailing="arrow-left">
            سفارش پروژه مشابه
        </x-ui.button>
    </div>
</div>
@endsection
