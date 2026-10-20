<?php
/**
 * Title: Cinematic Walkthrough Zoom Hero
 * Slug: cinematic-interior/hero-walkthrough-zoom
 * Categories: nior-cinematic
 * Description: Continuous 3D depth camera fly-through zooming through 5 architectural interior spaces on scroll with high-DPR Canvas and floating luxury HUD.
 */
?>
<!-- wp:html -->
<section id="niorWalkthroughHeroTrack" class="nior-walkthrough-hero-track" aria-label="Cinematic Interior Architecture Walkthrough">
  <div class="nior-walkthrough-hero-stage">
    
    <!-- Hardware-Accelerated 3D Depth Canvas -->
    <div id="niorWalkthroughCanvasContainer" class="nior-walkthrough-canvas-container">
      <canvas id="niorWalkthroughCanvas" class="nior-walkthrough-canvas"></canvas>
    </div>

    <!-- Expanding Factory Background Disc with Scrim Overlay -->
    <div id="niorHeroGrowDisc" class="nior-hero-grow-disc" aria-hidden="true"></div>

    <!-- Center Brand Emblem (Fades smoothly on initial scroll) -->
    <div id="niorWalkthroughBrand" class="nior-hero-center-brand">
      <div class="nior-hero-center-brand__title">NIOR ATELIER</div>
      <div class="nior-hero-center-brand__divider"></div>
      <div class="nior-hero-center-brand__tagline">
        <span class="nior-brand-word">Architecture</span>
        <span id="niorHeroGrowDot" class="nior-hero-grow-dot">·</span>
        <span class="nior-brand-word">Design</span>
        <span class="nior-hero-tagline-dot">·</span>
        <span class="nior-brand-word">Build</span>
      </div>
    </div>

    <!-- Staged Initial Headline & CTAs (Fades gracefully on initial scroll) -->
    <div id="niorWalkthroughContent" class="nior-walkthrough-content">
      <div class="nior-container">
        <div class="nior-walkthrough-ui-container">
          <div class="nior-hero-badge">
            <span class="nior-eyebrow">Company Profile 2026</span>
          </div>

          <h1 class="nior-hero-headline">
            Where Art <span class="nior-text-gold">Shapes Space.</span>
          </h1>

          <p class="nior-hero-sub">
            We create distinctive spaces where architecture, atmosphere and functionality come together — transforming ideas into environments that inspire, connect and perform.
          </p>

          <div class="nior-hero-actions">
            <a href="<?php echo esc_url( home_url( '/projects' ) ); ?>" class="nior-btn">
              <span>Explore Our Projects</span>
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="nior-btn nior-btn--outline">
              <span>Start A Project</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Minimalist Floating Gold Architectural HUD -->
    <div id="niorWalkthroughHUD" class="nior-walkthrough-hud" aria-hidden="true">
      <div class="nior-walkthrough-hud__pill">
        <div class="nior-walkthrough-hud__counter">
          <span id="niorWalkthroughFrameNum" class="nior-walkthrough-hud__current">01</span>
          <span class="nior-walkthrough-hud__divider">/</span>
          <span class="nior-walkthrough-hud__total">05</span>
        </div>
      </div>
      <div class="nior-walkthrough-hud__progress-track">
        <div id="niorWalkthroughProgressFill" class="nior-walkthrough-hud__progress-fill"></div>
      </div>
    </div>

    <!-- Ambient Micro Scroll Hint -->
    <div id="niorWalkthroughScrollHint" class="nior-walkthrough-scroll-hint" aria-hidden="true">
      <span class="nior-walkthrough-scroll-hint__line"></span>
      <span>SCROLL TO EXPLORE SPATIAL SEQUENCE</span>
    </div>

  </div>
</section>
<!-- /wp:html -->
