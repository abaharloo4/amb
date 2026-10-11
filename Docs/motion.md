# Motion, Three.js و GSAP — AMB

وضعیت: پیش‌نویس Phase 0 | نسخه: 0.1
این سند یکی از مهم‌ترین مستندات پروژه است. Three.js و GSAP امضای بصری AMB هستند و از Phase 1 (زیربنا) تا Phase 7 (تکمیل) به‌صورت یک سیستم مستقل با معماری، بودجه عملکرد و تست توسعه داده می‌شوند.

## 1. فلسفه حرکت

1. **هدفمند:** هر حرکت یا اطلاعات می‌دهد، توجه را هدایت می‌کند یا هویت می‌سازد. حرکت بی‌هدف حذف می‌شود.
2. **کنترل‌شده:** آرام، نرم، قابل‌پیش‌بینی؛ بدون لرزش، بدون Flash، بدون سرعت شدید.
3. **اختصاصی:** ظاهر حرکت (ریتم، easing، زبان بصری شبکه/ذره/خط) از هویت AMB می‌آید، نه از افکت‌های آماده.
4. **سیستمی:** هیچ انیمیشن یک‌بارمصرفی در Viewها نوشته نمی‌شود؛ همه از presetها و توکن‌های مرکزی می‌آیند.
5. **مقاوم:** سایت بدون JS، بدون WebGL یا با reduced-motion کاملاً قابل استفاده و زیبا است.
6. **اندازه‌گیری‌شده:** هر افکت با بودجه عملکرد سنجیده می‌شود.

## 2. تقسیم وظایف ابزارها

| ابزار | مسئولیت |
|---|---|
| Three.js | صحنه‌ها و جلوه‌های سه‌بعدی (فقط جاهای شاخص) |
| GSAP | Timelineها و انیمیشن‌های زمان‌بندی‌شده |
| ScrollTrigger | انیمیشن‌های وابسته به اسکرول |
| Alpine.js | تعاملات سبک رابط (باز/بسته، تب، مودال) |
| CSS | Hover، Transition و انیمیشن‌های ساده |

قاعده: اگر CSS کافی است، GSAP استفاده نمی‌شود. اگر Timeline، ترتیب‌دهی یا اسکرول لازم است، GSAP. اگر عمق یا فضا لازم است، Three.js.

## 3. توکن‌های حرکتی

در `tokens.css` به‌صورت CSS variables و در `motion/core/tokens.js` به‌صورت مقادیر قابل‌خواندن برای GSAP (از همان CSS variables خوانده می‌شوند تا یک منبع واحد باشد).

| توکن | مقدار پیشنهادی (قابل تنظیم) | کاربرد |
|---|---|---|
| `--motion-instant` | 80ms | بازخورد فوری (Press) |
| `--motion-fast` | 160ms | Hover، Focus |
| `--motion-base` | 320ms | Reveal کوچک، Dropdown |
| `--motion-slow` | 640ms | Reveal بخش‌ها |
| `--motion-hero` | 1200ms | ورود Hero |
| `--ease-standard` | `cubic-bezier(.2,.0,.0,1)` | حرکت عمومی |
| `--ease-emphasized` | `cubic-bezier(.16,1,.3,1)` | ورود عناصر شاخص |
| `--ease-exit` | `cubic-bezier(.4,0,1,1)` | خروج |
| `--stagger-sm` / `--stagger-md` | 40ms / 80ms | فاصله آبشاری |
| `--parallax-max` | 40px | سقف جابه‌جایی پارالاکس |

معادل GSAP (`power3.out`, `expo.out` و غیره) در یک نگاشت مرکزی نگه داشته می‌شود تا CSS و GSAP هم‌ریتم باشند. مقادیر دقیق در Phase 2 با آزمون بصری نهایی می‌شوند.

## 4. معماری کد

```
resources/js/
  motion/
    core/
      gsap-setup.js        ثبت پلاگین‌ها، تنظیمات سراسری، ticker
      tokens.js            خواندن توکن‌های حرکتی از CSS
      registry.js          ثبت و فراخوانی presetها
      scan.js              پیمایش DOM برای data-motion و اتصال presetها
      context.js           مدیریت gsap.context و matchMedia و پاک‌سازی
      reduced-motion.js    تشخیص و سیاست جایگزین
      direction.js         RTL/LTR (معکوس‌سازی محور X)
      refresh.js           ScrollTrigger.refresh پس از فونت/تصویر/تغییر جهت
    presets/
      reveal.js, stagger.js, counter.js, parallax.js,
      timeline-experience.js, section-transition.js,
      hero-intro.js, card-hover.js, text-split.js, svg-draw.js
  three/
    core/
      SceneBase.js         چرخه عمر پایه
      RendererManager.js   ساخت/اشتراک/آزادسازی Renderer، سقف DPR
      Loop.js              حلقه رندر هماهنگ با GSAP ticker
      Visibility.js        توقف هنگام مخفی بودن تب یا خارج از دید
      Quality.js           سطوح کیفیت و تشخیص توان دستگاه
      ThemeSync.js         همگام‌سازی رنگ‌ها با CSS variables
      Pointer.js           ورودی ماوس/لمس نرم و محدود
      Dispose.js           آزادسازی کامل منابع
      Capability.js        تشخیص WebGL/WebGL2 و Fallback
    scenes/
      hero/                صحنه اصلی
      (صحنه‌های ثانویه در بخش 9)
    shaders/               GLSL اختصاصی (vertex/fragment)
    utils/
```

- `three` با `dynamic import` و Chunk جدا؛ فقط در صفحاتی که `data-scene` دارند.
- همه چیز محلی و Tree-shaken؛ بدون CDN. فقط ماژول‌های لازم Three.js وارد می‌شود.
- در پنل مدیریت GSAP/Three.js بارگذاری نمی‌شود (فقط CSS و Alpine).

## 5. GSAP

### 5.1 راه‌اندازی
- `gsap-setup` یک بار پلاگین‌های لازم را ثبت می‌کند. فهرست پلاگین‌ها و مجوز هر کدام هنگام نصب بررسی و ثبت می‌شود.
- پلاگین‌های اولیه: ScrollTrigger؛ در صورت نیاز: SplitText (برای Reveal متن، با رعایت فارسی)، DrawSVG، Flip. هر پلاگین فقط با توجیه اضافه می‌شود.
- حلقه اصلی: `gsap.ticker`؛ حلقه Three.js هم از همین ticker تغذیه می‌شود تا دو حلقه رقیب وجود نداشته باشد.

### 5.2 Attribute API
Viewها فقط attribute می‌گذارند:

```html
<section data-motion="reveal" data-motion-delay="0.1">
<ul data-motion="stagger" data-motion-children="> li">
<span data-motion="counter" data-motion-to="120" data-motion-format="number">
<div data-motion="parallax" data-motion-speed="0.2">
```

| Preset | رفتار | پارامترها |
|---|---|---|
| `reveal` | محو + جابه‌جایی کم، یک بار هنگام ورود | `delay`, `distance`, `once` |
| `stagger` | ورود آبشاری فرزندان | `children`, `each` |
| `counter` | شمارنده برای آمار معتبر؛ فرمت فارسی/انگلیسی | `to`, `from`, `duration`, `format` |
| `parallax` | جابه‌جایی کنترل‌شده با سقف `--parallax-max` | `speed`, `axis` |
| `text-split` | Reveal خط/کلمه برای تیترها (با پشتیبانی فارسی، بدون شکستن اتصال حروف) | `by: lines/words` |
| `svg-draw` | رسم مسیر SVG (خطوط Timeline، نمودار) | `duration` |
| `timeline-experience` | Timeline سوابق: ورود نقاط و خط پیشرفت | |
| `section-transition` | انتقال میان بخش‌های منتخب | |
| `card-hover` | Hover اختصاصی (چرخش نرم، نور، ردیابی ماوس) | |
| `hero-intro` | Timeline ورود Hero | |

- انیمیشن سفارشی (فقط بخش‌های شاخص مثل Hero و Timeline) در `presets/` نوشته می‌شود، نه داخل Viewها.
- `scan.js` هنگام بارگذاری و پس از تغییر DOM (مثلاً فیلتر نمونه‌کار) presetها را اتصال/پاک‌سازی می‌کند.

### 5.3 قواعد فنی
- همه انیمیشن‌ها داخل `gsap.context()` و `gsap.matchMedia()` ساخته می‌شوند تا پاک‌سازی، ریسپانسیو و reduced-motion درست باشد.
- فقط `transform` و `opacity` انیمیت شوند؛ از انیمیت `width/height/top/left` پرهیز شود.
- `will-change` فقط موقت و روی عناصر درحال انیمیشن.
- ScrollTrigger: بدون Scroll-jacking؛ Pin فقط وقتی لازم است (مثل Timeline عمودی بلند) و روی موبایل با دقت.
- `ScrollTrigger.refresh()` پس از لود فونت‌ها، تصاویر مهم و تغییر جهت/اندازه.
- از `once: true` برای Revealها استفاده می‌شود تا کاربر با اسکرول رو به بالا هم دوباره آن‌ها را نبیند.
- متن Hero و محتوای حیاتی بدون JS هم قابل‌مشاهده است (حالت اولیه فقط در صورت اجرای JS مخفی می‌شود، با کلاس `js-motion` روی `<html>`).

### 5.4 RTL
- `direction.js` ضریب محور X را معکوس می‌کند (ورود از راست در فارسی، از چپ در انگلیسی).
- SplitText/تقسیم متن فارسی: تقسیم بر اساس کلمه/خط، نه حرف.

## 6. Three.js

### 6.1 چرخه عمر (`SceneBase`)
`init(container, options)`، `resize()`، `update(dt, state)`، `pause()`، `resume()`، `setQuality(tier)`، `setTheme(tokens)`، `dispose()`. همه صحنه‌ها از آن ارث می‌برند.

### 6.2 مدیریت منابع
- یک Renderer فعال در هر لحظه؛ صحنه‌های دیگر پیش از ساخت صحنه جدید `dispose` می‌شوند (محدودیت Context مرورگر).
- DPR سقف‌دار (مثلاً حداکثر 1.5 تا 2 بسته به tier).
- حلقه رندر هنگام مخفی بودن تب (`visibilitychange`) و خارج از دید (`IntersectionObserver`) متوقف می‌شود.
- رندر درخواستی: اگر چیزی تغییر نکرده، رندر اضافی انجام نمی‌شود.
- آزادسازی کامل Geometry، Material، Texture، RenderTarget و Renderer هنگام نابودی.
- هیچ مدل/بافت بزرگ؛ هندسه و Shader اختصاصی. Instancing برای ذرات و گره‌ها.

### 6.3 سطوح کیفیت (Quality Tiers)

| سطح | شرایط | تنظیمات |
|---|---|---|
| High | دسکتاپ قوی | تراکم کامل ذرات، DPR بالا، افکت‌های ثانویه فعال |
| Medium | لپ‌تاپ معمولی/تبلت | ذرات کمتر، DPR متوسط، بدون افکت‌های ثانویه |
| Low | موبایل/دستگاه ضعیف | ذرات کم، DPR کم، حرکت ساده |
| Static | بدون WebGL، reduced-motion یا خطا | تصویر/CSS/SVG ایستا، بدون Canvas |

- تشخیص اولیه از `hardwareConcurrency`, عرض صفحه، `deviceMemory` (در صورت وجود) و تست کوتاه FPS در 1 تا 2 ثانیه اول؛ کاهش خودکار tier در صورت افت FPS پایدار.
- کاربر می‌تواند حرکت را (در Footer/تنظیمات دسترسی‌پذیری) کم یا خاموش کند و انتخاب ذخیره شود.

### 6.4 همگام‌سازی تم
- `ThemeSync` رنگ‌های `--scene-*` را از CSS می‌خواند و با تغییر `data-theme` (MutationObserver) بدون Reload به Uniformها اعمال می‌کند (Tween نرم).
- پس‌زمینه Canvas شفاف یا برابر `--scene-bg` برای یکپارچگی با صفحه.

### 6.5 ورودی
- حرکت ماوس: محدود، با Easing و Damping؛ دامنه کوچک.
- لمس: بدون Drag که با اسکرول صفحه تداخل کند.
- Scroll: پیشرفت اسکرول Hero (از ScrollTrigger) به‌عنوان یک Uniform ساده منتقل می‌شود؛ بدون کنترل اسکرول.

### 6.6 دسترسی‌پذیری
- Canvas `aria-hidden="true"`، `pointer-events: none` روی لایه Canvas (کنترل‌ها روی HTML هستند).
- HTML Hero (تیتر، توضیح، دکمه‌ها) مستقل و واقعی است.
- Fallback Static در صورت خطای WebGL، reduced-motion یا WebGL غیرفعال.

## 7. جهت‌های پیشنهادی Hero (برای تأیید در Phase 2)

هر سه جهت از رنگ‌های رسمی استفاده می‌کنند: ساختار Deep Teal، خطوط Stormy Teal، ذرات/نقاط Golden Orange، پس‌زمینه Carbon (و Mist در تم روشن).

**A. Signal Lattice (توصیه اولیه)**
شبکه‌ای از نقاط/گره‌ها که یک میدان موجی نرم تشکیل می‌دهد. خطوط ظریف بین گره‌های نزدیک، چند گره نارنجی که پالس می‌دهند و سیگنال‌ها را در شبکه می‌فرستند. ماوس باعث موج محلی و کم‌دامنه می‌شود. پیام: ساختار، ارتباط، دقت فنی. کم‌هزینه با Instancing و Shader.

**B. Orbital Structure**
خوشه‌ای از اشکال هندسی سیمی (wireframe) متمرکز که آرام می‌چرخند؛ حلقه‌ها و خطوط اتصال به‌صورت لایه‌ای. ذرات نارنجی روی مدارها. پیام: معماری، لایه‌ها، سیستم. هزینه متوسط.

**C. Data Terrain**
چشم‌انداز انتزاعی از خطوط ارتفاع (contour/terrain) که روی مسیر اسکرول تغییر شکل می‌دهد؛ نقاط نارنجی روی قله‌ها. پیام: رشد و مسیر. هزینه متوسط تا بالا.

در Phase 2 از هر جهت حداقل یک نمونه کوچک ساخته می‌شود و با معیارهای زیر مقایسه می‌شود: هویت، خوانایی متن روی صحنه، FPS، حجم، رفتار موبایل. جهت نهایی با تأیید مالک انتخاب می‌شود. (امکان ترکیب A و B وجود دارد.)

## 8. طراحی حرکت صفحه اصلی

| بخش | حرکت | ابزار |
|---|---|---|
| Hero | ورود تدریجی: ذرات و شبکه، سپس تیتر (Reveal خطی)، توضیح، CTA؛ ماوس روی صحنه؛ هنگام اسکرول صحنه آرام محو/کوچک می‌شود | Three.js + GSAP Timeline + ScrollTrigger |
| معرفی و تخصص‌ها | Reveal تیتر و متن، آبشاری تخصص‌ها | `reveal`, `stagger` |
| CTA شروع همکاری | Reveal ساده، Hover دکمه Accent | `reveal` + CSS |
| خدمات منتخب | آبشاری کارت‌ها، Hover اختصاصی | `stagger`, `card-hover` |
| نمونه‌کارهای برجسته | ورود کارت‌ها، پارالاکس بسیار ملایم تصویر، Hover اختصاصی | `stagger`, `parallax`, `card-hover` |
| آمار و دستاوردها | شمارنده‌ها (فقط داده معتبر) | `counter` |
| روند پروژه | Timeline اسکرولی با رسم خط و فعال‌شدن مراحل | `svg-draw`, `timeline-experience` |
| مهارت‌ها و فناوری‌ها | آبشاری نشان‌ها | `stagger` |
| GitHub | Reveal ساده، نمودار با رسم تدریجی | `reveal`, `svg-draw` |
| نظرات | Reveal ملایم | `reveal` |
| مقالات منتخب | آبشاری کارت‌ها | `stagger` |
| دعوت نهایی | Reveal، در صورت نیاز صحنه کوچک (بخش 9) | `reveal` |
| Footer | بدون انیمیشن سنگین | CSS |

صفحات داخلی: Reveal ملایم تیتر و محتوا، Timeline در رزومه، Hover کارت‌ها، انتقال ظریف صفحات. صفحات فرم‌محور (فرم همکاری، رزرو، پنل) فقط حرکت‌های کوچک و غیرمزاحم.

### انتقال میان صفحات
View Transitions API به‌صورت Progressive Enhancement ارزیابی می‌شود؛ در غیر این صورت Fade/Slide کوتاه با GSAP. معماری Server-rendered حفظ می‌شود، SPA ساخته نمی‌شود.

## 9. صحنه‌های Three.js

| صحنه | هدف | فاز |
|---|---|---|
| Hero (اصلی) | امضای بصری برند | 2 |
| CTA نهایی (اختیاری) | نسخه کم‌هزینه از همان زبان بصری | 7 |
| 404 | صفحه اختصاصی و خاص | 7 |
| نمونه‌کار (اختیاری) | تعامل بصری هدفمند در صفحه پروژه، فقط در صورت توجیه عملکردی | 7 |

قاعده: صحنه ثانویه فقط با توجیه و پس از تأیید بودجه عملکرد؛ همیشه یک Renderer فعال.

## 10. Reduced Motion و دسترسی‌پذیری حرکتی

| حالت | رفتار |
|---|---|
| `prefers-reduced-motion: reduce` | Three.js: Static؛ Revealها: ظاهر شدن ساده (Fade کوتاه یا بدون حرکت)؛ شمارنده: نمایش عدد نهایی؛ Parallax و Pin: غیرفعال |
| کنترل دستی کاربر | کلید «کاهش حرکت» در Footer؛ ذخیره ترجیح |
| عمومی | بدون Flash/چشمک سریع، بدون حرکت سریع و بزرگ، محتوا هرگز وابسته به انیمیشن برای قابل‌خواندن بودن نیست |

## 11. بودجه عملکرد (شروع اولیه، پس از اندازه‌گیری نهایی می‌شود)

| معیار | هدف اولیه |
|---|---|
| حجم JS صحنه Hero (Three.js + کد + Shader، gzip) | تا حدود 180KB؛ پس از Tree-shaking واقعی تنظیم شود |
| حجم JS سایت اصلی بدون Three.js (gzip) | تا حدود 90KB (Alpine + GSAP + presetها)؛ پس از اندازه‌گیری نهایی شود |
| FPS Hero | حدود 60fps در دستگاه میان‌رده؛ افت پایدار زیر 40fps باعث کاهش tier |
| LCP | تحت تأثیر Canvas نیست؛ متن Hero و تصویر Fallback عنصر LCP‌اند |
| CLS | کمتر از 0.1؛ Canvas با ابعاد رزرو‌شده |
| INP | کمتر از 200ms؛ هیچ کار سنگین روی Main thread هنگام ورودی |
| زمان بارگذاری Three.js | پس از Idle/ورود به دید، نه Blocking |

این اعداد هدف شروع هستند و در Phase 2 با اندازه‌گیری واقعی روی دستگاه‌های نمونه تأیید یا اصلاح می‌شوند.

## 12. ابزار توسعه و تست حرکت

- حالت دیباگ (`?debug=motion` فقط در محیط توسعه): FPS، تعداد Draw call، حافظه، tier فعلی، Triggerهای فعال.
- صفحه آزمایشگاه `/_ui/motion`: همه presetها، با کنترل reduced-motion، RTL/LTR، دو تم.
- چک‌لیست تست حرکت:
  - هیچ Layout Shift ناشی از انیمیشن.
  - بدون لرزش در Reveal و پارالاکس.
  - پاک‌سازی کامل هنگام ترک صفحه (بدون نشت Trigger/Context).
  - تغییر تم زنده روی صحنه.
  - تغییر جهت و زبان بدون خطا.
  - رفتار با اتصال کند و دستگاه ضعیف (Throttling).
  - WebGL غیرفعال و reduced-motion.
  - Console بدون خطا.
- اندازه‌گیری: Lighthouse و Web Vitals، به‌علاوه تست دستی روی موبایل واقعی.

## 13. ریسک‌ها

| ریسک | کاهش |
|---|---|
| سنگین‌شدن Hero | tier، بارگذاری تنبل، بودجه، اندازه‌گیری مداوم |
| تداخل GSAP و Three.js در حلقه | ticker مشترک، یک Loop |
| تقسیم متن فارسی | تقسیم بر کلمه/خط، تست دستی |
| نشت حافظه در صحنه | `dispose` اجباری، تست ورود/خروج مکرر |
| ScrollTrigger و تغییر Layout | `refresh` پس از فونت/تصویر، ابعاد ثابت برای رسانه |
| مجوز پلاگین GSAP | بررسی و ثبت قبل از نصب |
| WebGL در دستگاه‌های قدیمی | Capability + Static fallback |
