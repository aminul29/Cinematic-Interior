<?php
/**
 * Title: Cinematic Walkthrough Zoom Hero
 * Slug: nioratelier/hero-walkthrough-zoom
 * Categories: nior-cinematic
 * Description: Continuous 3D depth camera fly-through zooming through 11 architectural interior spaces on scroll with high-DPR Canvas and floating luxury HUD.
 */
?>
<!-- wp:html -->
<section id="niorWalkthroughHeroTrack" class="nior-walkthrough-hero-track" aria-label="Cinematic Interior Architecture Walkthrough">
  <div class="nior-walkthrough-hero-stage">
    
    <!-- Hardware-Accelerated 3D Depth Canvas -->
    <div id="niorWalkthroughCanvasContainer" class="nior-walkthrough-canvas-container">
      <canvas id="niorWalkthroughCanvas" class="nior-walkthrough-canvas"></canvas>
      <div class="nior-walkthrough-scrim-dark"></div>
      <div class="nior-walkthrough-scrim-radial"></div>
      <div class="nior-walkthrough-scrim-vignette"></div>
    </div>

    <!-- Center Brand Emblem (Fades smoothly on initial scroll) -->
    <div id="niorWalkthroughBrand" class="nior-hero-center-brand">
      <div class="nior-hero-center-brand__title">NIOR ATELIER</div>
      <div class="nior-hero-center-brand__divider"></div>
      <div class="nior-hero-center-brand__tagline">Architecture · Design · Build</div>
    </div>

    <!-- Staged Initial Headline & CTAs (Fades gracefully on initial scroll) -->
    <div id="niorWalkthroughContent" class="nior-walkthrough-content">
      <div class="nior-container">
        <div class="nior-walkthrough-ui-container">
          <div class="nior-hero-badge">
            <span class="nior-eyebrow">Company Profile 2026</span>
          </div>

          <h1 class="nior-hero-headline">
            Crafting <span class="nior-text-gold">Cinematic Spaces</span><br />
            That Perform.
          </h1>

          <p class="nior-hero-sub">
            Uniting architecture, custom fabrication, and spatial performance to craft unforgettable environments.
          </p>

          <div class="nior-hero-actions">
            <a href="#statement" class="nior-btn">
              <span>Explore Spaces</span>
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="nior-btn nior-btn--outline">
              <span>Start A Consultation</span>
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
          <span class="nior-walkthrough-hud__total">11</span>
        </div>
        <div class="nior-walkthrough-hud__sep"></div>
        <span id="niorWalkthroughZoneTag" class="nior-walkthrough-hud__tag">ATRIUM PORTAL</span>
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
