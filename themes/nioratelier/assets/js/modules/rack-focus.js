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

    // Guarantee section visibility when reached
    if (rect.top <= 0) {
      section.style.visibility = 'visible';
    }

    // 1. Eyebrow "Our Philosophy" appears immediately as soon as the circle consumes the hero section
    if (eyebrow) {
      eyebrow.style.opacity = '1';
      eyebrow.style.transform = 'translateY(0px)';
    }

    // 2. Headline baseline: Soft luxury rack blur with first word in crisp focus at p=0
    const baseWordOpacity = 0.18;

    // 3. Staggered rack-focus word transitions: unfolds smoothly from p = 0.00 to 0.70
    for (let k = 0; k < n; k++) {
      const wordStart = (k / (n - 1)) * 0.68;
      const word = words[k];

      let o = 0;
      if (k === 0) {
        // First word "We" is 100% focused at the start of Philosophy section
        o = 1.0;
      } else {
        o = clamp((p - wordStart) / 0.06, 0, 1);
      }

      word.style.opacity = (baseWordOpacity + (1 - baseWordOpacity) * o).toFixed(3);
      word.style.transform = `translateY(${((1 - o) * 0.22).toFixed(3)}em)`;
      word.style.filter = `blur(${((1 - o) * 5.5).toFixed(2)}px)`;
    }

    // 4. Subtitle reveals gracefully as word sequence nears completion
    if (sub) {
      sub.style.opacity = clamp((p - 0.70) / 0.18, 0, 1).toFixed(3);
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });
  onScroll();
}
