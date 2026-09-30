import React, { useState } from 'react';
import { Type, Sparkles, Star, SlidersHorizontal, Check, Terminal, Quote } from 'lucide-react';

export const AdvancedHeadingWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'variant-1' | 'variant-2' | 'variant-3'>('variant-1');
  const [eyebrow, setEyebrow] = useState('Production-Grade Elementor Suite');
  const [primaryTitle, setPrimaryTitle] = useState('Architect Your Vision With');
  const [accentTitle, setAccentTitle] = useState('Unrivaled Precision');
  const [description, setDescription] = useState(
    'Engineered for high-throughput enterprise sites with clean semantic DOM output, strict WPCS compliance, and zero runtime bloat.'
  );
  const [alignment, setAlignment] = useState<'left' | 'center' | 'right'>('center');

  return (
    <div className="space-y-6">
      {/* Elementor Control: design_variant */}
      <div className="p-4 rounded-xl bg-slate-900 border border-slate-800 space-y-4">
        <div className="flex flex-wrap items-center justify-between gap-4">
          <div className="flex items-center gap-2">
            <SlidersHorizontal className="w-4 h-4 text-emerald-400" />
            <span className="text-xs font-bold text-white uppercase tracking-wider">
              Elementor Control: design_variant
            </span>
          </div>

          <div className="flex flex-wrap gap-2">
            {[
              { id: 'variant-1', name: 'Variant 1: Core Refined' },
              { id: 'variant-2', name: 'Variant 2: Editorial Serif' },
              { id: 'variant-3', name: 'Variant 3: Cyber Monospace' }
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
            <label className="text-slate-400 block mb-1">Eyebrow</label>
            <input
              type="text"
              value={eyebrow}
              onChange={(e) => setEyebrow(e.target.value)}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            />
          </div>
          <div>
            <label className="text-slate-400 block mb-1">Primary Title</label>
            <input
              type="text"
              value={primaryTitle}
              onChange={(e) => setPrimaryTitle(e.target.value)}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            />
          </div>
          <div>
            <label className="text-slate-400 block mb-1">Accent Title</label>
            <input
              type="text"
              value={accentTitle}
              onChange={(e) => setAccentTitle(e.target.value)}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            />
          </div>
        </div>
      </div>

      {/* ================= VARIANT 1: CORE / REFINED ================= */}
      {activeVariant === 'variant-1' && (
        <div className="p-10 rounded-2xl bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 text-center shadow-xl">
          {eyebrow && (
            <div className="mb-4 flex justify-center">
              <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <Sparkles className="w-3.5 h-3.5" />
                {eyebrow}
              </span>
            </div>
          )}
          <h2 className="text-3xl md:text-5xl font-black tracking-tight leading-tight text-white mb-4">
            <span className="text-slate-100">{primaryTitle} </span>
            <span className="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">
              {accentTitle}
            </span>
          </h2>
          <div className="flex items-center justify-center gap-3 my-5">
            <div className="w-16 h-0.5 bg-gradient-to-r from-transparent to-emerald-500" />
            <Star className="w-4 h-4 text-emerald-400 fill-emerald-400" />
            <div className="w-16 h-0.5 bg-gradient-to-l from-transparent to-emerald-500" />
          </div>
          {description && (
            <p className="text-slate-300 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
              {description}
            </p>
          )}
        </div>
      )}

      {/* ================= VARIANT 2: EDITORIAL / ASYMMETRIC ================= */}
      {activeVariant === 'variant-2' && (
        <div className="p-10 rounded-2xl bg-stone-900 border border-stone-800 text-left relative overflow-hidden shadow-xl">
          <Quote className="absolute right-6 top-6 w-24 h-24 text-stone-800/60 pointer-events-none -rotate-12" />
          <div className="max-w-3xl relative z-10 space-y-4">
            <div className="flex items-center gap-3">
              <span className="w-8 h-[1px] bg-amber-500" />
              <span className="text-xs font-serif italic tracking-widest text-amber-400 uppercase">
                {eyebrow}
              </span>
            </div>
            <h2 className="text-4xl md:text-6xl font-serif font-normal text-stone-100 leading-tight">
              {primaryTitle}{' '}
              <em className="font-serif italic font-bold text-amber-300 underline decoration-amber-500/40 underline-offset-8">
                {accentTitle}
              </em>
            </h2>
            <div className="pt-2">
              <p className="text-stone-300 text-base md:text-lg font-light leading-relaxed border-l-2 border-amber-500/50 pl-5">
                {description}
              </p>
            </div>
          </div>
        </div>
      )}

      {/* ================= VARIANT 3: CYBER / MONOSPACE TECH ================= */}
      {activeVariant === 'variant-3' && (
        <div className="p-8 rounded-2xl bg-slate-950 border border-cyan-500/30 font-mono shadow-2xl relative">
          <div className="flex items-center justify-between pb-4 mb-4 border-b border-cyan-500/20 text-xs text-cyan-400">
            <div className="flex items-center gap-2">
              <Terminal className="w-4 h-4" />
              <span>STDOUT::RENDER_HEADING_V3</span>
            </div>
            <span className="text-slate-500">FORMAT: UTF-8</span>
          </div>
          <div className="space-y-4">
            <div className="inline-block px-2.5 py-0.5 rounded bg-cyan-950 text-cyan-300 border border-cyan-500/40 text-xs">
              &gt; {eyebrow}
            </div>
            <h2 className="text-3xl md:text-5xl font-black uppercase tracking-wider text-white">
              {primaryTitle}{' '}
              <span className="bg-cyan-500 text-slate-950 px-2 inline-block">
                {accentTitle}
              </span>
            </h2>
            <p className="text-slate-400 text-xs font-sans leading-relaxed max-w-2xl">
              // {description}
            </p>
          </div>
        </div>
      )}
    </div>
  );
};
