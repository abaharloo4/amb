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
                <span class="text-xs font-medium text-content-tertiary">جلسات رزرو شده</span>
                <div class="text-2xl font-bold text-content-primary mt-1">{{ $stats['appointments_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand-glow/10 text-brand-glow flex items-center justify-center">
                <x-ui.icon name="calendar" class="w-6 h-6" />
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
                <span class="text-xs font-medium text-content-tertiary">مقالات وبلاگ</span>
                <div class="text-2xl font-bold text-content-primary mt-1">{{ $stats['posts_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center">
                <x-ui.icon name="book-open" class="w-6 h-6" />
            </div>
        </div>
    </div>

    <!-- Quick Sections Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Projects -->
        <div class="p-6 rounded-3xl bg-surface-card border border-border-subtle shadow-sm flex flex-col justify-between">
            <div>
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
                        <div class="p-3 rounded-xl bg-surface-subtle flex items-center justify-between">
                            <div class="flex items-center gap-2.5 truncate">
                                <div class="w-7 h-7 rounded-lg bg-surface-base border border-border-subtle flex items-center justify-center text-xs font-bold text-brand flex-shrink-0">
                                    {{ $proj->id }}
                                </div>
                                <div class="truncate">
                                    <h4 class="text-xs font-semibold text-content-primary truncate">
                                        {{ $proj->translations->firstWhere('locale', 'fa')?->title ?? $proj->slug }}
                                    </h4>
                                    <span class="text-[10px] text-content-tertiary" dir="ltr">{{ $proj->slug }}</span>
                                </div>
                            </div>

                            <a href="{{ route('admin.crud.edit', ['resource' => 'projects', 'id' => $proj->id]) }}" class="p-1.5 rounded-lg text-content-tertiary hover:text-content-primary hover:bg-surface-base transition-colors flex-shrink-0">
                                <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-content-tertiary">
                            هنوز پروژه‌ای ثبت نشده است.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="p-6 rounded-3xl bg-surface-card border border-border-subtle shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-base text-content-primary flex items-center gap-2">
                        <x-ui.icon name="calendar" class="w-5 h-5 text-brand-glow" />
                        <span>آخرین جلسات رزرو شده</span>
                    </h3>
                    <a href="{{ route('admin.crud.index', 'appointments') }}" class="text-xs font-medium text-brand hover:underline">
                        مشاهده همه
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse ($recentAppointments as $app)
                        <div class="p-3 rounded-xl bg-surface-subtle flex items-center justify-between">
                            <div class="truncate">
                                <h4 class="text-xs font-semibold text-content-primary truncate">{{ $app->client_name }}</h4>
                                <span class="text-[10px] text-content-tertiary">{{ $app->start_time ? $app->start_time->format('Y/m/d H:i') : '-' }}</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] rounded-full bg-brand/10 text-brand flex-shrink-0">
                                {{ $app->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-content-tertiary">
                            جلسه‌ای ثبت نشده است.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Inquiries -->
        <div class="p-6 rounded-3xl bg-surface-card border border-border-subtle shadow-sm flex flex-col justify-between">
            <div>
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
                        <div class="p-3 rounded-xl bg-surface-subtle flex items-center justify-between">
                            <div class="truncate">
                                <h4 class="text-xs font-semibold text-content-primary truncate">{{ $inq->name }}</h4>
                                <span class="text-[10px] text-content-tertiary truncate">{{ $inq->email }}</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] rounded-full bg-warning/10 text-warning flex-shrink-0">
                                {{ $inq->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-content-tertiary">
                            صندوق پیام‌ها خالی است.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
