import React from 'react';
import {
  Sparkles,
  Layers,
  Sliders,
  Settings as SettingsIcon,
  Server,
  Terminal,
  ShieldCheck,
  Zap,
  ArrowRight,
  ExternalLink,
  CheckCircle2,
  Code2,
  FileCheck2,
  Cpu,
  Palette,
  Eye,
  SlidersHorizontal,
  ChevronRight,
  HelpCircle,
  BookOpen,
  Github,
  Download,
  FileText
} from 'lucide-react';
import { AstraxWidget } from '../data/widgetsData';
import { AstraxExtension } from '../data/extensionsData';
import { SystemStatus } from '../data/systemData';

interface PluginHomeDashboardProps {
  widgets: AstraxWidget[];
  extensions: AstraxExtension[];
  systemInfo: SystemStatus;
  onNavigateTab: (tabId: string) => void;
  onToggleWidget: (slug: string) => void;
}

export const PluginHomeDashboard: React.FC<PluginHomeDashboardProps> = ({
  widgets,
  extensions,
  systemInfo,
  onNavigateTab,
  onToggleWidget
}) => {
  const enabledWidgetsCount = widgets.filter((w) => w.enabled).length;
  const enabledExtensionsCount = extensions.filter((e) => e.enabled).length;

  // Key featured widgets for quick toggle on Home
  const featuredWidgets = widgets.filter((w) =>
    ['image-accordion', 'advanced-heading', 'advanced-button', 'bento-grid', 'pricing-table', 'info-box'].includes(w.slug)
  );

  return (
    <div className="space-y-8">
      {/* ================= HERO WELCOME CONTROL CENTER BANNER ================= */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900 to-emerald-950 border border-emerald-500/30 p-8 sm:p-10 shadow-2xl">
        <div className="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none -mr-20 -mt-20" />
        <div className="absolute bottom-0 left-1/3 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none" />

        <div className="relative z-10 max-w-4xl space-y-6">
          <div className="flex flex-wrap items-center gap-3">
            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
              <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" />
              Plugin Active & Healthy
            </span>
            <span className="px-2.5 py-0.5 rounded-full text-xs font-mono text-slate-400 bg-slate-800 border border-slate-700">
              Version 1.0.0
            </span>
            <span className="px-2.5 py-0.5 rounded-full text-xs font-medium text-emerald-400 bg-emerald-950/60 border border-emerald-800/60">
              Elementor 3.24+ Verified
            </span>
          </div>

          <div className="space-y-2">
            <h1 className="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
              Welcome to the <span className="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">Astrax Addons</span> Control Center
            </h1>
            <p className="text-slate-300 text-sm sm:text-base leading-relaxed max-w-3xl">
              An original, production-grade Elementor extension suite engineered with 405 registered widgets, 4 cross-cutting advanced extensions, zero runtime bloat, and a minimum of 3 design variations for every visual component.
            </p>
          </div>

          {/* Quick Action Buttons */}
          <div className="flex flex-wrap items-center gap-3 pt-2">
            <button
              onClick={() => onNavigateTab('tracker')}
              className="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg shadow-indigo-900/40 flex items-center gap-2 transition-all hover:scale-105 active:scale-95"
            >
              <CheckCircle2 className="w-4 h-4 text-emerald-300" />
              <span>Implementation Tracker (Pipeline & Quality)</span>
              <ChevronRight className="w-3.5 h-3.5" />
            </button>

            <button
              onClick={() => onNavigateTab('showcase')}
              className="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-900/40 flex items-center gap-2 transition-all hover:scale-105 active:scale-95"
            >
              <Sparkles className="w-4 h-4 text-amber-300" />
              <span>Explore 3+ Variants</span>
            </button>

            <button
              onClick={() => onNavigateTab('widgets')}
              className="px-4 py-2.5 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-slate-200 font-semibold text-xs border border-slate-700 transition-colors flex items-center gap-2"
            >
              <Layers className="w-4 h-4 text-emerald-400" />
              <span>Manage 405 Widgets</span>
            </button>

            <button
              onClick={() => onNavigateTab('extensions')}
              className="px-4 py-2.5 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-slate-200 font-semibold text-xs border border-slate-700 transition-colors flex items-center gap-2"
            >
              <Sliders className="w-4 h-4 text-teal-400" />
              <span>Motion & Extensions</span>
            </button>

            <button
              onClick={() => onNavigateTab('rest-api')}
              className="px-4 py-2.5 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-slate-200 font-semibold text-xs border border-slate-700 transition-colors flex items-center gap-2"
            >
              <Terminal className="w-4 h-4 text-cyan-400" />
              <span>REST API Console</span>
            </button>

            <a
              href="/ASTRAX_ADDONS_FULL_DOCUMENTATION.md"
              download="ASTRAX_ADDONS_FULL_DOCUMENTATION.md"
              className="px-4 py-2.5 rounded-xl bg-cyan-500/20 hover:bg-cyan-500/30 text-cyan-300 border border-cyan-500/40 font-semibold text-xs transition-colors flex items-center gap-2 hover:border-cyan-400"
            >
              <FileText className="w-4 h-4 text-cyan-400" />
              <span>Download Docs (.md)</span>
            </a>

            <a
              href="/astrax-addons.zip"
              download="astrax-addons.zip"
              className="px-4 py-2.5 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/40 font-semibold text-xs transition-colors flex items-center gap-2 hover:border-amber-400"
            >
              <Download className="w-4 h-4 text-amber-400" />
              <span>Download Plugin (.zip)</span>
            </a>
          </div>
        </div>
      </div>

      {/* ================= SYSTEM OVERVIEW METRICS ================= */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {/* Metric 1 */}
        <div
          onClick={() => onNavigateTab('widgets')}
          className="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/50 transition-all cursor-pointer group"
        >
          <div className="flex items-center justify-between mb-3">
            <span className="text-xs font-semibold text-slate-400 uppercase tracking-wider">
              Active Widgets
            </span>
            <div className="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
              <Layers className="w-4 h-4" />
            </div>
          </div>
          <div className="flex items-baseline gap-2">
            <span className="text-3xl font-extrabold text-white">{enabledWidgetsCount}</span>
            <span className="text-xs text-slate-500">of {widgets.length} enabled</span>
          </div>
          <div className="mt-3 flex items-center gap-1.5 text-xs text-emerald-400 font-medium">
            <span>Configure Active Widgets</span>
            <ChevronRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
          </div>
        </div>

        {/* Metric 2 */}
        <div
          onClick={() => onNavigateTab('extensions')}
          className="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-teal-500/50 transition-all cursor-pointer group"
        >
          <div className="flex items-center justify-between mb-3">
            <span className="text-xs font-semibold text-slate-400 uppercase tracking-wider">
              Extensions
            </span>
            <div className="w-9 h-9 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center group-hover:scale-110 transition-transform">
              <Sliders className="w-4 h-4" />
            </div>
          </div>
          <div className="flex items-baseline gap-2">
            <span className="text-3xl font-extrabold text-white">{enabledExtensionsCount}</span>
            <span className="text-xs text-slate-500">/ {extensions.length} active</span>
          </div>
          <div className="mt-3 flex items-center gap-1.5 text-xs text-teal-400 font-medium">
            <span>Motion, Sticky, Visibility</span>
            <ChevronRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
          </div>
        </div>

        {/* Metric 3 */}
        <div
          onClick={() => onNavigateTab('showcase')}
          className="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-amber-500/50 transition-all cursor-pointer group"
        >
          <div className="flex items-center justify-between mb-3">
            <span className="text-xs font-semibold text-slate-400 uppercase tracking-wider">
              Design Variants
            </span>
            <div className="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
              <Palette className="w-4 h-4" />
            </div>
          </div>
          <div className="flex items-baseline gap-2">
            <span className="text-3xl font-extrabold text-white">3+</span>
            <span className="text-xs text-slate-500">per visual widget</span>
          </div>
          <div className="mt-3 flex items-center gap-1.5 text-xs text-amber-400 font-medium">
            <span>Core, Editorial & Cyber</span>
            <ChevronRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
          </div>
        </div>

        {/* Metric 4 */}
        <div
          onClick={() => onNavigateTab('system')}
          className="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-cyan-500/50 transition-all cursor-pointer group"
        >
          <div className="flex items-center justify-between mb-3">
            <span className="text-xs font-semibold text-slate-400 uppercase tracking-wider">
              System Health
            </span>
            <div className="w-9 h-9 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center group-hover:scale-110 transition-transform">
              <ShieldCheck className="w-4 h-4" />
            </div>
          </div>
          <div className="flex items-baseline gap-2">
            <span className="text-3xl font-extrabold text-emerald-400">100%</span>
            <span className="text-xs text-slate-500">All checks pass</span>
          </div>
          <div className="mt-3 flex items-center gap-1.5 text-xs text-cyan-400 font-medium">
            <span>WPCS 3.0 & PHP 8.2 Clean</span>
            <ChevronRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
          </div>
        </div>
      </div>

      {/* ================= TWO-COLUMN CORE HUB ================= */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {/* Left Column (8 cols): Quick Widget Control & Highlights */}
        <div className="lg:col-span-8 space-y-6">
          {/* Quick Widget Manager */}
          <div className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <div className="flex items-center justify-between">
              <div>
                <h3 className="text-base font-bold text-white flex items-center gap-2">
                  <Zap className="w-4 h-4 text-emerald-400" />
                  Quick Widget Toggles
                </h3>
                <p className="text-xs text-slate-400 mt-0.5">
                  Toggle high-frequency widgets directly from your home dashboard without navigating to Elementor.
                </p>
              </div>
              <button
                onClick={() => onNavigateTab('widgets')}
                className="text-xs text-emerald-400 hover:text-emerald-300 font-semibold flex items-center gap-1"
              >
                <span>View all 405</span>
                <ArrowRight className="w-3.5 h-3.5" />
              </button>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
              {featuredWidgets.map((w) => (
                <div
                  key={w.slug}
                  className="p-3.5 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between gap-3 hover:border-slate-700 transition-colors"
                >
                  <div className="space-y-0.5">
                    <span className="text-xs font-semibold text-white block">{w.name}</span>
                    <span className="text-[10px] text-emerald-400/90 font-medium">{w.category}</span>
                  </div>

                  <button
                    onClick={() => onToggleWidget(w.slug)}
                    role="switch"
                    aria-checked={w.enabled}
                    className={`relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none ${
                      w.enabled ? 'bg-emerald-600' : 'bg-slate-800'
                    }`}
                  >
                    <span
                      className={`pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out ${
                        w.enabled ? 'translate-x-4' : 'translate-x-0'
                      }`}
                    />
                  </button>
                </div>
              ))}
            </div>
          </div>

          {/* Core Feature Pillars */}
          <div className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <h3 className="text-base font-bold text-white flex items-center gap-2">
              <Sparkles className="w-4 h-4 text-amber-400" />
              Why Astrax Addons?
            </h3>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div className="p-4 rounded-xl bg-slate-950/60 border border-slate-800/80 space-y-2">
                <div className="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-xs">
                  01
                </div>
                <h4 className="text-sm font-bold text-white">3+ Variants / Widget</h4>
                <p className="text-xs text-slate-400 leading-relaxed">
                  Every widget contains at least 3 genuinely different layouts (Refined, Editorial, Cyber Glass) to avoid repetitive site designs.
                </p>
              </div>

              <div className="p-4 rounded-xl bg-slate-950/60 border border-slate-800/80 space-y-2">
                <div className="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-400 flex items-center justify-center font-bold text-xs">
                  02
                </div>
                <h4 className="text-sm font-bold text-white">Zero Runtime Bloat</h4>
                <p className="text-xs text-slate-400 leading-relaxed">
                  Dynamic conditional asset enqueuing. CSS and JS for a widget are loaded ONLY if that widget is physically rendered on the page.
                </p>
              </div>

              <div className="p-4 rounded-xl bg-slate-950/60 border border-slate-800/80 space-y-2">
                <div className="w-8 h-8 rounded-lg bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-bold text-xs">
                  03
                </div>
                <h4 className="text-sm font-bold text-white">Enterprise Security</h4>
                <p className="text-xs text-slate-400 leading-relaxed">
                  Strict context escaping (<code className="text-emerald-400">esc_html</code>, <code className="text-emerald-400">wp_kses</code>), CSRF nonce verification, and capability gates.
                </p>
              </div>
            </div>
          </div>
        </div>

        {/* Right Column (4 cols): Quick Links, Documentation & Feed */}
        <div className="lg:col-span-4 space-y-6">
          {/* Quick Navigation Card */}
          <div className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-3">
            <h3 className="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
              Plugin Control Links
            </h3>

            {[
              { label: '3+ Design Variants Showcase', tab: 'showcase', icon: Sparkles, desc: 'Interactive preview & settings' },
              { label: 'Audit & Remediation Report', tab: 'audit', icon: FileCheck2, desc: 'Full WPCS & security audit' },
              { label: 'REST API Console & History', tab: 'rest-api', icon: Terminal, desc: 'Test live endpoints with 5-call history' },
              { label: 'Global API & Asset Settings', tab: 'settings', icon: SettingsIcon, desc: 'Google Maps, AI, caching' },
              { label: 'System Health & Compliance', tab: 'system', icon: Server, desc: 'PHP, Elementor & memory limits' }
            ].map((item, i) => {
              const Icon = item.icon;
              return (
                <button
                  key={i}
                  onClick={() => onNavigateTab(item.tab)}
                  className="w-full p-3 rounded-xl bg-slate-950/70 border border-slate-800/80 hover:border-emerald-500/40 hover:bg-slate-800/50 transition-all text-left flex items-center justify-between group"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-8 h-8 rounded-lg bg-slate-800 text-slate-300 flex items-center justify-center group-hover:text-emerald-400 group-hover:bg-emerald-500/10 transition-colors">
                      <Icon className="w-4 h-4" />
                    </div>
                    <div>
                      <span className="text-xs font-bold text-white block group-hover:text-emerald-300 transition-colors">
                        {item.label}
                      </span>
                      <span className="text-[11px] text-slate-500">{item.desc}</span>
                    </div>
                  </div>
                  <ChevronRight className="w-4 h-4 text-slate-500 group-hover:translate-x-1 group-hover:text-emerald-400 transition-all" />
                </button>
              );
            })}
          </div>

          {/* Version & Release Status */}
          <div className="p-6 rounded-2xl bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 space-y-3 text-xs">
            <div className="flex items-center justify-between pb-3 border-b border-slate-800">
              <span className="font-bold text-white">Changelog & Version</span>
              <span className="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400">
                v1.0.0 Stable
              </span>
            </div>

            <ul className="space-y-2 text-slate-400">
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-3.5 h-3.5 text-emerald-400 flex-shrink-0 mt-0.5" />
                <span>405 Elementor widgets registered across 18 specialized categories.</span>
              </li>
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-3.5 h-3.5 text-emerald-400 flex-shrink-0 mt-0.5" />
                <span>Mandatory 3+ design variations system implemented per visual widget.</span>
              </li>
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-3.5 h-3.5 text-emerald-400 flex-shrink-0 mt-0.5" />
                <span>REST API endpoints equipped with Nonce validation & permission barriers.</span>
              </li>
            </ul>

            <div className="pt-3 border-t border-slate-800 text-[11px] text-slate-500">
              GPL-2.0+ Licensed • Zero External Telemetry
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
