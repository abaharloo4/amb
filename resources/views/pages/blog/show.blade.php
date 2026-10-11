@extends('layouts.public')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-10">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-content-tertiary">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-content-primary">خانه</a>
        <span>/</span>
        <a href="{{ route('blog.index', ['locale' => $locale]) }}" class="hover:text-content-primary">وبلاگ</a>
        <span>/</span>
        <span class="text-content-primary truncate">{{ $trans?->title ?? $post->slug }}</span>
    </nav>

    <!-- Post Header -->
    <header class="space-y-4">
        <div class="flex items-center gap-4 text-xs text-content-tertiary">
            <span>{{ $post->published_at ? \App\Support\Jalali::fromDateTime($post->published_at) : 'به‌زودی' }}</span>
            <span>•</span>
            <span>{{ $post->reading_time_minutes ?? 5 }} دقیقه مطالعه</span>
            <span>•</span>
            <span>{{ $post->views_count }} بازدید</span>
        </div>

        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-primary tracking-tight leading-tight">
            {{ $trans?->title ?? $post->slug }}
        </h1>

        <p class="text-sm sm:text-base text-content-secondary leading-relaxed border-s-2 border-brand ps-4">
            {{ $trans?->summary ?? '' }}
        </p>
    </header>

    <!-- Post Article Body -->
    <article class="prose prose-invert max-w-none space-y-6 text-sm text-content-secondary leading-relaxed border-t border-border-subtle pt-8">
        @if ($trans?->body)
            {!! nl2br(e($trans->body)) !!}
        @else
            <p>متن کامل این مقاله به زودی بارگذاری خواهد شد.</p>
        @endif
    </article>

    <!-- Author Box & Back -->
    <div class="pt-8 border-t border-border-subtle flex items-center justify-between">
        <a href="{{ route('blog.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-content-secondary hover:text-content-primary">
            <x-ui.icon name="arrow-right" class="w-4 h-4 rtl:block ltr:hidden" />
            <x-ui.icon name="arrow-left" class="w-4 h-4 ltr:block rtl:hidden" />
            <span>بازگشت به فهرست مقالات</span>
        </a>

        <div class="text-xs text-content-tertiary">
            نویسنده: <span class="font-bold text-content-primary">امیرمحمد بحرلو</span>
        </div>
    </div>
</div>
@endsection
