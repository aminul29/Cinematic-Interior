/**
 * Cinematic Scroll-Driven Walkthrough Zoom Hero
 * Continuous 3D Depth Camera Fly-Through with High-DPR Canvas & Floating HUD
 */

export function initWalkthroughZoom() {
  const canvas = document.getElementById('niorWalkthroughCanvas');
  const track = document.getElementById('niorWalkthroughHeroTrack');
  if (!canvas || !track) return;

  const { gsap, ScrollTrigger, niorConfig } = window;
  if (!gsap || !ScrollTrigger) return;

  const themeUri = (niorConfig && niorConfig.themeUri) ? niorConfig.themeUri : '';
  const totalFrames = 11;

  // Spatial Zone Tags for the architectural HUD indicator
  const zoneTags = [
    'ATRIUM PORTAL',
    'CENTRAL ROTUNDA',
    'VELVET LOUNGE',
    'LINEAR BAR & MILLWORK',
    'BRONZE ARCHWAY',
    'MEZZANINE GALLERY',
    'PRIVATE CELLAR',
    'VIP COVE',
    'BESPOKE JOINERY',
    'SALON FINALE',
    'ATRIUM PORTAL (CYCLE)',
  ];

  // Resolve image paths (frame-01.jpg to frame-11.jpg)
  const imageSources = (niorConfig && niorConfig.walkthroughImages && niorConfig.walkthroughImages.length === totalFrames)
    ? niorConfig.walkthroughImages
    : Array.from({ length: totalFrames }, (_, i) => {
        const num = String(i + 1).padStart(2, '0');
        return `${themeUri}/assets/img/walkthrough/frame-${num}.jpg`;
      });

  const context = canvas.getContext('2d', { alpha: false, desynchronized: true });
  const images = [];
  let loadedCount = 0;
  let isPrimed = false;

  // Elements
  const brandEl = document.getElementById('niorWalkthroughBrand');
  const contentEl = document.getElementById('niorWalkthroughContent');
  const hudEl = document.getElementById('niorWalkthroughHUD');
  const frameNumEl = document.getElementById('niorWalkthroughFrameNum');
  const zoneTagEl = document.getElementById('niorWalkthroughZoneTag');
  const progressFillEl = document.getElementById('niorWalkthroughProgressFill');
  const scrollHintEl = document.getElementById('niorWalkthroughScrollHint');

  // Animation scrub state
  const state = {
    progress: 0,
  };

  // Preload walkthrough frames
  imageSources.forEach((src, index) => {
    const img = new Image();
    img.src = src;
    img.onload = () => {
      loadedCount++;
      if (index === 0 && !isPrimed) {
        isPrimed = true;
        render(0);
      }
    };
    images.push(img);
  });

  /**
   * Cover-fit image calculation with center scaling
   */
  function drawCoverImage(img, scale = 1, alpha = 1) {
    if (!img || !img.complete || img.naturalWidth === 0) return;

    const cw = canvas.width;
    const ch = canvas.height;
    const iw = img.naturalWidth;
    const ih = img.naturalHeight;

    // Calculate aspect ratio cover scale
    const hRatio = cw / iw;
    const vRatio = ch / ih;
    const baseRatio = Math.max(hRatio, vRatio);

    const drawW = iw * baseRatio * scale;
    const drawH = ih * baseRatio * scale;
    const dx = (cw - drawW) / 2;
    const dy = (ch - drawH) / 2;

    context.save();
    context.globalAlpha = Math.max(0, Math.min(1, alpha));
    context.drawImage(img, dx, dy, drawW, drawH);
    context.restore();
  }

  /**
   * Master Render Loop
   */
  function render(progress) {
    const dpr = Math.min(window.devicePixelRatio || 1, 1.75);
    const width = window.innerWidth;
    const height = window.innerHeight;

    if (canvas.width !== Math.floor(width * dpr) || canvas.height !== Math.floor(height * dpr)) {
      canvas.width = Math.floor(width * dpr);
      canvas.height = Math.floor(height * dpr);
      canvas.style.width = `${width}px`;
      canvas.style.height = `${height}px`;
    }

    // Reset transform & background
    context.fillStyle = '#0c0d0e';
    context.fillRect(0, 0, canvas.width, canvas.height);

    const clampedP = Math.max(0, Math.min(1, progress));
    const totalTransitions = totalFrames - 1; // 10 intervals
    const scaledP = clampedP * totalTransitions;

    const currentIndex = Math.min(totalTransitions - 1, Math.floor(scaledP));
    const nextIndex = Math.min(totalFrames - 1, currentIndex + 1);
    const t = scaledP - currentIndex; // Local transition progress 0 -> 1

    const currentImg = images[currentIndex];
    const nextImg = images[nextIndex];

    // Smooth cubic easing for organic camera fly-through
    const easeT = t * t * (3 - 2 * t);

    if (t <= 0.001) {
      // Resting on exact frame
      drawCoverImage(currentImg, 1.0, 1.0);
    } else {
      // 1. Draw Next Image emerging from background depth
      // Scales from 0.88 -> 1.0, Opacity from 0 -> 1
      const nextScale = 0.88 + 0.12 * easeT;
      const nextAlpha = Math.min(1, Math.max(0, (t - 0.15) / 0.8));
      drawCoverImage(nextImg, nextScale, nextAlpha);

      // 2. Draw Current Image zooming forward into camera
      // Scales from 1.0 -> 1.85, Opacity dissolves 1 -> 0 starting midway
      const currentScale = 1.0 + 0.85 * easeT;
      const currentAlpha = 1 - Math.min(1, Math.max(0, (t - 0.32) / 0.68));
      drawCoverImage(currentImg, currentScale, currentAlpha);
    }

    // Update UI Indicators
    updateUI(clampedP, currentIndex, t);
  }

  function updateUI(p, activeIndex, t) {
    // 1. Staged reveal: Initial brand & headline fade out gracefully as scroll begins
    if (contentEl) {
      const contentAlpha = Math.max(0, 1 - p / 0.08);
      const contentY = -35 * (p / 0.08);
      contentEl.style.opacity = contentAlpha;
      contentEl.style.transform = `translateY(${contentY}px)`;
      contentEl.style.pointerEvents = contentAlpha <= 0.05 ? 'none' : 'auto';
    }

    if (brandEl) {
      const brandAlpha = Math.max(0, 1 - p / 0.07);
      brandEl.style.opacity = brandAlpha;
      brandEl.style.transform = `translateY(${-25 * (p / 0.07)}px)`;
    }

    if (scrollHintEl) {
      scrollHintEl.style.opacity = p > 0.04 ? '0' : '1';
    }

    // 2. Minimalist Gold HUD: Activates on scroll
    if (hudEl) {
      if (p > 0.04 && p < 0.995) {
        hudEl.classList.add('is-active');
      } else {
        hudEl.classList.remove('is-active');
      }
    }

    // Determine current display frame (switches midway through transition)
    const displayIndex = (t > 0.5 && activeIndex < totalFrames - 1) ? activeIndex + 1 : activeIndex;

    if (frameNumEl) {
      const numStr = String(displayIndex + 1).padStart(2, '0');
      if (frameNumEl.textContent !== numStr) {
        frameNumEl.textContent = numStr;
      }
    }

    if (zoneTagEl) {
      const tag = zoneTags[displayIndex] || 'NIOR ATELIER';
      if (zoneTagEl.textContent !== tag) {
        zoneTagEl.textContent = tag;
      }
    }

    if (progressFillEl) {
      progressFillEl.style.width = `${Math.min(100, p * 100).toFixed(1)}%`;
    }
  }

  // Setup GSAP ScrollTrigger Scrub
  const trigger = ScrollTrigger.create({
    trigger: track,
    start: 'top top',
    end: 'bottom bottom',
    scrub: 0.85, // Smooth inertia matching Lenis
    onUpdate: (self) => {
      state.progress = self.progress;
      render(state.progress);
    },
  });

  // Window resize handler with DPR recalibration
  let resizeTimer = null;
  const onResize = () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      render(state.progress);
      ScrollTrigger.refresh();
    }, 150);
  };
  window.addEventListener('resize', onResize, { passive: true });

  // Initial trigger refresh once images load
  setTimeout(() => {
    ScrollTrigger.refresh();
    render(0);
  }, 200);
}
