(() => {
  const initReveal = (root) => {
    const nodes = [];
    if (root.nodeType === Node.ELEMENT_NODE && root.matches('[data-astrax-v3-reveal]')) nodes.push(root);
    nodes.push(...root.querySelectorAll('[data-astrax-v3-reveal]'));
    nodes.forEach((node) => {
      if (node.dataset.revealInitialized) return;
      node.dataset.revealInitialized = 'true';
      if (!('IntersectionObserver' in window)) {
        node.classList.add('is-visible');
        return;
      }
      node.classList.add('astrax-v3-reveal-pending');
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        });
      }, { threshold: 0.15 });
      observer.observe(node);
    });
  };

  const initialize = () => {
    initReveal(document);
    if ('MutationObserver' in window) {
      const observer = new MutationObserver((records) => {
        records.forEach((record) => record.addedNodes.forEach((node) => {
          if (node.nodeType === Node.ELEMENT_NODE) initReveal(node);
        }));
      });
      observer.observe(document.documentElement, { childList: true, subtree: true });
    }
  };

  document.addEventListener('click', (event) => {
    const navigation = event.target.closest('[data-gallery-prev], [data-gallery-next]');
    if (navigation) {
      const gallery = navigation.closest('[data-astrax-v3-carousel]');
      const track = gallery && gallery.querySelector('.astrax-v3-gallery-items');
      if (!track) return;
      const direction = navigation.hasAttribute('data-gallery-next') ? 1 : -1;
      const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
      track.scrollBy({ left: direction * track.clientWidth * 0.85, behavior });
      return;
    }

    const hotspot = event.target.closest('.astrax-v3-hotspot');
    if (hotspot) {
      const expanded = hotspot.getAttribute('aria-expanded') === 'true';
      hotspot.setAttribute('aria-expanded', String(!expanded));
      const content = hotspot.querySelector('.astrax-v3-hotspot-content');
      if (content) content.hidden = expanded;
    }
  });

  let syncing = false;
  document.addEventListener('scroll', (event) => {
    const track = event.target;
    if (syncing || !track.matches || !track.matches('.astrax-v3-gallery-items')) return;
    const gallery = track.closest('[data-astrax-v3-sync]');
    const group = gallery && gallery.dataset.astraxV3Sync;
    if (!group) return;
    const peers = document.querySelectorAll(`[data-astrax-v3-sync="${CSS.escape(group)}"] .astrax-v3-gallery-items`);
    const ratio = track.scrollWidth > track.clientWidth ? track.scrollLeft / (track.scrollWidth - track.clientWidth) : 0;
    syncing = true;
    peers.forEach((peer) => {
      if (peer !== track) peer.scrollLeft = ratio * Math.max(0, peer.scrollWidth - peer.clientWidth);
    });
    requestAnimationFrame(() => { syncing = false; });
  }, true);

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialize, { once: true });
  } else {
    initialize();
  }
})();
