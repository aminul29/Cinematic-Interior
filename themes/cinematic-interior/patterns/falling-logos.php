<?php
/**
 * Title: Falling Client Logos Section
 * Slug: cinematic-interior/falling-logos
 * Categories: nior-cinematic
 * Description: 'Our Clients' section featuring 11 authentic client brand logos with physics drop and luxury card illumination.
 */
?>
<?php
$logo_ver = defined( 'CINEMATIC_INTERIOR_VERSION' ) ? CINEMATIC_INTERIOR_VERSION : '1.7.2';
?>
<!-- wp:html -->
<section id="clients" class="nior-falling-section" aria-label="Our Clients">
  <div class="nior-falling-watermark">PARTNERS</div>
  
  <div class="nior-container">
    <div class="nior-falling-header">
      <span class="nior-eyebrow">Our Clients</span>
      <h2>Trusted By Brands Across Industries</h2>
      <p>From dining and nightlife venues to commercial headquarters and luxury retail destinations.</p>
    </div>

    <div id="niorFallingArena" class="nior-falling-arena">
      <div class="nior-falling-grid">
        
        <!-- 01. Giorgio Armani -->
        <div class="nior-logo-chip" data-client="Giorgio Armani">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/02-giorgio-armani.webp?v=' . $logo_ver ); ?>" alt="Giorgio Armani" decoding="async" />
        </div>

        <!-- 02. Ralph Lauren -->
        <div class="nior-logo-chip" data-client="Ralph Lauren">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/03-ralph-lauren.webp?v=' . $logo_ver ); ?>" alt="Ralph Lauren" decoding="async" />
        </div>

        <!-- 03. Aesop -->
        <div class="nior-logo-chip" data-client="Aesop">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/01-aesop.webp?v=' . $logo_ver ); ?>" alt="Aesop" decoding="async" />
        </div>

        <!-- 04. M·A·C Cosmetics -->
        <div class="nior-logo-chip" data-client="M·A·C Cosmetics">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/04-mac.webp?v=' . $logo_ver ); ?>" alt="M·A·C Cosmetics" decoding="async" />
        </div>

        <!-- 05. H&M -->
        <div class="nior-logo-chip" data-client="H&M">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/05-hm.webp?v=' . $logo_ver ); ?>" alt="H&M" decoding="async" />
        </div>

        <!-- 06. Acqua Panna -->
        <div class="nior-logo-chip" data-client="Acqua Panna">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/11-acqua-panna.svg?v=' . $logo_ver ); ?>" alt="Acqua Panna" decoding="async" />
        </div>

        <!-- 07. Bradbury -->
        <div class="nior-logo-chip" data-client="Bradbury">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/06-bradbury.webp?v=' . $logo_ver ); ?>" alt="Bradbury" decoding="async" />
        </div>

        <!-- 08. CEVA Logistics -->
        <div class="nior-logo-chip" data-client="CEVA Logistics">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/07-ceva.webp?v=' . $logo_ver ); ?>" alt="CEVA Logistics" decoding="async" />
        </div>

        <!-- 09. Dreame -->
        <div class="nior-logo-chip" data-client="Dreame">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/08-dreame.webp?v=' . $logo_ver ); ?>" alt="Dreame" decoding="async" />
        </div>

        <!-- 10. Super Loco -->
        <div class="nior-logo-chip" data-client="Super Loco">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/09-super-loco.webp?v=' . $logo_ver ); ?>" alt="Super Loco" decoding="async" />
        </div>

        <!-- 11. Santan -->
        <div class="nior-logo-chip" data-client="Santan">
          <img class="nior-logo-chip__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logos/10-santan.webp?v=' . $logo_ver ); ?>" alt="Santan" decoding="async" />
        </div>

      </div>
    </div>
  </div>
</section>
<!-- /wp:html -->
