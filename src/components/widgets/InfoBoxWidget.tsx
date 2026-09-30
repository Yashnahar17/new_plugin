import React, { useState } from 'react';
import { SlidersHorizontal, Check, Info, ArrowRight, Sparkles, Shield, Compass } from 'lucide-react';

export const InfoBoxWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'core' | 'editorial' | 'cyber'>('core');
  const [title, setTitle] = useState('Scalable Cloud Architecture');
  const [description, setDescription] = useState(
    'Engineered for maximum reliability and decoupled performance across enterprise WordPress and Elementor workloads.'
  );
  const [badgeText, setBadgeText] = useState('Enterprise Tier');
  const [hasLink, setHasLink] = useState(true);

  return (
    <div className="space-y-6">
      {/* Elementor Control: design_variant & settings */}
      <div className="p-4 rounded-xl bg-slate-900 border border-slate-800 space-y-4">
        <div className="flex flex-wrap items-center justify-between gap-4">
          <div className="flex items-center gap-2">
            <SlidersHorizontal className="w-4 h-4 text-emerald-400" />
            <span className="text-xs font-bold text-white uppercase tracking-wider">
              Elementor Control: design_variant (Info Box)
            </span>
          </div>

          <div className="flex flex-wrap gap-2">
            {[
              { id: 'core', name: 'Variant 1: Core Service Card' },
              { id: 'editorial', name: 'Variant 2: Editorial Asymmetric' },
              { id: 'cyber', name: 'Variant 3: Cyber Glassmorphism' }
            ].map((v) => (
              <button
                key={v.id}
                onClick={() => setActiveVariant(v.id as any)}
                className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 ${
                  activeVariant === v.id
                    ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40'
                    : 'bg-slate-800 text-slate-400 hover:text-slate-200'
                }`}
              >
                {activeVariant === v.id && <Check className="w-3.5 h-3.5" />}
                <span>{v.name}</span>
              </button>
            ))}
          </div>
        </div>

        {/* Input fields */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-3 pt-3 border-t border-slate-800/80 text-xs">
          <div>
            <label className="text-slate-400 block mb-1">Title</label>
            <input
              type="text"
              value={title}
              onChange={(e) => setTitle(e.target.value)}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            />
          </div>
          <div>
            <label className="text-slate-400 block mb-1">Badge Text</label>
            <input
              type="text"
              value={badgeText}
              onChange={(e) => setBadgeText(e.target.value)}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            />
          </div>
          <div className="flex items-center pt-5">
            <label className="flex items-center gap-2 cursor-pointer text-slate-300">
              <input
                type="checkbox"
                checked={hasLink}
                onChange={(e) => setHasLink(e.target.checked)}
                className="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4"
              />
              <span>Enable Full Box Link Anchor</span>
            </label>
          </div>
          <div className="md:col-span-3">
            <label className="text-slate-400 block mb-1">Description</label>
            <textarea
              rows={2}
              value={description}
              onChange={(e) => setDescription(e.target.value)}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            />
          </div>
        </div>
      </div>

      {/* LIVE PREVIEW CONTAINER */}
      <div className="p-8 sm:p-12 rounded-2xl bg-slate-950 border border-slate-800/80 flex items-center justify-center min-h-[380px]">
        {/* VARIANT 1: CORE REFINED */}
        {activeVariant === 'core' && (
          <div className="astrax-widget astrax-info-box-wrapper astrax-variant-core max-w-md w-full bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div className="flex items-center justify-between mb-4">
              <div className="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-500/20">
                <Compass className="w-6 h-6" />
              </div>
              {badgeText && (
                <span className="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800/50">
                  {badgeText}
                </span>
              )}
            </div>
            <h3 className="astrax-info-box-title text-lg font-bold text-slate-900 dark:text-white mb-2">
              {title}
            </h3>
            <p className="astrax-info-box-description text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
              {description}
            </p>
            {hasLink && (
              <div className="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 cursor-pointer">
                <span>Explore Infrastructure</span>
                <ArrowRight className="w-3.5 h-3.5" />
              </div>
            )}
          </div>
        )}

        {/* VARIANT 2: EDITORIAL ASYMMETRIC */}
        {activeVariant === 'editorial' && (
          <div className="astrax-widget astrax-info-box-wrapper astrax-variant-editorial max-w-lg w-full bg-[#faf7f2] dark:bg-stone-900 p-8 border-l-4 border-amber-600 shadow-lg">
            <div className="flex items-baseline justify-between mb-4 pb-2 border-b border-stone-300 dark:border-stone-800">
              <span className="text-[10px] uppercase font-mono tracking-widest text-amber-700 dark:text-amber-400 font-bold">
                01 // {badgeText}
              </span>
              <span className="text-xs font-serif italic text-stone-500 dark:text-stone-400">Astrax Addons</span>
            </div>
            <h3 className="astrax-info-box-title text-2xl font-serif text-stone-900 dark:text-stone-100 mb-3 tracking-tight">
              {title}
            </h3>
            <p className="astrax-info-box-description text-sm font-sans text-stone-700 dark:text-stone-300 leading-relaxed mb-6">
              {description}
            </p>
            {hasLink && (
              <button className="text-xs font-bold uppercase tracking-wider text-amber-900 dark:text-amber-300 hover:underline flex items-center gap-1">
                <span>Read Full Specification</span>
                <ArrowRight className="w-3.5 h-3.5" />
              </button>
            )}
          </div>
        )}

        {/* VARIANT 3: CYBER GLASSMORPHISM */}
        {activeVariant === 'cyber' && (
          <div className="astrax-widget astrax-info-box-wrapper astrax-variant-cyber max-w-md w-full relative p-6 rounded-2xl bg-slate-900/80 backdrop-blur-xl border border-cyan-500/30 shadow-2xl shadow-cyan-950/40">
            <div className="absolute top-0 right-0 w-24 h-24 bg-cyan-500/10 rounded-full blur-xl pointer-events-none" />
            <div className="flex items-center justify-between mb-4">
              <div className="px-2 py-0.5 rounded bg-cyan-950/60 border border-cyan-500/40 text-[10px] font-mono text-cyan-300">
                SYS::INFO_BOX
              </div>
              <span className="px-2 py-0.5 rounded-full text-[10px] font-mono text-emerald-400 bg-emerald-950/50 border border-emerald-500/30">
                ACTIVE
              </span>
            </div>
            <h3 className="astrax-info-box-title text-lg font-mono font-bold text-white mb-2 flex items-center gap-2">
              <span className="text-cyan-400">&gt;</span>
              <span>{title}</span>
            </h3>
            <p className="astrax-info-box-description text-xs font-mono text-slate-300 leading-relaxed mb-5">
              {description}
            </p>
            {hasLink && (
              <div className="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs font-mono text-cyan-400 cursor-pointer hover:text-cyan-300">
                <span>EXECUTE_ACTION()</span>
                <span className="text-slate-500">[RETURN: 200]</span>
              </div>
            )}
          </div>
        )}
      </div>

      {/* SELECTOR MAPPING & QUALITY AUDIT NOTES */}
      <div className="p-4 rounded-xl bg-slate-900/60 border border-slate-800 text-xs space-y-2">
        <div className="flex items-center justify-between text-slate-400">
          <span className="font-semibold text-slate-200">Elementor Selectors Mapped:</span>
          <span className="text-emerald-400 font-mono">100% (3/3 selectors active)</span>
        </div>
        <div className="flex flex-wrap gap-2 font-mono text-[11px] text-slate-400">
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-info-box-wrapper</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-info-box-title</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-info-box-description</span>
        </div>
      </div>
    </div>
  );
};
