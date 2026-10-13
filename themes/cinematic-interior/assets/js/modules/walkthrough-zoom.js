/**
 * Cinematic Scroll-Driven Walkthrough Zoom Hero
 * Magnetic 3D Camera Fly-Through with 65% Solid Framing & Velvety Auto-Snap
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
  let isPrimed = false;

  // DOM Elements
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

  /**
   * Resize Canvas Buffer (called on mount and debounced resize only)
   * Avoids expensive GPU texture reallocations during active scroll frames.
   */
  function resizeCanvas() {
    const dpr = Math.min(window.devicePixelRatio || 1, 1.75);
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
   * 65% Solid Framing & 35% Fly-Through Window
   * Eliminates lingering double-exposures: image is 100% solid for 65% of interval,
   * then transitions dynamically in the final 35%.
   */
  function render(progress) {
    const clampedP = Math.max(0, Math.min(1, progress));
    const totalTransitions = totalFrames - 1; // 10 intervals
    const u = clampedP * totalTransitions; // Continuous coordinate [0.0 ... 10.0]

    const currentIndex = Math.min(totalTransitions - 1, Math.floor(u));
    const nextIndex = Math.min(totalFrames - 1, currentIndex + 1);
    const t = u - currentIndex; // Progress within interval [0.0 ... 1.0]

    const currentImg = images[currentIndex];
    const nextImg = images[nextIndex];

    // Reset canvas background
    context.globalAlpha = 1.0;
    context.fillStyle = '#0c0d0e';
    context.fillRect(0, 0, canvas.width, canvas.height);

    const transitionStart = 0.72; // 72% solid display, 28% transition window

    if (t <= transitionStart) {
      // 1. Pure Solid Frame (ZERO OVERLAPPING):
      // Only the current room is drawn at 100% solid opacity with a gentle push
      const solidProgress = t / transitionStart;
      const currentScale = 1.0 + 0.22 * solidProgress;
      drawCoverImage(currentImg, currentScale, 1.0);
    } else {
      // 2. Active 28% Fly-Through Transition:
      const tau = (t - transitionStart) / (1.0 - transitionStart); // 0.0 ... 1.0

      // Next Room emerging from background depth (Solid backdrop)
      const nextScale = 0.86 + 0.14 * tau;
      drawCoverImage(nextImg, nextScale, 1.0);

      // Current Room zooming forward past the camera and dissolving
      const currentScale = 1.22 + 0.98 * tau;
      const currentAlpha = 1.0 - Math.pow(tau, 1.3);
      drawCoverImage(currentImg, currentScale, currentAlpha);
    }

    // Reset canvas globalAlpha
    context.globalAlpha = 1.0;

    // Update UI HUD & Staged Overlays
    updateUI(clampedP, currentIndex, t, transitionStart);
  }

  function updateUI(p, activeIndex, t, transitionStart) {
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

    // Display frame advances when entering the active transition window
    const displayIndex = (t > transitionStart && activeIndex < totalFrames - 1) ? activeIndex + 1 : activeIndex;

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

  // Setup GSAP ScrollTrigger with Magnetic Auto-Snap
  const trigger = ScrollTrigger.create({
    trigger: track,
    start: 'top top',
    end: 'bottom bottom',
    scrub: true,
    snap: {
      snapTo: (value) => {
        if (value <= 0.02) return 0;
        if (value >= 0.98) return 1;

        const totalTransitions = totalFrames - 1; // 10 intervals
        const u = value * totalTransitions;
        const index = Math.floor(u);
        const t = u - index;

        // Snaps forward if user pushed past 60% of the room, otherwise settles to current room
        const targetIndex = (t >= 0.60) ? Math.min(totalTransitions, index + 1) : index;
        return targetIndex / totalTransitions;
      },
      duration: { min: 0.45, max: 0.65 },
      delay: 0.12,
      ease: 'power3.out',
    },
    onUpdate: (self) => {
      state.progress = self.progress;
      render(state.progress);
    },
  });

  // Velvety Lenis Magnetic Glide:
  // Fallback safety lock ensures that if the user stops their wheel directly in the transition window,
  // Lenis automatically glides smoothly into the nearest 100% solid room frame.
  let settleTimer = null;
  const onScrollActivity = () => {
    clearTimeout(settleTimer);
    settleTimer = setTimeout(() => {
      if (!trigger || trigger.progress <= 0.02 || trigger.progress >= 0.98) return;

      const totalTransitions = totalFrames - 1;
      const u = trigger.progress * totalTransitions;
      const index = Math.floor(u);
      const t = u - index;

      // If user stopped within the transition window (0.60 < t < 0.98)
      if (t > 0.60 && t < 0.98) {
        const targetP = (index + 1) / totalTransitions;
        const targetScroll = trigger.start + targetP * (trigger.end - trigger.start);
        if (window.niorLenis && typeof window.niorLenis.scrollTo === 'function') {
          window.niorLenis.scrollTo(targetScroll, {
            duration: 0.55,
            easing: (x) => 1 - Math.pow(1 - x, 4), // Velvety easeOutQuart
          });
        }
      }
    }, 120);
  };
  window.addEventListener('scroll', onScrollActivity, { passive: true });

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
