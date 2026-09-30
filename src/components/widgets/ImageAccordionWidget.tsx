import React, { useState } from 'react';
import { Layers, ArrowRight, Sparkles, SlidersHorizontal, Check } from 'lucide-react';

interface AccordionItem {
  id: string;
  num: string;
  title: string;
  category: string;
  description: string;
  imageUrl: string;
  ctaText: string;
  date?: string;
}

const ACCORDION_DATA: AccordionItem[] = [
  {
    id: '1',
    num: '01',
    title: 'Kinetic Architecture',
    category: 'Spatial Design',
    description: 'Dynamic structural facades engineered with adaptive biomimetic panels for climate resiliency.',
    imageUrl: 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
    ctaText: 'Explore Project',
    date: 'Autumn 2026'
  },
  {
    id: '2',
    num: '02',
    title: 'Photonic Computing',
    category: 'Deep Tech',
    description: 'Next-generation optical photonics delivering sub-nanosecond tensor calculations with zero thermal loss.',
    imageUrl: 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
    ctaText: 'View Architecture',
    date: 'Core Review'
  },
  {
    id: '3',
    num: '03',
    title: 'Alpine Biosphere',
    category: 'Conservation',
    description: 'High-altitude ecological sensors tracking permafrost retreat and mycorrhizal network resilience.',
    imageUrl: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80',
    ctaText: 'Field Reports',
    date: 'Long-term Cohort'
  },
  {
    id: '4',
    num: '04',
    title: 'Autonomous Systems',
    category: 'Robotics',
    description: 'Bipedal locomotive agents operating in unstructured subterranean search and survey environments.',
    imageUrl: 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80',
    ctaText: 'Benchmark Specs',
    date: 'Milestone 4'
  }
];

export const ImageAccordionWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'variant-1' | 'variant-2' | 'variant-3'>('variant-1');
  const [activeId, setActiveId] = useState<string>('1');
  const [direction, setDirection] = useState<'horizontal' | 'vertical'>('horizontal');
  const [trigger, setTrigger] = useState<'click' | 'hover'>('click');

  const handleInteraction = (id: string, isHover: boolean) => {
    if (trigger === 'hover' && isHover) {
      setActiveId(id);
    } else if (trigger === 'click' && !isHover) {
      setActiveId(id);
    }
  };

  return (
    <div className="space-y-6">
      {/* Elementor Control: Design Variant Selector */}
      <div className="p-4 rounded-xl bg-slate-900 border border-slate-800 space-y-4">
        <div className="flex flex-wrap items-center justify-between gap-4">
          <div className="flex items-center gap-2">
            <SlidersHorizontal className="w-4 h-4 text-emerald-400" />
            <span className="text-xs font-bold text-white uppercase tracking-wider">
              Elementor Control: design_variant
            </span>
          </div>

          {/* 3 Genuine Variant Toggles */}
          <div className="flex flex-wrap gap-2">
            {[
              { id: 'variant-1', name: 'Variant 1: Core / Refined', badge: 'Standard' },
              { id: 'variant-2', name: 'Variant 2: Editorial Asymmetric', badge: 'Editorial' },
              { id: 'variant-3', name: 'Variant 3: Cyber Glass', badge: 'Glassmorphic' }
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

        {/* Secondary options */}
        <div className="flex flex-wrap items-center gap-4 pt-3 border-t border-slate-800/80 text-xs text-slate-400">
          <div className="flex items-center gap-2">
            <span>Orientation:</span>
            <div className="flex bg-slate-800 rounded p-0.5">
              <button
                onClick={() => setDirection('horizontal')}
                className={`px-2.5 py-1 rounded text-[11px] font-medium ${
                  direction === 'horizontal' ? 'bg-slate-700 text-white' : 'text-slate-400'
                }`}
              >
                Horizontal
              </button>
              <button
                onClick={() => setDirection('vertical')}
                className={`px-2.5 py-1 rounded text-[11px] font-medium ${
                  direction === 'vertical' ? 'bg-slate-700 text-white' : 'text-slate-400'
                }`}
              >
                Vertical
              </button>
            </div>
          </div>

          <div className="flex items-center gap-2">
            <span>Interaction:</span>
            <div className="flex bg-slate-800 rounded p-0.5">
              <button
                onClick={() => setTrigger('click')}
                className={`px-2.5 py-1 rounded text-[11px] font-medium ${
                  trigger === 'click' ? 'bg-slate-700 text-white' : 'text-slate-400'
                }`}
              >
                Click
              </button>
              <button
                onClick={() => setTrigger('hover')}
                className={`px-2.5 py-1 rounded text-[11px] font-medium ${
                  trigger === 'hover' ? 'bg-slate-700 text-white' : 'text-slate-400'
                }`}
              >
                Hover
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* ================= VARIANT 1: CORE / REFINED ================= */}
      {activeVariant === 'variant-1' && (
        <div
          className={`w-full rounded-2xl overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl transition-all duration-500 flex gap-2 p-2 ${
            direction === 'vertical' ? 'flex-col h-[540px]' : 'h-[440px]'
          }`}
        >
          {ACCORDION_DATA.map((item) => {
            const isActive = activeId === item.id;
            return (
              <div
                key={item.id}
                onClick={() => handleInteraction(item.id, false)}
                onMouseEnter={() => handleInteraction(item.id, true)}
                tabIndex={0}
                onKeyDown={(e) => {
                  if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    setActiveId(item.id);
                  }
                }}
                className={`relative overflow-hidden rounded-xl cursor-pointer transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)] ${
                  isActive ? (direction === 'horizontal' ? 'flex-[4]' : 'flex-[3]') : 'flex-1 hover:brightness-105'
                }`}
              >
                <div
                  className="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out"
                  style={{ backgroundImage: `url(${item.imageUrl})`, transform: isActive ? 'scale(1.02)' : 'scale(1.08)' }}
                />
                <div className={`absolute inset-0 transition-opacity duration-500 ${isActive ? 'bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent' : 'bg-black/60 hover:bg-black/45'}`} />

                {!isActive && direction === 'horizontal' && (
                  <div className="absolute inset-0 flex items-center justify-center p-3 pointer-events-none">
                    <span className="text-slate-200 font-semibold text-sm tracking-wider uppercase [writing-mode:vertical-rl] rotate-180 drop-shadow select-none">
                      {item.title}
                    </span>
                  </div>
                )}

                <div className={`absolute inset-0 p-6 flex flex-col justify-end transition-all duration-500 ${isActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none'}`}>
                  <div className="max-w-md space-y-2">
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                      <Sparkles className="w-3 h-3" />
                      {item.category}
                    </span>
                    <h3 className="text-2xl font-bold text-white tracking-tight">{item.title}</h3>
                    <p className="text-slate-200/90 text-xs leading-relaxed line-clamp-2">{item.description}</p>
                    <div className="pt-2">
                      <button className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs tracking-wide shadow-md transition-all">
                        {item.ctaText}
                        <ArrowRight className="w-3.5 h-3.5" />
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      )}

      {/* ================= VARIANT 2: EDITORIAL / ASYMMETRIC ================= */}
      {activeVariant === 'variant-2' && (
        <div className="w-full rounded-2xl bg-stone-900 border border-stone-800 p-6 shadow-2xl">
          <div className="mb-4 pb-4 border-b border-stone-800 flex items-center justify-between text-xs text-stone-400">
            <span className="uppercase tracking-widest font-mono">Curated Portfolio Series</span>
            <span>Vol. 12 / 2026</span>
          </div>

          <div className={`flex gap-4 ${direction === 'vertical' ? 'flex-col' : 'flex-row h-[420px]'}`}>
            {ACCORDION_DATA.map((item) => {
              const isActive = activeId === item.id;
              return (
                <div
                  key={item.id}
                  onClick={() => handleInteraction(item.id, false)}
                  onMouseEnter={() => handleInteraction(item.id, true)}
                  className={`group relative overflow-hidden rounded-lg cursor-pointer border transition-all duration-500 ${
                    isActive
                      ? 'flex-[3] border-amber-500/60 bg-stone-950 shadow-xl'
                      : 'flex-1 border-stone-800/80 bg-stone-950/40 hover:border-stone-700'
                  }`}
                >
                  <div
                    className="absolute inset-0 bg-cover bg-center transition-all duration-700 grayscale contrast-125 group-hover:grayscale-0"
                    style={{ backgroundImage: `url(${item.imageUrl})`, opacity: isActive ? 0.35 : 0.15 }}
                  />

                  <div className="relative h-full p-5 flex flex-col justify-between z-10">
                    <div className="flex items-start justify-between">
                      <span className="font-mono text-2xl font-light text-amber-400/90">{item.num}</span>
                      <span className="text-[10px] uppercase font-mono tracking-wider text-stone-400 bg-stone-800/80 px-2 py-0.5 rounded">
                        {item.date}
                      </span>
                    </div>

                    <div>
                      <span className="text-[11px] uppercase tracking-widest text-amber-500 font-semibold block mb-1">
                        {item.category}
                      </span>
                      <h4 className="text-xl font-serif font-bold text-stone-100 group-hover:text-amber-200 transition-colors">
                        {item.title}
                      </h4>

                      {isActive && (
                        <div className="mt-3 pt-3 border-t border-stone-800 space-y-3 animate-fadeIn">
                          <p className="text-stone-300 text-xs font-sans leading-relaxed line-clamp-3">
                            {item.description}
                          </p>
                          <a
                            href="#view"
                            onClick={(e) => e.preventDefault()}
                            className="inline-flex items-center gap-1.5 text-xs text-amber-400 hover:text-amber-300 font-mono tracking-wide underline underline-offset-4"
                          >
                            <span>Read Full Documentation</span>
                            <ArrowRight className="w-3.5 h-3.5" />
                          </a>
                        </div>
                      )}
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}

      {/* ================= VARIANT 3: CYBER / MODERN GLASS ================= */}
      {activeVariant === 'variant-3' && (
        <div className="relative w-full rounded-2xl overflow-hidden bg-slate-950 border border-cyan-500/30 p-4 shadow-2xl shadow-cyan-950/40">
          <div className="absolute -top-24 -left-24 w-72 h-72 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none" />
          <div className="absolute -bottom-24 -right-24 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl pointer-events-none" />

          <div className={`relative flex gap-3 ${direction === 'vertical' ? 'flex-col h-[520px]' : 'h-[440px]'}`}>
            {ACCORDION_DATA.map((item) => {
              const isActive = activeId === item.id;
              return (
                <div
                  key={item.id}
                  onClick={() => handleInteraction(item.id, false)}
                  onMouseEnter={() => handleInteraction(item.id, true)}
                  className={`relative overflow-hidden rounded-xl cursor-pointer transition-all duration-500 backdrop-blur-md border ${
                    isActive
                      ? 'flex-[4] border-cyan-400/80 bg-slate-900/60 shadow-[0_0_25px_rgba(6,182,212,0.25)] ring-1 ring-cyan-400/40'
                      : 'flex-1 border-slate-800/80 bg-slate-900/30 hover:border-cyan-500/40'
                  }`}
                >
                  <div
                    className="absolute inset-0 bg-cover bg-center transition-transform duration-700"
                    style={{ backgroundImage: `url(${item.imageUrl})`, filter: isActive ? 'saturate(1.2)' : 'saturate(0.5)' }}
                  />
                  <div className={`absolute inset-0 transition-opacity ${isActive ? 'bg-gradient-to-t from-slate-950 via-slate-950/70 to-slate-950/20' : 'bg-slate-950/75'}`} />

                  {/* Corner Tech Accents */}
                  <div className="absolute top-2 left-2 w-2 h-2 border-t-2 border-l-2 border-cyan-400/60 pointer-events-none" />
                  <div className="absolute bottom-2 right-2 w-2 h-2 border-b-2 border-r-2 border-cyan-400/60 pointer-events-none" />

                  <div className="relative h-full p-6 flex flex-col justify-between z-10">
                    <div className="flex items-center justify-between">
                      <span className="font-mono text-xs px-2 py-0.5 rounded bg-cyan-950/80 text-cyan-300 border border-cyan-500/30">
                        SYS::{item.num}
                      </span>
                      {isActive && (
                        <span className="flex items-center gap-1.5 text-[10px] font-mono text-cyan-400">
                          <span className="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-ping" />
                          ONLINE
                        </span>
                      )}
                    </div>

                    <div>
                      {!isActive && direction === 'horizontal' && (
                        <div className="py-8 [writing-mode:vertical-rl] rotate-180 text-slate-300 font-mono text-xs tracking-widest uppercase">
                          {item.title}
                        </div>
                      )}

                      {isActive && (
                        <div className="space-y-3">
                          <span className="text-[11px] font-mono uppercase tracking-wider text-purple-400 block">
                            // {item.category}
                          </span>
                          <h3 className="text-2xl font-black tracking-tight text-white drop-shadow">
                            {item.title}
                          </h3>
                          <p className="text-xs text-slate-300 leading-relaxed font-sans line-clamp-2">
                            {item.description}
                          </p>
                          <div className="pt-1">
                            <button className="px-4 py-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg shadow-cyan-500/30 hover:brightness-110 flex items-center gap-2">
                              <span>Execute Protocol</span>
                              <ArrowRight className="w-3.5 h-3.5" />
                            </button>
                          </div>
                        </div>
                      )}
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}
    </div>
  );
};
