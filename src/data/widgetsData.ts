export interface AstraxWidget {
  slug: string;
  name: string;
  category: string;
  description: string;
  enabled: boolean;
  isPopular?: boolean;
  isPro?: boolean;
  version?: string;
}

export const WIDGET_CATEGORIES = [
  'All',
  'Featured',
  'Content',
  'Images',
  'Typography',
  'Creative',
  'Interactive',
  'Navigation',
  'Blog',
  'Team',
  'Testimonials',
  'Social',
  'WooCommerce',
  'Forms',
  'Business',
  'Data & Maps',
  'DataViz',
  'Developer',
  'AI'
] as const;

export const INITIAL_WIDGETS: AstraxWidget[] = [
  // Core / Root widgets
  { slug: 'advanced-heading', name: 'Advanced Heading', category: 'Typography', description: 'Dual-style headings with subtitle, icon, highlight gradients and animated reveals.', enabled: true, isPopular: true },
  { slug: 'advanced-button', name: 'Advanced Button', category: 'Content', description: 'Interactive magnetic buttons with dual actions, hover glow, and icon morphing.', enabled: true, isPopular: true },
  { slug: 'image-accordion', name: 'Image Accordion', category: 'Images', description: 'Fluid expanding panels on hover or click with custom captions and call-to-actions.', enabled: true, isPopular: true },
  { slug: 'info-box', name: 'Info Box', category: 'Content', description: 'Multi-purpose service box with icon, badge, text, and interactive hover effects.', enabled: true, isPopular: true },
  { slug: 'icon-box', name: 'Icon Box', category: 'Content', description: 'Feature icons with badges, micro-interactions, and custom borders.', enabled: true },
  { slug: 'post-grid', name: 'Post Grid', category: 'Blog', description: 'Customizable responsive grid for WordPress posts, taxonomies, and custom post types.', enabled: true, isPopular: true },
  { slug: 'woo-product-grid', name: 'Woo Product Grid', category: 'WooCommerce', description: 'Showcase WooCommerce inventory with add-to-cart, badges, and quick-view modals.', enabled: true, isPopular: true, isPro: true },
  { slug: 'woo-product-carousel', name: 'Woo Product Carousel', category: 'WooCommerce', description: 'Smooth swipeable product slider with auto-play and stock indicators.', enabled: true, isPro: true },
  { slug: 'woo-category-grid', name: 'Woo Category Grid', category: 'WooCommerce', description: 'Visual taxonomy tiles with product counts and overlay gradients.', enabled: true },

  // Content
  { slug: 'heading', name: 'Heading', category: 'Content', description: 'Clean semantic heading tag generator with responsive font control.', enabled: true },
  { slug: 'text-editor', name: 'Text Editor', category: 'Content', description: 'Rich typography container with column splits and drop caps.', enabled: true },
  { slug: 'rich-text', name: 'Rich Text', category: 'Content', description: 'Extended WYSIWYG text block with custom shortcode execution.', enabled: true },
  { slug: 'icon', name: 'Icon', category: 'Content', description: 'SVG & icon font wrapper with pulse, rotate, and color shift animations.', enabled: true },
  { slug: 'image', name: 'Image', category: 'Content', description: 'High-performance responsive image container with lazy loading & aspect ratio locks.', enabled: true },
  { slug: 'image-box', name: 'Image Box', category: 'Content', description: 'Combined image thumbnail, title, copy, and link block.', enabled: true },
  { slug: 'image-text', name: 'Image + Text', category: 'Content', description: 'Split media and narrative layout with responsive stacking options.', enabled: true },
  { slug: 'button', name: 'Button', category: 'Content', description: 'Primary action trigger with custom padding, radius, and ripple styling.', enabled: true },
  { slug: 'dual-button', name: 'Dual Button', category: 'Content', description: 'Side-by-side CTA buttons with connecting separator badge.', enabled: true },
  { slug: 'cta', name: 'Call to Action', category: 'Content', description: 'Conversion-focused banner box with dynamic background and focal points.', enabled: true, isPopular: true },
  { slug: 'badge', name: 'Badge', category: 'Content', description: 'Subtle contextual pill tag for status, version, or category markers.', enabled: true },
  { slug: 'divider', name: 'Divider', category: 'Content', description: 'Visual section rule with embedded text, icons, or animated lines.', enabled: true },
  { slug: 'spacer', name: 'Spacer', category: 'Content', description: 'Responsive vertical height controller across desktop, tablet, and mobile.', enabled: true },
  { slug: 'notice', name: 'Notice Box', category: 'Content', description: 'Alert box for warnings, announcements, success notifications, and tips.', enabled: true },
  { slug: 'blockquote', name: 'Blockquote', category: 'Content', description: 'Stylized editorial quote container with cite attribution and quotation marks.', enabled: true },
  { slug: 'content-toggle', name: 'Content Toggle', category: 'Content', description: 'Switch between two distinct views, such as monthly/yearly or code/preview.', enabled: true },

  // Images
  { slug: 'gallery', name: 'Image Gallery', category: 'Images', description: 'Responsive grid gallery with filtering tabs and lightbox zoom.', enabled: true, isPopular: true },
  { slug: 'masonry-gallery', name: 'Masonry Gallery', category: 'Images', description: 'Pinterest-style seamless image flow respecting natural aspect ratios.', enabled: true },
  { slug: 'image-carousel', name: 'Image Carousel', category: 'Images', description: 'Touch-enabled media slider with pagination dots and navigation arrows.', enabled: true },
  { slug: 'before-after', name: 'Before/After Slider', category: 'Images', description: 'Interactive split-screen comparison slider for transformations and redesigns.', enabled: true, isPopular: true },
  { slug: 'hotspots', name: 'Image Hotspots', category: 'Images', description: 'Pin interactive tooltips and product tags over high-res diagrams or photos.', enabled: true, isPro: true },
  { slug: 'image-stack', name: 'Image Stack', category: 'Images', description: 'Layered overlapping photos with hover depth shifts.', enabled: true },
  { slug: 'image-reveal', name: 'Image Reveal', category: 'Images', description: 'Curtain wipe and mask animation triggered on viewport entry.', enabled: true },
  { slug: 'lightbox-gallery', name: 'Lightbox Gallery', category: 'Images', description: 'Full-screen zoomable gallery with gesture swipe and caption support.', enabled: true },

  // Typography
  { slug: 'animated-heading', name: 'Animated Heading', category: 'Typography', description: 'Rotating, typing, and flip effects for dynamic title headlines.', enabled: true, isPopular: true },
  { slug: 'text-marquee', name: 'Text Marquee', category: 'Typography', description: 'Infinite looping ticker banner with pause-on-hover and speed controls.', enabled: true },
  { slug: 'typing-text', name: 'Typing Text', category: 'Typography', description: 'Realistic typewriter simulation with backspace and cursor blink.', enabled: true },
  { slug: 'gradient-text', name: 'Gradient Text', category: 'Typography', description: 'Vibrant multi-stop color transitions clipped to font glyphs.', enabled: true },
  { slug: 'glitch-text', name: 'Glitch Text', category: 'Typography', description: 'Cyberpunk style RGB chromatic aberration effect on hover.', enabled: true },
  { slug: 'counter', name: 'Number Counter', category: 'Typography', description: 'Animated statistics odometer rolling up when scrolled into view.', enabled: true, isPopular: true },

  // Creative
  { slug: 'bento-grid', name: 'Bento Grid', category: 'Creative', description: 'Modern Apple-style modular feature grid with varying card spans and glass effects.', enabled: true, isPopular: true, isPro: true },
  { slug: 'liquid-buttons', name: 'Liquid Buttons', category: 'Creative', description: 'Gooey SVG filter buttons with organic fluid hover animations.', enabled: true },
  { slug: 'magnetic-buttons', name: 'Magnetic Buttons', category: 'Creative', description: 'Buttons that subtly gravitate toward the user cursor.', enabled: true },
  { slug: 'glass-cards', name: 'Glassmorphism Cards', category: 'Creative', description: 'Translucent frosted glass panels with specular highlight borders.', enabled: true },
  { slug: 'spotlight-cards', name: 'Spotlight Cards', category: 'Creative', description: 'Radial cursor-tracking torch effect that illuminates card outlines.', enabled: true, isPro: true },
  { slug: 'image-cards-3d', name: '3D Image Cards', category: 'Creative', description: 'Multi-layer parallax tilt cards that react to mouse coordinate position.', enabled: true, isPopular: true },
  { slug: 'floating-dock', name: 'Floating Dock', category: 'Creative', description: 'macOS inspired floating icon dock with parabolic scale on hover.', enabled: true, isPro: true },
  { slug: 'horizontal-scroll', name: 'Horizontal Scroll Container', category: 'Creative', description: 'Converts vertical page scroll into horizontal timeline motion.', enabled: true, isPro: true },
  { slug: 'command-palette', name: 'Command Palette (CMD+K)', category: 'Creative', description: 'Quick search and keyboard navigation popup for power users.', enabled: true, isPro: true },

  // Interactive
  { slug: 'accordion', name: 'Accordion', category: 'Interactive', description: 'Smooth collapsible FAQ panels with single or multi-expand modes.', enabled: true, isPopular: true },
  { slug: 'tabs', name: 'Tabs', category: 'Interactive', description: 'Horizontal and vertical tabbed panes with animated active pill indicator.', enabled: true, isPopular: true },
  { slug: 'flip-box', name: '3D Flip Box', category: 'Interactive', description: 'Double-sided card that flips 180 degrees horizontally or vertically on hover.', enabled: true },
  { slug: 'modal', name: 'Modal Popup', category: 'Interactive', description: 'Accessible dialogue overlay with backdrop blur and custom exit transitions.', enabled: true },
  { slug: 'off-canvas', name: 'Off-Canvas Drawer', category: 'Interactive', description: 'Slide-in sidebar panel for navigation menus, carts, or filters.', enabled: true },
  { slug: 'stepper', name: 'Step-by-Step Flow', category: 'Interactive', description: 'Visual onboarding or checkout wizard with step progress tracker.', enabled: true },

  // Business
  { slug: 'pricing-table', name: 'Pricing Table', category: 'Business', description: 'Tiered subscription cards with feature lists, badges, and toggle switches.', enabled: true, isPopular: true },
  { slug: 'business-hours', name: 'Business Hours', category: 'Business', description: 'Weekly opening schedule table with live Open/Closed badge based on timezone.', enabled: true },
  { slug: 'contact-info', name: 'Contact Info', category: 'Business', description: 'Structured organization contact block with vCard download and map links.', enabled: true },
  { slug: 'feature-comparison', name: 'Feature Comparison', category: 'Business', description: 'Matrix table comparing product tiers, specs, and checkmarks.', enabled: true },
  { slug: 'store-locator', name: 'Store Locator', category: 'Business', description: 'Search branch locations with proximity calculation and interactive map pins.', enabled: true, isPro: true },

  // Team
  { slug: 'team-card', name: 'Team Card', category: 'Team', description: 'Member portrait with bio, position title, and social media hover links.', enabled: true },
  { slug: 'team-grid', name: 'Team Grid', category: 'Team', description: 'Filterable staff directory with department tags and modal bios.', enabled: true },
  { slug: 'team-carousel', name: 'Team Carousel', category: 'Team', description: 'Swipeable team showcase slider with responsive breakpoint controls.', enabled: true },

  // Testimonials
  { slug: 'testimonial', name: 'Testimonial Card', category: 'Testimonials', description: 'Customer quotes with avatar, client designation, and star ratings.', enabled: true, isPopular: true },
  { slug: 'review-slider', name: 'Review Slider', category: 'Testimonials', description: 'Rotating carousel of client praise with Google / Trustpilot styling.', enabled: true },
  { slug: 'star-rating', name: 'Star Rating', category: 'Testimonials', description: 'Visual 5-star scoring widget with schema.org AggregateRating markup.', enabled: true },

  // Data & Maps
  { slug: 'google-map', name: 'Google Maps Extended', category: 'Data & Maps', description: 'Custom styled maps with multiple pins, snazzy styles, and geo-filters.', enabled: true },
  { slug: 'open-street-map', name: 'OpenStreetMap (No API Key)', category: 'Data & Maps', description: 'Free open-source Leaflet map widget without third-party API billing limits.', enabled: true, isPopular: true },

  // Forms
  { slug: 'contact-form', name: 'Contact Form 7 / WPForms Styler', category: 'Forms', description: 'Beautify third-party WordPress forms with custom field styling and submit buttons.', enabled: true },
  { slug: 'newsletter-form', name: 'Newsletter Form', category: 'Forms', description: 'Lead capture widget with Mailchimp and Webhook integrations.', enabled: true },
  { slug: 'multi-step-form', name: 'Multi-Step Form Styler', category: 'Forms', description: 'Transform long forms into friendly guided step sequences.', enabled: true, isPro: true },

  // AI Widgets
  { slug: 'ai-content-writer', name: 'AI Content Assistant', category: 'AI', description: 'Elementor panel widget providing copy generation and rewrites inside the builder.', enabled: true, isPro: true },
  { slug: 'ai-image-generator', name: 'AI Image Generator', category: 'AI', description: 'Direct AI prompt-to-media canvas placeholder generation.', enabled: true, isPro: true },
  { slug: 'ai-faq-generator', name: 'AI FAQ Generator', category: 'AI', description: 'Auto-generates relevant FAQ accordion items based on page topic.', enabled: true, isPro: true }
];
