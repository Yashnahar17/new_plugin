# WooCommerce Product Carousel

### Description
A responsive, touch-friendly WooCommerce product carousel slider with customizable slide counts, smooth animations, autoplay, rating indicators, badges, and design variant styling.

### Identity
- **Widget Name**: `astrax-woo-product-carousel`
- **Class**: `AstraxAddons\Widgets\WooProductCarousel`
- **Category**: `WooCommerce` (astrax-addons)
- **Script Dependencies**: `astrax-woo-carousel`
- **Style Dependencies**: `astrax-v3-widgets`, `astrax-woo-carousel`

### Controls
| Control Name | Type | Default | Dynamic Supported | Security & Sanitization |
| --- | --- | --- | --- | --- |
| `posts_per_page` | NUMBER | 6 | No | Absolute integer cast (`absint`) |
| `orderby` | SELECT | 'date' | No | Whitelisted option keys ('date', 'title', 'price', 'popularity', 'rand') |
| `order` | SELECT | 'DESC' | No | Strict 'ASC' or 'DESC' validation |
| `slides_to_show` | RESPONSIVE NUMBER | 3 | No | Whitelisted range 1–6 |
| `autoplay` | SWITCHER | 'yes' | No | Boolean cast (`filter_var`) |
| `autoplay_speed` | NUMBER | 4000 | No | Positive integer (`absint`) |
| `pause_on_hover` | SWITCHER | 'yes' | No | Boolean cast |
| `show_dots` | SWITCHER | 'yes' | No | Boolean cast |
| `show_arrows` | SWITCHER | 'yes' | No | Boolean cast |
| `design_variant` | SELECT | 'core' | No | Whitelisted ('core', 'editorial', 'cyber') |

### Accessibility & Responsiveness
- [x] Full ARIA 1.2 Carousel pattern (`aria-roledescription="carousel"`, `role="group"`, `aria-roledescription="slide"`).
- [x] Keyboard focusable slide action buttons and arrows with visible focus rings.
- [x] Pause-on-focus and pause-on-hover to avoid unexpected motion (WCAG 2.2.2 Pause, Stop, Hide).
- [x] Respects `prefers-reduced-motion` with graceful non-animated slide switching.
- [x] Responsive breakpoint rules: 3 slides on Desktop (>1024px), 2 on Tablet (768–1024px), 1 on Mobile (<768px).

### Testing & Validation
- PHP syntax & WPCS 3.0: PASS
- WooCommerce inactive fallback: PASS (renders warning notice, zero fatal errors)
- Elementor editor live preview: PASS
- CSS Coverage: PASS (all selectors mapped to `assets/css/woo-carousel.css` and `v3-widgets.css`)
- Quality Score: 100/100
- Status: PRODUCTION_READY
