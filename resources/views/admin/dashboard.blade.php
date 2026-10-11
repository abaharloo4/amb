@extends('admin.layouts.app')

@section('title', 'میز کار')
@section('header_title', 'داشبورد مدیریت')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand/20 via-surface-card to-accent/10 border border-border-subtle p-8">
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-2xl font-bold text-content-primary">
                درود، {{ Auth::user()->name }}! خوش آمدید.
            </h1>
            <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                سامانه مدیریت یکپارچه پلتفرم شخصی امیرمحمد بحرلو آماده است. از این بخش می‌توانید پروژه‌ها، مقالات تخصصی و پیام‌های متقاضیان را هدایت نمایید.
            </p>
        </div>
        <div class="absolute -end-10 -bottom-10 w-48 h-48 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="p-6 rounded-2xl bg-surface-card border border-border-subtle shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-tertiary">پروژه‌های ثبت‌شده</span>
                <div class="text-2xl font-bold text-content-primary mt-1">{{ $stats['projects_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center">
                <x-ui.icon name="folder" class="w-6 h-6" />
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-surface-card border border-border-subtle shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-tertiary">مقالات وبلاگ</span>
                <div class="text-2xl font-bold text-content-primary mt-1">{{ $stats['posts_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center">
                <x-ui.icon name="book-open" class="w-6 h-6" />
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-surface-card border border-border-subtle shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-tertiary">پیام‌های جدید</span>
                <div class="text-2xl font-bold text-content-primary mt-1">{{ $stats['inquiries_new'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-warning/10 text-warning flex items-center justify-center">
                <x-ui.icon name="mail" class="w-6 h-6" />
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-surface-card border border-border-subtle shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-tertiary">کاربران سیستم</span>
                <div class="text-2xl font-bold text-content-primary mt-1">{{ $stats['users_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-success/10 text-success flex items-center justify-center">
                <x-ui.icon name="users" class="w-6 h-6" />
            </div>
        </div>
    </div>

    <!-- Quick Sections Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Projects -->
        <div class="p-6 rounded-3xl bg-surface-card border border-border-subtle shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-content-primary flex items-center gap-2">
                    <x-ui.icon name="folder" class="w-5 h-5 text-brand" />
                    <span>آخرین پروژه‌ها</span>
                </h3>
                <a href="{{ route('admin.crud.index', 'projects') }}" class="text-xs font-medium text-brand hover:underline">
                    مشاهده همه
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($recentProjects as $proj)
                    <div class="p-3.5 rounded-xl bg-surface-subtle flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-surface-base border border-border-subtle flex items-center justify-center text-xs font-bold text-brand">
                                {{ $proj->id }}
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-content-primary">
                                    {{ $proj->translations->firstWhere('locale', 'fa')?->title ?? $proj->slug }}
                                </h4>
                                <span class="text-xs text-content-tertiary" dir="ltr">{{ $proj->slug }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($proj->is_demo)
                                <span class="px-2 py-0.5 text-[10px] rounded bg-warning/10 text-warning border border-warning/20">Demo</span>
                            @endif
                            <a href="{{ route('admin.crud.edit', ['resource' => 'projects', 'id' => $proj->id]) }}" class="p-1.5 rounded-lg text-content-tertiary hover:text-content-primary hover:bg-surface-base transition-colors">
                                <x-ui.icon name="edit" class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-sm text-content-tertiary">
                        هنوز پروژه‌ای ثبت نشده است.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Inquiries -->
        <div class="p-6 rounded-3xl bg-surface-card border border-border-subtle shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-content-primary flex items-center gap-2">
                    <x-ui.icon name="mail" class="w-5 h-5 text-warning" />
                    <span>آخرین پیام‌های دریافتی</span>
                </h3>
                <a href="{{ route('admin.crud.index', 'inquiries') }}" class="text-xs font-medium text-brand hover:underline">
                    مشاهده همه
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($recentInquiries as $inq)
                    <div class="p-3.5 rounded-xl bg-surface-subtle flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-semibold text-content-primary">{{ $inq->name }}</h4>
                            <span class="text-xs text-content-tertiary">{{ $inq->email }}</span>
                        </div>
                        <span class="px-2.5 py-1 text-xs rounded-full bg-brand/10 text-brand">
                            {{ $inq->status }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-sm text-content-tertiary">
                        صندوق پیام‌ها در حال حاضر خالی است.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
