@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <!-- Header -->
    <div class="space-y-3" data-motion="scrollReveal">
        <x-ui.badge tone="brand" size="sm">مشاوره تخصصی و جلسه آنلاین</x-ui.badge>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-heading tracking-tight">
            رزرو جلسه ویدئویی و مشاوره تخصصی
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            تاریخ و زمان مناسب خود را انتخاب نمایید تا جلسه مشاوره ۳۰ دقیقه‌ای فنی با امیرمحمد بحرلو رزرو و هماهنگ گردد.
        </p>
    </div>

    <!-- Booking Card Form -->
    <x-ui.card class="p-8 sm:p-10" data-motion="scrollReveal">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-md bg-status-success/15 border border-status-success/30 text-status-success text-sm flex items-center gap-3">
                <x-ui.icon name="check-circle-2" size="sm" class="flex-shrink-0" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-md bg-status-error/15 border border-status-error/30 text-status-error text-sm">
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store', ['locale' => $locale]) }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-ui.field label="نام و نام خانوادگی" required="true" id="client_name">
                    <x-ui.input 
                        type="text" 
                        id="client_name" 
                        name="client_name" 
                        required 
                        value="{{ old('client_name') }}"
                        placeholder="مثال: سارا محمدی"
                        iconLeading="users"
                    />
                </x-ui.field>

                <x-ui.field label="ایمیل معتبر (جهت ارسال لینک جلسه)" required="true" id="client_email">
                    <x-ui.input 
                        type="email" 
                        id="client_email" 
                        name="client_email" 
                        required 
                        dir="ltr"
                        value="{{ old('client_email') }}"
                        placeholder="sara@example.com"
                        iconLeading="mail"
                    />
                </x-ui.field>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <x-ui.field label="شماره تماس هماهنگی" id="client_phone">
                    <x-ui.input 
                        type="text" 
                        id="client_phone" 
                        name="client_phone" 
                        dir="ltr"
                        value="{{ old('client_phone') }}"
                        placeholder="0912..."
                        iconLeading="phone"
                    />
                </x-ui.field>

                <x-ui.field label="تاریخ جلسه" required="true" id="slot_date">
                    <x-ui.input 
                        type="date" 
                        id="slot_date" 
                        name="slot_date" 
                        required 
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        value="{{ old('slot_date', date('Y-m-d', strtotime('+2 days'))) }}"
                        iconLeading="calendar"
                    />
                </x-ui.field>

                <x-ui.field label="ساعت جلسه" required="true" id="slot_time">
                    <x-ui.select id="slot_time" name="slot_time" required="true">
                        <option value="11:00">۱۱:۰۰ صبح</option>
                        <option value="14:00">۱۴:۰۰ بعدازظهر</option>
                        <option value="16:00">۱۶:۰۰ عصر</option>
                        <option value="18:00">۱۸:۰۰ عصر</option>
                    </x-ui.select>
                </x-ui.field>
            </div>

            <x-ui.field label="موضوع یا سرفصل‌های مدنظر برای طرح در جلسه" id="notes">
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="4" 
                    placeholder="مختصری درباره موضوع پروژه، چالش‌های فنی یا اهداف جلسه بنویسید..."
                    class="w-full bg-surface text-content-primary rounded-md p-3.5 text-sm border border-edge transition-all duration-fast placeholder:text-content-disabled focus:outline-none focus:ring-2 focus:ring-brand-accent/70 focus:border-brand-primary"
                >{{ old('notes') }}</textarea>
            </x-ui.field>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-edge">
                <span class="text-xs text-content-secondary flex items-center gap-1.5">
                    <x-ui.icon name="video" size="xs" />
                    <span>جلسه از طریق Google Meet یا پلتفرم آنلاین برگزار می‌شود.</span>
                </span>

                <x-ui.button 
                    type="submit"
                    variant="accent"
                    size="lg"
                    iconLeading="calendar"
                >
                    تایید و رزرو قطعی جلسه
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
@endsection
