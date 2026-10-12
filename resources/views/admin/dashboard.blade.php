@extends('admin.layouts.app')

@section('title', 'میز کار')
@section('header_title', 'داشبورد مدیریت')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <x-ui.card class="relative overflow-hidden p-8 sm:p-10 bg-gradient-to-r from-brand/20 via-surface to-brand-secondary/15 border-brand/30">
        <div class="relative z-10 max-w-2xl space-y-2">
            <x-ui.badge tone="accent" size="sm">سامانه مدیریت پرتال</x-ui.badge>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-content-heading">
                درود، {{ Auth::user()->name }}! خوش آمدید.
            </h1>
            <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
                سامانه مدیریت یکپارچه پلتفرم شخصی امیرمحمد بحرلو آماده است. از این بخش می‌توانید پروژه‌ها، مقالات تخصصی و پیام‌های متقاضیان را هدایت نمایید.
            </p>
        </div>
        <div class="absolute -end-10 -bottom-10 w-56 h-56 bg-brand-accent/10 rounded-full blur-3xl pointer-events-none"></div>
    </x-ui.card>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <x-ui.card class="p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-secondary">پروژه‌های ثبت‌شده</span>
                <div class="text-3xl font-black text-content-heading mt-1 font-mono">{{ $stats['projects_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-lg bg-brand/10 text-brand flex items-center justify-center">
                <x-ui.icon name="folder" size="md" />
            </div>
        </x-ui.card>

        <x-ui.card class="p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-secondary">جلسات رزرو شده</span>
                <div class="text-3xl font-black text-brand-secondary mt-1 font-mono">{{ $stats['appointments_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-lg bg-brand-secondary/15 text-brand-secondary flex items-center justify-center">
                <x-ui.icon name="calendar" size="md" />
            </div>
        </x-ui.card>

        <x-ui.card class="p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-secondary">پیام‌های جدید</span>
                <div class="text-3xl font-black text-brand-accent mt-1 font-mono">{{ $stats['inquiries_new'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-lg bg-brand-accent/15 text-brand-accent flex items-center justify-center">
                <x-ui.icon name="mail" size="md" />
            </div>
        </x-ui.card>

        <x-ui.card class="p-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-content-secondary">مقالات وبلاگ</span>
                <div class="text-3xl font-black text-content-heading mt-1 font-mono">{{ $stats['posts_count'] }}</div>
            </div>
            <div class="w-12 h-12 rounded-lg bg-surface-subtle text-content-secondary flex items-center justify-center border border-edge">
                <x-ui.icon name="book-open" size="md" />
            </div>
        </x-ui.card>
    </div>

    <!-- Quick Sections Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Projects -->
        <x-ui.card class="p-6 flex flex-col justify-between space-y-4">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-edge pb-3">
                    <h3 class="font-bold text-sm text-content-heading flex items-center gap-2">
                        <x-ui.icon name="folder" size="sm" class="text-brand" />
                        <span>آخرین پروژه‌ها</span>
                    </h3>
                    <a href="{{ route('admin.crud.index', 'projects') }}" class="text-xs font-semibold text-brand hover:underline">
                        مشاهده همه
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse ($recentProjects as $proj)
                        <div class="p-3 rounded-md bg-surface-subtle border border-edge flex items-center justify-between">
                            <div class="flex items-center gap-2.5 truncate">
                                <div class="w-7 h-7 rounded bg-surface border border-edge flex items-center justify-center text-xs font-bold text-brand font-mono flex-shrink-0">
                                    {{ $proj->id }}
                                </div>
                                <div class="truncate">
                                    <h4 class="text-xs font-bold text-content-heading truncate">
                                        {{ $proj->translations->firstWhere('locale', 'fa')?->title ?? $proj->slug }}
                                    </h4>
                                    <span class="text-[10px] font-mono text-content-secondary" dir="ltr">{{ $proj->slug }}</span>
                                </div>
                            </div>

                            <a href="{{ route('admin.crud.edit', ['resource' => 'projects', 'id' => $proj->id]) }}" class="p-1.5 rounded text-content-secondary hover:text-brand hover:bg-action-hover transition-colors flex-shrink-0">
                                <x-ui.icon name="pencil" size="xs" />
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-content-secondary">
                            هنوز پروژه‌ای ثبت نشده است.
                        </div>
                    @endforelse
                </div>
            </div>
        </x-ui.card>

        <!-- Recent Appointments -->
        <x-ui.card class="p-6 flex flex-col justify-between space-y-4">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-edge pb-3">
                    <h3 class="font-bold text-sm text-content-heading flex items-center gap-2">
                        <x-ui.icon name="calendar" size="sm" class="text-brand-secondary" />
                        <span>آخرین جلسات رزرو شده</span>
                    </h3>
                    <a href="{{ route('admin.crud.index', 'appointments') }}" class="text-xs font-semibold text-brand hover:underline">
                        مشاهده همه
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse ($recentAppointments as $app)
                        <div class="p-3 rounded-md bg-surface-subtle border border-edge flex items-center justify-between">
                            <div class="truncate">
                                <h4 class="text-xs font-bold text-content-heading truncate">{{ $app->client_name }}</h4>
                                <span class="text-[10px] text-content-secondary font-mono">{{ $app->start_time ? $app->start_time->format('Y/m/d H:i') : '-' }}</span>
                            </div>
                            <x-ui.badge tone="brand" size="sm">
                                {{ $app->status }}
                            </x-ui.badge>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-content-secondary">
                            جلسه‌ای ثبت نشده است.
                        </div>
                    @endforelse
                </div>
            </div>
        </x-ui.card>

        <!-- Recent Inquiries -->
        <x-ui.card class="p-6 flex flex-col justify-between space-y-4">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-edge pb-3">
                    <h3 class="font-bold text-sm text-content-heading flex items-center gap-2">
                        <x-ui.icon name="mail" size="sm" class="text-brand-accent" />
                        <span>آخرین پیام‌های دریافتی</span>
                    </h3>
                    <a href="{{ route('admin.crud.index', 'inquiries') }}" class="text-xs font-semibold text-brand hover:underline">
                        مشاهده همه
                    </a>
                </div>

                <div class="space-y-2.5">
                    @forelse ($recentInquiries as $inq)
                        <div class="p-3 rounded-md bg-surface-subtle border border-edge flex items-center justify-between">
                            <div class="truncate">
                                <h4 class="text-xs font-bold text-content-heading truncate">{{ $inq->name }}</h4>
                                <span class="text-[10px] text-content-secondary truncate block">{{ $inq->email }}</span>
                            </div>
                            <x-ui.badge tone="accent" size="sm">
                                {{ $inq->status }}
                            </x-ui.badge>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-content-secondary">
                            صندوق پیام‌ها خالی است.
                        </div>
                    @endforelse
                </div>
            </div>
        </x-ui.card>
    </div>
</div>
@endsection
