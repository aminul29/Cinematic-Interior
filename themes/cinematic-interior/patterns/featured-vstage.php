<?php
/**
 * Title: Featured Project V Stage Lounge
 * Slug: cinematic-interior/featured-vstage
 * Categories: nior-cinematic
 * Description: Editorial showcase of V Stage Lounge nightlife and entertainment venue.
 */
?>
<!-- wp:html -->
<section id="vstage" class="nior-section nior-section--surface" aria-label="Featured Project V Stage Lounge">
  <div class="nior-container">
    <div class="nior-vstage-grid">
      <div class="nior-vstage-media">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/projects/bar.jpg' ); ?>" alt="V Stage Lounge Interior Architecture by Nior Atelier" loading="lazy" />
        <div class="nior-vstage-tag">Featured Project</div>
      </div>

      <div class="nior-vstage-details nior-content-block">
        <span class="nior-eyebrow">Featured Project</span>
        <h2>V Stage Lounge</h2>
        <span class="nior-vstage-cat">Nightlife · Entertainment · F&B</span>
        <p>
          An immersive nightlife environment built around a commanding central stage, layered lighting and carefully considered seating zones.
        </p>
        <p>
          Through lighting, spatial planning and a cohesive visual identity, the space becomes more than a venue — it becomes an experience designed to be remembered.
        </p>

        <div class="nior-vstage-impact-grid">
          <div class="nior-impact-item"><span class="num">01</span> Visual Identity</div>
          <div class="nior-impact-item"><span class="num">02</span> Spatial Planning</div>
          <div class="nior-impact-item"><span class="num">03</span> Layered Lighting</div>
          <div class="nior-impact-item"><span class="num">04</span> Seating Zones</div>
          <div class="nior-impact-item"><span class="num">05</span> High-Energy Atmosphere</div>
          <div class="nior-impact-item"><span class="num">06</span> Customer Engagement</div>
        </div>

        <div style="margin-top: 32px;">
          <a href="<?php echo esc_url( home_url( '/projects' ) ); ?>" class="nior-btn">
            <span>Explore Project</span>
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /wp:html -->
