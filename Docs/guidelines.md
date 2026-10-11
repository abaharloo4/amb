# Guidelines — AMB Personal Portfolio

وضعیت: پیش‌نویس Phase 0 | نسخه: 0.1
این سند استانداردهای کدنویسی، ساختار پروژه، تست و گردش کار Git را تعیین می‌کند. هر انحراف باید در `architecture.md` (ADR) ثبت شود.

## 1. اصول عمومی

1. خوانایی و نگهداری مقدم بر هوشمندی کد.
2. یک منبع حقیقت: توکن‌ها در `tokens.css`، آیکون‌ها در `resources/icons`، presetهای حرکت در `motion/presets`، پیکربندی CRUD در `Admin/Crud`.
3. هیچ کد تکراری برای رفتار یا ظاهر مشترک؛ ابتدا `components.md` را بررسی کن.
4. هیچ ایموجی در کد، متن، Seeder، Commit، لاگ و مستندات.
5. هیچ داده ساختگی بدون برچسب Demo؛ هیچ قیمت یا ادعای واقعی بدون تأیید مالک.
6. هر وابستگی جدید با ضرورت، هزینه نگهداری، مجوز و اثر عملکردی در `architecture.md` ثبت شود.

## 2. ساختار مخزن

```
app/
  Modules/<Module>/{Models,Actions,DTOs,Policies,Events,Listeners,Http/{Controllers/{Public,Admin},Requests,Resources},Database/{Migrations,Factories,Seeders},routes.php}
  Support/            Helperهای مشترک (Locale, Jalali, Slug, TextNormalizer, Sanitizer)
  Admin/Crud/         هسته CRUD پنل
bootstrap/ config/ database/ lang/{fa,en}/ routes/
resources/{views,js,css,icons}/
public/               تنها پوشه در معرض وب
scripts/              release، تولید Sprite، lint سفارشی
tests/{Unit,Feature,Browser}/
docs/                 مستندات پروژه (prd.md, architecture.md, ...)
```

مرز ماژول‌ها: ماژول‌ها از طریق Action، Event یا Interface با هم حرف می‌زنند، نه با دستکاری مستقیم مدل‌های یکدیگر.

## 3. استاندارد PHP / Laravel

- `declare(strict_types=1);` در همه فایل‌های جدید.
- PSR-12 با Laravel Pint (پیکربندی ثابت در مخزن)؛ Larastan حداقل سطح 6 (هدف 8 برای `Modules/*/Actions`).
- Controller نازک است: اعتبارسنجی با Form Request، Authorization با Policy، اجرای کار با Action، پاسخ با Resource/View.
- هر Action یک مسئولیت دارد، `handle()` عمومی، ورودی DTO یا مقادیر نوع‌دار، تراکنش در Action (نه Controller).
- Eloquent: `$fillable` صریح (نه `$guarded = []`)، `casts()` برای تاریخ/JSON/Enum، Enumهای PHP برای وضعیت‌ها.
- `Model::preventLazyLoading()` و `preventSilentlyDiscardingAttributes()` در محیط غیر Production فعال باشد تا N+1 و خطای Mass Assignment زود پیدا شود.
- Queryهای سنگین با `select` محدود، Eager Loading صریح، Index مناسب؛ بدون Query در Blade.
- Event/Listener برای اثرات جانبی (اعلان، Audit، پاک‌سازی کش)، نه فراخوانی مستقیم از Controller.
- خطاها: استثناهای دامنه‌ای نام‌دار؛ پیام کاربر از `lang/`؛ جزئیات فنی فقط در لاگ.
- لاگ: ساختاریافته، بدون PII و Secret؛ سطح مناسب؛ کانال `daily` با نگهداری محدود.
- تاریخ‌ها: ذخیره UTC؛ تبدیل و نمایش فقط در لایه نمایش با `Support/Jalali` و Locale.
- متن کاربر (فارسی): همه ورودی‌ها قبل از اعتبارسنجی/ذخیره با `TextNormalizer` نرمال شوند (ی/ک عربی به فارسی، ارقام، ZWNJ، فاصله‌ها).

## 4. استاندارد Blade و UI

- هیچ منطق تجاری یا Query در Blade؛ فقط نمایش.
- هر المان تکراری از `x-ui.*` می‌آید؛ مارکاپ کپی‌شده بین Viewها ممنوع.
- هیچ `style=""`، هیچ HEX یا مقدار فاصله hardcode؛ فقط کلاس‌های Tailwind مبتنی بر توکن.
- فقط کلاس‌های منطقی (`ms-`, `me-`, `ps-`, `pe-`, `start`, `end`)؛ چپ/راست فیزیکی با دلیل مستند.
- همه متن‌ها از `lang/` (کلید معنادار)؛ بدون رشته hardcode در Viewها.
- HTML معنایی: Landmarkها، ترتیب Heading، `alt` دوزبانه، `aria-*` درست.
- خروجی HTML کاربر فقط پس از Sanitizer سمت سرور و با `{!! !!}` در نقطه‌های مشخص و مستند.
- جداسازی: Viewهای عمومی در `views/public`، پنل در `views/admin`، کامپوننت‌ها در `views/components/ui`.

## 5. استاندارد JavaScript

- ES Modules؛ بدون jQuery؛ ESLint + Prettier در مخزن.
- Alpine Data modules در `resources/js/components/*` و ثبت مرکزی؛ بدون `x-data` طولانی و کد تکراری داخل Blade.
- GSAP فقط از `motion/` (presetها و `data-motion`)؛ Three.js فقط از `three/` با `SceneBase`.
- بارگذاری تنبل (`import()`) برای Three.js و ماژول‌های سنگین؛ هیچ اسکریپت غیرضروری در صفحه.
- پاک‌سازی اجباری: هر چیزی که Listener/Trigger/Context/Renderer می‌سازد، متد `destroy`/`dispose` دارد.
- بدون `console.log` در Build نهایی (حذف در Vite).
- بدون CDN؛ همه وابستگی‌ها از `node_modules` و باندل محلی.

## 6. استاندارد CSS

- Tailwind + `tokens.css` به‌عنوان تنها منبع مقادیر طراحی.
- کلاس‌های ترکیبی تکراری به کامپوننت Blade منتقل شوند، نه `@apply` پراکنده.
- حالت‌های Hover/Focus/Active/Disabled/Invalid برای هر عنصر تعاملی تعریف شود؛ Focus ring از `--focus-ring`.
- `prefers-reduced-motion`، `prefers-color-scheme`، `prefers-contrast` رعایت شود.
- Lint سفارشی در Build: شکست در صورت یافتن HEX/`style=""`/ایموجی خارج از مجاز.

## 7. قراردادهای نام‌گذاری

| مورد | قرارداد | مثال |
|---|---|---|
| جدول | snake_case جمع | `project_translations` |
| مدل | PascalCase مفرد | `ProjectTranslation` |
| Action | فعل + مفعول | `PublishProject`, `SubmitInquiry` |
| Event | گذشته | `InquirySubmitted` |
| Policy | `<Model>Policy` | `ProjectPolicy` |
| Blade component | kebab-case | `x-ui.button` |
| کلید ترجمه | `module.section.key` | `inquiry.step1.title` |
| کلید حرکت | kebab-case | `data-motion="card-hover"` |
| Route name | `module.area.action` | `blog.public.show` |
| Branch | `type/short-name` | `feat/inquiry-wizard` |

## 8. چندزبانگی در کد

- هر موجودیت ترجمه‌پذیر یک جدول `<entity>_translations` دارد؛ بدون ستون زبان‌محور در جدول اصلی.
- دسترسی ترجمه: رابطه `translations` و Accessor/Scope `translate($locale)` با Fallback مشخص (زبان دیگر فقط در پنل، نه به‌صورت پیش‌فرض در سایت عمومی).
- Slug یکتا در سطح `(locale, slug)`؛ تغییر Slug Redirect خودکار می‌سازد.
- ترجمه ناقص: نمایش عمومی فقط اگر وضعیت انتشار آن زبان `published` باشد؛ وضعیت انتشار هر زبان مستقل است.
- هیچ ترجمه ماشینی منتشرشده بدون بازبینی.

## 9. تست

| نوع | ابزار | پوشش لازم |
|---|---|---|
| Unit | Pest/PHPUnit | Estimator (محاسبه)، TextNormalizer، Jalali، Slug، قواعد Booking |
| Feature | Pest/PHPUnit | مسیرهای عمومی و پنل، فرم‌ها و اعتبارسنجی، Policyها (هر نقش)، Rate Limit، Idempotency درخواست، سیاست انتشار |
| همزمانی | تست اختصاصی | رزرو هم‌زمان یک بازه (فقط یکی موفق شود) |
| Browser/E2E | Playwright (روی سیستم توسعه) | فرم چندمرحله‌ای، تغییر تم، تغییر زبان RTL/LTR، reduced-motion، Fallback WebGL |
| دسترسی‌پذیری | axe (در E2E) | صفحات کلیدی در هر دو تم |
| عملکرد | Lighthouse CI/دستی | LCP، CLS، INP؛ بودجه باندل |
| امنیت | چک‌لیست `security.md` + `composer audit` + `npm audit` | قبل از هر Release |

- هر باگ جدی یک تست Regression می‌گیرد و در `debug_log.md` ثبت می‌شود.
- Factory/Seeder: داده Demo با ستون `is_demo` علامت‌گذاری می‌شود و از پنل قابل حذف/جایگزینی است.

## 10. Git و Commit

- Branch اصلی `main` همیشه قابل Release؛ کار روی `feat/*`, `fix/*`, `chore/*`, `docs/*`.
- Commit کوچک و معنادار با قرارداد Conventional (`feat:`, `fix:`, `docs:`, `refactor:`, `test:`, `chore:`)، بدون ایموجی.
- `.env`، کلیدها و فایل‌های Secret هرگز Commit نمی‌شوند؛ `.gitignore` استاندارد Laravel + `public/build`, `node_modules`, `storage` محتوای تولیدی.
- هر Release یک Tag نسخه (`v0.1.0`) و بسته zip متناظر دارد.
- بازبینی خود (Self Review) پیش از Merge: Diff، تست‌ها، چک‌لیست بخش 12.

## 11. اسکریپت‌های توسعه (هدف)

| دستور | کار |
|---|---|
| `composer lint` | Pint + Larastan |
| `composer test` | Pest |
| `npm run dev` | Vite توسعه |
| `npm run build` | Build تولیدی |
| `npm run icons` | ساخت Sprite آیکون‌ها و اعتبارسنجی نام‌ها |
| `npm run lint` | ESLint + Prettier + Lint سفارشی (HEX، ایموجی، `style=""`) |
| `npm run release` | ساخت بسته zip قابل آپلود (بدون `.env`، شامل `vendor` و `public/build`) |

## 12. تعریف «انجام‌شده» (Definition of Done)

- کار مطابق PRD و مستندات انجام شده و Demo/Placeholder مشخص است.
- تست‌های مرتبط نوشته و سبز شده‌اند؛ Lint و Static analysis بدون خطا.
- Policy و اعتبارسنجی سمت سرور بررسی شده‌اند.
- RTL/LTR و تم روشن/تاریک بررسی شده‌اند؛ کیبورد و Focus درست است.
- reduced-motion و Fallback بررسی شده‌اند (برای حرکت و WebGL).
- هیچ مارکاپ/منطق تکراری که باید مشترک می‌شد وجود ندارد.
- کنتراست و دسترسی‌پذیری بررسی شده‌اند.
- هیچ ایموجی، HEX پراکنده یا `style=""` وجود ندارد.
- مستندات مرتبط (`components.md`, `architecture.md`, `debug_log.md`, ...) به‌روز شده‌اند.
- هیچ خطای Console یا درخواست ناموفق باقی نمانده است.

## 13. سیاست وابستگی‌ها

برای هر وابستگی جدید، قبل از نصب در ADR ثبت شود:
1. چه مسئله‌ای را حل می‌کند و چرا ساخت داخلی منطقی نیست.
2. مجوز، فعال بودن نگهداری، سازگاری با نسخه PHP/Laravel هاست.
3. اثر روی حجم باندل/زمان اجرا.
4. سطح ریسک امنیتی (وابستگی‌های تودرتو، دسترسی به شبکه/فایل).
5. جایگزین و هزینه خروج.

وابستگی‌هایی که روی هاست به باینری خارجی یا Node نیاز دارند، رد می‌شوند مگر Build-time روی سیستم توسعه باشد.

## 14. سیاست مستندات

- مستندات اجباری: `prd.md`, `architecture.md`, `design.md`, `components.md`, `icons.md`, `motion.md`, `database.md`, `guidelines.md`, `roadmap.md`, `deployment.md`, `security.md`, `debug_log.md`, `README.md`.
- در پایان هر فاز: مستندات به‌روز و گزارش فاز (تغییرات، فایل‌های جدید، تست‌ها، مشکلات، گام بعدی).
- `debug_log.md`: هر خطای مهم با علامت، علت، راه‌حل، تست Regression.
