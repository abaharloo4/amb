# Architecture — AMB Personal Portfolio

وضعیت: پیش‌نویس Phase 0، منتظر تأیید | نسخه: 0.1

## 1. اصول

1. Modular Monolith؛ بدون Microservices.
2. صفحات عمومی Server-rendered با Blade؛ JS فقط برای بهبود تجربه.
3. هر رفتار تکراری یک کامپوننت یا ماژول مشترک دارد.
4. هیچ وابستگی بدون بررسی ضرورت، هزینه نگهداری و اثر عملکردی اضافه نمی‌شود.
5. سایت باید با محدودیت هاست (بدون SSH/Node) نصب، به‌روزرسانی و Rollback شود.
6. منطق تجاری در Action/Service است، نه Controller.

## 2. نمای کلی

```
مرورگر
  |  HTML (Blade) + JS باندل محلی (Vite) + Three.js (lazy)
  v
Apache/LiteSpeed (cPanel) -> public/index.php -> Laravel
  |-- Public routes  (/fa, /en)
  |-- Admin routes   (/admin)  [auth + role + policy]
  |-- Installer      (/_install, توکن‌دار، قفل پس از نصب)
  v
Modules (Actions/Services) -> Eloquent -> MySQL/MariaDB
  |
  |-- Notification adapters: Mail, Melipayamak SMS, In-panel
  |-- Queue (database driver) <- Cron (هر دقیقه)
  |-- Scheduled tasks <- Cron (کش GitHub، پاک‌سازی، یادآوری جلسه)
```

## 3. ساختار کد

```
app/
  Modules/
    Content/        صفحات، بخش‌های صفحه اصلی، تنظیمات
    Portfolio/      پروژه‌ها، رسانه پروژه
    Services/       خدمات
    Blog/           مقاله، دسته، برچسب
    Seo/            متادیتا، ریدایرکت، sitemap، structured data
    Identity/       کاربران، نقش‌ها، Policyها
    Inquiry/        درخواست همکاری، مراحل، رویدادها
    Estimator/      قواعد و محاسبه تخمین
    Booking/        زمان‌های آزاد، رزرو
    Notification/   Adapterها، قالب پیام‌ها
    Testimonial/    نظرات و تأیید
    Resume/         تجربه، مهارت، مدرک، تحصیلات
    Media/          آپلود، پردازش تصویر
    Audit/          لاگ فعالیت
  Support/          Helperهای مشترک (Locale, Jalali, Slug, UI helpers)
  Admin/Crud/       هسته CRUD مشترک پنل
resources/
  views/
    components/ui/        primitives و patterns مشترک
    public/ admin/        صفحات هر ناحیه
  js/ three/ motion/ components/ admin/
  icons/                  SVGهای خام
  css/                    tokens + Tailwind
```

هر ماژول: `Models`, `Actions`, `Policies`, `Http/Controllers` (Public و Admin جدا)، `Http/Requests`، `routes.php`، `Database` (Migration/Factory/Seeder). مرز ماژول‌ها از طریق Action/Event است؛ ماژول‌ها مدل داخلی یکدیگر را مستقیم دستکاری نمی‌کنند.

## 4. چندزبانگی

- مسیرها: `/fa/...` و `/en/...`. ریدایرکت `/` بر اساس ترجیح ذخیره‌شده یا Accept-Language به زبان مناسب.
- محتوای ترجمه‌پذیر در **جدول‌های ترجمه اختصاصی** (`project_translations`, `service_translations`, `post_translations` و غیره) با کلید یکتای `(entity_id, locale)`؛ slug هر زبان مستقل و یکتا.
- `hreflang`، canonical و sitemap از لایه Seo تولید می‌شوند.
- متن‌های رابط کاربری در فایل‌های ترجمه Laravel.
- جهت صفحه: `dir` و `lang` در `<html>`؛ ابزارهای Tailwind منطقی (`ms-`, `me-`, `start`, `end`) به‌جای چپ/راست.
- تاریخ: ذخیره Gregorian/UTC؛ نمایش فارسی با تقویم شمسی. پیشنهاد: `IntlDateFormatter` با تقویم persian در صورت وجود `intl`، وگرنه کتابخانه سبک Jalali.
- اعداد: فارسی‌سازی فقط در لایه نمایش؛ ورودی‌ها قبل از اعتبارسنجی نرمال‌سازی می‌شوند.

## 5. فرانت‌اند و Build

- Vite روی سیستم توسعه؛ خروجی `public/build` داخل بسته Release.
- ورودی‌ها: `app` (سایت)، `admin` (پنل)، چانک‌های lazy برای `three/hero` و ماژول‌های سنگین.
- Tailwind با Design Tokens (CSS variables) و پشتیبانی منطقی RTL.
- Alpine برای رفتارهای سبک؛ GSAP/ScrollTrigger فقط در صفحات نیازمند؛ Three.js فقط در صفحات دارای صحنه.
- فونت‌ها محلی با `font-display` مناسب و preload فقط وزن‌های حیاتی.
- تم: اسکریپت کوچک inline در `<head>` ترجیح را از `localStorage` یا سیستم می‌خواند و `data-theme` را پیش از رندر می‌گذارد (بدون Flash، بدون درخواست سرور).

## 6. پنل مدیریت اختصاصی

- Blade + Alpine + یک کمک‌تابع fetch کوچک برای بروزرسانی بخش‌ها؛ بدون SPA.
- **هسته CRUD مشترک** (`Admin/Crud`): تعریف هر منبع با یک کلاس پیکربندی (ستون‌ها، فیلترها، جست‌وجو، فیلدهای فرم، قواعد، Policy، رویدادهای Audit) و رندر با کامپوننت‌های مشترک.
- ماژول‌های پنل فقط پیکربندی و بخش‌های واقعاً خاص را اضافه می‌کنند.
- کنترل دسترسی با Policy و Permission سمت سرور؛ مخفی‌کردن دکمه کنترل دسترسی نیست.

## 7. احراز هویت و دسترسی

- Laravel auth با session، Hash استاندارد، بازیابی رمز، محدودیت تلاش ورود، بازتولید session.
- نقش‌ها: Admin، Editor (و آینده: Client). مجوزها مبتنی بر Policy.
- دسترسی مشتری به داده دیگران در سطح Query و Policy مسدود است (زیرساخت فاز آینده).

## 8. Queue، Cron و کارهای زمان‌بندی‌شده

- `QUEUE_CONNECTION=database`.
- یک Cron هر دقیقه: `php artisan schedule:run`. داخل Scheduler: `queue:work --stop-when-empty --max-time=50`.
- کارها: ارسال ایمیل/پیامک، یادآوری جلسه، کش GitHub، پاک‌سازی رسانه/نشست/لاگ قدیمی، تولید sitemap در صورت نیاز.
- کار طولانی یا Worker دائمی فرض نمی‌شود. ارسال حیاتی (مثل اعلان درخواست جدید) ابتدا در جدول اعلان ثبت می‌شود تا با خطای ارسال از بین نرود.

## 9. اعلان‌ها

- رابط `NotificationChannel` با Adapterهای `MailChannel`, `MelipayamakChannel`, `DatabaseChannel`.
- تعویض سرویس پیامکی فقط با Adapter جدید و تنظیم Environment.
- کلیدها فقط در `.env`؛ در صورت نبودن کلید، Adapter غیرفعال و رویداد در لاگ ثبت می‌شود (بدون شکست درخواست کاربر).

## 10. رسانه

- ماژول Media نازک: اعتبارسنجی MIME واقعی و پسوند، سقف حجم، نام امن تصادفی، ذخیره خارج از مسیرهای اجرایی.
- پردازش تصویر: تولید نسخه‌های responsive (WebP/AVIF در صورت پشتیبانی GD/Imagick) هنگام آپلود.
- `alt` و متن جایگزین برای هر زبان.

## 11. تخمین هزینه، درخواست‌ها و رزرو

- **Estimator:** قواعد در جدول/تنظیمات با نسخه؛ محاسبه در یک Action خالص (بدون وابستگی UI) برای تست آسان.
- **Inquiry:** فرم بر پایه «تعریف مراحل» (کلاس یا پیکربندی هر مرحله با فیلدها و قواعد)؛ افزودن مرحله = افزودن یک تعریف. کلید Idempotency و Honeypot/زمان‌سنج و Rate Limit.
- **Booking:** قفل هم‌زمانی با تراکنش و Unique Constraint روی بازه، نه فقط بررسی در کد.

## 12. دیتابیس (سطح بالا)

همه موجودیت‌های پرامپت اصلی (بخش 17) بدون حذف یا ادغام، به‌علاوه جدول‌های ترجمه لازم برای هر موجودیت ترجمه‌پذیر (دسته، برچسب، بخش‌های صفحه، نظرات، مهارت، تجربه، مدرک و غیره). اصول: Foreign Key، Index، Unique، Migration/Factory/Seeder، تراکنش برای عملیات حساس، جلوگیری از N+1، تفکیک داده عمومی و خصوصی، Soft Delete فقط در صورت نیاز. نقشه کامل جدول‌ها، ستون‌ها و روابط در `database.md` ثبت شده است و در Phase 3 هنگام نوشتن Migrationها نهایی می‌شود.

## 13. کش

- پیش‌فرض: `file` یا `database` (بدون Redis/Memcached فرض‌شده).
- کش فرگمنت‌های عمومی سنگین (آمار، فهرست‌ها) با ابطال هنگام انتشار/ویرایش.
- `config:cache/route:cache/view:cache` از طریق Installer/Updater وب اجرا می‌شوند.

## 14. استقرار و به‌روزرسانی

- بسته Release zip: شامل `vendor` و `public/build`، بدون `.env`.
- ساختار پیشنهادی: Document Root روی `public`؛ در غیر این صورت ساختار جایگزین امن (مستند در `deployment.md`).
- Installer/Updater وب: بررسی محیط، اجرای migration و seed اولیه، ساخت لینک storage، پاک‌سازی/ساخت cache؛ توکن‌دار، فقط ادمین، با لاگ و قفل بعد از نصب.
- Rollback: نگهداری Release قبلی و بکاپ دیتابیس پیش از هر migration.

## 15. تصمیم‌های معماری (ADR) و وضعیت

| # | تصمیم | وضعیت | یادداشت |
|---|---|---|---|
| 1 | Modular Monolith با Laravel | قطعی | |
| 2 | پنل اختصاصی با Blade + Alpine | قطعی | بدون Filament |
| 3 | بدون Livewire | قطعی (تأیید شد) | پنل روی Blade + Alpine و هسته CRUD مشترک |
| 4 | جدول‌های ترجمه اختصاصی برای همه موجودیت‌های ترجمه‌پذیر | قطعی (تأیید شد) | مطابق پرامپت اصلی؛ بدون پکیج Translatable و بدون ساده‌سازی |
| 5 | نقش/مجوز با `spatie/laravel-permission` (جدول‌های roles و permissions مطابق پرامپت) | قطعی (تأیید شد) | Policy ها روی آن سوار می‌شوند |
| 6 | رسانه: ماژول اختصاصی روی GD/Imagick با جدول `media` کامل | قطعی (تأیید شد) | نسخه‌های responsive، alt دوزبانه |
| 7 | تاریخ شمسی: Intl یا کتابخانه سبک | نیازمند تأیید با تشخیص محیط | وابسته به افزونه `intl` |
| 8 | TipTap با خروجی HTML پاک‌سازی‌شده سمت سرور | قطعی (ویرایشگر) | Sanitizer سمت سرور الزامی |
| 9 | Queue دیتابیس + Cron | قطعی | |
| 10 | Three.js و GSAP با معماری مستقل | قطعی | جزئیات `motion.md` |
| 11 | آیکون SVG Sprite | قطعی | جزئیات `icons.md` |
| 12 | نسخه Laravel/PHP | در Phase 0 با تشخیص محیط | آخرین نسخه پایدار سازگار با هاست |

## 16. ریسک‌ها

| ریسک | اثر | کاهش |
|---|---|---|
| پنل اختصاصی با 15 ماژول زمان‌بر است | تأخیر | هسته CRUD مشترک، ساخت ماژول‌ها با پیکربندی |
| بدون SSH: خطا در migration یا آپدیت | توقف سایت | Updater وب با بکاپ، Rollback مستند |
| Installer وب هدف حمله است | امنیت | توکن، قفل پس از نصب، IP/Rate limit، حذف/غیرفعال‌سازی |
| سنگین‌شدن Hero | LCP/INP بد | بودجه عملکرد، Quality Tiers، بارگذاری تنبل، Fallback |
| محدودیت Cron/Memory هاست | ارسال دیرهنگام اعلان | `--max-time`، ثبت اعلان در DB، گزارش وضعیت در پنل |
| دسترسی خروجی هاست به GitHub/سرویس‌ها | نبود داده | کش، نمایش Fallback، قابلیت غیرفعال‌سازی |
| مجوز فونت/آیکون | مشکل حقوقی | ثبت مجوز هر دارایی در `icons.md`/`design.md` |

## 17. نیاز به تأیید شما

ADR شماره 3 تا 6 تأیید شده‌اند. ADR شماره 7 (تاریخ شمسی) پس از تشخیص محیط بسته می‌شود و بخش «سوالات باز» در `prd.md` پیش از Phase 1 باید بسته شود.
