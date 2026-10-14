/**
 * Apple-Style Pinned Rack-Focus Word-Build Engine
 * Depth-of-field kinetic typography transition
 */

export function initRackFocus() {
  const section = document.getElementById('niorRackSection');
  const words = Array.from(document.querySelectorAll('#niorRackHeadline span.rack-word'));
  const sub = document.getElementById('niorRackSub');
  if (!section || !words.length) return;

  const eyebrow = section.querySelector('.nior-rack-eyebrow');
  const clamp = (v, min, max) => Math.max(min, Math.min(max, v));
  const n = words.length;

  function onScroll() {
    const rect = section.getBoundingClientRect();
    const range = section.offsetHeight - window.innerHeight;
    if (range <= 0) return;

    const p = clamp(-rect.top / range, 0, 1);

    // 1. Eyebrow "Our Philosophy" gracefully emerges onto the white canvas
    const eyebrowProgress = clamp(p / 0.12, 0, 1);
    if (eyebrow) {
      eyebrow.style.opacity = eyebrowProgress.toFixed(3);
      eyebrow.style.transform = `translateY(${((1 - eyebrowProgress) * 18).toFixed(2)}px)`;
    }

    // 2. Headline baseline emerges softly from pure white
    const baseWordOpacity = 0.14 * eyebrowProgress;

    // 3. Staggered rack-focus word transitions
    for (let k = 0; k < n; k++) {
      const wordStart = 0.10 + (k / n) * 0.68;
      const o = clamp((p - wordStart) / 0.08, 0, 1);
      const word = words[k];
      word.style.opacity = (baseWordOpacity + (1 - baseWordOpacity) * o).toFixed(3);
      word.style.transform = `translateY(${((1 - o) * 0.25).toFixed(3)}em)`;
      word.style.filter = `blur(${((1 - o) * 6).toFixed(2)}px)`;
    }

    // 4. Subtitle reveals as word sequence completes
    if (sub) {
      sub.style.opacity = clamp((p - 0.82) / 0.15, 0, 1).toFixed(3);
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });
  onScroll();
}
