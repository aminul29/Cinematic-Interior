<?php
/**
 * Title: Page Content — About Us
 * Slug: cinematic-interior/page-about-content
 * Categories: nior-pages
 * Description: Complete editorial layout for the About Us page.
 */
?>
<!-- wp:html -->
<div class="nior-page-hero nior-page-hero--about" style="background-image: linear-gradient(180deg, rgba(12, 13, 14, 0.20) 0%, rgba(12, 13, 14, 0.32) 100%), url('<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-4.jpg' ) ); ?>');">
  <div class="nior-container">
    <div class="nior-page-hero__inner">
      <span class="nior-eyebrow">Interior Architecture · Design · Build</span>
      <h1>Who We Are</h1>
      <p class="nior-lead">
        NIOR ATELIER is an interior architecture, design and build studio creating distinctive spaces for brands, businesses and private clients.
      </p>
    </div>
  </div>
</div>

<section class="nior-section nior-section--surface">
  <div class="nior-container">
    <div class="nior-about-story">
      <div class="nior-content-block">
        <span class="nior-eyebrow">Creative Direction &amp; Execution</span>
        <h2 style="font-size: clamp(2.2rem, 3.8vw, 3.4rem); margin-bottom: 24px;">Transforming Ideas Into Considered Environments</h2>
        <p class="nior-lead" style="font-size: 16px; line-height: 1.8; color: var(--nior-muted);">
          We combine creative direction, spatial design and technical execution to transform ideas into environments that are visually compelling, commercially purposeful and built to last.
        </p>
        <p style="font-size: 15px; line-height: 1.8; color: var(--nior-muted); margin-top: 16px;">
          From concept development to final completion, we bring together design thinking, materiality, lighting, functionality and construction to create spaces that do more than look good — they create experiences people remember.
        </p>
      </div>

      <div class="nior-about-manifesto">
        <blockquote>
          “We approach every project as a complete spatial experience, balancing creative vision with technical requirements and practical execution.”
        </blockquote>
        <cite>NIOR ATELIER Principle</cite>
      </div>
    </div>

    <!-- Beyond Interior Design: 11,000 SQ FT Factory -->
    <div class="nior-content-block" style="margin-top: 70px; padding-top: 50px; border-top: 1px solid var(--nior-border);">
      <span class="nior-eyebrow">Beyond Interior Design</span>
      <h3 style="font-family: var(--font-serif); font-size: clamp(1.8rem, 3vw, 2.4rem); margin-bottom: 12px; color: var(--nior-white);">Crafted In-House. Designed With Purpose.</h3>
      <p style="color: var(--nior-muted); max-width: 760px; margin-bottom: 30px; font-size: 15px; line-height: 1.8;">
        Based in Johor Bahru, our 11,000 sq ft headquarters brings design development and furniture production together. This integrated setup allows us to coordinate materials, fabrication and project execution while maintaining the original design intent from concept to completion.
      </p>
      <div class="nior-factory-grid">
        <div class="nior-factory-card nior-factory-card--featured">
          <img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-1.jpg' ) ); ?>" alt="Nior Atelier Joinery &amp; Fabrication Machinery" loading="lazy" />
          <div class="nior-factory-card__tag">Joinery &amp; High-Precision Machinery</div>
        </div>
        <div class="nior-factory-card">
          <img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-2.jpg' ) ); ?>" alt="Bespoke Metalwork &amp; Millwork Assembly" loading="lazy" />
          <div class="nior-factory-card__tag">Bespoke Metalwork &amp; Millwork Assembly</div>
        </div>
        <div class="nior-factory-card">
          <img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-3.jpg' ) ); ?>" alt="Direct Material Procurement &amp; Custom Finishing" loading="lazy" />
          <div class="nior-factory-card__tag">Material Procurement &amp; Custom Finishing</div>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- /wp:html -->

<!-- wp:pattern {"slug":"cinematic-interior/integrated-process"} /-->
<!-- wp:pattern {"slug":"cinematic-interior/cta-handover"} /-->

