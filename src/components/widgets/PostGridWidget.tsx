import React, { useState } from 'react';
import { SlidersHorizontal, Check, Calendar, ArrowRight, Sparkles } from 'lucide-react';

export const PostGridWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'core' | 'editorial' | 'cyber'>('core');

  const samplePosts = [
    {
      title: 'Architecting Scalable WordPress Addons with PSR-4',
      date: 'Sept 30, 2026',
      tag: 'Engineering',
      excerpt: 'How native autoloader trees prevent symbol collision and deliver zero-overhead runtime execution.'
    },
    {
      title: 'Zero-Runtime CSS Bleed: Namespacing Design Systems',
      date: 'Sept 28, 2026',
      tag: 'Architecture',
      excerpt: 'Strict CSS token isolation eliminates layout collision across third-party theme ecosystems.'
    }
  ];

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
      </div>

      {/* Rendered Preview Canvas */}
      <div className="p-6 rounded-2xl bg-slate-950/70 border border-slate-800/80">
        {activeVariant === 'core' && (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {samplePosts.map((post, idx) => (
              <article key={idx} className="bg-white rounded-xl border border-slate-200 p-6 text-slate-900 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all">
                <div className="flex items-center gap-2 text-xs text-emerald-700 font-semibold mb-2">
                  <span className="px-2 py-0.5 rounded-full bg-emerald-50">{post.tag}</span>
                  <span>•</span>
                  <span>{post.date}</span>
                </div>
                <h4 className="text-lg font-bold text-slate-900 mb-2 hover:text-emerald-700 transition-colors">
                  {post.title}
                </h4>
                <p className="text-xs text-slate-600 leading-relaxed mb-4">{post.excerpt}</p>
                <div className="text-xs font-bold text-emerald-700 flex items-center gap-1">
                  Read Article <ArrowRight className="w-3.5 h-3.5" />
                </div>
              </article>
            ))}
          </div>
        )}

        {activeVariant === 'editorial' && (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {samplePosts.map((post, idx) => (
              <article key={idx} className="bg-[#fdfbf7] p-7 border border-[#e8e3d9] text-[#1a1612] hover:bg-[#faf4e8] transition-colors">
                <div className="flex items-center gap-2 font-serif text-xs text-[#8c4a27] mb-3 uppercase tracking-widest border-b border-[#e8e3d9] pb-2">
                  <span>{post.tag}</span>
                  <span>/</span>
                  <span>{post.date}</span>
                </div>
                <h4 className="font-serif text-2xl font-bold text-[#1a1612] mb-3 leading-snug hover:text-[#8c4a27] transition-colors">
                  {post.title}
                </h4>
                <p className="font-serif text-[14px] text-[#4a3e35] leading-relaxed mb-4">{post.excerpt}</p>
                <div className="font-serif italic text-xs text-[#8c4a27] flex items-center gap-1">
                  Continue Reading →
                </div>
              </article>
            ))}
          </div>
        )}

        {activeVariant === 'cyber' && (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {samplePosts.map((post, idx) => (
              <article key={idx} className="bg-slate-900/90 border border-cyan-500/30 backdrop-blur-xl p-6 rounded-lg text-slate-100 shadow-[0_0_20px_rgba(6,182,212,0.1)] hover:border-cyan-400 hover:shadow-[0_0_30px_rgba(6,182,212,0.3)] transition-all">
                <div className="flex items-center justify-between text-[11px] font-mono text-cyan-400 mb-3 border-b border-cyan-500/20 pb-2">
                  <span className="flex items-center gap-1">
                    <Sparkles className="w-3 h-3 text-purple-400" />
                    TAG: {post.tag.toUpperCase()}
                  </span>
                  <span>{post.date}</span>
                </div>
                <h4 className="text-base font-mono font-bold text-white mb-2 hover:text-cyan-400 transition-colors">
                  {post.title}
                </h4>
                <p className="text-xs text-slate-300 font-sans leading-relaxed mb-4">{post.excerpt}</p>
                <div className="text-[11px] font-mono text-cyan-400 flex items-center gap-1">
                  [EXEC_LINK: POST_VIEW]
                </div>
              </article>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};
