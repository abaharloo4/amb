@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Header -->
    <div class="max-w-2xl space-y-3">
        <span class="text-xs font-bold text-brand uppercase tracking-wider">نمونه‌کارها</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-content-primary">
            پروژه‌ها و کیس‌استادی‌های تخصصی
        </h1>
        <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
            گزیده‌ای از معماری‌ها، راهکارهای نرم‌افزاری و محصولاتی که از ایده تا استقرار مقیاس‌پذیر مهندسی کرده‌ام.
        </p>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($projects as $project)
            @php $trans = $project->translation($locale); @endphp
            <div class="rounded-3xl bg-surface-card border border-border-subtle/80 overflow-hidden hover:border-brand/40 transition-all shadow-sm flex flex-col group">
                <div class="h-48 bg-gradient-to-br from-surface-subtle to-brand/10 p-5 flex flex-col justify-between relative overflow-hidden">
                    <div class="flex items-center justify-between z-10">
                        @if ($project->is_demo)
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-warning/10 text-warning border border-warning/20">Demo</span>
                        @endif
                        <span class="text-[10px] font-mono text-content-tertiary">{{ $project->slug }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-content-primary group-hover:text-brand transition-colors z-10">
                        {{ $trans?->title ?? $project->slug }}
                    </h3>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <p class="text-xs text-content-secondary leading-relaxed line-clamp-3">
                        {{ $trans?->summary ?? 'شرح کیس‌استادی و راهکارهای پیاده‌سازی شده در این پروژه.' }}
                    </p>

                    <div class="pt-4 border-t border-border-subtle flex items-center justify-between">
                        <div class="flex flex-wrap gap-1">
                            @foreach ($project->technologies->take(2) as $tech)
                                <span class="px-2 py-0.5 rounded bg-surface-subtle text-[10px] font-mono text-content-tertiary">
                                    {{ $tech->name }}
                                </span>
                            @endforeach
                        </div>

                        <a href="{{ route('portfolio.show', ['locale' => $locale, 'slug' => $project->slug]) }}" class="text-xs font-bold text-brand hover:underline">
                            مشاهده کیس‌استادی →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-sm text-content-tertiary">
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
