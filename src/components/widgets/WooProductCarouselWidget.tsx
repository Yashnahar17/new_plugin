import React, { useState, useEffect } from 'react';
import { SlidersHorizontal, Check, ShoppingBag, Star, ChevronLeft, ChevronRight, Play, Pause } from 'lucide-react';

export const WooProductCarouselWidget: React.FC = () => {
  const [activeVariant, setActiveVariant] = useState<'core' | 'editorial' | 'cyber'>('core');
  const [slidesToShow, setSlidesToShow] = useState<number>(3);
  const [autoplay, setAutoplay] = useState<boolean>(true);
  const [currentSlideIndex, setCurrentSlideIndex] = useState<number>(0);
  const [isPaused, setIsPaused] = useState<boolean>(false);
  const [cartFeedback, setCartFeedback] = useState<string | null>(null);

  const carouselItems = [
    {
      id: 1,
      title: 'Astra Stealth Chronograph',
      category: 'Timepieces',
      price: '$340.00',
      rating: 5,
      badge: 'NEW',
      image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop&q=60'
    },
    {
      id: 2,
      title: 'Studio Hi-Fi Headphones',
      category: 'Audio',
      price: '$210.00',
      rating: 5,
      badge: '-20%',
      image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=60'
    },
    {
      id: 3,
      title: 'Precision Ceramic Lamp',
      category: 'Lighting',
      price: '$180.00',
      rating: 4,
      badge: 'TOP',
      image: 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&auto=format&fit=crop&q=60'
    },
    {
      id: 4,
      title: 'Aerospace Mechanical Pen',
      category: 'Accessories',
      price: '$95.00',
      rating: 5,
      badge: 'HOT',
      image: 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=500&auto=format&fit=crop&q=60'
    },
    {
      id: 5,
      title: 'Nordic Leather Folio',
      category: 'Stationery',
      price: '$120.00',
      rating: 4,
      badge: 'SALE',
      image: 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=500&auto=format&fit=crop&q=60'
    }
  ];

  const maxIndex = Math.max(0, carouselItems.length - slidesToShow);

  useEffect(() => {
    if (!autoplay || isPaused) return;
    const interval = setInterval(() => {
      setCurrentSlideIndex((prev) => (prev >= maxIndex ? 0 : prev + 1));
    }, 3500);
    return () => clearInterval(interval);
  }, [autoplay, isPaused, maxIndex]);

  const handlePrev = () => {
    setCurrentSlideIndex((prev) => (prev <= 0 ? maxIndex : prev - 1));
  };

  const handleNext = () => {
    setCurrentSlideIndex((prev) => (prev >= maxIndex ? 0 : prev + 1));
  };

  const handleAddToCart = (title: string) => {
    setCartFeedback(`Added "${title}" to cart!`);
    setTimeout(() => setCartFeedback(null), 2500);
  };

  return (
    <div className="space-y-6">
      {/* Controls */}
      <div className="p-4 rounded-xl bg-slate-900 border border-slate-800 space-y-4">
        <div className="flex flex-wrap items-center justify-between gap-4">
          <div className="flex items-center gap-2">
            <SlidersHorizontal className="w-4 h-4 text-emerald-400" />
            <span className="text-xs font-bold text-white uppercase tracking-wider">
              Elementor Controls: Woo Product Carousel Slider
            </span>
          </div>

          <div className="flex flex-wrap gap-2">
            {[
              { id: 'core', name: 'Variant 1: Core Carousel' },
              { id: 'editorial', name: 'Variant 2: Editorial Slide' },
              { id: 'cyber', name: 'Variant 3: Cyber Monolith' }
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

        {/* Carousel Settings */}
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-3 border-t border-slate-800/80 text-xs">
          <div>
            <label className="text-slate-400 block mb-1">Slides To Show</label>
            <select
              value={slidesToShow}
              onChange={(e) => {
                setSlidesToShow(Number(e.target.value));
                setCurrentSlideIndex(0);
              }}
              className="w-full px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-200 focus:outline-none focus:border-emerald-500"
            >
              <option value={2}>2 Slides</option>
              <option value={3}>3 Slides</option>
            </select>
          </div>
          <div className="flex items-center pt-5">
            <label className="flex items-center gap-2 cursor-pointer text-slate-300">
              <input
                type="checkbox"
                checked={autoplay}
                onChange={(e) => setAutoplay(e.target.checked)}
                className="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4"
              />
              <span>Autoplay Slider</span>
            </label>
          </div>
          <div className="flex items-center pt-5">
            <span className="text-slate-400 font-mono text-[11px]">
              Slide {currentSlideIndex + 1} of {maxIndex + 1}
            </span>
          </div>
          <div className="flex items-center justify-end pt-4 gap-2">
            <button
              onClick={() => setIsPaused(!isPaused)}
              className="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 text-[11px] flex items-center gap-1"
              title={isPaused ? 'Resume autoplay' : 'Pause autoplay'}
            >
              {isPaused ? <Play className="w-3 h-3 text-emerald-400" /> : <Pause className="w-3 h-3 text-amber-400" />}
              <span>{isPaused ? 'Resume' : 'Pause'}</span>
            </button>
          </div>
        </div>

        {cartFeedback && (
          <div className="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
            <Check className="w-4 h-4 text-emerald-400" />
            <span>{cartFeedback}</span>
          </div>
        )}
      </div>

      {/* LIVE CAROUSEL TRACK */}
      <div
        className="p-6 sm:p-10 rounded-2xl bg-slate-950 border border-slate-800/80 relative"
        onMouseEnter={() => setIsPaused(true)}
        onMouseLeave={() => setIsPaused(false)}
        role="region"
        aria-roledescription="carousel"
        aria-label="Astrax WooCommerce Featured Product Carousel"
      >
        <div className="overflow-hidden">
          <div
            className="flex transition-transform duration-500 ease-out"
            style={{
              transform: `translateX(-${currentSlideIndex * (100 / slidesToShow)}%)`,
              width: `${(carouselItems.length / slidesToShow) * 100}%`
            }}
          >
            {carouselItems.map((item) => (
              <div
                key={item.id}
                className="px-3"
                style={{ width: `${100 / carouselItems.length}%` }}
                role="group"
                aria-roledescription="slide"
              >
                <div
                  className={`astrax-product-card group relative p-4 transition-all duration-300 h-full flex flex-col justify-between ${
                    activeVariant === 'core'
                      ? 'bg-slate-900 rounded-2xl border border-slate-800 hover:border-emerald-500/40 shadow-xl'
                      : activeVariant === 'editorial'
                      ? 'bg-[#faf8f5] dark:bg-stone-900 border-l-4 border-amber-600'
                      : 'bg-slate-900/90 backdrop-blur-xl border border-cyan-500/40 rounded-xl shadow-lg shadow-cyan-950/40'
                  }`}
                >
                  <div>
                    <div className="relative aspect-square overflow-hidden rounded-xl bg-slate-800 mb-3">
                      <img
                        src={item.image}
                        alt={item.title}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                      />
                      <span
                        className={`absolute top-2.5 left-2.5 px-2 py-0.5 rounded text-[10px] font-bold ${
                          activeVariant === 'cyber'
                            ? 'bg-cyan-950 text-cyan-300 border border-cyan-500/40'
                            : 'bg-emerald-600 text-white'
                        }`}
                      >
                        {item.badge}
                      </span>
                    </div>

                    <span className="text-[10px] uppercase font-mono tracking-wider text-slate-400 block mb-1">
                      {item.category}
                    </span>
                    <h4
                      className={`font-bold leading-snug line-clamp-1 mb-2 ${
                        activeVariant === 'editorial'
                          ? 'font-serif text-stone-900 dark:text-stone-100 text-base'
                          : activeVariant === 'cyber'
                          ? 'font-mono text-cyan-100 text-xs'
                          : 'text-sm text-white'
                      }`}
                    >
                      {item.title}
                    </h4>

                    <div className="flex items-center gap-1 mb-3 text-amber-400">
                      {Array.from({ length: 5 }).map((_, i) => (
                        <Star
                          key={i}
                          className={`w-3 h-3 ${i < item.rating ? 'fill-current' : 'text-slate-600'}`}
                        />
                      ))}
                    </div>
                  </div>

                  <div className="pt-3 border-t border-slate-800/80 flex items-center justify-between mt-auto">
                    <span
                      className={`font-bold ${
                        activeVariant === 'editorial'
                          ? 'font-serif text-stone-900 dark:text-stone-100'
                          : activeVariant === 'cyber'
                          ? 'font-mono text-cyan-300'
                          : 'text-emerald-400'
                      }`}
                    >
                      {item.price}
                    </span>
                    <button
                      onClick={() => handleAddToCart(item.title)}
                      className={`inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold ${
                        activeVariant === 'cyber'
                          ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 hover:bg-cyan-500 hover:text-slate-950'
                          : 'bg-emerald-600 text-white hover:bg-emerald-500'
                      }`}
                    >
                      <ShoppingBag className="w-3 h-3" />
                      <span>Add</span>
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Carousel Arrows */}
        <div className="flex items-center justify-between mt-6">
          <div className="flex items-center gap-2">
            <button
              onClick={handlePrev}
              aria-label="Previous product slide"
              className="p-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 border border-slate-800 hover:border-slate-700 transition-colors"
            >
              <ChevronLeft className="w-4 h-4" />
            </button>
            <button
              onClick={handleNext}
              aria-label="Next product slide"
              className="p-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 border border-slate-800 hover:border-slate-700 transition-colors"
            >
              <ChevronRight className="w-4 h-4" />
            </button>
          </div>

          {/* Dots Pagination */}
          <div className="flex items-center gap-1.5" role="tablist" aria-label="Slide dots">
            {Array.from({ length: maxIndex + 1 }).map((_, i) => (
              <button
                key={i}
                onClick={() => setCurrentSlideIndex(i)}
                aria-label={`Jump to slide page ${i + 1}`}
                className={`h-2 rounded-full transition-all ${
                  currentSlideIndex === i ? 'w-6 bg-emerald-500' : 'w-2 bg-slate-800 hover:bg-slate-700'
                }`}
              />
            ))}
          </div>
        </div>
      </div>

      {/* Selectors and Dependencies */}
      <div className="p-4 rounded-xl bg-slate-900/60 border border-slate-800 text-xs space-y-2">
        <div className="flex items-center justify-between text-slate-400">
          <span className="font-semibold text-slate-200">Elementor Selectors & Assets Mapped:</span>
          <span className="text-emerald-400 font-mono">100% (CSS: astrax-woo-carousel.css)</span>
        </div>
        <div className="flex flex-wrap gap-2 font-mono text-[11px] text-slate-400">
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-woo-carousel</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-carousel-slide</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.astrax-arrow</span>
          <span className="px-2 py-0.5 rounded bg-slate-800">.woocommerce.products</span>
        </div>
      </div>
    </div>
  );
};
