/**
 * Two-Way Bidirectional 3D Kinetic ScrollTrigger Ingress Recipes
 * Spiraling 3D ingress, angular perspective convergence, and dynamic spring elevation.
 */

export function initKineticIngress() {
  const { gsap, ScrollTrigger } = window;
  if (!gsap || !ScrollTrigger) return;

  // Honor user accessibility preferences
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReducedMotion) return;

  // 1. Value Pillar Cards: Spiraling 3D Ingress
  const pillarCards = document.querySelectorAll('.nior-pillar-card');
  if (pillarCards.length) {
    const angles = [
      { rotate: -8, rotateY: -15, y: 50 },
      { rotate: 6, rotateY: 12, y: 50 },
      { rotate: -6, rotateY: -12, y: 50 },
      { rotate: 8, rotateY: 15, y: 50 },
    ];

    pillarCards.forEach((card, index) => {
      const conf = angles[index % angles.length];
      gsap.fromTo(
        card,
        {
          rotate: conf.rotate,
          rotateY: conf.rotateY,
          y: conf.y,
          scale: 0.85,
          opacity: 0,
        },
        {
          rotate: 0,
          rotateY: 0,
          y: 0,
          scale: 1,
          opacity: 1,
          duration: 1.0,
          ease: 'back.out(1.4)',
          scrollTrigger: {
            trigger: card,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    });
  }

  // 2. Process Step Cards: Staggered 3D Ingress
  const processSteps = document.querySelectorAll('.nior-process-step');
  if (processSteps.length) {
    processSteps.forEach((step, idx) => {
      gsap.fromTo(
        step,
        { y: 60, opacity: 0, scale: 0.9 },
        {
          y: 0,
          opacity: 1,
          scale: 1,
          duration: 0.9,
          delay: idx * 0.08,
          ease: 'back.out(1.3)',
          scrollTrigger: {
            trigger: step,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    });
  }

  // 3. Why Nior Advantage Cards: Dynamic 3D Tilt Ingress
  const advantageCards = document.querySelectorAll('.nior-advantage-card');
  if (advantageCards.length) {
    const advAngles = [
      { rotate: -5, rotateY: -12, y: 50 },
      { rotate: 5, rotateY: 12, y: 50 },
      { rotate: -4, rotateY: -10, y: 50 },
      { rotate: 4, rotateY: 10, y: 50 },
    ];

    advantageCards.forEach((card, index) => {
      const conf = advAngles[index % advAngles.length];
      gsap.fromTo(
        card,
        {
          rotate: conf.rotate,
          rotateY: conf.rotateY,
          y: conf.y,
          scale: 0.88,
          opacity: 0,
        },
        {
          rotate: 0,
          rotateY: 0,
          y: 0,
          scale: 1,
          opacity: 1,
          duration: 1.0,
          ease: 'back.out(1.4)',
          scrollTrigger: {
            trigger: card,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    });
  }

  // 4. Commercial Sectors Grid: Alternating 3D Ingress
  const sectorCards = document.querySelectorAll('.nior-sector-card');
  if (sectorCards.length) {
    const sectorAngles = [
      { rotate: -6, rotateY: -12, y: 50 },
      { rotate: 6, rotateY: 12, y: 50 },
      { rotate: -5, rotateY: -10, y: 50 },
      { rotate: 5, rotateY: 10, y: 50 },
    ];

    sectorCards.forEach((card, index) => {
      const conf = sectorAngles[index % sectorAngles.length];
      gsap.fromTo(
        card,
        {
          rotate: conf.rotate,
          rotateY: conf.rotateY,
          y: conf.y,
          scale: 0.88,
          opacity: 0,
        },
        {
          rotate: 0,
          rotateY: 0,
          y: 0,
          scale: 1,
          opacity: 1,
          duration: 1.0,
          ease: 'back.out(1.3)',
          scrollTrigger: {
            trigger: card,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    });
  }

  // 5. Featured Project & Split Grid 3D Convergence
  const splitSections = document.querySelectorAll(
    '.nior-vstage-grid, .nior-inhouse-grid, .nior-about-story, .nior-contact-grid'
  );
  splitSections.forEach((section) => {
    const leftCol = section.children[0];
    const rightCol = section.children[1];

    if (leftCol && rightCol) {
      gsap.fromTo(
        leftCol,
        { x: -70, opacity: 0, scale: 0.94 },
        {
          x: 0,
          opacity: 1,
          scale: 1,
          duration: 1.1,
          ease: 'power3.out',
          scrollTrigger: {
            trigger: section,
            start: 'top 80%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );

      gsap.fromTo(
        rightCol,
        { x: 70, opacity: 0, scale: 0.94 },
        {
          x: 0,
          opacity: 1,
          scale: 1,
          duration: 1.1,
          ease: 'power3.out',
          scrollTrigger: {
            trigger: section,
            start: 'top 80%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    }
  });

  // 6. CTA Box Explosive Scale-Up
  const ctaBox = document.querySelector('.nior-cta-box');
  if (ctaBox) {
    gsap.fromTo(
      ctaBox,
      { scale: 0.88, opacity: 0, y: 50 },
      {
        scale: 1,
        opacity: 1,
        y: 0,
        duration: 1.1,
        ease: 'back.out(1.4)',
        scrollTrigger: {
          trigger: ctaBox,
          start: 'top 85%',
          end: 'bottom 15%',
          toggleActions: 'play reverse play reverse',
        },
      }
    );
  }

  // 7. Cinematic Scenario Cards: Staggered Parallax Ingress
  const scenarioCards = document.querySelectorAll('.nior-scenario-card');
  scenarioCards.forEach((card) => {
    const media = card.querySelector('.nior-scenario-card__media');
    const content = card.querySelector('.nior-scenario-card__content');

    if (media && content) {
      gsap.fromTo(
        media,
        { opacity: 0, y: 50, scale: 0.95 },
        {
          opacity: 1,
          y: 0,
          scale: 1,
          duration: 1.1,
          ease: 'power3.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 82%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );

      gsap.fromTo(
        content,
        { opacity: 0, y: 40 },
        {
          opacity: 1,
          y: 0,
          duration: 1.0,
          delay: 0.15,
          ease: 'power3.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 82%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    }
  });

  // 8. Supporting Pages: Service Items & Portfolio Cards
  const serviceItems = document.querySelectorAll('.nior-service-item');
  if (serviceItems.length) {
    serviceItems.forEach((item, index) => {
      const rot = index % 2 === 0 ? -4 : 4;
      gsap.fromTo(
        item,
        { rotate: rot, rotateY: rot * 1.5, y: 40, opacity: 0, scale: 0.9 },
        {
          rotate: 0,
          rotateY: 0,
          y: 0,
          opacity: 1,
          scale: 1,
          duration: 0.95,
          ease: 'back.out(1.3)',
          scrollTrigger: {
            trigger: item,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    });
  }

  const portfolioCards = document.querySelectorAll('.nior-portfolio-card');
  if (portfolioCards.length) {
    portfolioCards.forEach((card, index) => {
      const rot = index % 2 === 0 ? -4 : 4;
      gsap.fromTo(
        card,
        { rotate: rot, rotateY: rot * 1.5, y: 45, opacity: 0, scale: 0.9 },
        {
          rotate: 0,
          rotateY: 0,
          y: 0,
          opacity: 1,
          scale: 1,
          duration: 0.95,
          delay: (index % 3) * 0.08,
          ease: 'back.out(1.3)',
          scrollTrigger: {
            trigger: card,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    });
  }

  // Helper: extract direct narrative children for staggered luxury ingress
  function getNarrativeChildren(container) {
    const excludedClasses = [
      'nior-pillars-grid',
      'nior-process-steps',
      'nior-advantages-grid',
      'nior-sectors-grid',
      'nior-portfolio-grid',
      'nior-scenarios-grid',
      'nior-vstage-impact-grid',
    ];
    return Array.from(container.children).filter((child) => {
      for (const cls of excludedClasses) {
        if (child.classList.contains(cls)) return false;
      }
      return true;
    });
  }

  // 9. Section Header & Introductory Content Blocks: Staggered Luxury Ingress
  const sectionHeaders = document.querySelectorAll(
    '.nior-section-header, .nior-scenarios-header, .nior-services-header, .nior-page-hero__inner'
  );
  sectionHeaders.forEach((header) => {
    const targets = getNarrativeChildren(header);
    if (!targets.length) return;

    gsap.fromTo(
      targets,
      {
        y: 48,
        opacity: 0,
        scale: 0.94,
      },
      {
        y: 0,
        opacity: 1,
        scale: 1,
        duration: 1.0,
        stagger: 0.14,
        ease: 'back.out(1.2)',
        scrollTrigger: {
          trigger: header,
          start: 'top 86%',
          end: 'bottom 15%',
          toggleActions: 'play reverse play reverse',
        },
      }
    );
  });

  // 10. Architectural Details & Secondary Content Blocks
  // 10a. V-Stage Lounge Impact Items
  const impactGrid = document.querySelector('.nior-vstage-impact-grid');
  if (impactGrid) {
    const items = impactGrid.querySelectorAll('.nior-impact-item');
    if (items.length) {
      gsap.fromTo(
        items,
        { y: 28, opacity: 0, scale: 0.92 },
        {
          y: 0,
          opacity: 1,
          scale: 1,
          duration: 0.75,
          stagger: 0.08,
          ease: 'back.out(1.3)',
          scrollTrigger: {
            trigger: impactGrid,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    }
  }

  // 10b. Factory Infrastructure Showcase Cards
  const factoryCards = document.querySelectorAll('.nior-factory-card');
  if (factoryCards.length) {
    gsap.fromTo(
      factoryCards,
      { y: 55, opacity: 0, scale: 0.88, rotate: -2 },
      {
        y: 0,
        opacity: 1,
        scale: 1,
        rotate: 0,
        duration: 1.0,
        stagger: 0.12,
        ease: 'back.out(1.3)',
        scrollTrigger: {
          trigger: factoryCards[0].parentElement,
          start: 'top 85%',
          end: 'bottom 15%',
          toggleActions: 'play reverse play reverse',
        },
      }
    );
  }

  // 10c. Scenarios Section Footer Button
  const scenariosFooter = document.querySelector('.nior-scenarios-footer');
  if (scenariosFooter) {
    gsap.fromTo(
      scenariosFooter,
      { y: 40, opacity: 0, scale: 0.92 },
      {
        y: 0,
        opacity: 1,
        scale: 1,
        duration: 0.95,
        ease: 'back.out(1.3)',
        scrollTrigger: {
          trigger: scenariosFooter,
          start: 'top 88%',
          end: 'bottom 15%',
          toggleActions: 'play reverse play reverse',
        },
      }
    );
  }

  // 10d. Explicit Content Blocks (.nior-content-block)
  const contentBlocks = document.querySelectorAll(
    '.nior-content-block:not(.nior-vstage-details)'
  );
  contentBlocks.forEach((block) => {
    if (block.classList.contains('nior-section-header')) return;
    const targets = getNarrativeChildren(block);
    if (!targets.length) return;

    gsap.fromTo(
      targets,
      { y: 48, opacity: 0, scale: 0.95 },
      {
        y: 0,
        opacity: 1,
        scale: 1,
        duration: 1.0,
        stagger: targets.length > 1 ? 0.14 : 0,
        ease: 'back.out(1.2)',
        scrollTrigger: {
          trigger: block,
          start: 'top 85%',
          end: 'bottom 15%',
          toggleActions: 'play reverse play reverse',
        },
      }
    );
  });

  // 11. WordPress Gutenberg Page Content Blocks
  const postContentContainers = document.querySelectorAll(
    '.wp-block-post-content, .entry-content, #main-content.wp-block-group'
  );
  postContentContainers.forEach((container) => {
    const blocks = Array.from(container.children).filter((el) => {
      const tag = el.tagName.toLowerCase();
      if (tag === 'header' || tag === 'footer') return false;
      if (
        el.classList.contains('nior-section') ||
        el.classList.contains('nior-page-hero') ||
        el.classList.contains('nior-walkthrough-hero-track') ||
        el.classList.contains('nior-rack-section') ||
        el.classList.contains('nior-portfolio-unified')
      ) {
        return false;
      }
      return true;
    });

    blocks.forEach((block) => {
      // Multi-column blocks: stagger each column
      if (block.classList.contains('wp-block-columns')) {
        const columns = block.querySelectorAll(':scope > .wp-block-column');
        if (columns.length) {
          gsap.fromTo(
            columns,
            { y: 50, opacity: 0, scale: 0.90 },
            {
              y: 0,
              opacity: 1,
              scale: 1,
              duration: 1.0,
              stagger: 0.14,
              ease: 'back.out(1.3)',
              scrollTrigger: {
                trigger: block,
                start: 'top 85%',
                end: 'bottom 15%',
                toggleActions: 'play reverse play reverse',
              },
            }
          );
          return;
        }
      }

      // Group or nested container blocks: stagger narrative children if multiple
      if (block.classList.contains('wp-block-group')) {
        const innerItems = getNarrativeChildren(block);
        if (innerItems.length > 1) {
          gsap.fromTo(
            innerItems,
            { y: 48, opacity: 0, scale: 0.95 },
            {
              y: 0,
              opacity: 1,
              scale: 1,
              duration: 1.0,
              stagger: 0.14,
              ease: 'back.out(1.2)',
              scrollTrigger: {
                trigger: block,
                start: 'top 85%',
                end: 'bottom 15%',
                toggleActions: 'play reverse play reverse',
              },
            }
          );
          return;
        }
      }

      // Individual Gutenberg content blocks (headings, paragraphs, images, quotes, embeds, tables)
      gsap.fromTo(
        block,
        { y: 46, opacity: 0, scale: 0.96 },
        {
          y: 0,
          opacity: 1,
          scale: 1,
          duration: 1.0,
          ease: 'back.out(1.2)',
          scrollTrigger: {
            trigger: block,
            start: 'top 86%',
            end: 'bottom 15%',
            toggleActions: 'play reverse play reverse',
          },
        }
      );
    });
  });
}
