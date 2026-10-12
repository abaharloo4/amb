@extends('layouts.public')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center space-y-8" data-motion="scrollReveal">
    <div class="relative inline-block">
        <div class="w-32 h-32 sm:w-40 sm:h-40 mx-auto rounded-xl bg-gradient-to-tr from-brand/20 via-brand-accent/20 to-brand-secondary/20 border border-edge flex items-center justify-center p-6 relative overflow-hidden shadow-md">
            <span class="text-6xl sm:text-7xl font-mono font-black text-brand tracking-tighter select-none">404</span>
            <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent pointer-events-none"></div>
        </div>
        <div class="absolute -inset-4 bg-brand-accent/10 rounded-full blur-2xl -z-10"></div>
    </div>

    <div class="space-y-3">
        <x-ui.badge tone="warning" size="md">
            {{ app()->getLocale() === 'fa' ? 'خطای دسترسی' : 'Error 404' }}
        </x-ui.badge>
        
        <h1 class="text-2xl sm:text-4xl font-extrabold text-content-heading tracking-tight">
            {{ app()->getLocale() === 'fa' ? 'صفحه مورد نظر یافت نشد' : 'Page Not Found' }}
        </h1>
        <p class="text-sm sm:text-base text-content-secondary max-w-md mx-auto leading-relaxed">
            {{ app()->getLocale() === 'fa' 
                ? 'آدرسی که به دنبال آن بودید تغییر کرده، حذف شده یا وجود خارجی ندارد.'
                : 'The link you followed may be broken, or the page may have been removed or relocated.' }}
        </p>
    </div>

    <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
        <x-ui.button 
            as="a" 
            href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
            variant="accent"
            size="lg"
            iconLeading="arrow-right"
        >
            {{ app()->getLocale() === 'fa' ? 'بازگشت به صفحه اصلی' : 'Back to Home' }}
        </x-ui.button>

        <x-ui.button 
            as="a" 
            href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" 
            variant="outline"
            size="lg"
            iconLeading="folder"
        >
            {{ app()->getLocale() === 'fa' ? 'مشاهده پروژه‌ها' : 'View Portfolio' }}
        </x-ui.button>
    </div>
</div>
@endsection
