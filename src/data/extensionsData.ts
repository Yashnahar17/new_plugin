export interface AstraxExtension {
  slug: string;
  name: string;
  description: string;
  enabled: boolean;
  features: string[];
  docUrl?: string;
}

export const INITIAL_EXTENSIONS: AstraxExtension[] = [
  {
    slug: 'motion',
    name: 'Motion Effects & Parallax',
    description: 'Brings smooth mouse tracking, 3D card tilt, multi-layer scroll parallax, and viewport entrance animations to ANY Elementor widget or container.',
    enabled: true,
    features: [
      'Mouse Movement Parallax (X/Y tilt & depth)',
      '3D Perspective Tilt on Hover',
      'Continuous Floating & Hover Animations',
      'Reduced Motion / prefers-reduced-motion safe'
    ]
  },
  {
    slug: 'sticky',
    name: 'Sticky Section & Columns',
    description: 'Pin headers, sidebars, banners, or checkout summaries to the top or bottom of the screen with smooth transition offsets and mobile break options.',
    enabled: true,
    features: [
      'Sticky Top & Sticky Bottom anchors',
      'Target parent column or entire page body',
      'Scroll offset triggering with custom transition CSS',
      'Disable on Mobile / Tablet toggle'
    ]
  },
  {
    slug: 'visibility',
    name: 'Display Visibility Rules',
    description: 'Conditionally show or hide any element based on user authentication, roles, date/time scheduling, operating system, or query string parameters.',
    enabled: true,
    features: [
      'User Status: Logged In / Logged Out / User Role',
      'Device & Operating System detection',
      'Date & Time range scheduling (ideal for flash sales)',
      'URL Parameter conditional matching'
    ]
  },
  {
    slug: 'wrapper-link',
    name: 'Wrapper Link (Clickable Container)',
    description: 'Turns entire Elementor sections, containers, or columns into clickable hyperlink triggers without breaking nested semantics or accessibility.',
    enabled: true,
    features: [
      'Full Container clickable area',
      'Custom target (_blank / _self) and rel="nofollow"',
      'ARIA keyboard accessibility support (Enter / Space)',
      'Hover state bubbling to nested children'
    ]
  }
];
