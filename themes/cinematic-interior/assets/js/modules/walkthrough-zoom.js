/**
 * Cinematic Scroll-Driven Walkthrough Zoom Hero
 * Fluid Scroll-Linked Spatial Crossfade & 3D Depth Transitions
 */

export function initWalkthroughZoom() {
  const canvas = document.getElementById('niorWalkthroughCanvas');
  const track = document.getElementById('niorWalkthroughHeroTrack');
  if (!canvas || !track) return;

  const { gsap, ScrollTrigger, niorConfig } = window;
  if (!gsap || !ScrollTrigger) return;

  const themeUri = (niorConfig && niorConfig.themeUri) ? niorConfig.themeUri : '';
  const totalFrames = 9;

  // Spatial Zone Tags for the architectural HUD indicator (9 curated zones)
  const zoneTags = [
    'ATRIUM PORTAL',
    'CENTRAL ROTUNDA',
    'VELVET LOUNGE',
    'LINEAR BAR & MILLWORK',
    'BRONZE ARCHWAY',
    'MEZZANINE GALLERY',
    'PRIVATE CELLAR',
    'SALON FINALE',
    'ATRIUM PORTAL (CYCLE)',
  ];

  // Resolve image paths (frame-01.jpg to frame-09.jpg)
  const imageSources = (niorConfig && niorConfig.walkthroughImages && niorConfig.walkthroughImages.length === totalFrames)
    ? niorConfig.walkthroughImages
    : Array.from({ length: totalFrames }, (_, i) => {
        const num = String(i + 1).padStart(2, '0');
        return `${themeUri}/assets/img/walkthrough/frame-${num}.jpg`;
      });

  const context = canvas.getContext('2d', { alpha: false, desynchronized: true });
  if (context) {
    context.imageSmoothingEnabled = true;
    context.imageSmoothingQuality = 'high';
  }
  const images = [];
  let isPrimed = false;

  // DOM Elements
  const brandEl = document.getElementById('niorWalkthroughBrand');
  const contentEl = document.getElementById('niorWalkthroughContent');
  const hudEl = document.getElementById('niorWalkthroughHUD');
  const frameNumEl = document.getElementById('niorWalkthroughFrameNum');
  const totalEl = hudEl ? hudEl.querySelector('.nior-walkthrough-hud__total') : null;
  const zoneTagEl = document.getElementById('niorWalkthroughZoneTag');
  const progressFillEl = document.getElementById('niorWalkthroughProgressFill');
  const scrollHintEl = document.getElementById('niorWalkthroughScrollHint');

  // Synchronize HUD total frames display dynamically
  if (totalEl) {
    totalEl.textContent = String(totalFrames).padStart(2, '0');
  }

  // Animation scrub state
  const state = {
    progress: 0,
  };

  /**
   * Resize Canvas Buffer (called on mount and debounced resize only)
   * Avoids expensive GPU texture reallocations during active scroll frames.
   */
  function resizeCanvas() {
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    const width = window.innerWidth;
    const height = window.innerHeight;

    const targetW = Math.floor(width * dpr);
    const targetH = Math.floor(height * dpr);

    if (canvas.width !== targetW || canvas.height !== targetH) {
      canvas.width = targetW;
      canvas.height = targetH;
      canvas.style.width = `${width}px`;
      canvas.style.height = `${height}px`;
    }

    if (context) {
      context.imageSmoothingEnabled = true;
      context.imageSmoothingQuality = 'high';
    }
  }

  // Preload and decode walkthrough frames in parallel
  imageSources.forEach((src, index) => {
    const img = new Image();
    img.src = src;

    const onReady = () => {
      if (index === 0 && !isPrimed) {
        isPrimed = true;
        resizeCanvas();
        render(0);
      }
    };

    img.onload = () => {
      if (typeof img.decode === 'function') {
        img.decode().then(onReady).catch(onReady);
      } else {
        onReady();
      }
    };

    images.push(img);
  });

  /**
   * High-Performance Cover-Fit Draw with Center Scaling
   */
  function drawCoverImage(img, scale = 1, alpha = 1) {
    if (!img || !img.complete || img.naturalWidth === 0 || alpha <= 0.001) return;

    const cw = canvas.width;
    const ch = canvas.height;
    const iw = img.naturalWidth;
    const ih = img.naturalHeight;

    // Cover aspect ratio multiplier
    const hRatio = cw / iw;
    const vRatio = ch / ih;
    const baseRatio = Math.max(hRatio, vRatio);

    const drawW = iw * baseRatio * scale;
    const drawH = ih * baseRatio * scale;
    const dx = (cw - drawW) * 0.5;
    const dy = (ch - drawH) * 0.5;

    context.globalAlpha = Math.max(0, Math.min(1, alpha));
    context.drawImage(img, dx, dy, drawW, drawH);
  }

  /**
   * Continuous Scroll-Driven Walkthrough Spatial Transitions
   * Smoothly transitions images from one room to another as the user scrolls,
   * with subtle cinematic depth and zero magnetic scroll-jacking.
   */
  function render(progress) {
    const clampedP = Math.max(0, Math.min(1, progress));
    const totalTransitions = totalFrames - 1; // 8 intervals for 9 frames
    const u = clampedP * totalTransitions; // Continuous coordinate [0.0 ... 8.0]

    // Reset canvas background
    context.globalAlpha = 1.0;
    context.fillStyle = '#0c0d0e';
    context.fillRect(0, 0, canvas.width, canvas.height);

    if (u >= totalTransitions) {
      const lastImg = images[totalFrames - 1];
      drawCoverImage(lastImg, 1.0, 1.0);
      updateUI(clampedP, totalFrames - 1, 1.0);
      return;
    }

    const currentIndex = Math.floor(u);
    const nextIndex = currentIndex + 1;
    const t = u - currentIndex; // Progress within interval [0.0 ... 1.0)

    const currentImg = images[currentIndex];
    const nextImg = images[nextIndex];

    // Smooth transition window:
    // t <= 0.12: Crisp initial room frame with gentle drift
    // 0.12 < t < 0.88: Fluid crossfade and depth zoom
    // t >= 0.88: Seamless arrival into the next solid room frame
    const fadeStart = 0.12;
    const fadeEnd = 0.88;

    if (t <= fadeStart) {
      const solidProgress = t / fadeStart;
      const currentScale = 1.0 + 0.015 * solidProgress;
      drawCoverImage(currentImg, currentScale, 1.0);
    } else if (t >= fadeEnd) {
      const arrivalProgress = (t - fadeEnd) / (1.0 - fadeEnd);
      const nextScale = 1.0 + 0.008 * arrivalProgress;
      drawCoverImage(nextImg, nextScale, 1.0);
    } else {
      const tau = (t - fadeStart) / (fadeEnd - fadeStart); // 0.0 ... 1.0
      // Smooth cubic ease curve for velvety crossfade
      const ease = tau * tau * (3 - 2 * tau);

      // Incoming room emerging from subtle depth
      const nextScale = 0.94 + 0.06 * ease;
      drawCoverImage(nextImg, nextScale, 1.0);

      // Current room pushing forward and dissolving smoothly
      const currentScale = 1.015 + 0.10 * ease;
      const currentAlpha = 1.0 - ease;
      drawCoverImage(currentImg, currentScale, currentAlpha);
    }

    // Reset canvas globalAlpha
    context.globalAlpha = 1.0;

    // Update UI HUD & Staged Overlays
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

    // 2. Minimalist Gold HUD: Activates smoothly on scroll
    if (hudEl) {
      if (p > 0.04 && p < 0.995) {
        hudEl.classList.add('is-active');
      } else {
        hudEl.classList.remove('is-active');
      }
    }

    // Display frame advances when entering the second half of the transition
    const displayIndex = (t >= 0.50 && activeIndex < totalFrames - 1) ? activeIndex + 1 : activeIndex;

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

  // Setup GSAP ScrollTrigger without magnetic auto-snap (Fluid natural scrub)
  const trigger = ScrollTrigger.create({
    trigger: track,
    start: 'top top',
    end: 'bottom bottom',
    scrub: true,
    onUpdate: (self) => {
      state.progress = self.progress;
      render(state.progress);
    },
  });

  // Debounced window resize handler
  let resizeTimer = null;
  const onResize = () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      resizeCanvas();
      render(state.progress);
      ScrollTrigger.refresh();
    }, 120);
  };
  window.addEventListener('resize', onResize, { passive: true });

  // Initial trigger refresh once images load
  setTimeout(() => {
    resizeCanvas();
    ScrollTrigger.refresh();
    render(0);
  }, 180);
}
