import React, { useState } from 'react';
import { SlidersHorizontal, Check, ArrowRight, Sparkles, Command, Zap } from 'lucide-react';

export const AdvancedButtonWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'variant-1' | 'variant-2' | 'variant-3'>('variant-1');
  const [buttonText, setButtonText] = useState('Explore Component Library');

  return (
    <div className="space-y-6">
      {/* Control Selector */}
      <div className="p-4 rounded-xl bg-slate-900 border border-slate-800 flex flex-wrap items-center justify-between gap-4">
        <div className="flex items-center gap-2">
          <SlidersHorizontal className="w-4 h-4 text-emerald-400" />
          <span className="text-xs font-bold text-white uppercase tracking-wider">
            Elementor Control: design_variant
          </span>
        </div>

        <div className="flex flex-wrap gap-2">
          {[
            { id: 'variant-1', name: 'Variant 1: Magnetic Solid' },
            { id: 'variant-2', name: 'Variant 2: Split Dual Action' },
            { id: 'variant-3', name: 'Variant 3: Holographic Glass' }
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

      {/* Button Preview Canvas */}
      <div className="p-12 rounded-2xl bg-slate-950 border border-slate-800 flex flex-col items-center justify-center min-h-[220px]">
        {/* VARIANT 1: MAGNETIC SOLID */}
        {activeVariant === 'variant-1' && (
          <div className="text-center space-y-4">
            <button className="relative group px-8 py-4 rounded-xl font-bold text-sm text-white overflow-hidden shadow-xl shadow-emerald-900/40 transition-all hover:scale-105 active:scale-95 bg-emerald-600 hover:bg-emerald-500">
              <span className="relative flex items-center gap-3">
                <span>{buttonText}</span>
                <ArrowRight className="w-4 h-4 transition-transform group-hover:translate-x-1" />
              </span>
            </button>
            <p className="text-xs text-slate-500">Design 1: High-contrast solid primary CTA with arrow translation.</p>
          </div>
        )}

        {/* VARIANT 2: SPLIT DUAL ACTION */}
        {activeVariant === 'variant-2' && (
          <div className="text-center space-y-4">
            <div className="inline-flex rounded-xl bg-stone-900 p-1 border border-stone-700 shadow-2xl">
              <button className="px-6 py-3 rounded-lg text-xs font-serif font-bold text-stone-100 bg-stone-800 hover:bg-stone-700 transition-colors flex items-center gap-2">
                <span>{buttonText}</span>
              </button>
              <div className="w-[1px] bg-stone-700 my-1" />
              <button className="px-4 py-3 rounded-lg text-xs font-mono font-medium text-amber-400 hover:bg-stone-800 transition-colors flex items-center gap-1.5">
                <Command className="w-3.5 h-3.5" />
                <span>K</span>
              </button>
            </div>
            <p className="text-xs text-slate-500">Design 2: Editorial segmented action bar with keyboard shortcut hint.</p>
          </div>
        )}

        {/* VARIANT 3: HOLOGRAPHIC GLASS */}
        {activeVariant === 'variant-3' && (
          <div className="text-center space-y-4">
            <button className="relative group px-8 py-4 rounded-xl font-mono text-xs uppercase tracking-widest text-cyan-300 bg-cyan-950/40 hover:bg-cyan-950/80 border border-cyan-500/50 backdrop-blur-md shadow-[0_0_20px_rgba(6,182,212,0.2)] transition-all hover:scale-105 flex items-center gap-3">
              <Zap className="w-4 h-4 text-cyan-400 animate-pulse" />
              <span>{buttonText}</span>
              <span className="w-2 h-2 rounded-full bg-cyan-400 group-hover:animate-ping" />
            </button>
            <p className="text-xs text-slate-500">Design 3: Translucent cybernetic glass button with neon ping indicator.</p>
          </div>
        )}
      </div>
    </div>
  );
};
