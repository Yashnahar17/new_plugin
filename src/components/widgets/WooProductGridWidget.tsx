import React, { useState } from 'react';
import { SlidersHorizontal, Check, ShoppingBag, Star, Eye, ArrowRight, Heart } from 'lucide-react';

export const WooProductGridWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'core' | 'editorial' | 'cyber'>('core');
  const [columns, setColumns] = useState<number>(3);
  const [showRating, setShowRating] = useState<boolean>(true);
  const [showPrice, setShowPrice] = useState<boolean>(true);
  const [showAddToCart, setShowAddToCart] = useState<boolean>(true);
  const [cartFeedback, setCartFeedback] = useState<string | null>(null);

  const mockProducts = [
    {
      id: 1,
      title: 'Minimalist Titanium Chrono',
      price: '$285.00',
      rating: 5,
      badge: 'SALE',
      category: 'Watches',
      image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop&q=60'
    },
    {
      id: 2,
      title: 'Acoustic Studio Headphones',
      price: '$199.00',
      rating: 4,
      badge: 'FEATURED',
      category: 'Audio',
      image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=60'
    },
    {
      id: 3,
      title: 'Ergonomic Desk Luminary',
      price: '$149.00',
      rating: 5,
      badge: 'HOT',
      category: 'Workspace',
      image: 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&auto=format&fit=crop&q=60'
    }
  ];

  const handleAddToCart = (title: string) => {
    setCartFeedback(`Added "${title}" to WooCommerce Cart!`);
    setTimeout(() => setCartFeedback(null), 2500);
  };

  return (
    <div className="space-y-6">
      {/* Elementor Controls */}
      <div className="p-4 rounded-xl bg-slate-900 border border-slate-800 space-y-4">
        <div className="flex flex-wrap items-center justify-between gap-4">
          <div className="flex items-center gap-2">
            <SlidersHorizontal className="w-4 h-4 text-emerald-400" />
            <span className="text-xs font-bold text-white uppercase tracking-wider">
              Elementor Controls: WooCommerce Product Grid
            </span>
          </div>

          <div className="flex flex-wrap gap-2">
            {[
              { id: 'core', name: 'Variant 1: Core E-Commerce' },
              { id: 'editorial', name: 'Variant 2: Editorial Boutique' },
              { id: 'cyber', name: 'Variant 3: Cyber Glass' }
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

        {/* Options */}
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-3 border-t border-slate-800/80 text-xs">
          <div>
            <label className="text-slate-400 block mb-1">Columns</label>
            <select
              value={columns}
              onChange={(e) => setColumns(Number(e.target.value))}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            >
              <option value={2}>2 Columns</option>
              <option value={3}>3 Columns</option>
            </select>
          </div>
          <div className="flex items-center pt-5">
            <label className="flex items-center gap-2 cursor-pointer text-slate-300">
              <input
                type="checkbox"
                checked={showPrice}
                onChange={(e) => setShowPrice(e.target.checked)}
                className="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4"
              />
              <span>Show Price</span>
            </label>
          </div>
          <div className="flex items-center pt-5">
            <label className="flex items-center gap-2 cursor-pointer text-slate-300">
              <input
                type="checkbox"
                checked={showRating}
                onChange={(e) => setShowRating(e.target.checked)}
                className="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4"
              />
              <span>Show Rating</span>
            </label>
          </div>
          <div className="flex items-center pt-5">
            <label className="flex items-center gap-2 cursor-pointer text-slate-300">
              <input
                type="checkbox"
                checked={showAddToCart}
                onChange={(e) => setShowAddToCart(e.target.checked)}
                className="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4"
              />
              <span>Show Add to Cart</span>
            </label>
          </div>
        </div>

        {cartFeedback && (
          <div className="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2 animate-fade-in">
            <Check className="w-4 h-4 text-emerald-400" />
            <span>{cartFeedback}</span>
          </div>
        )}
      </div>

      {/* LIVE PREVIEW CONTAINER */}
      <div className="p-6 sm:p-10 rounded-2xl bg-slate-950 border border-slate-800/80">
        <div
          className={`grid gap-6 ${
            columns === 2 ? 'grid-cols-1 md:grid-cols-2' : 'grid-cols-1 md:grid-cols-3'
          }`}
        >
          {mockProducts.slice(0, columns).map((product) => (
            <div
              key={product.id}
              className={`astrax-product-card group relative transition-all duration-300 ${
                activeVariant === 'core'
                  ? 'bg-slate-900 rounded-2xl border border-slate-800 p-4 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-950/20'
                  : activeVariant === 'editorial'
                  ? 'bg-[#faf8f5] dark:bg-stone-900 border-t-2 border-stone-800 dark:border-stone-200 p-5'
                  : 'bg-slate-900/80 backdrop-blur-xl border border-cyan-500/30 p-4 rounded-xl shadow-lg shadow-cyan-950/40'
              }`}
            >
              {/* Image & Badge */}
              <div className="relative aspect-square overflow-hidden rounded-xl bg-slate-800 mb-4">
                <img
                  src={product.image}
                  alt={product.title}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                <span
                  className={`absolute top-3 left-3 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider ${
                    activeVariant === 'cyber'
                      ? 'bg-cyan-950/80 text-cyan-300 border border-cyan-500/40'
                      : activeVariant === 'editorial'
                      ? 'bg-stone-900 text-white dark:bg-stone-100 dark:text-stone-900'
                      : 'bg-emerald-600 text-white'
                  }`}
                >
                  {product.badge}
                </span>
                <button
                  type="button"
                  aria-label="Wishlist"
                  className="absolute top-3 right-3 p-1.5 rounded-full bg-slate-900/60 text-slate-300 hover:text-rose-400 hover:bg-slate-900 transition-colors"
                >
                  <Heart className="w-3.5 h-3.5" />
                </button>
              </div>

              {/* Title & Category */}
              <div className="mb-2">
                <span className="text-[10px] uppercase font-mono tracking-wider text-slate-400 block mb-1">
                  {product.category}
                </span>
                <h4
                  className={`astrax-product-title font-bold leading-snug line-clamp-1 ${
                    activeVariant === 'editorial'
                      ? 'font-serif text-lg text-stone-900 dark:text-stone-100'
                      : activeVariant === 'cyber'
                      ? 'font-mono text-sm text-cyan-100'
                      : 'text-sm text-white'
                  }`}
                >
                  <a href="#product" className="hover:text-emerald-400 transition-colors">
                    {product.title}
                  </a>
                </h4>
              </div>

              {/* Rating */}
              {showRating && (
                <div className="flex items-center gap-1 mb-3 text-amber-400">
                  {Array.from({ length: 5 }).map((_, i) => (
                    <Star
                      key={i}
                      className={`w-3 h-3 ${i < product.rating ? 'fill-current' : 'text-slate-600'}`}
                    />
                  ))}
                  <span className="text-[10px] text-slate-400 font-mono ml-1">({product.rating}.0)</span>
                </div>
              )}

              {/* Price & CTA */}
              <div className="pt-3 border-t border-slate-800/80 flex items-center justify-between">
                {showPrice && (
                  <div className="astrax-product-price">
                    <span
                      className={`font-bold ${
                        activeVariant === 'editorial'
                          ? 'font-serif text-stone-900 dark:text-stone-100 text-base'
                          : activeVariant === 'cyber'
                          ? 'font-mono text-cyan-300 text-sm'
                          : 'text-emerald-400 text-base'
                      }`}
                    >
                      {product.price}
                    </span>
                  </div>
                )}

                {showAddToCart && (
                  <button
                    onClick={() => handleAddToCart(product.title)}
                    className={`inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all ${
                      activeVariant === 'editorial'
                        ? 'bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 hover:bg-stone-800'
                        : activeVariant === 'cyber'
                        ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 hover:bg-cyan-500 hover:text-slate-950'
                        : 'bg-emerald-600 text-white hover:bg-emerald-500 shadow-md shadow-emerald-950/40'
                    }`}
                  >
                    <ShoppingBag className="w-3.5 h-3.5" />
                    <span>Add to Cart</span>
                  </button>
                )}
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Selector & Quality Mapping */}
      <div className="p-4 rounded-xl bg-slate-900/60 border border-slate-800 text-xs space-y-2">
        <div className="flex items-center justify-between text-slate-400">
          <span className="font-semibold text-slate-200">Elementor Selectors Mapped:</span>
          <span className="text-emerald-400 font-mono">100% (4/4 selectors active)</span>
        </div>
        <div className="flex flex-wrap gap-2 font-mono text-[11px] text-slate-400">
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-woo-product-grid</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-product-card</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-product-title a</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-product-price</span>
        </div>
      </div>
    </div>
  );
};
