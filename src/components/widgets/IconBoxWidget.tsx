import React, { useState } from 'react';
import { SlidersHorizontal, Check, Zap, Shield, Sparkles, Terminal } from 'lucide-react';

export const IconBoxWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'core' | 'editorial' | 'cyber'>('core');
  const [title, setTitle] = useState('Enterprise Infrastructure');
  const [description, setDescription] = useState(
    'Engineered with micro-modular CSS architecture, zero global selector leakage, and full Elementor style control synchronization.'
  );

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
              { id: 'core', name: 'Variant 1: Core Refined' },
              { id: 'editorial', name: 'Variant 2: Editorial Serif' },
              { id: 'cyber', name: 'Variant 3: Cyber Monospace' }
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
        <div className="grid grid-cols-1 md:grid-cols-2 gap-3 pt-3 border-t border-slate-800/80 text-xs">
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
            <label className="text-slate-400 block mb-1">Description</label>
            <input
              type="text"
              value={description}
              onChange={(e) => setDescription(e.target.value)}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            />
          </div>
        </div>
      </div>

      {/* Rendered Preview Canvas */}
      <div className="p-8 rounded-2xl bg-slate-950/70 border border-slate-800/80 flex items-center justify-center min-h-[300px]">
        {activeVariant === 'core' && (
          <div className="max-w-md w-full p-7 rounded-2xl bg-white text-slate-900 border border-slate-200 shadow-xl transition-all hover:-translate-y-1 hover:shadow-2xl">
            <div className="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-5 transition-transform hover:scale-105">
              <Zap className="w-7 h-7" />
            </div>
            <h3 className="text-xl font-bold text-slate-900 mb-2">{title}</h3>
            <p className="text-sm text-slate-600 leading-relaxed">{description}</p>
            <div className="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 font-mono">
              <span>.astrax-icon-box-wrapper</span>
              <span className="text-emerald-600 font-semibold">.astrax-variant-core</span>
            </div>
          </div>
        )}

        {activeVariant === 'editorial' && (
          <div className="max-w-md w-full p-8 bg-[#fdfbf7] text-[#1a1612] border border-[#e8e3d9] border-l-4 border-l-[#8c4a27] transition-all hover:bg-[#faf4e8]">
            <div className="text-[#8c4a27] mb-5">
              <Shield className="w-8 h-8" />
            </div>
            <h3 className="text-2xl font-serif font-bold text-[#1a1612] mb-3 leading-snug">{title}</h3>
            <p className="font-serif text-[15px] text-[#4a3e35] leading-relaxed">{description}</p>
            <div className="mt-5 pt-4 border-t border-[#e8e3d9] flex items-center justify-between text-xs text-[#8c4a27] font-serif italic">
              <span>astrax-icon-box</span>
              <span>astrax-variant-editorial</span>
            </div>
          </div>
        )}

        {activeVariant === 'cyber' && (
          <div className="max-w-md w-full p-7 rounded-lg bg-slate-900/90 text-slate-100 border border-cyan-500/40 backdrop-blur-xl shadow-[0_0_30px_rgba(6,182,212,0.15)] transition-all hover:border-cyan-400 hover:shadow-[0_0_40px_rgba(6,182,212,0.35)] hover:-translate-y-1">
            <div className="text-cyan-400 mb-4 inline-block drop-shadow-[0_0_10px_rgba(6,182,212,0.7)]">
              <Terminal className="w-8 h-8" />
            </div>
            <div className="text-[11px] font-mono text-purple-400 uppercase tracking-widest mb-1 flex items-center gap-1.5">
              <Sparkles className="w-3.5 h-3.5" />
              <span>[SYS.NODE_ONLINE]</span>
            </div>
            <h3 className="text-lg font-mono font-bold text-white mb-2">{title}</h3>
            <p className="text-xs text-slate-300 font-sans leading-relaxed">{description}</p>
            <div className="mt-5 pt-3 border-t border-cyan-500/20 flex items-center justify-between text-[11px] font-mono text-cyan-400">
              <span>CLASS: ICON_BOX</span>
              <span>VARIANT: CYBER</span>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};
