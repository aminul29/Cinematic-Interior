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
  const totalFrames = (niorConfig && Array.isArray(niorConfig.walkthroughImages) && niorConfig.walkthroughImages.length)
    ? niorConfig.walkthroughImages.length
    : ((niorConfig && niorConfig.walkthroughTotalFrames) ? niorConfig.walkthroughTotalFrames : 5);

  // Resolve image paths (frame-01.jpg to frame-05.jpg) with robust cache-busting
  const themeVersion = (niorConfig && niorConfig.version) ? niorConfig.version : '1.9.15';
  const hasConfigImages = niorConfig && Array.isArray(niorConfig.walkthroughImages) && niorConfig.walkthroughImages.length > 0;
  const imageSources = hasConfigImages
    ? niorConfig.walkthroughImages
    : Array.from({ length: totalFrames }, (_, i) => {
        const num = String(i + 1).padStart(2, '0');
        return `${themeUri}/assets/img/walkthrough/frame-${num}.jpg?v=${themeVersion}`;
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
  const titleCard = document.getElementById('niorWalkthroughTitleCard');
  const heroWords = titleCard ? Array.from(titleCard.querySelectorAll('.nior-hero-word')) : [];
  const hudEl = document.getElementById('niorWalkthroughHUD');
  const frameNumEl = document.getElementById('niorWalkthroughFrameNum');
  const totalEl = hudEl ? hudEl.querySelector('.nior-walkthrough-hud__total') : null;
  const progressFillEl = document.getElementById('niorWalkthroughProgressFill');
  const scrollHintEl = document.getElementById('niorWalkthroughScrollHint');
  const growDotEl = document.getElementById('niorHeroGrowDot');
  const growDiscEl = document.getElementById('niorHeroGrowDisc');
  const stageEl = track.querySelector('.nior-walkthrough-hero-stage');
  const rackSection = document.getElementById('niorRackSection');
  const rackStage = rackSection ? rackSection.querySelector('.nior-rack-stage') : null;

  let discOriginX = 0;
  let discOriginY = 0;
  let maxDiscRadius = 1200;

  /**
   * Calculate precise dot coordinates and maximum radius to engulf the stage
   */
  function updateDiscOrigin() {
    if (!growDotEl || !growDiscEl || !stageEl) return;
    const stageRect = stageEl.getBoundingClientRect();
    const dotRect = growDotEl.getBoundingClientRect();

    let currentBrandY = 0;
    if (brandEl && brandEl.style.transform) {
      const match = brandEl.style.transform.match(/translateY\(([-\d.]+)px\)/);
      if (match) currentBrandY = parseFloat(match[1]) || 0;
    }

    const dotCenterX = dotRect.left + dotRect.width / 2;
    const dotCenterY = (dotRect.top + dotRect.height / 2) - currentBrandY;

    discOriginX = dotCenterX - stageRect.left;
    discOriginY = dotCenterY - stageRect.top;

    const stageW = stageRect.width || window.innerWidth;
    const stageH = stageRect.height || window.innerHeight;
    const d1 = Math.hypot(discOriginX, discOriginY);
    const d2 = Math.hypot(stageW - discOriginX, discOriginY);
    const d3 = Math.hypot(discOriginX, stageH - discOriginY);
    const d4 = Math.hypot(stageW - discOriginX, stageH - discOriginY);
    maxDiscRadius = Math.max(d1, d2, d3, d4) * 1.06;
  }

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
   * Safe loaded image resolver with fallback to nearest available frame
   */
  function getLoadedImage(targetIndex) {
    if (images[targetIndex] && images[targetIndex].complete && images[targetIndex].naturalWidth > 0) {
      return images[targetIndex];
    }
    for (let k = targetIndex - 1; k >= 0; k--) {
      if (images[k] && images[k].complete && images[k].naturalWidth > 0) {
        return images[k];
      }
    }
    for (let k = targetIndex + 1; k < images.length; k++) {
      if (images[k] && images[k].complete && images[k].naturalWidth > 0) {
        return images[k];
      }
    }
    return null;
  }

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

  // Cinematic scroll budget allocation:
  // p: 0.00 -> 0.74 : High-static spatial walkthrough through rooms 1-5 (65% static hold per room)
  // p: 0.74 -> 0.82 : Solid hold on room 5 finale with brand emblem & tagline fully settled
  // p: 0.82 -> 1.00 : Primary dot between "Architecture" and "Design" expands to engulf the stage
  const walkthroughProgressEnd = 0.74;
  const brandSettleEnd = 0.82;

  /**
   * Continuous Scroll-Driven Walkthrough Spatial Transitions
   * Smoothly transitions images from one room to another as the user scrolls,
   * with generous static hold time per room for maximum architectural appreciation.
   */
  function render(progress) {
    const clampedP = Math.max(0, Math.min(1, progress));
    const totalTransitions = totalFrames - 1; // 4 intervals for 5 frames

    // Map progress to spatial transitions
    const spatialP = Math.min(1, clampedP / walkthroughProgressEnd);
    const u = spatialP * totalTransitions; // Continuous coordinate [0.0 ... 8.0]

    // Reset canvas background
    context.globalAlpha = 1.0;
    context.fillStyle = '#0c0d0e';
    context.fillRect(0, 0, canvas.width, canvas.height);

    if (u >= totalTransitions) {
      const lastImg = getLoadedImage(totalFrames - 1);
      drawCoverImage(lastImg, 1.0, 1.0);
      updateUI(clampedP, totalFrames - 1, 1.0);
      return;
    }

    const currentIndex = Math.floor(u);
    const nextIndex = currentIndex + 1;
    const t = u - currentIndex; // Progress within interval [0.0 ... 1.0)

    const currentImg = getLoadedImage(currentIndex);
    const nextImg = getLoadedImage(nextIndex);

    // Generous high-static viewing window:
    // t <= 0.65 (65% of interval): Room image is 100% solid, static, razor-sharp with subtle micro-drift
    // 0.65 < t < 0.95 (30% window): Swift, velvety spatial crossfade to the next room
    // t >= 0.95: Next room arrives 100% solid
    const fadeStart = 0.65;
    const fadeEnd = 0.95;

    if (t <= fadeStart) {
      const solidProgress = t / fadeStart;
      const currentScale = 1.0 + 0.008 * solidProgress;
      drawCoverImage(currentImg, currentScale, 1.0);
    } else if (t >= fadeEnd) {
      const arrivalProgress = (t - fadeEnd) / (1.0 - fadeEnd);
      const nextScale = 1.0 + 0.004 * arrivalProgress;
      drawCoverImage(nextImg, nextScale, 1.0);
    } else {
      const tau = (t - fadeStart) / (fadeEnd - fadeStart); // 0.0 ... 1.0
      // Smooth cubic ease curve for velvety crossfade
      const ease = tau * tau * (3 - 2 * tau);

      // Incoming room emerging from subtle depth
      const nextScale = 0.96 + 0.04 * ease;
      drawCoverImage(nextImg, nextScale, 1.0);

      // Current room pushing forward subtly and dissolving
      const currentScale = 1.008 + 0.04 * ease;
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

    // 2. Center brand emblem: Fades out initially, fades back in on room 9 finale,
    // and stays at 100% opacity while the expanding disc swallows it from the inside out!
    if (brandEl) {
      let brandAlpha = 0;
      let brandY = 0;

      if (p <= 0.07) {
        // Initial intro frame fade out
        const factor = p / 0.07;
        brandAlpha = Math.max(0, 1 - factor);
        brandY = -25 * factor;
      } else if (p >= (walkthroughProgressEnd - 0.08) && p <= walkthroughProgressEnd) {
        // Ending frame (frame 05) fade back in
        const factor = Math.min(1, Math.max(0, (p - (walkthroughProgressEnd - 0.08)) / 0.08));
        brandAlpha = factor;
        brandY = 25 * (1 - factor);
      } else if (p > walkthroughProgressEnd) {
        // Fully settled on frame 5, stays visible until the expanding disc covers it
        brandAlpha = 1;
        brandY = 0;
      } else {
        brandAlpha = 0;
        brandY = -25;
      }

      brandEl.style.opacity = brandAlpha;
      brandEl.style.transform = `translateY(${brandY}px)`;
    }

    // 2b. Persistent Center-Stage Cinematic Title with Optical Rack-Focus Word Reveal (Frames 02-04)
    if (titleCard && heroWords.length > 0) {
      const u = activeIndex + t; // Continuous transition coordinate [0.0 ... 4.0]
      let cardAlpha = 0;
      let cardY = 20;

      if (u >= 0.72 && u <= 3.65) {
        if (u < 0.95) {
          // Emerge and float up as Room 2 arrives
          const factor = (u - 0.72) / (0.95 - 0.72);
          cardAlpha = Math.min(1, Math.max(0, factor));
          cardY = 20 * (1 - cardAlpha);
        } else if (u <= 3.40) {
          // Perfectly pinned and 100% visible across Rooms 2, 3, and 4
          cardAlpha = 1;
          cardY = 0;
        } else {
          // Dissolve smoothly and float up before Room 5 brand emblem returns
          const factor = (u - 3.40) / (3.65 - 3.40);
          cardAlpha = Math.max(0, 1 - factor);
          cardY = -20 * factor;
        }

        // Staggered rack-focus depth-of-field word reveal across Rooms 2, 3, and 4
        // Unrevealed words maintain a noticeable, high-contrast shadowed silhouette
        const s = Math.max(0, Math.min(1, (u - 0.95) / (3.35 - 0.95)));
        const wordStarts = [0.00, 0.18, 0.38, 0.56, 0.76];
        const wordDuration = 0.16;
        const baseOpacity = 0.38;

        heroWords.forEach((word, k) => {
          const start = wordStarts[k] !== undefined ? wordStarts[k] : (k / (heroWords.length - 1)) * 0.8;
          const o = Math.max(0, Math.min(1, (s - start) / wordDuration));

          word.style.opacity = (baseOpacity + (1 - baseOpacity) * o).toFixed(3);
          word.style.transform = `translate3d(0, ${((1 - o) * 0.18).toFixed(3)}em, 0)`;
          word.style.filter = `blur(${((1 - o) * 2.2).toFixed(2)}px)`;
        });
      } else {
        cardAlpha = 0;
        cardY = u < 0.72 ? 20 : -20;
      }

      titleCard.style.opacity = cardAlpha.toFixed(3);
      titleCard.style.transform = `translate3d(0, ${cardY.toFixed(1)}px, 0)`;
      titleCard.style.visibility = cardAlpha > 0.005 ? 'visible' : 'hidden';
    }

    if (scrollHintEl) {
      scrollHintEl.style.opacity = p > 0.04 ? '0' : '1';
    }

    // 3. Minimalist Gold HUD: Activates smoothly on scroll, recedes on ending finale
    if (hudEl) {
      if (p > 0.04 && p < walkthroughProgressEnd) {
        hudEl.classList.add('is-active');
      } else {
        hudEl.classList.remove('is-active');
      }
    }

    // Display frame advances when entering the active crossfade window
    const displayIndex = (t >= 0.78 && activeIndex < totalFrames - 1) ? activeIndex + 1 : activeIndex;

    if (frameNumEl) {
      const numStr = String(displayIndex + 1).padStart(2, '0');
      if (frameNumEl.textContent !== numStr) {
        frameNumEl.textContent = numStr;
      }
    }

    if (progressFillEl) {
      const spatialProgress = Math.min(1, p / walkthroughProgressEnd);
      progressFillEl.style.width = `${(spatialProgress * 100).toFixed(1)}%`;
    }

    // 4. Growing White Vector Mask: Expands from the dot between "Architecture" and "Design",
    // swallowing the text and the entire hero stage into pure white with silky vector edges & zero overflow.
    if (growDiscEl) {
      if (p <= brandSettleEnd) {
        growDiscEl.style.clipPath = 'circle(0px at 50% 50%)';
        growDiscEl.style.webkitClipPath = 'circle(0px at 50% 50%)';
        growDiscEl.style.opacity = '0';
        growDiscEl.style.visibility = 'hidden';
        track.style.backgroundColor = '#0c0d0e';
      } else {
        // Dynamically ensure exact origin coordinates once brand text has settled
        if (!growDiscEl.dataset.aligned && p >= brandSettleEnd) {
          updateDiscOrigin();
          growDiscEl.dataset.aligned = 'true';
        }

        const expandT = Math.min(1, (p - brandSettleEnd) / (1.0 - brandSettleEnd));
        // Exponential deceleration curve for organic fluid bloom
        const ease = Math.pow(expandT, 1.8);
        const currentRadius = ease * maxDiscRadius;

        growDiscEl.style.visibility = 'visible';
        growDiscEl.style.opacity = '1';
        const clipStr = `circle(${currentRadius.toFixed(1)}px at ${discOriginX.toFixed(1)}px ${discOriginY.toFixed(1)}px)`;
        growDiscEl.style.clipPath = clipStr;
        growDiscEl.style.webkitClipPath = clipStr;

        // Maintain consistent architectural background
        track.style.backgroundColor = '#0c0d0e';
      }

      // Reset alignment cache flag when scrolling back up above the finale
      if (p < 0.70 && growDiscEl.dataset.aligned) {
        delete growDiscEl.dataset.aligned;
      }
    }

    // 5. Seamless Handover to "Our Philosophy":
    // As soon as the circle has consumed the whole hero section (p >= 1.0),
    // immediately reveal the Our Philosophy section with zero scroll gap.
    if (rackSection) {
      if (p >= 1.0) {
        rackSection.style.visibility = 'visible';
        rackSection.style.opacity = '1';
        rackSection.style.pointerEvents = 'auto';
        if (rackStage) {
          rackStage.style.visibility = 'visible';
          rackStage.style.opacity = '1';
          rackStage.style.pointerEvents = 'auto';
        }
        if (stageEl) stageEl.style.visibility = 'hidden';
        track.style.pointerEvents = 'none';
      } else {
        rackSection.style.visibility = 'hidden';
        rackSection.style.opacity = '0';
        rackSection.style.pointerEvents = 'none';
        if (rackStage) {
          rackStage.style.visibility = 'hidden';
          rackStage.style.opacity = '0';
          rackStage.style.pointerEvents = 'none';
        }
        if (stageEl) {
          stageEl.style.visibility = 'visible';
          stageEl.style.opacity = '1';
        }
        track.style.pointerEvents = 'auto';
      }
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
    onRefresh: (self) => {
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
      updateDiscOrigin();
      render(state.progress);
      ScrollTrigger.refresh();
    }, 120);
  };
  window.addEventListener('resize', onResize, { passive: true });

  // Initial trigger refresh once images load
  setTimeout(() => {
    resizeCanvas();
    updateDiscOrigin();
    ScrollTrigger.refresh();
    render(0);
  }, 180);
}
