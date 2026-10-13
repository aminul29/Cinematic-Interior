<?php
/**
 * Title: Page Content — Contact Us
 * Slug: cinematic-interior/page-contact-content
 * Categories: nior-pages
 * Description: Complete contact page layout with studio details, phone, and inquiry form.
 */
?>
<!-- wp:html -->
<div class="nior-page-hero">
  <div class="nior-container">
    <div class="nior-page-hero__inner">
      <span class="nior-eyebrow">Connect With Us</span>
      <h1>Start Your Project.</h1>
      <p class="nior-lead">
        Discuss your forthcoming spatial concept, commercial development, or bespoke residence with our architecture and design directors.
      </p>
    </div>
  </div>
</div>

<section class="nior-section nior-section--surface">
  <div class="nior-container">
    <div class="nior-contact-grid">
      
      <!-- Studio Details Card -->
      <div class="nior-contact-info-card">
        <span class="nior-eyebrow">Studio & Headquarters</span>
        <h3>Nior Atelier Malaysia</h3>
        <p>Our multidisciplinary practice bridges strategic design with complete in-house construction and bespoke joinery fabrication.</p>
        
        <div class="nior-contact-detail-row">
          <div class="item">
            <span class="label">Headquarters Office</span>
            <div class="val">
              S-03-03A, Empire Kota Damansara<br />
              Petaling Jaya, Selangor, Malaysia
            </div>
          </div>

          <div class="item">
            <span class="label">Factory & Fabrication</span>
            <div class="val">
              11,000 SQ FT Production Facility<br />
              Johor Bahru, Malaysia
            </div>
          </div>

          <div class="item">
            <span class="label">Direct Telephone</span>
            <div class="val">
              <a href="tel:+60376131376">+603 7613 1376</a> / <a href="tel:+60376131377">+603 7613 1377</a>
            </div>
          </div>

          <div class="item">
            <span class="label">General Inquiries</span>
            <div class="val">
              <a href="mailto:info@nioratelier.com">info@nioratelier.com</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Architectural Consultation Form -->
      <form class="nior-form" action="#" method="POST" onsubmit="event.preventDefault(); alert('Thank you for reaching out to Nior Atelier. Our design directors will review your inquiry promptly.');">
        <h3 style="font-size: 24px; margin-bottom: 24px; color: var(--nior-white);">Project Consultation Request</h3>
        
        <div class="nior-form__row">
          <div class="nior-form__group">
            <label for="niorName">Full Name *</label>
            <input type="text" id="niorName" name="name" required placeholder="Your Name" />
          </div>
          <div class="nior-form__group">
            <label for="niorEmail">Email Address *</label>
            <input type="email" id="niorEmail" name="email" required placeholder="name@company.com" />
          </div>
        </div>

        <div class="nior-form__row">
          <div class="nior-form__group">
            <label for="niorPhone">Phone / WhatsApp</label>
            <input type="tel" id="niorPhone" name="phone" placeholder="+60 12 345 6789" />
          </div>
          <div class="nior-form__group">
            <label for="niorType">Project Typology *</label>
            <select id="niorType" name="type" required>
              <option value="">Select Project Typology</option>
              <option value="commercial">Commercial / Workplace</option>
              <option value="hospitality">F&B / Hospitality / Lounge</option>
              <option value="retail">Retail / Flagship Store</option>
              <option value="residential">Luxury Residential / Villa</option>
              <option value="custom">Custom Fabrication / Build</option>
            </select>
          </div>
        </div>

        <div class="nior-form__group">
          <label for="niorLocation">Project Location & Estimated SQ FT</label>
          <input type="text" id="niorLocation" name="location" placeholder="e.g. Kuala Lumpur, 4,500 sq ft" />
        </div>

        <div class="nior-form__group">
          <label for="niorMessage">Project Vision & Brief *</label>
          <textarea id="niorMessage" name="message" required placeholder="Tell us about the space, concept, timeline, and key goals..."></textarea>
        </div>

        <button type="submit" class="nior-btn" style="width: 100%; border: none;">
          <span>Submit Project Inquiry</span>
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </form>

    </div>
  </div>
</section>
<!-- /wp:html -->
