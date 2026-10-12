@extends('layouts.public')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-10">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-content-secondary" data-motion="scrollReveal">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-brand transition-colors">خانه</a>
        <span>/</span>
        <a href="{{ route('blog.index', ['locale' => $locale]) }}" class="hover:text-brand transition-colors">وبلاگ</a>
        <span>/</span>
        <span class="text-content-heading font-medium truncate">{{ $trans?->title ?? $post->slug }}</span>
    </nav>

    <!-- Post Header -->
    <header class="space-y-4" data-motion="scrollReveal">
        <div class="flex items-center gap-4 text-xs text-content-secondary">
            <span class="flex items-center gap-1">
                <x-ui.icon name="calendar" size="xs" />
                <span>{{ $post->published_at ? \App\Support\Jalali::fromDateTime($post->published_at) : 'به‌زودی' }}</span>
            </span>
            <span>•</span>
            <x-ui.badge tone="neutral" size="sm">
                {{ $post->reading_time_minutes ?? 5 }} دقیقه مطالعه
            </x-ui.badge>
            <span>•</span>
            <span class="flex items-center gap-1 font-mono">
                <x-ui.icon name="activity" size="xs" />
                <span>{{ $post->views_count }} بازدید</span>
            </span>
        </div>

        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-heading tracking-tight leading-tight">
            {{ $trans?->title ?? $post->slug }}
        </h1>

        <p class="text-sm sm:text-base text-content-secondary leading-relaxed border-s-2 border-brand ps-4">
            {{ $trans?->summary ?? '' }}
        </p>
    </header>

    <!-- Post Article Body -->
    <article class="prose max-w-none space-y-6 text-sm text-content-secondary leading-relaxed border-t border-edge pt-8" data-motion="scrollReveal">
        @if ($trans?->body)
            <div class="leading-loose">
                {!! nl2br(e($trans->body)) !!}
            </div>
        @else
            <x-ui.card class="p-8 text-center text-content-secondary text-sm">
                متن کامل این مقاله به زودی بارگذاری خواهد شد.
            </x-ui.card>
        @endif
    </article>

    <!-- Author Box & Back -->
    <div class="pt-8 border-t border-edge flex items-center justify-between">
        <a href="{{ route('blog.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-content-secondary hover:text-brand transition-colors">
            <x-ui.icon name="arrow-right" size="sm" class="rtl:block ltr:hidden" />
            <x-ui.icon name="arrow-left" size="sm" class="ltr:block rtl:hidden" />
            <span>بازگشت به فهرست مقالات</span>
        </a>

        <div class="text-xs text-content-secondary flex items-center gap-1.5">
            <span>نویسنده:</span>
            <span class="font-bold text-content-heading">امیرمحمد بحرلو</span>
        </div>
    </div>
</div>
@endsection
