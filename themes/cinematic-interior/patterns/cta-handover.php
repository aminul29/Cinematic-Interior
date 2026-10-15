<?php
/**
 * Title: CTA Let's Create Something Remembered
 * Slug: cinematic-interior/cta-handover
 * Categories: nior-cinematic
 * Description: Grand call-to-action inviting clients to start a bespoke architectural collaboration.
 */
?>
<!-- wp:html -->
<section class="nior-section nior-section--dark nior-cta-video-section" aria-label="Start A Project">
  <video class="nior-cta-video-bg" autoplay muted loop playsinline poster="<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-3.jpg' ) ); ?>">
    <source src="<?php echo esc_url( get_theme_file_uri( '/assets/video/cta-ambient.mp4' ) ); ?>" type="video/mp4" />
  </video>
  <div class="nior-cta-overlay" aria-hidden="true"></div>
  <div class="nior-container">
    <div class="nior-cta-box">
      <span class="nior-eyebrow" style="justify-content: center;">Start A Conversation</span>
      <h2>Let’s Create Something People Remember.</h2>
      <p>
        Whether you are conceiving a flagship hospitality concept, an entertainment lounge, or a distinctive commercial space, our team brings ideas into striking physical form.
      </p>
      <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
        <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="nior-btn">
          <span>Inquire About A Project</span>
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <a href="tel:+60376131376" class="nior-btn nior-btn--outline">
          <span>+603 7613 1376</span>
        </a>
      </div>
    </div>
  </div>
</section>
<!-- /wp:html -->
