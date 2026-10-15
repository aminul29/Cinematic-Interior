/**
 * Weighted Silky Smooth Scroll Engine (Lenis + GSAP Sync)
 * Based on the cinematic-scroll-homepage skill architecture.
 */

export function initSmoothScroll() {
  if (typeof window.Lenis === 'undefined' || typeof window.gsap === 'undefined') {
    return null;
  }

  const { gsap, ScrollTrigger, Lenis } = window;
  if (ScrollTrigger) {
    gsap.registerPlugin(ScrollTrigger);
  }

  // Buttery-smooth, weighted luxury Lenis configuration
  const lenis = new Lenis({
    duration: 1.35,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Velvety exponential deceleration
    orientation: 'vertical',
    gestureOrientation: 'vertical',
    smoothWheel: true,
    wheelMultiplier: 0.88, // Softens aggressive wheel jumps
    touchMultiplier: 1.5,
  });

  // Keep ScrollTrigger coordinate system in sync
  if (ScrollTrigger) {
    lenis.on('scroll', ScrollTrigger.update);
  }

  const updateTicker = (time) => {
    lenis.raf(time * 1000);
  };

  gsap.ticker.add(updateTicker);
  gsap.ticker.lagSmoothing(500, 33);

  setTimeout(() => {
    if (ScrollTrigger) {
      ScrollTrigger.refresh();
    }
  }, 150);

  // Recalculate layout geometries when late-loading fonts and images finish loading
  window.addEventListener('load', () => {
    if (ScrollTrigger) {
      ScrollTrigger.refresh();
    }
  });

  // Smoothly glide internal anchor links via Lenis
  document.addEventListener('click', (e) => {
    const anchor = e.target.closest('a[href*="#"]');
    if (!anchor) return;
    try {
      const url = new URL(anchor.href, window.location.href);
      if (url.pathname === window.location.pathname && url.hash && url.hash.length > 1) {
        const targetEl = document.querySelector(url.hash);
        if (targetEl) {
          e.preventDefault();
          lenis.scrollTo(targetEl, {
            offset: -80,
            duration: 1.4,
          });
        }
      }
    } catch {
      // Fallback to default browser handling
    }
  });

  window.niorLenis = lenis;
  return lenis;
}
