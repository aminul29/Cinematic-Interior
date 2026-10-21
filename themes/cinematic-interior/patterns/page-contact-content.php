<?php
/**
 * Title: Page Content — Contact Us
 * Slug: cinematic-interior/page-contact-content
 * Categories: nior-pages
 * Description: Complete contact page layout with studio details, phone, and inquiry form.
 */
?>
<!-- wp:html -->
<div class="nior-page-hero nior-page-hero--contact" style="background-image: linear-gradient(180deg, rgba(12, 13, 14, 0.60) 0%, rgba(12, 13, 14, 0.78) 100%), url('<?php echo esc_url( get_theme_file_uri( '/assets/img/contact-us-banner-bg.jpg' ) ); ?>');">
  <div class="nior-container">
    <div class="nior-page-hero__inner">
      <span class="nior-eyebrow">Let's Create Something People Remember</span>
      <h1>Start A Project</h1>
      <p class="nior-lead">
        Every great space begins with a conversation. Tell us about your project, your vision and what you hope to achieve. Our team looks forward to exploring the possibilities with you.
      </p>
    </div>
  </div>
</div>

<section class="nior-section nior-section--surface">
  <div class="nior-container">
    <div class="nior-contact-grid">
      
      <!-- Studio Details Card -->
      <div class="nior-contact-info-card">
        <span class="nior-eyebrow">Get In Touch</span>
        <h3>NIOR ATELIER</h3>
        <p>Our multidisciplinary practice bridges strategic design with complete in-house construction and bespoke joinery fabrication.</p>
        
        <div class="nior-contact-detail-row">
          <div class="item">
            <span class="label">Headquarters Office</span>
            <div class="val">
              <a href="https://www.google.com/maps/search/?api=1&query=S-03-03A%2C+Empire+Kota+Damansara%2C+Persiaran+Surian%2C+47810+Petaling+Jaya%2C+Selangor%2C+Malaysia" target="_blank" rel="noopener noreferrer" title="Open in Google Maps">
                S-03-03A, Empire Kota Damansara,<br />
                Persiaran Surian, 47810 Petaling Jaya,<br />
                Selangor, Malaysia.
              </a>
            </div>
          </div>

          <div class="item">
            <span class="label">Factory &amp; Fabrication</span>
            <div class="val">
              11,000 SQ FT Headquarters + Furniture Factory<br />
              Johor Bahru, Malaysia.
            </div>
          </div>

          <div class="item">
            <span class="label">Direct Telephone</span>
            <div class="val">
              <a href="tel:+60376131376">+603 7613 1376</a> / <a href="tel:+60376131377">+603 7613 1377</a>
            </div>
          </div>

          <div class="item">
            <span class="label">Email Address</span>
            <div class="val">
              <a href="mailto:info@nioratelier.com">info@nioratelier.com</a>
            </div>
          </div>

          <div class="item">
            <span class="label">Official Website</span>
            <div class="val">
              <a href="https://www.nioratelier.com" target="_blank" rel="noopener">www.nioratelier.com</a>
            </div>
          </div>
        </div>

        <div class="nior-contact-map-wrap">
          <div class="nior-contact-map-header">
            <span class="label">Location Map</span>
            <a href="https://www.google.com/maps/search/?api=1&query=S-03-03A%2C+Empire+Kota+Damansara%2C+Persiaran+Surian%2C+47810+Petaling+Jaya%2C+Selangor%2C+Malaysia" target="_blank" rel="noopener noreferrer" class="nior-contact-map-sublink" title="Open Empire Kota Damansara in Google Maps">
              <span>Empire Kota Damansara</span>
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            </a>
          </div>
          <div class="nior-contact-map-frame">
            <iframe
              src="https://maps.google.com/maps?q=Empire+Kota+Damansara%2C%20Persiaran%20Surian%2C%2047810%20Petaling%20Jaya%2C%20Selangor%2C%20Malaysia&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Google Map location of Nior Atelier Headquarters at Empire Kota Damansara">
            </iframe>
          </div>
          <a href="https://www.google.com/maps/search/?api=1&query=S-03-03A%2C+Empire+Kota+Damansara%2C+Persiaran+Surian%2C+47810+Petaling+Jaya%2C+Selangor%2C+Malaysia" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="nior-contact-map-btn"
             title="Open in Google Maps for directions and navigation">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
              <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>Open in Google Maps / Directions</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
              <polyline points="15 3 21 3 21 9"></polyline>
              <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
          </a>
        </div>
      </div>

      <!-- Architectural Consultation Form -->
      <form class="nior-form" action="#" method="POST" onsubmit="event.preventDefault(); document.getElementById('niorFormSuccess').style.display='block'; this.reset();">
        <h3 style="font-size: 24px; margin-bottom: 8px; color: var(--nior-white);">Start A Project</h3>
        <p style="font-size: 14px; color: var(--nior-muted); margin-bottom: 24px;">Tell us a little about your project so we can better understand your requirements.</p>
        
        <div class="nior-form__row">
          <div class="nior-form__group">
            <label for="niorName">Full Name *</label>
            <input type="text" id="niorName" name="name" required placeholder="Your Name" />
          </div>
          <div class="nior-form__group">
            <label for="niorCompany">Company Name</label>
            <input type="text" id="niorCompany" name="company" placeholder="Your Business / Brand" />
          </div>
        </div>

        <div class="nior-form__row">
          <div class="nior-form__group">
            <label for="niorEmail">Email Address *</label>
            <input type="email" id="niorEmail" name="email" required placeholder="name@company.com" />
          </div>
          <div class="nior-form__group">
            <label for="niorPhone">Contact Number *</label>
            <input type="tel" id="niorPhone" name="phone" required placeholder="+60 12 345 6789" />
          </div>
        </div>

        <div class="nior-form__row">
          <div class="nior-form__group">
            <label for="niorType">Project Type *</label>
            <select id="niorType" name="type" required>
              <option value="">Select Project Type</option>
              <option value="commercial">Commercial Interiors</option>
              <option value="retail">Retail &amp; Shopping Malls</option>
              <option value="hospitality">F&amp;B &amp; Hospitality</option>
              <option value="residential">Residential &amp; Villas</option>
              <option value="custom">Custom Fabrication &amp; Build</option>
            </select>
          </div>
          <div class="nior-form__group">
            <label for="niorBudget">Estimated Budget</label>
            <select id="niorBudget" name="budget">
              <option value="">Select Estimated Budget</option>
              <option value="under-200k">Under RM 200,000</option>
              <option value="200k-500k">RM 200,000 – RM 500,000</option>
              <option value="500k-1m">RM 500,000 – RM 1,000,000</option>
              <option value="above-1m">Above RM 1,000,000</option>
            </select>
          </div>
        </div>

        <div class="nior-form__group">
          <label for="niorLocation">Project Location</label>
          <input type="text" id="niorLocation" name="location" placeholder="e.g. Kuala Lumpur, Johor Bahru, Petaling Jaya" />
        </div>

        <div class="nior-form__group">
          <label for="niorMessage">Tell Us About Your Project *</label>
          <textarea id="niorMessage" name="message" required placeholder="Tell us about the space, concept, timeline, and key goals..."></textarea>
        </div>

        <button type="submit" class="nior-btn" style="width: 100%; border: none;">
          <span>Submit Project Enquiry</span>
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>

        <div id="niorFormSuccess" style="display:none; padding:16px 20px; margin-top:20px; background:rgba(201,162,94,0.12); border:1px solid var(--nior-gold); border-radius:4px; color:var(--nior-gold-light); font-size:14px; text-align:center; line-height: 1.6;">
          Thank you for your enquiry. Our team will be in touch to discuss your project.
        </div>
      </form>

    </div>
  </div>
</section>
<!-- /wp:html -->
