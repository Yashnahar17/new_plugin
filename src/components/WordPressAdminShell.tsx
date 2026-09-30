import React, { useState } from 'react';
import {
  Home,
  Layers,
  Sliders,
  Settings as SettingsIcon,
  Server,
  Terminal,
  Sparkles,
  FileCheck2,
  CheckCircle2,
  ChevronDown,
  MessageSquare,
  Plus,
  Compass,
  FileText,
  Image,
  Paintbrush,
  Users,
  Wrench,
  ChevronLeft,
  ChevronRight,
  ExternalLink,
  Download
} from 'lucide-react';

interface WordPressAdminShellProps {
  currentTab: string;
  onSelectTab: (tab: string) => void;
  children: React.ReactNode;
}

export const WordPressAdminShell: React.FC<WordPressAdminShellProps> = ({
  currentTab,
  onSelectTab,
  children
}) => {
  const [collapsed, setCollapsed] = useState(false);

  return (
    <div className="min-h-screen bg-[#f0f0f1] text-[#2c3338] font-sans flex flex-col">
      {/* ================= WORDPRESS TOP ADMIN BAR (#1d2327) ================= */}
      <div className="h-8 bg-[#1d2327] text-[#c3c4c7] text-[13px] px-3 flex items-center justify-between select-none z-50 sticky top-0 border-b border-[#2c3338]">
        {/* Left items */}
        <div className="flex items-center space-x-4">
          {/* WordPress Icon */}
          <div className="flex items-center gap-1.5 hover:text-white cursor-pointer hover:bg-[#2271b1] px-2 py-1 rounded">
            <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.167 6.839 9.489L4.856 9.873C4.307 10.518 4 11.233 4 12c0 2.458 1.107 4.67 2.87 6.136L12 22l5.13-14.864C18.893 8.67 20 10.882 20 13.34c0 .767-.307 1.482-.856 2.127l-3.983 11.614C19.135 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10zm-1.87 17.514L5.688 8.442C6.88 7.332 8.47 6.64 10.13 6.64c1.19 0 2.33.35 3.3.99l-3.3 11.884zm5.74 0L19.312 8.442C18.12 7.332 16.53 6.64 14.87 6.64c-.45 0-.89.05-1.32.14l2.32 12.734z" />
            </svg>
          </div>

          {/* Site Name & Home */}
          <div className="flex items-center gap-1.5 hover:text-white cursor-pointer px-2 py-1 rounded hover:bg-[#2c3338]">
            <Home className="w-3.5 h-3.5" />
            <span className="font-semibold text-white">My WordPress Site</span>
          </div>

          {/* Comments */}
          <div className="hidden sm:flex items-center gap-1 hover:text-white cursor-pointer px-2 py-1 rounded hover:bg-[#2c3338]">
            <MessageSquare className="w-3.5 h-3.5" />
            <span className="text-[11px] font-bold bg-[#4f94d4] text-white px-1.5 py-0.2 rounded-full">0</span>
          </div>

          {/* + New */}
          <div className="hidden sm:flex items-center gap-1 hover:text-white cursor-pointer px-2 py-1 rounded hover:bg-[#2c3338]">
            <Plus className="w-3.5 h-3.5" />
            <span>New</span>
          </div>

          {/* Edit with Elementor badge */}
          <div className="hidden md:flex items-center gap-1 text-[11px] text-emerald-400 font-medium px-2 py-0.5 rounded bg-emerald-950/60 border border-emerald-800/60">
            <span>Astrax Addons v1.0.0 Active</span>
          </div>
        </div>

        {/* Right items */}
        <div className="flex items-center gap-2.5">
          <a
            href="/ASTRAX_ADDONS_FULL_DOCUMENTATION.md"
            download="ASTRAX_ADDONS_FULL_DOCUMENTATION.md"
            className="flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded bg-cyan-500/20 hover:bg-cyan-500/30 text-cyan-300 border border-cyan-500/50 hover:text-white transition-colors"
            title="Download Complete Project Documentation (.md)"
          >
            <FileText className="w-3.5 h-3.5 text-cyan-400" />
            <span className="hidden md:inline">Download Docs (.md)</span>
          </a>

          <a
            href="/astrax-addons.zip"
            download="astrax-addons.zip"
            className="flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/50 hover:text-white transition-colors"
            title="Download fixed astrax-addons.zip plugin"
          >
            <Download className="w-3.5 h-3.5 text-amber-400" />
            <span className="hidden sm:inline">Download Plugin (.zip)</span>
          </a>

          <div className="flex items-center gap-2 hover:text-white cursor-pointer px-2 py-1 rounded hover:bg-[#2c3338]">
            <span className="text-xs">Howdy, <strong>Administrator</strong></span>
            <div className="w-5 h-5 rounded-full bg-emerald-700 flex items-center justify-center text-white text-[10px] font-bold">
              A
            </div>
          </div>
        </div>
      </div>

      <div className="flex-1 flex overflow-hidden">
        {/* ================= WORDPRESS ADMIN SIDEBAR (#1d2327) ================= */}
        <aside
          className={`bg-[#1d2327] text-[#c3c4c7] transition-all duration-200 select-none flex flex-col justify-between z-40 border-r border-[#2c3338] ${
            collapsed ? 'w-12' : 'w-48 sm:w-56'
          }`}
        >
          <div className="py-2 text-[13px] space-y-0.5">
            {/* Standard WP Menu Items */}
            <div className="px-3 py-2 text-[#8c8f94] hover:text-white hover:bg-[#2271b1] cursor-pointer flex items-center gap-2.5">
              <Compass className="w-4 h-4 flex-shrink-0" />
              {!collapsed && <span>Dashboard</span>}
            </div>

            <div className="px-3 py-2 text-[#8c8f94] hover:text-white hover:bg-[#2271b1] cursor-pointer flex items-center gap-2.5">
              <FileText className="w-4 h-4 flex-shrink-0" />
              {!collapsed && <span>Posts</span>}
            </div>

            <div className="px-3 py-2 text-[#8c8f94] hover:text-white hover:bg-[#2271b1] cursor-pointer flex items-center gap-2.5">
              <Image className="w-4 h-4 flex-shrink-0" />
              {!collapsed && <span>Media</span>}
            </div>

            <div className="px-3 py-2 text-[#8c8f94] hover:text-white hover:bg-[#2271b1] cursor-pointer flex items-center gap-2.5">
              <Layers className="w-4 h-4 flex-shrink-0" />
              {!collapsed && <span>Elementor</span>}
            </div>

            {/* HIGHLIGHTED DEDICATED ASTRAX ADDONS MENU */}
            <div className="my-2 border-t border-b border-[#2c3338] py-1 bg-[#151a1e]">
              <div
                className="px-3 py-2.5 bg-[#2271b1] text-white font-bold flex items-center justify-between cursor-pointer"
                onClick={() => onSelectTab('home')}
              >
                <div className="flex items-center gap-2.5">
                  <Sparkles className="w-4 h-4 text-amber-300 flex-shrink-0" />
                  {!collapsed && <span className="tracking-wide">Astrax Addons</span>}
                </div>
              </div>

              {/* Submenu items */}
              {!collapsed && (
                <div className="bg-[#121619] py-1 text-[12px] space-y-0.5 font-medium pl-6">
                  {[
                    { id: 'home', label: 'Home / Dashboard', icon: Home },
                    { id: 'tracker', label: 'Implementation Tracker', icon: CheckCircle2 },
                    { id: 'showcase', label: '3+ Variants Showcase', icon: Sparkles },
                    { id: 'widgets', label: 'Manage Widgets (405)', icon: Layers },
                    { id: 'extensions', label: 'Extensions (4)', icon: Sliders },
                    { id: 'audit', label: 'Audit & Remediation', icon: FileCheck2 },
                    { id: 'rest-api', label: 'REST API Console', icon: Terminal },
                    { id: 'settings', label: 'Plugin Settings', icon: SettingsIcon },
                    { id: 'system', label: 'System Status', icon: Server },
                    { id: 'docs', label: 'Documentation (.md)', icon: FileText }
                  ].map((sub) => {
                    const isSubActive = currentTab === sub.id;
                    const SubIcon = sub.icon;
                    return (
                      <div
                        key={sub.id}
                        onClick={() => onSelectTab(sub.id)}
                        className={`px-3 py-1.5 rounded-l cursor-pointer flex items-center gap-2 transition-colors ${
                          isSubActive
                            ? 'text-white bg-[#2271b1] font-bold'
                            : 'text-[#c3c4c7] hover:text-white hover:bg-[#1d2327]'
                        }`}
                      >
                        <SubIcon className={`w-3.5 h-3.5 ${isSubActive ? 'text-amber-300' : 'text-slate-400'}`} />
                        <span>{sub.label}</span>
                      </div>
                    );
                  })}
                </div>
              )}
            </div>

            {/* Other WP Items */}
            <div className="px-3 py-2 text-[#8c8f94] hover:text-white hover:bg-[#2271b1] cursor-pointer flex items-center gap-2.5">
              <Paintbrush className="w-4 h-4 flex-shrink-0" />
              {!collapsed && <span>Appearance</span>}
            </div>

            <div className="px-3 py-2 text-[#8c8f94] hover:text-white hover:bg-[#2271b1] cursor-pointer flex items-center gap-2.5">
              <Wrench className="w-4 h-4 flex-shrink-0" />
              {!collapsed && <span>Plugins</span>}
            </div>

            <div className="px-3 py-2 text-[#8c8f94] hover:text-white hover:bg-[#2271b1] cursor-pointer flex items-center gap-2.5">
              <Users className="w-4 h-4 flex-shrink-0" />
              {!collapsed && <span>Users</span>}
            </div>
          </div>

          {/* Collapse Button */}
          <div
            onClick={() => setCollapsed(!collapsed)}
            className="p-3 border-t border-[#2c3338] text-[#8c8f94] hover:text-white cursor-pointer flex items-center justify-between text-xs"
          >
            {!collapsed && <span>Collapse menu</span>}
            {collapsed ? <ChevronRight className="w-4 h-4" /> : <ChevronLeft className="w-4 h-4" />}
          </div>
        </aside>

        {/* ================= MAIN WORDPRESS WRAP AREA ================= */}
        <div className="flex-1 overflow-y-auto bg-slate-950 p-4 sm:p-8">
          <div className="max-w-7xl mx-auto">
            {children}
          </div>
        </div>
      </div>
    </div>
  );
};
