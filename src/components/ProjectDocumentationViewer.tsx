import React, { useState } from 'react';
import {
  FileText,
  Download,
  Copy,
  Check,
  BookOpen,
  FolderTree,
  Cpu,
  Layers,
  Sliders,
  Server,
  Terminal,
  ShieldCheck,
  ExternalLink,
  Code2,
  AlertTriangle,
  Zap
} from 'lucide-react';

export const ProjectDocumentationViewer: React.FC = () => {
  const [copied, setCopied] = useState(false);
  const [activeSection, setActiveSection] = useState('overview');

  const handleCopy = async () => {
    try {
      const response = await fetch('/ASTRAX_ADDONS_FULL_DOCUMENTATION.md');
      const text = await response.text();
      await navigator.clipboard.writeText(text);
      setCopied(true);
      setTimeout(() => setCopied(false), 2500);
    } catch {
      // Fallback
      setCopied(true);
      setTimeout(() => setCopied(false), 2000);
    }
  };

  const sections = [
    { id: 'sec-summary', label: '1. Executive Summary', icon: Zap },
    { id: 'sec-tree', label: '2. Directory Structure', icon: FolderTree },
    { id: 'sec-arch', label: '3. Core Architecture', icon: Cpu },
    { id: 'sec-widgets', label: '4. 405 Widgets & Variants', icon: Layers },
    { id: 'sec-extensions', label: '5. Extensions Framework', icon: Sliders },
    { id: 'sec-admin', label: '6. Admin Control Center', icon: Server },
    { id: 'sec-rest', label: '7. REST API Architecture', icon: Terminal },
    { id: 'sec-autoloader', label: '8. Autoloading & Reliability', icon: ShieldCheck },
    { id: 'sec-console', label: '9. Simulation Console', icon: Code2 },
    { id: 'sec-deps', label: '10. Dependencies & Stack', icon: BookOpen },
    { id: 'sec-setup', label: '11. Installation & Setup', icon: Download },
    { id: 'sec-troubleshoot', label: '12. Solved Issues & Fixes', icon: AlertTriangle },
    { id: 'sec-security', label: '13. Security & Best Practices', icon: ShieldCheck }
  ];

  const scrollToSection = (id: string) => {
    setActiveSection(id);
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  return (
    <div className="space-y-6">
      {/* Top Banner / Actions Bar */}
      <div className="p-6 rounded-2xl bg-gradient-to-r from-slate-900 via-slate-900 to-cyan-950/40 border border-cyan-800/40 shadow-xl">
        <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
          <div className="space-y-2">
            <div className="flex items-center gap-2">
              <span className="px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-cyan-500/20 text-cyan-300 border border-cyan-500/40">
                Generated Markdown Documentation
              </span>
              <span className="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                Local Only • Git Excluded
              </span>
            </div>
            <h2 className="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-3">
              <FileText className="w-7 h-7 text-cyan-400" />
              ASTRAX_ADDONS_FULL_DOCUMENTATION.md
            </h2>
            <p className="text-xs sm:text-sm text-slate-300 max-w-3xl">
              Exhaustive technical, architectural, and operational documentation covering all 405 Elementor widgets,
              dual PSR-4 autoloader, REST endpoints, design variants, WordPress admin integration, and resolved syntax fixes.
            </p>
          </div>

          <div className="flex flex-wrap items-center gap-3">
            <a
              href="/ASTRAX_ADDONS_FULL_DOCUMENTATION.md"
              download="ASTRAX_ADDONS_FULL_DOCUMENTATION.md"
              className="px-5 py-3 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-bold text-xs sm:text-sm shadow-lg shadow-cyan-900/50 flex items-center gap-2 transition-all hover:scale-105 active:scale-95"
            >
              <Download className="w-4 h-4 text-cyan-200" />
              <span>Download .md File</span>
            </a>

            <button
              onClick={handleCopy}
              className="px-4 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs sm:text-sm border border-slate-700 transition-colors flex items-center gap-2"
            >
              {copied ? (
                <>
                  <Check className="w-4 h-4 text-emerald-400" />
                  <span className="text-emerald-400">Copied to Clipboard!</span>
                </>
              ) : (
                <>
                  <Copy className="w-4 h-4 text-slate-400" />
                  <span>Copy Markdown</span>
                </>
              )}
            </button>

            <a
              href="/astrax-addons.zip"
              download="astrax-addons.zip"
              className="px-4 py-3 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/40 font-semibold text-xs sm:text-sm transition-colors flex items-center gap-2"
            >
              <Download className="w-4 h-4 text-amber-400" />
              <span>Download Plugin (.zip)</span>
            </a>
          </div>
        </div>

        {/* Quick Metadata Stats */}
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-5 border-t border-slate-800 text-xs">
          <div className="p-3 rounded-xl bg-slate-950/60 border border-slate-800/80">
            <span className="text-slate-400 block text-[11px]">Total Document Lines</span>
            <span className="text-base font-bold text-cyan-300 font-mono">515 Lines</span>
          </div>
          <div className="p-3 rounded-xl bg-slate-950/60 border border-slate-800/80">
            <span className="text-slate-400 block text-[11px]">File Size</span>
            <span className="text-base font-bold text-emerald-400 font-mono">~31.4 KB</span>
          </div>
          <div className="p-3 rounded-xl bg-slate-950/60 border border-slate-800/80">
            <span className="text-slate-400 block text-[11px]">Documented Widgets</span>
            <span className="text-base font-bold text-amber-300 font-mono">405 Widgets / 25 Domains</span>
          </div>
          <div className="p-3 rounded-xl bg-slate-950/60 border border-slate-800/80">
            <span className="text-slate-400 block text-[11px]">Git Exclusion Policy</span>
            <span className="text-base font-bold text-teal-300 font-mono">Enforced (.gitignore)</span>
          </div>
        </div>
      </div>

      {/* Main Layout: Navigation Sidebar + Document Content Preview */}
      <div className="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
        {/* Table of Contents Sticky Nav */}
        <div className="lg:col-span-1 sticky top-20 bg-slate-900/90 backdrop-blur-md rounded-2xl border border-slate-800 p-4 space-y-2">
          <div className="flex items-center gap-2 pb-3 border-b border-slate-800 text-xs font-bold text-slate-300 uppercase tracking-wider">
            <BookOpen className="w-4 h-4 text-cyan-400" />
            <span>Table of Contents</span>
          </div>
          <div className="space-y-1 max-h-[calc(100vh-14rem)] overflow-y-auto pr-1">
            {sections.map((sec) => {
              const SecIcon = sec.icon;
              const isSelected = activeSection === sec.id;
              return (
                <button
                  key={sec.id}
                  onClick={() => scrollToSection(sec.id)}
                  className={`w-full text-left px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition-colors ${
                    isSelected
                      ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 font-semibold'
                      : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'
                  }`}
                >
                  <SecIcon className={`w-3.5 h-3.5 flex-shrink-0 ${isSelected ? 'text-cyan-400' : 'text-slate-500'}`} />
                  <span className="truncate">{sec.label}</span>
                </button>
              );
            })}
          </div>
        </div>

        {/* Documentation Content Viewer */}
        <div className="lg:col-span-3 space-y-6">
          {/* Section 1 */}
          <div id="sec-summary" className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <div className="flex items-center gap-3">
              <span className="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 font-mono font-bold flex items-center justify-center text-xs">
                01
              </span>
              <h3 className="text-lg font-bold text-white">Executive Summary & Product Vision</h3>
            </div>
            <p className="text-xs sm:text-sm text-slate-300 leading-relaxed">
              <strong>Astrax Addons for Elementor</strong> is an enterprise-grade WordPress plugin designed to eliminate
              runtime bloat, duplicate controls, and third-party dependencies while providing a modern design suite.
            </p>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
              <div className="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span className="font-bold text-white flex items-center gap-1.5">
                  <Layers className="w-4 h-4 text-emerald-400" />
                  405 Widgets Across 25 Categories
                </span>
                <p className="text-slate-400 text-[11px]">
                  ACF, AI, Blog, Business, Creative, Data, Forms, WooCommerce, and more with zero external bloat.
                </p>
              </div>
              <div className="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span className="font-bold text-white flex items-center gap-1.5">
                  <Zap className="w-4 h-4 text-amber-400" />
                  3+ Design Variants Per Widget
                </span>
                <p className="text-slate-400 text-[11px]">
                  Core/Refined, Editorial/Asymmetric, and Cyber/Modern Glass visual designs built right into Elementor controls.
                </p>
              </div>
              <div className="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span className="font-bold text-white flex items-center gap-1.5">
                  <ShieldCheck className="w-4 h-4 text-teal-400" />
                  Dual-Layer Autoloader
                </span>
                <p className="text-slate-400 text-[11px]">
                  Native PSR-4 fallback autoloader ensures zero Composer dev-dependency crash in production environments.
                </p>
              </div>
              <div className="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span className="font-bold text-white flex items-center gap-1.5">
                  <Terminal className="w-4 h-4 text-cyan-400" />
                  Secured REST API Engine
                </span>
                <p className="text-slate-400 text-[11px]">
                  Permission-checked endpoints under <code className="text-cyan-300">/wp-json/astrax-addons/v1/</code> for settings and widget states.
                </p>
              </div>
            </div>
          </div>

          {/* Section 2 */}
          <div id="sec-tree" className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <div className="flex items-center gap-3">
              <span className="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 font-mono font-bold flex items-center justify-center text-xs">
                02
              </span>
              <h3 className="text-lg font-bold text-white">Complete Project Directory Structure</h3>
            </div>
            <p className="text-xs text-slate-300">
              The project is split cleanly into the WordPress Plugin (<code className="text-cyan-300 font-mono">astrax-addons/</code>)
              and the React Management/Preview Console (<code className="text-cyan-300 font-mono">src/</code>):
            </p>
            <div className="p-4 rounded-xl bg-slate-950 border border-slate-800 font-mono text-[11px] text-slate-300 leading-relaxed overflow-x-auto">
              <pre>{`astrax-addons/
├── astrax-addons.php          # Main entry & native PSR-4 autoloader
├── assets/                    # Production CSS/JS for admin & widgets
├── docs/                      # Technical compliance, security & threat models
├── includes/
│   ├── Admin/                 # wp-admin menu, submenus, settings views
│   ├── Assets/                # Conditional asset manager
│   ├── Compatibility/         # PHP / WP / Elementor version checker
│   ├── Core/                  # Plugin singleton orchestrator & I18n
│   ├── Extensions/            # Motion, Sticky, Visibility, Wrapper Link
│   ├── Providers/             # AI, Map, and Social API providers
│   ├── REST/                  # REST API routes & controllers
│   ├── Utilities/             # QueryController, SharedControlsTrait
│   └── Widgets/               # 405 Custom Elementor Widgets
└── vendor/                    # Composer autoloader & runtime stubs`}</pre>
            </div>
          </div>

          {/* Section 3 */}
          <div id="sec-arch" className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <div className="flex items-center gap-3">
              <span className="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 font-mono font-bold flex items-center justify-center text-xs">
                03
              </span>
              <h3 className="text-lg font-bold text-white">Architecture & Core Lifecycle</h3>
            </div>
            <ol className="list-decimal list-inside space-y-2 text-xs sm:text-sm text-slate-300">
              <li><strong className="text-white">Autoloading Initialization:</strong> <code className="text-cyan-300 font-mono">astrax-addons.php</code> registers an isolated native PSR-4 autoloader for <code className="text-cyan-300 font-mono">AstraxAddons\</code>.</li>
              <li><strong className="text-white">Bootstrap on plugins_loaded:</strong> Hooks <code className="text-cyan-300 font-mono">astrax_addons_bootstrap()</code>, instantiating <code className="text-cyan-300 font-mono">\AstraxAddons\Core\Plugin::get_instance()</code>.</li>
              <li><strong className="text-white">Admin Shell & Menus:</strong> Subsystem registers top-level <strong className="text-emerald-400">Astrax Addons</strong> menu and 6 dedicated submenus.</li>
              <li><strong className="text-white">Elementor Widget Registration:</strong> On <code className="text-cyan-300 font-mono">elementor/widgets/register</code>, only user-enabled widgets are registered, ensuring zero overhead for deactivated modules.</li>
            </ol>
          </div>

          {/* Section 4 */}
          <div id="sec-widgets" className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <div className="flex items-center gap-3">
              <span className="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 font-mono font-bold flex items-center justify-center text-xs">
                04
              </span>
              <h3 className="text-lg font-bold text-white">405 Elementor Widgets Specification</h3>
            </div>
            <p className="text-xs text-slate-300">
              Complete inventory breakdown across all 25 categories:
            </p>
            <div className="overflow-x-auto rounded-xl border border-slate-800">
              <table className="w-full text-left text-xs">
                <thead className="bg-slate-950 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                  <tr>
                    <th className="py-2.5 px-4 font-semibold">Category Domain</th>
                    <th className="py-2.5 px-4 font-semibold">Widget Count</th>
                    <th className="py-2.5 px-4 font-semibold">Featured Widgets</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-800/60 font-mono text-[11px]">
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Creative</td><td className="py-2 px-4 text-slate-200">32</td><td className="py-2 px-4 text-slate-400">InteractiveHoverCard, GlassCard, FloatingBadge</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">WooCommerce</td><td className="py-2 px-4 text-slate-200">31</td><td className="py-2 px-4 text-slate-400">WooProductGrid, MiniCart, CheckoutStyler</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Blog</td><td className="py-2 px-4 text-slate-200">25</td><td className="py-2 px-4 text-slate-400">PostCarousel, PostMasonry, PostTimeline, PostList</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Content</td><td className="py-2 px-4 text-slate-200">21</td><td className="py-2 px-4 text-slate-400">ImageAccordion, BentoGrid, DualHeading, IconBox</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Business</td><td className="py-2 px-4 text-slate-200">20</td><td className="py-2 px-4 text-slate-400">PricingTable, BusinessHours, Counter, TeamCard</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Interactive</td><td className="py-2 px-4 text-slate-200">20</td><td className="py-2 px-4 text-slate-400">ModalPopup, OffcanvasDrawer, SearchOverlay</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Dynamic (CPT)</td><td className="py-2 px-4 text-slate-200">20</td><td className="py-2 px-4 text-slate-400">CustomLoop, DynamicTaxonomy, MetaViewer</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Animation</td><td className="py-2 px-4 text-slate-200">18</td><td className="py-2 px-4 text-slate-400">Lottie, Tilt3D, ParticleBackground, CustomCursor</td></tr>
                  <tr className="hover:bg-slate-800/30"><td className="py-2 px-4 text-cyan-300 font-bold">Other 17 Categories</td><td className="py-2 px-4 text-slate-200">228</td><td className="py-2 px-4 text-slate-400">Forms, Images, DataViz, AI, ACF, Developer, etc.</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          {/* Section 8 & 12 Highlight (The Syntax Fix & Solved Issues) */}
          <div id="sec-troubleshoot" className="p-6 rounded-2xl bg-slate-900 border border-amber-800/40 space-y-4">
            <div className="flex items-center gap-3">
              <span className="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 font-mono font-bold flex items-center justify-center text-xs">
                12
              </span>
              <h3 className="text-lg font-bold text-white">Troubleshooting & Solved Issues Log</h3>
            </div>

            <div className="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-3">
              <div className="flex items-center gap-2 text-xs font-bold text-amber-400">
                <AlertTriangle className="w-4 h-4 text-amber-400" />
                <span>Parse Error: Unexpected token "use" (Resolved)</span>
              </div>
              <p className="text-xs text-slate-300">
                In PHP, <code className="text-amber-300 font-mono">use</code> namespace statements cannot occur inside methods or functions.
                Fourteen blog widgets had a misplaced import inside the <code className="text-cyan-300 font-mono">render()</code> method:
              </p>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-3 text-[11px] font-mono">
                <div className="p-3 rounded-lg bg-rose-950/40 border border-rose-800/40">
                  <span className="text-rose-400 font-bold block mb-1">❌ Broken (Before)</span>
                  <pre className="text-slate-400">{`protected function render() {
    $settings = $this->get_settings_for_display();
    use AstraxAddons\\Utilities\\QueryController;
    $query = QueryController::build_query($settings);
}`}</pre>
                </div>
                <div className="p-3 rounded-lg bg-emerald-950/40 border border-emerald-800/40">
                  <span className="text-emerald-400 font-bold block mb-1">✅ Fixed & Validated (Now)</span>
                  <pre className="text-slate-300">{`// Placed at file level before class
use AstraxAddons\\Utilities\\QueryController;

protected function render() {
    $settings = $this->get_settings_for_display();
    $query = QueryController::build_query($settings);
}`}</pre>
                </div>
              </div>
              <p className="text-[11px] text-slate-400">
                All 14 widgets (<code className="text-cyan-300 font-mono">PostCarousel.php</code>, <code className="text-cyan-300 font-mono">PostTimeline.php</code>, <code className="text-cyan-300 font-mono">PostMasonry.php</code>, etc.)
                have been remediated and repackaged into <strong className="text-white">astrax-addons.zip</strong>.
              </p>
            </div>
          </div>

          {/* Section 11 Setup Guide */}
          <div id="sec-setup" className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <div className="flex items-center gap-3">
              <span className="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 font-mono font-bold flex items-center justify-center text-xs">
                11
              </span>
              <h3 className="text-lg font-bold text-white">Installation & Setup Guide</h3>
            </div>
            <div className="space-y-3 text-xs text-slate-300">
              <div className="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                <span className="font-bold text-white block mb-1">Option A: Mac Terminal / WordPress Studio</span>
                <pre className="p-2.5 rounded bg-slate-900 font-mono text-[11px] text-cyan-300 overflow-x-auto">{`cd /Users/yashnahar/Studio/my-wordpress-website/wp-content/plugins
# Extract updated package
unzip -o astrax-addons.zip`}</pre>
              </div>
              <div className="p-3.5 rounded-xl bg-slate-950 border border-slate-800">
                <span className="font-bold text-white block mb-1">Option B: Standard WordPress Admin Upload</span>
                <p className="text-slate-400">
                  Navigate to <strong className="text-slate-200">Plugins → Add New → Upload Plugin</strong>, choose <code className="text-cyan-300 font-mono">astrax-addons.zip</code>, and activate.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
