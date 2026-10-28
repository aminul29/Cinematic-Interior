/**
 * Apple-Style Pinned Rack-Focus Word-Build Engine & Next-Section Card Takeover
 * Depth-of-field kinetic typography transition with pinned card-to-fullscreen morph.
 */

export function initRackFocus() {
  const section = document.getElementById('niorRackSection');
  const stage = section ? section.querySelector('.nior-rack-stage') : null;
  const words = Array.from(document.querySelectorAll('#niorRackHeadline span.rack-word'));
  const sub = document.getElementById('niorRackSub');
  if (!section || !words.length) return;

  const { ScrollTrigger } = window;
  const eyebrow = section.querySelector('.nior-rack-eyebrow');
  const clamp = (v, min, max) => Math.max(min, Math.min(max, v));
  const n = words.length;

  // Locate the next section (Cinematic Scenarios)
  const nextSection = section.nextElementSibling || document.getElementById('niorScenarios');
  const isMobile = window.innerWidth <= 768;

  if (isMobile) {
    section.style.visibility = 'visible';
    section.style.opacity = '1';
    section.style.pointerEvents = 'auto';
    if (stage) {
      stage.style.visibility = 'visible';
      stage.style.opacity = '1';
      stage.style.pointerEvents = 'auto';
    }
  }

  // 1. GSAP ScrollTrigger Pinning of "Our Philosophy" Stage
  // Keeps the Philosophy stage pinned at top: 0 while the next section glides up over it.
  if (stage && nextSection && ScrollTrigger) {
    ScrollTrigger.create({
      trigger: section,
      start: 'top top',
      endTrigger: nextSection,
      end: 'top top',
      pin: stage,
      pinSpacing: false,
      anticipatePin: 1,
      onToggle: (self) => {
        if (self.isActive) {
          section.style.visibility = 'visible';
          section.style.opacity = '1';
          section.style.pointerEvents = 'auto';
          stage.style.visibility = 'visible';
          stage.style.opacity = '1';
          stage.style.pointerEvents = 'auto';
        } else if (!isMobile && self.scroll() < self.start) {
          section.style.visibility = 'hidden';
          section.style.opacity = '0';
          section.style.pointerEvents = 'none';
          stage.style.visibility = 'hidden';
          stage.style.opacity = '0';
          stage.style.pointerEvents = 'none';
        }
      },
      onUpdate: (self) => {
        if (self.isActive) {
          section.style.visibility = 'visible';
          section.style.opacity = '1';
          section.style.pointerEvents = 'auto';
          stage.style.visibility = 'visible';
          stage.style.opacity = '1';
          stage.style.pointerEvents = 'auto';
        }
      },
    });

    // 2. Next Section Morph: Huge Border-Radius & Margin -> Full Screen
    // As the next section scrolls from entering the viewport (top bottom) to covering Philosophy (top top),
    // its huge border radius and margins smoothly reduce to 0, expanding into 100% full screen.
    const updateNextSectionCard = (progress) => {
      if (!nextSection) return;
      const p = clamp(progress, 0, 1);
      const vw = window.innerWidth;
      const isMobile = vw <= 768;

      if (isMobile) {
        // On mobile devices, keep edges completely flush to prevent any horizontal clipping
        nextSection.style.borderTopLeftRadius = '0px';
        nextSection.style.borderTopRightRadius = '0px';
        nextSection.style.borderBottomLeftRadius = '0px';
        nextSection.style.borderBottomRightRadius = '0px';
        nextSection.style.marginLeft = '0px';
        nextSection.style.marginRight = '0px';
        nextSection.style.boxShadow = 'none';
        return;
      }

      // Huge border radius: 56px on desktop (scales down on smaller viewports)
      const maxRadius = Math.min(64, Math.max(28, vw * 0.045));
      // Huge margin: 48px on desktop (scales down on smaller viewports)
      const maxMargin = Math.min(60, Math.max(16, vw * 0.04));

      if (p >= 0.999) {
        // Fully on top: 100% Full Screen flush with viewport edges
        nextSection.style.borderTopLeftRadius = '0px';
        nextSection.style.borderTopRightRadius = '0px';
        nextSection.style.borderBottomLeftRadius = '0px';
        nextSection.style.borderBottomRightRadius = '0px';
        nextSection.style.marginLeft = '0px';
        nextSection.style.marginRight = '0px';
        nextSection.style.boxShadow = 'none';
      } else if (p <= 0.001) {
        // Initial Card State: Huge border-radius & margin with architectural elevation shadow
        nextSection.style.borderTopLeftRadius = `${maxRadius.toFixed(1)}px`;
        nextSection.style.borderTopRightRadius = `${maxRadius.toFixed(1)}px`;
        nextSection.style.borderBottomLeftRadius = `${maxRadius.toFixed(1)}px`;
        nextSection.style.borderBottomRightRadius = `${maxRadius.toFixed(1)}px`;
        nextSection.style.marginLeft = `${maxMargin.toFixed(1)}px`;
        nextSection.style.marginRight = `${maxMargin.toFixed(1)}px`;
        nextSection.style.boxShadow = '0 -25px 60px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.08)';
      } else {
        // Fluid interpolation as next section glides on top of Philosophy
        const factor = 1 - p;
        const currentRadius = (factor * maxRadius).toFixed(1);
        const currentMargin = (factor * maxMargin).toFixed(1);
        const shadowAlpha = (factor * 0.45).toFixed(3);
        const borderAlpha = (factor * 0.08).toFixed(3);

        nextSection.style.borderTopLeftRadius = `${currentRadius}px`;
        nextSection.style.borderTopRightRadius = `${currentRadius}px`;
        nextSection.style.borderBottomLeftRadius = `${currentRadius}px`;
        nextSection.style.borderBottomRightRadius = `${currentRadius}px`;
        nextSection.style.marginLeft = `${currentMargin}px`;
        nextSection.style.marginRight = `${currentMargin}px`;
        nextSection.style.boxShadow = `0 -25px 60px rgba(0, 0, 0, ${shadowAlpha}), 0 0 0 1px rgba(255, 255, 255, ${borderAlpha})`;
      }
    };

    ScrollTrigger.create({
      trigger: nextSection,
      start: 'top bottom',
      end: 'top top',
      scrub: true,
      onUpdate: (self) => updateNextSectionCard(self.progress),
      onRefresh: (self) => updateNextSectionCard(self.progress),
    });
  }

  // 3. Apple-Style Typography Rack-Focus Animation
  function onScroll() {
    const rect = section.getBoundingClientRect();
    const range = section.offsetHeight - window.innerHeight;
    if (range <= 0) return;

    const p = clamp(-rect.top / range, 0, 1);

    // Guarantee section visibility when reached, and keep completely hidden when above (in hero)
    if (rect.top <= 0) {
      section.style.visibility = 'visible';
      section.style.opacity = '1';
      section.style.pointerEvents = 'auto';
      if (stage) {
        stage.style.visibility = 'visible';
        stage.style.opacity = '1';
        stage.style.pointerEvents = 'auto';
      }
    } else {
      section.style.visibility = 'hidden';
      section.style.opacity = '0';
      section.style.pointerEvents = 'none';
      if (stage) {
        stage.style.visibility = 'hidden';
        stage.style.opacity = '0';
        stage.style.pointerEvents = 'none';
      }
    }

    // 1. Eyebrow "Our Philosophy" appears immediately as soon as the circle consumes the hero section
    if (eyebrow) {
      eyebrow.style.opacity = '1';
      eyebrow.style.transform = 'translateY(0px)';
    }

    // 2. Headline baseline: Soft luxury rack blur with first word in crisp focus at p=0
    const baseWordOpacity = 0.18;

    // 3. Staggered rack-focus word transitions: unfolds smoothly from p = 0.00 to 0.68
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
      word.style.filter = 'none';
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
