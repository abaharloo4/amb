@extends('layouts.public')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center space-y-8">
    <div class="relative inline-block">
        <div class="w-32 h-32 sm:w-40 sm:h-40 mx-auto rounded-3xl bg-gradient-to-tr from-brand/20 via-accent/20 to-brand-glow/20 border border-border-subtle flex items-center justify-center p-6 shadow-glow relative overflow-hidden">
            <span class="text-6xl sm:text-7xl font-mono font-black text-brand tracking-tighter select-none">404</span>
            <div class="absolute inset-0 bg-gradient-to-t from-surface-canvas/40 to-transparent pointer-events-none"></div>
        </div>
        <div class="absolute -inset-4 bg-brand/10 rounded-full blur-2xl -z-10"></div>
    </div>

    <div class="space-y-3">
        <h1 class="text-2xl sm:text-4xl font-extrabold text-content-primary tracking-tight">
            {{ app()->getLocale() === 'fa' ? 'صفحه مورد نظر یافت نشد' : 'Page Not Found' }}
        </h1>
        <p class="text-sm sm:text-base text-content-secondary max-w-md mx-auto leading-relaxed">
            {{ app()->getLocale() === 'fa' 
                ? 'آدرسی که به دنبال آن بودید تغییر کرده، حذف شده یا وجود خارجی ندارد.'
                : 'The link you followed may be broken, or the page may have been removed or relocated.' }}
        </p>
    </div>

    <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
        <a 
            href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-brand to-brand-glow text-white text-sm font-semibold shadow-glow hover:opacity-95 active:scale-95 transition-all"
        >
            <x-ui.icon name="arrow-right" class="w-4 h-4 rtl:block ltr:hidden" />
            <x-ui.icon name="arrow-left" class="w-4 h-4 ltr:block rtl:hidden" />
            <span>{{ app()->getLocale() === 'fa' ? 'بازگشت به صفحه اصلی' : 'Back to Home' }}</span>
        </a>

        <a 
            href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" 
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-card border border-border-subtle text-content-secondary hover:text-content-primary hover:bg-surface-subtle text-sm font-semibold transition-all"
        >
            <x-ui.icon name="layout-grid" class="w-4 h-4 text-brand" />
            <span>{{ app()->getLocale() === 'fa' ? 'مشاهده پروژه‌ها' : 'View Portfolio' }}</span>
        </a>
    </div>
</div>
@endsection
