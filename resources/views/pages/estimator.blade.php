@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12" x-data="estimator()">
    <!-- Header -->
    <div class="space-y-3">
        <span class="text-xs font-bold text-brand uppercase tracking-wider">ابزار هوشمند</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-primary tracking-tight">
            برآورد هوشمند هزینه و مقیاس پروژه
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            مشخصات کلی پروژه و اهداف خود را انتخاب کنید تا محدوده برآورد بودجه و زمان‌بندی تخمینی را فوراً مشاهده نمایید.
        </p>
    </div>

    <!-- Estimator Interactive Form -->
    <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle shadow-sm space-y-8">
        <!-- Step 1: Project Scope -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-content-primary flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-brand/10 text-brand flex items-center justify-center text-xs font-mono">۱</span>
                <span>نوع و دامنه محصول نرم‌افزاری</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label 
                    class="p-4 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                    :class="projectType === 'mvp' ? 'border-brand bg-brand/5 shadow-sm' : 'border-border-subtle hover:bg-surface-subtle'"
                >
                    <input type="radio" name="project_type" value="mvp" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-primary block">MVP / نسخه اولیه سریع</span>
                        <span class="text-xs text-content-secondary block mt-0.5">پیاده‌سازی هسته کلیدی محصول جهت ورود سریع به بازار و جذب سرمایه</span>
                    </div>
                </label>

                <label 
                    class="p-4 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                    :class="projectType === 'full_system' ? 'border-brand bg-brand/5 shadow-sm' : 'border-border-subtle hover:bg-surface-subtle'"
                >
                    <input type="radio" name="project_type" value="full_system" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-primary block">سامانه جامع تحت وب / پلتفرم مقیاس‌پذیر</span>
                        <span class="text-xs text-content-secondary block mt-0.5">معماری ماژولار، پنل مدیریت، درگاه‌ها، اتوماسیون داده و پایداری بالا</span>
                    </div>
                </label>

                <label 
                    class="p-4 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                    :class="projectType === 'threejs_creative' ? 'border-brand bg-brand/5 shadow-sm' : 'border-border-subtle hover:bg-surface-subtle'"
                >
                    <input type="radio" name="project_type" value="threejs_creative" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-primary block">رابط سه‌بعدی و تعاملی Three.js</span>
                        <span class="text-xs text-content-secondary block mt-0.5">طراحی صحنه‌های تعاملی سه‌بعدی شتاب‌یافته روی بستر وب و موبایل</span>
                    </div>
                </label>

                <label 
                    class="p-4 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                    :class="projectType === 'performance_audit' ? 'border-brand bg-brand/5 shadow-sm' : 'border-border-subtle hover:bg-surface-subtle'"
                >
                    <input type="radio" name="project_type" value="performance_audit" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-primary block">بهینه‌سازی کارایی و امنیت سیستم موجود</span>
                        <span class="text-xs text-content-secondary block mt-0.5">پروفایلینگ کد، بهینه‌سازی دیتابیس و کاهش هزینه‌های زیرساخت سرور</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Step 2: Scale & Concurrency -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-content-primary flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-accent/10 text-accent flex items-center justify-center text-xs font-mono">۲</span>
                <span>مقیاس مخاطبان و حجم تراکنش</span>
            </h3>

            <div class="grid grid-cols-3 gap-3">
                <label 
                    class="p-3.5 rounded-xl border text-center cursor-pointer transition-all"
                    :class="scale === 'small' ? 'border-brand bg-brand/5 font-bold text-brand' : 'border-border-subtle text-content-secondary hover:bg-surface-subtle'"
                >
                    <input type="radio" name="scale" value="small" x-model="scale" class="sr-only">
                    <span class="text-xs block font-bold">محدود / تا چند هزار کاربر</span>
                </label>

                <label 
                    class="p-3.5 rounded-xl border text-center cursor-pointer transition-all"
                    :class="scale === 'medium' ? 'border-brand bg-brand/5 font-bold text-brand' : 'border-border-subtle text-content-secondary hover:bg-surface-subtle'"
                >
                    <input type="radio" name="scale" value="medium" x-model="scale" class="sr-only">
                    <span class="text-xs block font-bold">متوسط / تا ۵۰ هزار کاربر</span>
                </label>

                <label 
                    class="p-3.5 rounded-xl border text-center cursor-pointer transition-all"
                    :class="scale === 'enterprise' ? 'border-brand bg-brand/5 font-bold text-brand' : 'border-border-subtle text-content-secondary hover:bg-surface-subtle'"
                >
                    <input type="radio" name="scale" value="enterprise" x-model="scale" class="sr-only">
                    <span class="text-xs block font-bold">سازمانی / بار ترافیکی بالا</span>
                </label>
            </div>
        </div>

        <!-- Step 3: Timeline Urgency -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-content-primary flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-warning/10 text-warning flex items-center justify-center text-xs font-mono">۳</span>
                <span>اولویت زمان‌بندی تحویل</span>
            </h3>

            <div class="grid grid-cols-3 gap-3">
                <label 
                    class="p-3.5 rounded-xl border text-center cursor-pointer transition-all"
                    :class="timeline === 'relaxed' ? 'border-brand bg-brand/5 font-bold text-brand' : 'border-border-subtle text-content-secondary hover:bg-surface-subtle'"
                >
                    <input type="radio" name="timeline" value="relaxed" x-model="timeline" class="sr-only">
                    <span class="text-xs block font-bold">عادی و گام‌به‌گام</span>
                </label>

                <label 
                    class="p-3.5 rounded-xl border text-center cursor-pointer transition-all"
                    :class="timeline === 'standard' ? 'border-brand bg-brand/5 font-bold text-brand' : 'border-border-subtle text-content-secondary hover:bg-surface-subtle'"
                >
                    <input type="radio" name="timeline" value="standard" x-model="timeline" class="sr-only">
                    <span class="text-xs block font-bold">استاندارد</span>
                </label>

                <label 
                    class="p-3.5 rounded-xl border text-center cursor-pointer transition-all"
                    :class="timeline === 'rush' ? 'border-brand bg-brand/5 font-bold text-brand' : 'border-border-subtle text-content-secondary hover:bg-surface-subtle'"
                >
                    <input type="radio" name="timeline" value="rush" x-model="timeline" class="sr-only">
                    <span class="text-xs block font-bold">فوری / اسپرینت فشرده</span>
                </label>
            </div>
        </div>

        <!-- Estimate Result Box -->
        <div class="p-6 rounded-2xl bg-gradient-to-r from-brand/10 via-surface-subtle to-accent/10 border border-brand/30 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <span class="text-xs font-semibold text-content-tertiary block">برآورد بازه سرمایه‌گذاری مورد نیاز:</span>
                <div class="text-2xl sm:text-3xl font-extrabold text-content-primary mt-1 font-mono flex items-baseline gap-2">
                    <span x-text="minPrice">۲۵</span>
                    <span class="text-content-tertiary text-lg font-sans">تا</span>
                    <span x-text="maxPrice">۳۵</span>
                    <span class="text-sm font-sans text-brand font-bold">میلیون تومان</span>
                </div>
                <span class="text-[11px] text-content-tertiary mt-1 block">
                    * برآورد فوق تخمینی است و قیمت قطعی پس از جلسه بررسی نیازمندی‌ها نهایی می‌گردد.
                </span>
            </div>

            <a 
                href="{{ route('contact.index', ['locale' => $locale]) }}"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-brand to-brand-glow text-white font-semibold text-xs shadow-glow hover:opacity-95 whitespace-nowrap"
            >
                ثبت سفارش با این برآورد
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function estimator() {
        return {
            projectType: 'mvp',
            scale: 'small',
            timeline: 'standard',
            minPrice: 22,
            maxPrice: 30,

            init() {
                this.$watch('projectType', () => this.recalc());
                this.$watch('scale', () => this.recalc());
                this.$watch('timeline', () => this.recalc());
                this.recalc();
            },

            recalc() {
                const baseMap = { mvp: 25, full_system: 55, threejs_creative: 40, performance_audit: 15 };
                const scaleMap = { small: 1.0, medium: 1.5, enterprise: 2.3 };
                const timeMap = { relaxed: 0.9, standard: 1.0, rush: 1.3 };

                const base = baseMap[this.projectType] || 25;
                const total = base * (scaleMap[this.scale] || 1) * (timeMap[this.timeline] || 1);

                this.minPrice = Math.round(total * 0.9);
                this.maxPrice = Math.round(total * 1.2);
            }
        };
    }
</script>
@endpush
