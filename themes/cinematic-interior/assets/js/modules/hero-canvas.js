/**
 * Cinematic Scroll-Driven Hero Canvas & Video Sequence
 * Dual-Mode media layer: High-DPR Canvas Scrub <-> Ambient Video Autoplay
 */

export function initHeroCanvas() {
  const canvas = document.getElementById('niorHeroCanvas');
  const video = document.getElementById('niorHeroVideo');
  const heroTrack = document.getElementById('niorHeroTrack');
  if (!canvas || !heroTrack) return;

  const { gsap, ScrollTrigger, niorConfig } = window;
  if (!gsap || !ScrollTrigger) return;

  const totalFrames = (niorConfig && niorConfig.totalFrames) ? niorConfig.totalFrames : 101;
  const sequenceBase = (niorConfig && niorConfig.sequenceBase) ? niorConfig.sequenceBase : '';

  const getFramePath = (index) => {
    // Frames are 1-indexed: frame_001.webp to frame_101.webp
    const frameNum = String(index + 1).padStart(3, '0');
    return `${sequenceBase}${frameNum}.webp`;
  };

  const context = canvas.getContext('2d', { alpha: false, desynchronized: true });
  const images = [];
  const sequenceState = { frame: 0 };
  let isPrimed = false;

  // Preload sequence frames
  for (let i = 0; i < totalFrames; i++) {
    const img = new Image();
    img.src = getFramePath(i);
    img.onload = () => {
      if (i === 0 && !isPrimed) {
        isPrimed = true;
        renderFrame(0);
      }
    };
    images.push(img);
  }

  function renderFrame(frameIndex) {
    const clampedIndex = Math.min(totalFrames - 1, Math.max(0, Math.floor(frameIndex)));
    const img = images[clampedIndex];
    if (!img || !img.complete) return;

    const dpr = Math.min(window.devicePixelRatio || 1, 1.5);
    const width = window.innerWidth;
    const height = window.innerHeight;

    if (canvas.width !== Math.floor(width * dpr) || canvas.height !== Math.floor(height * dpr)) {
      canvas.width = Math.floor(width * dpr);
      canvas.height = Math.floor(height * dpr);
      canvas.style.width = `${width}px`;
      canvas.style.height = `${height}px`;
    }

    context.setTransform(1, 0, 0, 1, 0, 0);
    context.scale(dpr, dpr);

    // Calculate object-fit: cover coordinates
    const imgRatio = img.width / img.height;
    const canvasRatio = width / height;
    let drawWidth = width;
    let drawHeight = height;
    let offsetX = 0;
    let offsetY = 0;

    if (canvasRatio > imgRatio) {
      drawHeight = width / imgRatio;
      offsetY = (height - drawHeight) / 2;
    } else {
      drawWidth = height * imgRatio;
      offsetX = (width - drawWidth) / 2;
    }

    context.imageSmoothingEnabled = true;
    context.imageSmoothingQuality = 'medium';
    context.drawImage(img, offsetX, offsetY, drawWidth, drawHeight);
  }

  const handleResize = () => renderFrame(sequenceState.frame);
  window.addEventListener('resize', handleResize, { passive: true });

  // 1. Hero Canvas Frame Scrubbing ScrollTrigger
  ScrollTrigger.create({
    trigger: heroTrack,
    start: 'top top',
    end: 'bottom bottom',
    scrub: 0.6,
    onUpdate: (self) => {
      sequenceState.frame = self.progress * (totalFrames - 1);
      renderFrame(sequenceState.frame);
    },
    onLeave: () => {
      // Seamlessly crossfade to looping video
      if (canvas) canvas.style.opacity = '0';
      if (video) {
        video.style.opacity = '1';
        video.play().catch(() => {});
      }
    },
    onEnterBack: () => {
      // Revert to scrubbed canvas
      if (canvas) canvas.style.opacity = '1';
      if (video) {
        video.style.opacity = '0';
        video.pause();
      }
    },
  });

  // 2. Staged Scroll-Driven Hero Ingress Timeline
  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: heroTrack,
      start: 'top top',
      end: '+=1800',
      scrub: 0.8,
    },
  });

  // Stage 1: Status Badge
  tl.to('.nior-hero-badge', { opacity: 1, y: 0, duration: 0.15 }, 0.05);

  // Stage 2: Main Headline
  tl.to('.nior-hero-headline', { opacity: 1, y: 0, scale: 1, duration: 0.22 }, 0.15);

  // Stage 3: Subtitle & CTA Group
  tl.to('.nior-hero-sub', { opacity: 1, y: 0, duration: 0.18 }, 0.30);
  tl.to('.nior-hero-actions', { opacity: 1, y: 0, duration: 0.18 }, 0.35);

  // Stage 4: Floating Metrics Card
  tl.to('.nior-hero-floating-card', { opacity: 1, y: 0, scale: 1, duration: 0.22 }, 0.45);

  // Stage 5: Interface Hold
  tl.to({}, { duration: 0.15 }, 0.65);

  // Stage 6: Clean Upward Glissando Before Next Section Arrives
  tl.to('.nior-hero-ui-container', { y: -70, opacity: 0, duration: 0.18, ease: 'power2.in' }, 0.82);
  tl.to('.nior-hero-floating-card', { y: -40, opacity: 0, duration: 0.15, ease: 'power2.in' }, 0.85);
  tl.to('.nior-hero-scroll-prompt', { opacity: 0, duration: 0.1 }, 0.20);
}
