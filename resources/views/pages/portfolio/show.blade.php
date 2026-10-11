@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-10">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-content-tertiary">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-content-primary">خانه</a>
        <span>/</span>
        <a href="{{ route('portfolio.index', ['locale' => $locale]) }}" class="hover:text-content-primary">نمونه‌کارها</a>
        <span>/</span>
        <span class="text-content-primary truncate">{{ $trans?->title ?? $project->slug }}</span>
    </nav>

    <!-- Header -->
    <div class="space-y-4">
        <div class="flex items-center gap-3">
            @if ($project->is_demo)
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-warning/10 text-warning border border-warning/20">
                    محتوای نمونه (Demo Showcase)
                </span>
            @endif
            <span class="text-xs font-mono text-content-tertiary">کیس‌استادی معماری</span>
        </div>

        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-primary tracking-tight">
            {{ $trans?->title ?? $project->slug }}
        </h1>

        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            {{ $trans?->summary ?? 'بررسی جامع اهداف، چالش‌های فنی و دستاوردهای پروژه.' }}
        </p>
    </div>

    <!-- Tech Stack Pill Group -->
    <div class="p-6 rounded-3xl bg-surface-card border border-border-subtle flex flex-wrap items-center gap-3">
        <span class="text-xs font-bold text-content-tertiary">تکنولوژی‌های کلیدی:</span>
        @foreach ($project->technologies as $tech)
            <span class="px-3 py-1 rounded-xl bg-surface-subtle border border-border-subtle/60 text-xs font-mono font-medium text-brand">
                {{ $tech->name }}
            </span>
        @endforeach
    </div>

    <!-- Case Study Body Content -->
    <div class="prose prose-invert max-w-none space-y-6 text-sm text-content-secondary leading-relaxed border-t border-border-subtle pt-8">
        @if ($trans?->body)
            {!! nl2br(e($trans->body)) !!}
        @else
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-content-primary">چالش‌های پروژه</h3>
                <p>طراحی ساختاری با توان پاسخگویی به درخواست‌های هم‌زمان بالا و تضمین تأخیر زیر ۵۰ میلی‌ثانیه در تمامی نقاط پایانی.</p>
                
                <h3 class="text-lg font-bold text-content-primary">راهکارهای مهندسی</h3>
                <p>پیاده‌سازی معماری تمیز و بهره‌گیری از صف‌های توزیع‌شده، کشینگ هوشمند Redis و بهینه‌سازی کوئری‌های دیتابیس به همراه تست‌های خودکار پیوسته.</p>
            </div>
        @endif
    </div>

    <!-- Actions / Links -->
    <div class="pt-8 border-t border-border-subtle flex items-center justify-between">
        <a href="{{ route('portfolio.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-content-secondary hover:text-content-primary">
            <x-ui.icon name="arrow-right" class="w-4 h-4 rtl:block ltr:hidden" />
            <x-ui.icon name="arrow-left" class="w-4 h-4 ltr:block rtl:hidden" />
            <span>بازگشت به همه پروژه‌ها</span>
        </a>

        <a href="{{ route('contact.index', ['locale' => $locale]) }}" class="px-5 py-2.5 rounded-xl bg-brand text-white font-medium text-xs shadow-glow hover:opacity-95 transition-all">
            سفارش پروژه مشابه
        </a>
    </div>
</div>
@endsection
