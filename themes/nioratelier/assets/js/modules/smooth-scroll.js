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

  window.niorLenis = lenis;
  return lenis;
}
