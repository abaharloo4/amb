@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Header -->
    <div class="max-w-2xl space-y-3" data-motion="scrollReveal">
        <x-ui.badge tone="brand" size="sm">نمونه‌کارها و پروژه‌ها</x-ui.badge>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-content-heading">
            پروژه‌ها و کیس‌استادی‌های تخصصی
        </h1>
        <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
            گزیده‌ای از معماری‌ها، راهکارهای نرم‌افزاری و محصولاتی که از ایده تا استقرار مقیاس‌پذیر مهندسی کرده‌ام.
        </p>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-motion="scrollReveal">
        @forelse ($projects as $project)
            @php $trans = $project->translation($locale); @endphp
            <x-ui.card interactive="true" class="overflow-hidden flex flex-col justify-between group" data-motion="cardHover">
                <!-- Card Header Visual Area -->
                <div class="h-44 bg-gradient-to-br from-surface to-brand/15 p-6 flex flex-col justify-between border-b border-edge relative">
                    <div class="flex items-center justify-between z-10">
                        @if ($project->is_demo)
                            <x-ui.badge tone="warning" size="sm">Demo</x-ui.badge>
                        @else
                            <x-ui.badge tone="accent" size="sm">Live</x-ui.badge>
                        @endif
                        <span class="text-[10px] font-mono text-content-secondary uppercase tracking-wider">{{ $project->slug }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-content-heading group-hover:text-brand transition-colors z-10">
                        {{ $trans?->title ?? $project->slug }}
                    </h3>
                </div>

                <!-- Card Body -->
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <p class="text-xs text-content-secondary leading-relaxed line-clamp-3">
                        {{ $trans?->summary ?? 'شرح کیس‌استادی و راهکارهای پیاده‌سازی شده در این پروژه.' }}
                    </p>

                    <div class="pt-4 border-t border-edge flex items-center justify-between">
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($project->technologies->take(2) as $tech)
                                <x-ui.badge tone="neutral" size="sm">{{ $tech->name }}</x-ui.badge>
                            @endforeach
                        </div>

                        <a href="{{ route('portfolio.show', ['locale' => $locale, 'slug' => $project->slug]) }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                            <span>کیس‌استادی</span>
                            <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                            <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                        </a>
                    </div>
                </div>
            </x-ui.card>
        @empty
            <div class="col-span-full py-16 text-center text-sm text-content-secondary">
                در حال حاضر پروژه‌ای برای نمایش وجود ندارد.
            </div>
        @endforelse
    </div>

    @if ($projects->hasPages())
        <div class="pt-8">
            {{ $projects->links() }}
        </div>
    @endif
</div>
@endsection
