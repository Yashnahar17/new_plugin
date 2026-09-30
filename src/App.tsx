import React, { useState } from 'react';
import {
  Home,
  Layers,
  Sparkles,
  Sliders,
  Settings as SettingsIcon,
  Server,
  Terminal,
  Search,
  CheckCircle2,
  Shield,
  Zap,
  Check,
  RefreshCw,
  FileCheck2,
  TableProperties,
  History,
  Play,
  Trash2,
  Clock,
  Copy,
  SlidersHorizontal,
  ChevronRight,
  Database,
  Monitor,
  LayoutTemplate,
  FileText,
  Download
} from 'lucide-react';
import { INITIAL_WIDGETS, WIDGET_CATEGORIES, AstraxWidget } from './data/widgetsData';
import { INITIAL_EXTENSIONS, AstraxExtension } from './data/extensionsData';
import { INITIAL_SYSTEM_INFO, COMPATIBILITY_MATRIX } from './data/systemData';
import { PluginHomeDashboard } from './components/PluginHomeDashboard';
import { WordPressAdminShell } from './components/WordPressAdminShell';
import { ImageAccordionWidget } from './components/widgets/ImageAccordionWidget';
import { AdvancedHeadingWidget } from './components/widgets/AdvancedHeadingWidget';
import { AdvancedButtonWidget } from './components/widgets/AdvancedButtonWidget';
import { IconBoxWidget } from './components/widgets/IconBoxWidget';
import { InfoBoxWidget } from './components/widgets/InfoBoxWidget';
import { PostGridWidget } from './components/widgets/PostGridWidget';
import { WooProductGridWidget } from './components/widgets/WooProductGridWidget';
import { WooProductCarouselWidget } from './components/widgets/WooProductCarouselWidget';
import { WidgetImplementationTracker } from './components/WidgetImplementationTracker';
import { ProjectDocumentationViewer } from './components/ProjectDocumentationViewer';

type Tab = 'home' | 'tracker' | 'showcase' | 'audit' | 'widgets' | 'extensions' | 'settings' | 'system' | 'rest-api' | 'docs';

export interface RequestHistoryItem {
  id: string;
  endpoint: string;
  method: 'GET' | 'POST';
  timestamp: string;
  status: number;
  latency: number;
  bodyPreview?: string;
}

export default function App() {
  const [activeTab, setActiveTab] = useState<Tab>('home');
  const [isWpAdminView, setIsWpAdminView] = useState<boolean>(true);
  const [widgets, setWidgets] = useState<AstraxWidget[]>(INITIAL_WIDGETS);
  const [extensions, setExtensions] = useState<AstraxExtension[]>(INITIAL_EXTENSIONS);
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedCategory, setSelectedCategory] = useState<string>('All');
  const [showcaseWidget, setShowcaseWidget] = useState<
    'heading' | 'button' | 'accordion' | 'iconbox' | 'infobox' | 'postgrid' | 'woo-grid' | 'woo-carousel' | 'pricing'
  >('heading');

  // Settings State
  const [settings, setSettings] = useState({
    googleMapsApiKey: '',
    osmTileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    aiProvider: 'gemini',
    assetCache: true,
    loadFontAwesome: true,
    cleanDom: true
  });
  const [settingsSaved, setSettingsSaved] = useState(false);

  // REST API Tester State
  const [restEndpoint, setRestEndpoint] = useState<string>('widgets');
  const [restMethod, setRestMethod] = useState<'GET' | 'POST'>('GET');
  const [restResponse, setRestResponse] = useState<string>('');
  const [restLoading, setRestLoading] = useState(false);
  const [restLatency, setRestLatency] = useState<number | null>(null);
  const [copiedResponse, setCopiedResponse] = useState(false);

  // REST API History State (strictly capped to last 5 executed requests)
  const [requestHistory, setRequestHistory] = useState<RequestHistoryItem[]>([
    {
      id: 'req-init-1',
      endpoint: 'widgets',
      method: 'GET',
      timestamp: '10:36:12 AM',
      status: 200,
      latency: 52,
      bodyPreview: 'All 405 widgets retrieved'
    },
    {
      id: 'req-init-2',
      endpoint: 'system',
      method: 'GET',
      timestamp: '10:35:40 AM',
      status: 200,
      latency: 38,
      bodyPreview: 'System health & specs'
    },
    {
      id: 'req-init-3',
      endpoint: 'extensions',
      method: 'GET',
      timestamp: '10:34:10 AM',
      status: 200,
      latency: 44,
      bodyPreview: '4 extensions state'
    },
    {
      id: 'req-init-4',
      endpoint: 'settings',
      method: 'GET',
      timestamp: '10:32:05 AM',
      status: 200,
      latency: 49,
      bodyPreview: 'Global plugin options'
    },
    {
      id: 'req-init-5',
      endpoint: 'widgets',
      method: 'POST',
      timestamp: '10:30:19 AM',
      status: 200,
      latency: 65,
      bodyPreview: 'Toggle widget status'
    }
  ]);

  // Filtered widgets
  const filteredWidgets = widgets.filter((w) => {
    const matchesSearch =
      w.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      w.description.toLowerCase().includes(searchQuery.toLowerCase()) ||
      w.category.toLowerCase().includes(searchQuery.toLowerCase());
    const matchesCategory =
      selectedCategory === 'All'
        ? true
        : selectedCategory === 'Featured'
        ? w.isPopular
        : w.category === selectedCategory;
    return matchesSearch && matchesCategory;
  });

  const enabledCount = widgets.filter((w) => w.enabled).length;
  const enabledExtensionsCount = extensions.filter((e) => e.enabled).length;

  const toggleWidget = (slug: string) => {
    setWidgets((prev) =>
      prev.map((w) => (w.slug === slug ? { ...w, enabled: !w.enabled } : w))
    );
  };

  const toggleAllWidgets = (enable: boolean) => {
    setWidgets((prev) => prev.map((w) => ({ ...w, enabled: enable })));
  };

  const toggleExtension = (slug: string) => {
    setExtensions((prev) =>
      prev.map((e) => (e.slug === slug ? { ...e, enabled: !e.enabled } : e))
    );
  };

  const handleSaveSettings = (e: React.FormEvent) => {
    e.preventDefault();
    setSettingsSaved(true);
    setTimeout(() => setSettingsSaved(false), 3000);
  };

  // REST API execution
  const executeRestCall = (customEndpoint?: string, customMethod?: 'GET' | 'POST') => {
    const ep = customEndpoint || restEndpoint;
    const method = customMethod || restMethod;
    if (customEndpoint) setRestEndpoint(customEndpoint);
    if (customMethod) setRestMethod(customMethod);

    setRestLoading(true);
    setRestLatency(null);
    const start = performance.now();

    setTimeout(() => {
      let data: any;
      let summary = '';
      if (ep === 'widgets') {
        if (method === 'GET') {
          data = widgets.map((w) => ({
            slug: w.slug,
            name: w.name,
            category: w.category,
            enabled: w.enabled
          }));
          summary = `${widgets.length} widgets retrieved`;
        } else {
          data = {
            success: true,
            message: 'Widget toggled via REST API.',
            timestamp: new Date().toISOString()
          };
          summary = 'Widget status toggled';
        }
      } else if (ep === 'extensions') {
        data = extensions;
        summary = `${extensions.length} extensions retrieved`;
      } else if (ep === 'settings') {
        data = settings;
        summary = 'Global settings retrieved';
      } else if (ep === 'system') {
        data = {
          ...INITIAL_SYSTEM_INFO,
          active_widgets: enabledCount,
          active_extensions: enabledExtensionsCount
        };
        summary = 'System health & specs';
      }

      const calculatedLatency = Math.round(performance.now() - start + 42);
      setRestResponse(JSON.stringify(data, null, 2));
      setRestLatency(calculatedLatency);
      setRestLoading(false);

      // Prepend to history & maintain strictly the last 5 executed requests
      const newItem: RequestHistoryItem = {
        id: `req-${Date.now()}`,
        endpoint: ep,
        method: method,
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }),
        status: 200,
        latency: calculatedLatency,
        bodyPreview: summary
      };

      setRequestHistory((prev) => [newItem, ...prev.slice(0, 4)]);
    }, 160);
  };

  const handleReRun = (item: RequestHistoryItem) => {
    executeRestCall(item.endpoint, item.method);
  };

  const clearHistory = () => {
    setRequestHistory([]);
  };

  const copyToClipboard = () => {
    if (!restResponse) return;
    navigator.clipboard.writeText(restResponse);
    setCopiedResponse(true);
    setTimeout(() => setCopiedResponse(false), 2000);
  };

  // The Inner Dashboard Content
  const dashboardContent = (
    <div className="space-y-6">
      {/* View Switcher Ribbon */}
      <div className="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-slate-800/80">
        <div className="flex items-center gap-2 text-xs">
          <span className="text-slate-400">View Mode:</span>
          <div className="flex bg-slate-900 rounded-lg p-0.5 border border-slate-800">
            <button
              onClick={() => setIsWpAdminView(true)}
              className={`px-3 py-1 rounded-md text-xs font-semibold flex items-center gap-1.5 transition-colors ${
                isWpAdminView ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200'
              }`}
            >
              <LayoutTemplate className="w-3.5 h-3.5" />
              <span>WordPress Admin Panel View</span>
            </button>
            <button
              onClick={() => setIsWpAdminView(false)}
              className={`px-3 py-1 rounded-md text-xs font-semibold flex items-center gap-1.5 transition-colors ${
                !isWpAdminView ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200'
              }`}
            >
              <Monitor className="w-3.5 h-3.5" />
              <span>Full Canvas View</span>
            </button>
          </div>
        </div>

        {/* Tab Badges */}
        <div className="flex items-center gap-2 text-xs text-slate-400">
          <span>Active Section:</span>
          <span className="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold capitalize">
            {activeTab === 'home'
              ? 'Home / Dashboard'
              : activeTab === 'tracker'
              ? 'Implementation Tracker'
              : activeTab === 'showcase'
              ? '3+ Variants Showcase'
              : activeTab === 'rest-api'
              ? 'REST API Console'
              : activeTab}
          </span>
        </div>
      </div>

      {/* ================= TAB 1: HOME / DEDICATED PLUGIN DASHBOARD ================= */}
      {activeTab === 'home' && (
        <PluginHomeDashboard
          widgets={widgets}
          extensions={extensions}
          systemInfo={INITIAL_SYSTEM_INFO}
          onNavigateTab={(tab) => setActiveTab(tab as Tab)}
          onToggleWidget={toggleWidget}
        />
      )}

      {/* ================= TAB: WIDGET IMPLEMENTATION TRACKER ================= */}
      {activeTab === 'tracker' && (
        <WidgetImplementationTracker
          onNavigateToShowcase={(slug) => {
            if (slug.includes('heading')) setShowcaseWidget('heading');
            else if (slug.includes('button')) setShowcaseWidget('button');
            else if (slug.includes('accordion')) setShowcaseWidget('accordion');
            else if (slug.includes('icon-box')) setShowcaseWidget('iconbox');
            else if (slug.includes('info-box')) setShowcaseWidget('infobox');
            else if (slug.includes('post-grid')) setShowcaseWidget('postgrid');
            else if (slug.includes('woo-product-grid')) setShowcaseWidget('woo-grid');
            else if (slug.includes('woo-product-carousel')) setShowcaseWidget('woo-carousel');
            setActiveTab('showcase');
          }}
        />
      )}

      {/* ================= TAB 2: LIVE SHOWCASE & 3+ DESIGN VARIANTS ================= */}
      {activeTab === 'showcase' && (
        <div className="space-y-6">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900/60 p-6 rounded-2xl border border-slate-800">
            <div>
              <div className="flex items-center gap-2">
                <Sparkles className="w-5 h-5 text-amber-400" />
                <h2 className="text-xl font-bold text-white">Interactive 3+ Design Variants Playground</h2>
              </div>
              <p className="text-sm text-slate-400 mt-1">
                Group 1 Flagship Widgets — live interactive testing for Variant 1 (Core Refined), Variant 2 (Editorial Asymmetric), and Variant 3 (Cyber / Modern Glass).
              </p>
            </div>

            {/* Widget Selector Pills: All 8 Group 1 Flagships */}
            <div className="flex flex-wrap gap-2">
              {[
                { id: 'heading', label: 'Advanced Heading' },
                { id: 'button', label: 'Advanced Button' },
                { id: 'accordion', label: 'Image Accordion' },
                { id: 'iconbox', label: 'Icon Box' },
                { id: 'infobox', label: 'Info Box' },
                { id: 'postgrid', label: 'Post Grid' },
                { id: 'woo-grid', label: 'Woo Product Grid' },
                { id: 'woo-carousel', label: 'Woo Carousel' },
                { id: 'pricing', label: 'Pricing Table' }
              ].map((item) => (
                <button
                  key={item.id}
                  onClick={() => setShowcaseWidget(item.id as any)}
                  className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all ${
                    showcaseWidget === item.id
                      ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40'
                      : 'bg-slate-800 text-slate-300 hover:bg-slate-700'
                  }`}
                >
                  {item.label}
                </button>
              ))}
            </div>
          </div>

          <div className="p-6 rounded-2xl bg-slate-900/80 border border-slate-800 shadow-2xl">
            {showcaseWidget === 'heading' && <AdvancedHeadingWidget />}
            {showcaseWidget === 'button' && <AdvancedButtonWidget />}
            {showcaseWidget === 'accordion' && <ImageAccordionWidget />}
            {showcaseWidget === 'iconbox' && <IconBoxWidget />}
            {showcaseWidget === 'infobox' && <InfoBoxWidget />}
            {showcaseWidget === 'postgrid' && <PostGridWidget />}
            {showcaseWidget === 'woo-grid' && <WooProductGridWidget />}
            {showcaseWidget === 'woo-carousel' && <WooProductCarouselWidget />}
            {showcaseWidget === 'pricing' && (
              <div className="p-6 space-y-6">
                <div className="text-center max-w-xl mx-auto space-y-2">
                  <span className="text-xs font-semibold text-emerald-400 uppercase tracking-widest">
                    Transparent Pricing
                  </span>
                  <h3 className="text-3xl font-extrabold text-white">Astrax License Options</h3>
                  <p className="text-xs text-slate-400">Choose the license that matches your agency or personal project scale.</p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                  {[
                    {
                      name: 'Single Site',
                      price: '$49',
                      period: '/ year',
                      desc: 'Perfect for single production WordPress sites.',
                      features: ['All 405 Widgets', '1 Year Updates & Support', '4 Core Extensions', 'Template Library']
                    },
                    {
                      name: 'Agency Unlimited',
                      price: '$149',
                      period: '/ year',
                      popular: true,
                      desc: 'Uncapped activations for client web agencies.',
                      features: ['Unlimited Domain Activations', 'Priority Support', 'White-Label Branding', 'All Future Pro Widgets']
                    },
                    {
                      name: 'Lifetime Enterprise',
                      price: '$399',
                      period: 'one-time',
                      desc: 'Perpetual access with zero recurring billing.',
                      features: ['Lifetime Updates', 'VIP Slack Support', 'Source Code Access', 'Commercial Redistribution License']
                    }
                  ].map((tier, i) => (
                    <div
                      key={i}
                      className={`p-6 rounded-2xl flex flex-col justify-between border relative ${
                        tier.popular
                          ? 'bg-gradient-to-b from-slate-900 to-slate-950 border-emerald-500 shadow-xl shadow-emerald-950/40 ring-1 ring-emerald-500/50'
                          : 'bg-slate-900/80 border-slate-800'
                      }`}
                    >
                      {tier.popular && (
                        <span className="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-slate-950 uppercase tracking-wide">
                          Most Popular
                        </span>
                      )}
                      <div>
                        <h4 className="text-base font-bold text-white">{tier.name}</h4>
                        <p className="text-xs text-slate-400 mt-1">{tier.desc}</p>
                        <div className="my-5">
                          <span className="text-3xl font-extrabold text-white">{tier.price}</span>
                          <span className="text-xs text-slate-400 ml-1">{tier.period}</span>
                        </div>
                        <ul className="space-y-2 text-xs text-slate-300">
                          {tier.features.map((f, idx) => (
                            <li key={idx} className="flex items-center gap-2">
                              <Check className="w-3.5 h-3.5 text-emerald-400" />
                              <span>{f}</span>
                            </li>
                          ))}
                        </ul>
                      </div>
                      <div className="pt-6">
                        <button
                          className={`w-full py-2.5 rounded-xl text-xs font-semibold transition-all ${
                            tier.popular
                              ? 'bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-900/30'
                              : 'bg-slate-800 hover:bg-slate-700 text-slate-200'
                          }`}
                        >
                          Choose {tier.name}
                        </button>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}
          </div>
        </div>
      )}

      {/* ================= TAB 3: REST API CONSOLE WITH REQUEST HISTORY ================= */}
      {activeTab === 'rest-api' && (
        <div className="space-y-6">
          <div className="bg-slate-900/60 p-6 rounded-2xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <div className="flex items-center gap-2">
                <Terminal className="w-5 h-5 text-emerald-400" />
                <h2 className="text-xl font-bold text-white">WordPress REST API Console</h2>
              </div>
              <p className="text-sm text-slate-400 mt-1">
                Execute requests against Astrax controllers with a persistent history sidebar of the last 5 executed queries for one-click re-runs.
              </p>
            </div>

            <div className="flex items-center gap-2">
              <span className="px-2.5 py-1 rounded-lg text-xs font-mono bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                /wp-json/astrax-addons/v1/
              </span>
            </div>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {/* SIDEBAR: LAST 5 EXECUTED REQUESTS */}
            <div className="lg:col-span-3 p-5 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col justify-between space-y-4">
              <div className="space-y-4">
                <div className="flex items-center justify-between pb-3 border-b border-slate-800">
                  <div className="flex items-center gap-2">
                    <History className="w-4 h-4 text-emerald-400" />
                    <h3 className="text-xs font-bold text-white uppercase tracking-wider">
                      Request History
                    </h3>
                  </div>
                  <span className="px-1.5 py-0.5 rounded text-[10px] font-mono font-semibold bg-slate-800 text-slate-300">
                    {requestHistory.length}/5
                  </span>
                </div>

                {requestHistory.length === 0 ? (
                  <div className="text-center py-10 px-4 text-slate-500 text-xs">
                    <p>No recent requests.</p>
                    <p className="text-[11px] mt-1 text-slate-600">Execute a request to track it here.</p>
                  </div>
                ) : (
                  <div className="space-y-2.5">
                    {requestHistory.map((item, idx) => {
                      const isCurrentActive = restEndpoint === item.endpoint && restMethod === item.method;
                      return (
                        <div
                          key={item.id}
                          className={`group relative p-3 rounded-xl border transition-all text-xs cursor-pointer ${
                            isCurrentActive
                              ? 'bg-slate-800/90 border-emerald-500/50 shadow-md shadow-emerald-950/20'
                              : 'bg-slate-950/70 border-slate-800/80 hover:border-slate-700 hover:bg-slate-900'
                          }`}
                          onClick={() => handleReRun(item)}
                          title="Click to re-run this request"
                        >
                          <div className="flex items-center justify-between mb-1.5">
                            <span
                              className={`px-1.5 py-0.5 rounded text-[10px] font-mono font-bold ${
                                item.method === 'GET'
                                  ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'
                                  : 'bg-amber-500/20 text-amber-300 border border-amber-500/30'
                              }`}
                            >
                              {item.method}
                            </span>
                            <div className="flex items-center gap-1.5 text-[10px] text-slate-400 font-mono">
                              <Clock className="w-3 h-3 text-slate-500" />
                              <span>{item.timestamp}</span>
                            </div>
                          </div>

                          <div className="flex items-center justify-between gap-1">
                            <span className="font-mono text-slate-200 font-medium text-[11px] truncate">
                              /{item.endpoint}
                            </span>
                            <span className="text-[10px] font-mono text-emerald-400 font-semibold">
                              {item.latency}ms
                            </span>
                          </div>

                          {item.bodyPreview && (
                            <p className="text-[10px] text-slate-500 truncate mt-1">
                              {item.bodyPreview}
                            </p>
                          )}

                          <div className="mt-2 pt-2 border-t border-slate-800/60 flex items-center justify-between">
                            <span className="text-[10px] text-slate-500">#{idx + 1}</span>
                            <button
                              type="button"
                              onClick={(e) => {
                                e.stopPropagation();
                                handleReRun(item);
                              }}
                              className="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-600/30 text-emerald-300 hover:bg-emerald-600 hover:text-white transition-colors"
                            >
                              <Play className="w-2.5 h-2.5 fill-current" />
                              <span>Re-run</span>
                            </button>
                          </div>
                        </div>
                      );
                    })}
                  </div>
                )}
              </div>

              {requestHistory.length > 0 && (
                <button
                  onClick={clearHistory}
                  className="w-full py-1.5 rounded-lg text-[11px] font-medium text-slate-400 hover:text-rose-300 hover:bg-rose-500/10 border border-transparent hover:border-rose-500/30 transition-colors flex items-center justify-center gap-1.5"
                >
                  <Trash2 className="w-3 h-3" />
                  <span>Clear History</span>
                </button>
              )}
            </div>

            {/* CENTER: REQUEST CONFIGURATION PANEL */}
            <div className="lg:col-span-4 p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5">
              <div className="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 className="text-xs font-bold text-slate-300 uppercase tracking-wider">
                  Request Parameters
                </h3>
                <span className="text-[10px] text-slate-500">RestManager.php</span>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1.5">
                  Controller Route
                </label>
                <select
                  value={restEndpoint}
                  onChange={(e) => setRestEndpoint(e.target.value)}
                  className="w-full px-3 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-xs text-slate-200 focus:outline-none focus:border-emerald-500 transition-colors font-mono"
                >
                  <option value="widgets">/wp-json/astrax-addons/v1/widgets</option>
                  <option value="extensions">/wp-json/astrax-addons/v1/extensions</option>
                  <option value="settings">/wp-json/astrax-addons/v1/settings</option>
                  <option value="system">/wp-json/astrax-addons/v1/system</option>
                </select>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1.5">HTTP Method</label>
                <div className="flex bg-slate-800 rounded-lg p-0.5 border border-slate-700">
                  {(['GET', 'POST'] as const).map((m) => (
                    <button
                      key={m}
                      onClick={() => setRestMethod(m)}
                      className={`flex-1 py-1.5 rounded-md text-xs font-semibold transition-all ${
                        restMethod === m ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200'
                      }`}
                    >
                      {m}
                    </button>
                  ))}
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1.5">Security Headers</label>
                <div className="p-3 rounded-xl bg-slate-950 font-mono text-[11px] text-slate-400 space-y-1.5 border border-slate-800/80">
                  <div className="text-emerald-400">X-WP-Nonce: astrax_secure_nonce_1a89c</div>
                  <div>Content-Type: application/json</div>
                  <div>Accept: application/json</div>
                </div>
              </div>

              {restMethod === 'POST' && (
                <div>
                  <label className="block text-xs font-semibold text-slate-300 mb-1.5">
                    Request Body (JSON)
                  </label>
                  <textarea
                    readOnly
                    rows={3}
                    value={
                      restEndpoint === 'widgets'
                        ? JSON.stringify({ widget: 'image-accordion', enabled: true }, null, 2)
                        : restEndpoint === 'extensions'
                        ? JSON.stringify({ extension: 'motion', enabled: true }, null, 2)
                        : JSON.stringify({ google_maps_api_key: 'AIzaSy...', cache_assets: true }, null, 2)
                    }
                    className="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 font-mono text-[11px] text-slate-300 focus:outline-none"
                  />
                </div>
              )}

              <button
                onClick={() => executeRestCall()}
                disabled={restLoading}
                className="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-lg shadow-emerald-900/30 flex items-center justify-center gap-2 transition-all hover:gap-3"
              >
                {restLoading ? (
                  <>
                    <RefreshCw className="w-4 h-4 animate-spin" />
                    <span>Sending Request...</span>
                  </>
                ) : (
                  <>
                    <Terminal className="w-4 h-4" />
                    <span>Execute REST Call</span>
                  </>
                )}
              </button>
            </div>

            {/* RIGHT: RESPONSE VIEWER & INSPECTOR */}
            <div className="lg:col-span-5 p-6 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col justify-between space-y-4">
              <div>
                <div className="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                  <div className="flex items-center gap-2">
                    <span className="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                      200 OK
                    </span>
                    <span className="text-xs font-mono text-slate-300">
                      /wp-json/astrax-addons/v1/{restEndpoint}
                    </span>
                  </div>

                  <div className="flex items-center gap-3">
                    {restLatency !== null && (
                      <span className="text-xs text-slate-400 font-mono">{restLatency} ms</span>
                    )}
                    <button
                      onClick={copyToClipboard}
                      disabled={!restResponse}
                      className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors"
                      title="Copy Response JSON"
                    >
                      {copiedResponse ? (
                        <>
                          <Check className="w-3 h-3 text-emerald-400" />
                          <span className="text-emerald-400">Copied!</span>
                        </>
                      ) : (
                        <>
                          <Copy className="w-3 h-3" />
                          <span>Copy</span>
                        </>
                      )}
                    </button>
                  </div>
                </div>

                <div className="bg-slate-950 rounded-xl p-4 font-mono text-xs text-emerald-400 overflow-x-auto max-h-[440px] scrollbar-thin border border-slate-800/80">
                  <pre>
                    {restResponse ||
                      '// Click "Execute REST Call" or choose a request from the History Sidebar to inspect results.'}
                  </pre>
                </div>
              </div>

              <div className="pt-3 border-t border-slate-800/80 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Controller: \AstraxAddons\REST\RestManager</span>
                <span>Auth: current_user_can('manage_options')</span>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* ================= TAB 4: AUDIT & REMEDIATION REPORT ================= */}
      {activeTab === 'audit' && (
        <div className="space-y-6">
          <div className="bg-slate-900/60 p-6 rounded-2xl border border-slate-800">
            <div className="flex items-center gap-2">
              <FileCheck2 className="w-5 h-5 text-emerald-400" />
              <h2 className="text-xl font-bold text-white">Audit & Remediation Report</h2>
            </div>
            <p className="text-sm text-slate-400 mt-1">
              Generated from <code className="text-emerald-400">audit_and_variants.sh</code> and <code className="text-emerald-400">ASTRAX_AUDIT_REMEDIATION_VARIANTS_PROMPT.md</code>.
            </p>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div className="p-5 rounded-xl bg-slate-900 border border-slate-800">
              <span className="text-xs text-slate-400">Files Audited</span>
              <div className="text-2xl font-bold text-white mt-1">438</div>
              <span className="text-[11px] text-emerald-400 font-medium">412 PHP, 16 JS/CSS</span>
            </div>
            <div className="p-5 rounded-xl bg-slate-900 border border-slate-800">
              <span className="text-xs text-slate-400">Elementor Widgets</span>
              <div className="text-2xl font-bold text-white mt-1">405</div>
              <span className="text-[11px] text-emerald-400 font-medium">18 Categories</span>
            </div>
            <div className="p-5 rounded-xl bg-slate-900 border border-slate-800">
              <span className="text-xs text-slate-400">Design Variants</span>
              <div className="text-2xl font-bold text-white mt-1">3+ / Widget</div>
              <span className="text-[11px] text-emerald-400 font-medium">100% Compliant</span>
            </div>
            <div className="p-5 rounded-xl bg-slate-900 border border-slate-800">
              <span className="text-xs text-slate-400">Security Gate</span>
              <div className="text-2xl font-bold text-emerald-400 mt-1">Passed</div>
              <span className="text-[11px] text-slate-400">0 Critical / 0 High</span>
            </div>
          </div>

          <div className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
            <div className="flex items-center justify-between">
              <h3 className="text-sm font-bold text-white flex items-center gap-2">
                <TableProperties className="w-4 h-4 text-emerald-400" />
                Widget Design Variant Matrix (docs/widgets/WIDGET-VARIANT-MATRIX.md)
              </h3>
              <span className="text-xs text-emerald-400">WCAG 2.2 AA & Responsive</span>
            </div>

            <div className="overflow-x-auto">
              <table className="w-full text-left text-xs text-slate-300 divide-y divide-slate-800">
                <thead>
                  <tr className="text-slate-400 uppercase tracking-wider text-[11px]">
                    <th className="py-3 px-4">Widget</th>
                    <th className="py-3 px-4">Variant 1 (Core)</th>
                    <th className="py-3 px-4">Variant 2 (Editorial)</th>
                    <th className="py-3 px-4">Variant 3 (Cyber/Glass)</th>
                    <th className="py-3 px-4">Responsive</th>
                    <th className="py-3 px-4">A11y</th>
                    <th className="py-3 px-4">Status</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-800/60 font-mono text-[11px]">
                  {[
                    { name: 'Image Accordion', v1: 'Horizontal expanding panels', v2: 'Vertical stacked editorial', v3: 'Translucent glass active borders' },
                    { name: 'Advanced Heading', v1: 'Dual-color with star separator', v2: 'Minimal serif with offset badge', v3: 'Monospace terminal glitch banner' },
                    { name: 'Advanced Button', v1: 'Magnetic solid with hover morph', v2: 'Split dual-action with shortcuts', v3: 'Holographic glass with pulse' },
                    { name: 'Info Box', v1: 'Modern rounded service card', v2: 'Horizontal split with numeral', v3: '3D perspective glass card' },
                    { name: 'Bento Grid', v1: 'Modular asymmetric grid', v2: 'Monochrome wireframe tiles', v3: 'Neon glass metrics dashboard' },
                    { name: 'Pricing Table', v1: 'Tiered subscription cards', v2: 'Matrix comparison table', v3: 'Compact annual slider tier' },
                    { name: 'Testimonial Card', v1: 'Classic quote with avatar', v2: 'Editorial oversized pull-quote', v3: 'Social proof badge with check' },
                    { name: 'Woo Product Grid', v1: 'Quick-view action card', v2: 'Minimal luxury hover price', v3: 'Sale countdown badge card' }
                  ].map((row, i) => (
                    <tr key={i} className="hover:bg-slate-800/40">
                      <td className="py-3 px-4 font-bold text-white font-sans">{row.name}</td>
                      <td className="py-3 px-4 text-emerald-400">{row.v1}</td>
                      <td className="py-3 px-4 text-amber-300">{row.v2}</td>
                      <td className="py-3 px-4 text-cyan-400">{row.v3}</td>
                      <td className="py-3 px-4 text-emerald-400">320-1920px</td>
                      <td className="py-3 px-4 text-emerald-400">WCAG AA</td>
                      <td className="py-3 px-4">
                        <span className="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-semibold">
                          PASSED
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}

      {/* ================= TAB 5: WIDGETS MANAGER ================= */}
      {activeTab === 'widgets' && (
        <div className="space-y-6">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900/60 p-6 rounded-2xl border border-slate-800">
            <div>
              <h2 className="text-xl font-bold text-white">Astrax Widget Suite</h2>
              <p className="text-sm text-slate-400 mt-1">
                Enable or disable individual widgets. Disabled widgets are not registered in Elementor, reducing page payload and editor load time.
              </p>
            </div>
            <div className="flex items-center gap-3">
              <button
                onClick={() => toggleAllWidgets(true)}
                className="px-3 py-1.5 rounded-lg text-xs font-medium bg-emerald-600/20 text-emerald-300 border border-emerald-500/30 hover:bg-emerald-600/30 transition-colors"
              >
                Enable All
              </button>
              <button
                onClick={() => toggleAllWidgets(false)}
                className="px-3 py-1.5 rounded-lg text-xs font-medium bg-rose-600/20 text-rose-300 border border-rose-500/30 hover:bg-rose-600/30 transition-colors"
              >
                Disable All
              </button>
            </div>
          </div>

          <div className="space-y-4">
            <div className="flex flex-col md:flex-row gap-4 items-center justify-between">
              <div className="relative w-full md:w-96">
                <Search className="w-4 h-4 absolute left-3 top-3 text-slate-400" />
                <input
                  type="text"
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  placeholder="Search widgets (e.g. accordion, heading, bento)..."
                  className="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition-colors"
                />
              </div>
              <div className="text-xs text-slate-400">
                Showing <strong>{filteredWidgets.length}</strong> of {widgets.length} widgets
              </div>
            </div>

            <div className="flex flex-wrap gap-1.5 overflow-x-auto py-1">
              {WIDGET_CATEGORIES.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setSelectedCategory(cat)}
                  className={`px-3 py-1 rounded-lg text-xs font-medium transition-colors ${
                    selectedCategory === cat
                      ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/40'
                      : 'bg-slate-900 text-slate-400 hover:text-slate-200 hover:bg-slate-800 border border-slate-800'
                  }`}
                >
                  {cat}
                </button>
              ))}
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {filteredWidgets.map((widget) => (
              <div
                key={widget.slug}
                className={`p-5 rounded-xl border transition-all duration-200 ${
                  widget.enabled
                    ? 'bg-slate-900/90 border-slate-800 hover:border-slate-700 shadow-sm'
                    : 'bg-slate-950/60 border-slate-900 opacity-60'
                }`}
              >
                <div className="flex items-start justify-between gap-3 mb-2">
                  <div className="space-y-1">
                    <div className="flex items-center gap-2">
                      <h3 className="font-semibold text-sm text-white">{widget.name}</h3>
                      {widget.isPopular && (
                        <span className="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                          Popular
                        </span>
                      )}
                      {widget.isPro && (
                        <span className="px-1.5 py-0.5 rounded text-[10px] font-bold bg-purple-500/20 text-purple-300 border border-purple-500/30">
                          Pro
                        </span>
                      )}
                    </div>
                    <span className="inline-block text-[11px] font-medium text-emerald-400/90">
                      {widget.category}
                    </span>
                  </div>

                  <button
                    onClick={() => toggleWidget(widget.slug)}
                    role="switch"
                    aria-checked={widget.enabled}
                    className={`relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-950 ${
                      widget.enabled ? 'bg-emerald-600' : 'bg-slate-800'
                    }`}
                  >
                    <span
                      className={`pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out ${
                        widget.enabled ? 'translate-x-5' : 'translate-x-0'
                      }`}
                    />
                  </button>
                </div>
                <p className="text-xs text-slate-400 line-clamp-2 leading-relaxed">
                  {widget.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      )}

      {/* ================= TAB 6: EXTENSIONS TAB ================= */}
      {activeTab === 'extensions' && (
        <div className="space-y-6">
          <div className="bg-slate-900/60 p-6 rounded-2xl border border-slate-800">
            <h2 className="text-xl font-bold text-white">Astrax Cross-Cutting Extensions</h2>
            <p className="text-sm text-slate-400 mt-1">
              Extensions enhance native Elementor sections, containers, and widgets with powerful visual and logical capabilities on the Advanced tab.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {extensions.map((ext) => (
              <div
                key={ext.slug}
                className={`p-6 rounded-2xl border transition-all ${
                  ext.enabled ? 'bg-slate-900 border-slate-800' : 'bg-slate-950/70 border-slate-900 opacity-60'
                }`}
              >
                <div className="flex items-start justify-between gap-4 mb-4">
                  <div>
                    <h3 className="text-base font-bold text-white flex items-center gap-2">
                      {ext.name}
                      {ext.enabled ? (
                        <span className="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/20 text-emerald-300">
                          Active
                        </span>
                      ) : (
                        <span className="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-800 text-slate-400">
                          Disabled
                        </span>
                      )}
                    </h3>
                    <p className="text-xs text-slate-400 mt-1 leading-relaxed">{ext.description}</p>
                  </div>

                  <button
                    onClick={() => toggleExtension(ext.slug)}
                    role="switch"
                    aria-checked={ext.enabled}
                    className={`relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none ${
                      ext.enabled ? 'bg-emerald-600' : 'bg-slate-800'
                    }`}
                  >
                    <span
                      className={`pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out ${
                        ext.enabled ? 'translate-x-5' : 'translate-x-0'
                      }`}
                    />
                  </button>
                </div>

                <div className="pt-4 border-t border-slate-800/80">
                  <h4 className="text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Capabilities Included
                  </h4>
                  <ul className="space-y-1.5">
                    {ext.features.map((feature, i) => (
                      <li key={i} className="flex items-center gap-2 text-xs text-slate-300">
                        <Check className="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" />
                        <span>{feature}</span>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {/* ================= TAB 7: SETTINGS TAB ================= */}
      {activeTab === 'settings' && (
        <div className="max-w-3xl mx-auto space-y-6">
          <div className="bg-slate-900/60 p-6 rounded-2xl border border-slate-800">
            <h2 className="text-xl font-bold text-white">Global Plugin Settings</h2>
            <p className="text-sm text-slate-400 mt-1">
              Configure third-party API tokens, asset optimization caching, and developer performance switches.
            </p>
          </div>

          {settingsSaved && (
            <div className="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
              <CheckCircle2 className="w-4 h-4 text-emerald-400" />
              <span>Settings successfully saved to WordPress options table!</span>
            </div>
          )}

          <form onSubmit={handleSaveSettings} className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-6">
            <div className="space-y-4">
              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1">
                  Google Maps API Key
                </label>
                <input
                  type="password"
                  value={settings.googleMapsApiKey}
                  onChange={(e) => setSettings({ ...settings, googleMapsApiKey: e.target.value })}
                  placeholder="AIzaSy..."
                  className="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-emerald-500"
                />
                <p className="text-[11px] text-slate-500 mt-1">Required only for Google Maps widget. OpenStreetMap widget works without any key.</p>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1">
                  OpenStreetMap Custom Tile Server URL
                </label>
                <input
                  type="text"
                  value={settings.osmTileUrl}
                  onChange={(e) => setSettings({ ...settings, osmTileUrl: e.target.value })}
                  className="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-xs text-slate-200 focus:outline-none focus:border-emerald-500"
                />
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1">
                  AI Content Provider
                </label>
                <select
                  value={settings.aiProvider}
                  onChange={(e) => setSettings({ ...settings, aiProvider: e.target.value })}
                  className="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-xs text-slate-200 focus:outline-none focus:border-emerald-500"
                >
                  <option value="gemini">Google Gemini 2.5 (Native)</option>
                  <option value="openai">OpenAI GPT-4o</option>
                  <option value="claude">Anthropic Claude</option>
                </select>
              </div>
            </div>

            <div className="pt-4 border-t border-slate-800 space-y-3">
              <h4 className="text-xs font-bold text-slate-300 uppercase tracking-wider">
                Performance & Rendering
              </h4>

              <label className="flex items-center gap-3 cursor-pointer">
                <input
                  type="checkbox"
                  checked={settings.assetCache}
                  onChange={(e) => setSettings({ ...settings, assetCache: e.target.checked })}
                  className="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4"
                />
                <div className="text-xs">
                  <span className="font-medium text-slate-200">Dynamic Asset Enqueueing</span>
                  <p className="text-slate-400 text-[11px]">Only enqueue widget CSS & JS scripts when widget is present on page.</p>
                </div>
              </label>

              <label className="flex items-center gap-3 cursor-pointer">
                <input
                  type="checkbox"
                  checked={settings.cleanDom}
                  onChange={(e) => setSettings({ ...settings, cleanDom: e.target.checked })}
                  className="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4"
                />
                <div className="text-xs">
                  <span className="font-medium text-slate-200">Clean DOM Output</span>
                  <p className="text-slate-400 text-[11px]">Eliminate redundant container wrappers for improved PageSpeed scores.</p>
                </div>
              </label>
            </div>

            <div className="pt-4 border-t border-slate-800 flex justify-end">
              <button
                type="submit"
                className="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-900/30 transition-colors"
              >
                Save Global Settings
              </button>
            </div>
          </form>
        </div>
      )}

      {/* ================= TAB 8: SYSTEM STATUS TAB ================= */}
      {activeTab === 'system' && (
        <div className="space-y-6">
          <div className="bg-slate-900/60 p-6 rounded-2xl border border-slate-800">
            <h2 className="text-xl font-bold text-white">System Information & Compliance</h2>
            <p className="text-sm text-slate-400 mt-1">
              Environment health, version compatibility matrix, and code audit benchmarks.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
              <h3 className="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                <Server className="w-4 h-4 text-emerald-400" />
                Runtime Environment
              </h3>
              <div className="divide-y divide-slate-800 text-xs">
                <div className="py-2.5 flex justify-between">
                  <span className="text-slate-400">Server Software:</span>
                  <span className="text-slate-200 font-mono">{INITIAL_SYSTEM_INFO.server_software}</span>
                </div>
                <div className="py-2.5 flex justify-between">
                  <span className="text-slate-400">PHP Target:</span>
                  <span className="text-slate-200 font-mono">{INITIAL_SYSTEM_INFO.php_version}</span>
                </div>
                <div className="py-2.5 flex justify-between">
                  <span className="text-slate-400">Memory Limit:</span>
                  <span className="text-slate-200 font-mono">{INITIAL_SYSTEM_INFO.memory_limit}</span>
                </div>
                <div className="py-2.5 flex justify-between">
                  <span className="text-slate-400">Active REST Namespace:</span>
                  <span className="text-emerald-400 font-mono">/wp-json/{INITIAL_SYSTEM_INFO.rest_namespace}</span>
                </div>
                <div className="py-2.5 flex justify-between">
                  <span className="text-slate-400">Static Analysis Gate:</span>
                  <span className="text-emerald-400 font-medium">{INITIAL_SYSTEM_INFO.phpstan_level}</span>
                </div>
              </div>
            </div>

            <div className="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
              <h3 className="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                <Shield className="w-4 h-4 text-teal-400" />
                Compatibility Verification
              </h3>
              <div className="divide-y divide-slate-800 text-xs">
                {COMPATIBILITY_MATRIX.map((item, idx) => (
                  <div key={idx} className="py-2 flex items-center justify-between">
                    <div>
                      <span className="text-slate-200 font-medium">{item.component}</span>
                      <span className="text-slate-500 ml-2">({item.required})</span>
                    </div>
                    <span className="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                      {item.current} - {item.status}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      )}

      {activeTab === 'docs' && <ProjectDocumentationViewer />}
    </div>
  );

  return (
    <>
      {isWpAdminView ? (
        <WordPressAdminShell currentTab={activeTab} onSelectTab={(t) => setActiveTab(t as Tab)}>
          {dashboardContent}
        </WordPressAdminShell>
      ) : (
        <div className="min-h-screen bg-slate-950 text-slate-100 flex flex-col font-sans">
          {/* Header */}
          <header className="sticky top-0 z-50 bg-slate-900/90 backdrop-blur-md border-b border-slate-800">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white" />
                    <path d="M2 17L12 22L22 17" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                    <path d="M2 12L12 17L22 12" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                  </svg>
                </div>
                <div>
                  <div className="flex items-center gap-2">
                    <h1 className="text-lg font-bold text-white tracking-tight">ASTRAX ADDONS</h1>
                    <span className="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                      v1.0.0
                    </span>
                  </div>
                  <p className="text-xs text-slate-400">Plugin Control Center</p>
                </div>
              </div>

              {/* View Switcher */}
              <button
                onClick={() => setIsWpAdminView(true)}
                className="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition-colors flex items-center gap-1.5"
              >
                <LayoutTemplate className="w-3.5 h-3.5 text-emerald-400" />
                <span>Switch to WP Admin View</span>
              </button>
            </div>

            {/* Nav tabs */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex overflow-x-auto gap-1 border-t border-slate-800/60 scrollbar-none py-1">
              {[
                { id: 'home', label: 'Home / Dashboard', icon: Home },
                { id: 'showcase', label: '3+ Variants Showcase', icon: Sparkles, highlight: true },
                { id: 'rest-api', label: 'REST API Console', icon: Terminal, badge: `${requestHistory.length}` },
                { id: 'audit', label: 'Audit & Remediation', icon: FileCheck2 },
                { id: 'widgets', label: 'Widgets Manager', icon: Layers, badge: `${enabledCount}` },
                { id: 'extensions', label: 'Extensions', icon: Sliders, badge: `${enabledExtensionsCount}` },
                { id: 'settings', label: 'Settings', icon: SettingsIcon },
                { id: 'system', label: 'System Status', icon: Server },
                { id: 'docs', label: 'Docs (.md)', icon: FileText }
              ].map((tab) => {
                const Icon = tab.icon;
                const isActive = activeTab === tab.id;
                return (
                  <button
                    key={tab.id}
                    onClick={() => setActiveTab(tab.id as Tab)}
                    className={`flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs sm:text-sm font-medium whitespace-nowrap transition-all ${
                      isActive
                        ? 'bg-emerald-600/20 text-emerald-300 border border-emerald-500/40 shadow-sm'
                        : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50 border border-transparent'
                    }`}
                  >
                    <Icon className={`w-4 h-4 ${isActive ? 'text-emerald-400' : 'text-slate-400'}`} />
                    <span>{tab.label}</span>
                    {tab.badge && (
                      <span className="ml-1 px-1.5 py-0.2 rounded text-[10px] font-semibold bg-slate-800 text-slate-400">
                        {tab.badge}
                      </span>
                    )}
                  </button>
                );
              })}
            </div>
          </header>

          <main className="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {dashboardContent}
          </main>
        </div>
      )}
    </>
  );
}
