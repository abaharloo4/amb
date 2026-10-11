@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <!-- Header -->
    <div class="space-y-3">
        <span class="text-xs font-bold text-brand uppercase tracking-wider">مشاوره آنلاین</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-primary tracking-tight">
            رزرو جلسه ویدئویی و مشاوره تخصصی
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            تاریخ و زمان مناسب خود را انتخاب نمایید تا جلسه مشاوره ۳۰ دقیقه‌ای فنی با امیرمحمد بحرلو رزرو و هماهنگ گردد.
        </p>
    </div>

    <!-- Booking Card Form -->
    <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle shadow-sm">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-success/10 border border-success/20 text-success text-sm flex items-center gap-3">
                <x-ui.icon name="check-circle" class="w-5 h-5 flex-shrink-0" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-danger/10 border border-danger/20 text-danger text-sm">
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
                <div>
                    <label for="client_name" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        نام و نام خانوادگی <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="client_name" 
                        name="client_name" 
                        required 
                        value="{{ old('client_name') }}"
                        placeholder="مثال: سارا محمدی"
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                    />
                </div>

                <div>
                    <label for="client_email" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        ایمیل معتبر (جهت ارسال لینک جلسه) <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="client_email" 
                        name="client_email" 
                        required 
                        dir="ltr"
                        value="{{ old('client_email') }}"
                        placeholder="sara@example.com"
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="client_phone" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        شماره تماس هماهنگی
                    </label>
                    <input 
                        type="text" 
                        id="client_phone" 
                        name="client_phone" 
                        dir="ltr"
                        value="{{ old('client_phone') }}"
                        placeholder="0912..."
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                    />
                </div>

                <div>
                    <label for="slot_date" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        تاریخ جلسه <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="slot_date" 
                        name="slot_date" 
                        required 
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        value="{{ old('slot_date', date('Y-m-d', strtotime('+2 days'))) }}"
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-2.5 text-sm outline-none"
                    />
                </div>

                <div>
                    <label for="slot_time" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        ساعت جلسه <span class="text-danger">*</span>
                    </label>
                    <select 
                        id="slot_time" 
                        name="slot_time" 
                        required 
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-2.5 text-sm outline-none"
                    >
                        <option value="11:00">۱۱:۰۰ صبح</option>
                        <option value="14:00">۱۴:۰۰ بعدازظهر</option>
                        <option value="16:00">۱۶:۰۰ عصر</option>
                        <option value="18:00">۱۸:۰۰ عصر</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="notes" class="block text-xs font-semibold text-content-secondary mb-1.5">
                    موضوع یا سرفصل‌های مدنظر برای طرح در جلسه
                </label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="4" 
                    placeholder="مختصری درباره موضوع پروژه، چالش‌های فنی یا اهداف جلسه بنویسید..."
                    class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                >{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-border-subtle">
                <span class="text-xs text-content-tertiary">
                    جلسه از طریق Google Meet یا پلتفرم آنلاین برگزار می‌شود.
                </span>

                <button 
                    type="submit"
                    class="px-8 py-3 rounded-xl bg-gradient-to-r from-brand to-brand-glow text-white font-semibold text-sm shadow-glow hover:opacity-95 active:scale-95 transition-all flex items-center gap-2"
                >
                    <x-ui.icon name="calendar" class="w-4 h-4" />
                    <span>تایید و رزرو قطعی جلسه</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
