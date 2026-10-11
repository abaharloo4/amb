# AMB Design System
**Brand Identity, UI/UX, Motion & Visual Guidelines**
- **Project:** AMB Personal Portfolio
- **Brand:** AMB — AmirMohammad Baharlou
- **Website:** abaharlou.ir
- **Document:** `design.md`
- **Version:** 1.0
- **Status:** Approved implementation specification
- **Primary language:** Persian (`fa-IR`)
- **Secondary language:** English (`en`)
- **Target environment:** Laravel, Blade, Tailwind CSS, Alpine.js, GSAP, Three.js

───

## 1. Design Philosophy

### 1.1. Brand Vision
AMB is a personal technology and development brand focused on creating high-quality digital experiences, web applications, WordPress solutions, UI/UX design, and performance-oriented websites.

The visual identity must communicate:
- Technical expertise
- Creative thinking
- Precision and attention to detail
- Reliability and professionalism
- Modern digital craftsmanship
- Individuality without unnecessary decoration

The website should feel like a carefully engineered digital product, not a generic portfolio template.

### 1.2. Core Design Principles
1. **Precision over decoration**: Every visual element must have a clear purpose. Avoid unnecessary borders, gradients, shadows, animations, and decorative elements.
2. **Distinctive, not generic**: The AMB monogram, teal color system, orange signature accents, typography, and ribbon-inspired geometry should create a recognizable identity.
3. **Motion with intention**: Animation should explain relationships, establish hierarchy, or create memorable moments. Motion must never interfere with reading, navigation, or accessibility.
4. **Performance is part of design**: A visually impressive page that loads slowly is not a successful design. Every effect must justify its performance cost.
5. **Accessibility by default**: The interface must remain usable with keyboard navigation, screen readers, reduced-motion preferences, different viewport sizes, and both color themes.
6. **Content comes first**: Visual effects must support real content. Avoid filling the interface with fabricated metrics, fake testimonials, meaningless charts, or placeholder achievements presented as real.

───

## 2. Brand Personality

| Characteristic | Design expression |
| :--- | :--- |
| **Technical** | Geometric forms, structured layouts, code-inspired details |
| **Creative** | Ribbon-like monogram, asymmetric compositions, purposeful motion |
| **Professional** | Strong hierarchy, restrained color usage, clean typography |
| **Modern** | Subtle gradients, responsive layouts, precise transitions |
| **Approachable** | Clear copy, generous spacing, understandable interactions |

The final visual language must balance technical sophistication with readability. Avoid making the website look like a gaming interface, cryptocurrency landing page, generic AI startup, or excessive neon cyberpunk environment.

───

## 3. Official Color Palette

### 3.1. Core Brand Colors

| Token | Color name | HEX | Primary purpose |
| :--- | :--- | :--- | :--- |
| `brand-primary` | Deep Teal | `#18424E` | Main brand color, headings, identity |
| `brand-secondary` | Stormy Teal | `#29665F` | Secondary surfaces, interactions, graphics |
| `brand-accent` | Golden Orange | `#F49D07` | Important CTAs, signatures, active details |
| `neutral-carbon` | Carbon Black | `#1F1F1F` | Dark theme background |
| `neutral-silver` | Silver | `#BABABA` | Secondary text on dark surfaces and dividers |
| `neutral-mist` | Mist White | `#F4F7F6` | Main light theme background |
| `neutral-white` | Pure White | `#FFFFFF` | Cards, light surfaces, text on dark backgrounds |

- **Deep Teal — `#18424E`**: The primary brand color. Use for the main AMB monogram, primary headings in light mode, brand elements, selected navigation states, primary buttons where contrast permits, selected Three.js geometry, and major visual anchors.
- **Stormy Teal — `#29665F`**: The supporting brand color. Use for secondary logo elements, interactive surfaces, selected cards and graphics, secondary buttons, skill and technology visualizations, gradient transitions, and decorative geometry.
- **Golden Orange — `#F49D07`**: The signature accent color. Use for primary conversion actions, important active states, small logo details, progress indicators, selected navigation indicators, Three.js particles and focal points, small highlights in illustrations, and focus indicators.
- **Carbon Black — `#1F1F1F`**: The foundation of the dark theme. Use for dark page backgrounds, dark logo presentation backgrounds, hero and immersive visual sections, and dark-theme base surfaces.
- **Silver — `#BABABA`**: A supporting neutral. Use for secondary text on dark surfaces, subtle separators, disabled states, muted labels, secondary metadata, and nonessential graphic details.
- **Mist White — `#F4F7F6`**: The main light theme background. Use for main page background in light mode, light-theme section backgrounds, calm visual areas, and neutral space around cards and content.
- **Pure White — `#FFFFFF`**: Use for cards and elevated light-theme surfaces, form controls, and text on dark surfaces.

───

## 4. Extended Color Tokens

| Token | HEX | Usage |
| :--- | :--- | :--- |
| `teal-dark` | `#10313A` | Deeper teal surfaces and dark gradients |
| `teal-light` | `#3D8178` | Supporting hover and decorative states |
| `teal-highlight` | `#79CCBB` | Limited highlights in gradients and graphics |
| `carbon-deep` | `#171A1A` | Dark elevated contrast and immersive backgrounds |
| `carbon-surface` | `#272C2B` | Dark cards and panels |
| `carbon-elevated` | `#303735` | Elevated dark surfaces |
| `mist-elevated` | `#EAF0ED` | Elevated light-theme sections |
| `text-light-secondary` | `#4B5A58` | Secondary text on light backgrounds |
| `orange-light` | `#FFC45C` | Gradient highlights |
| `border-light` | `#DCE5E1` | Light theme borders |
| `border-dark` | `#3A4442` | Dark theme borders |

───

## 5. Color Usage Ratios
The initial visual distribution for brand-focused pages should approximately follow:
- **35% Deep Teal**
- **25% Carbon Black**
- **20% Mist White and other light surfaces**
- **12% Stormy Teal**
- **8% Golden Orange**

───

## 6. Semantic Colors

| State | Light theme | Dark theme |
| :--- | :--- | :--- |
| **Success** | `#216E4E` | `#65C99A` |
| **Warning** | `#8A5A00` | `#FFC45C` |
| **Error** | `#B42318` | `#FF8C82` |
| **Information** | `#245C9C` | `#8AB8F0` |

Rules:
- Never communicate status using color alone.
- Use labels, icons, or explanatory text.
- Keep error, success, and warning colors consistent throughout the application.
- Test status colors on both light and dark backgrounds.

───

## 7. Theme System
The website must support complete light and dark themes with zero flash on initial load (`data-theme="light"` and `data-theme="dark"`).

### 7.1. Light Theme Tokens
- `bg-primary`: `#F4F7F6`
- `bg-surface`: `#FFFFFF`
- `bg-elevated`: `#EAF0ED`
- `text-primary`: `#18424E`
- `text-secondary`: `#4B5A58`
- `border-color`: `#DCE5E1`
- `brand-primary`: `#18424E`
- `brand-secondary`: `#29665F`
- `brand-accent`: `#F49D07`
- `link-color`: `#29665F`
- `focus-ring`: `#8A5A00`

### 7.2. Dark Theme Tokens
- `bg-primary`: `#1F1F1F`
- `bg-surface`: `#272C2B`
- `bg-elevated`: `#303735`
- `text-primary`: `#F4F7F6`
- `text-secondary`: `#BABABA`
- `border-color`: `#3A4442`
- `brand-primary`: `#29665F`
- `brand-secondary`: `#79CCBB`
- `brand-accent`: `#F49D07`
- `link-color`: `#79CCBB`
- `focus-ring`: `#FFC45C`

───

## 8. Typography System
- **Persian Font**: Vazirmatn (clear letterforms, balanced RTL line height, distinct numerals)
- **English Font**: Inter (clean, modern grotesque sans-serif)
- **Monospace Font**: JetBrains Mono

───

## 9. Motion & Interaction Standards
- **Fast**: `120ms` (hover states, micro transitions)
- **Standard**: `220ms` (buttons, inputs, borders)
- **Medium**: `400ms` (cards, drawer/modals)
- **Slow**: `700ms` (section reveals)
- **Display**: `1000ms` (hero presentation)
- **Easing**: `cubic-bezier(0.22, 1, 0.36, 1)`
- **Reduced Motion**: Full compliance with `prefers-reduced-motion: reduce`.
