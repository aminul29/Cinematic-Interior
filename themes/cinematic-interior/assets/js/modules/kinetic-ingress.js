/**
 * Refined Luxury Architectural ScrollTrigger Ingress
 * Subtle, calm 2D micro-animations: gentle vertical elevations, soft opacity reveals,
 * and harmonious staggered pacing. Strictly no 3D tilt or gimmicky spring physics.
 */

export function initKineticIngress() {
  const { gsap, ScrollTrigger } = window;
  if (!gsap || !ScrollTrigger) return;

  // Honor user accessibility preferences
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReducedMotion) return;

  // 1. Value Pillar Cards: Clean Vertical Elevation
  const pillarCards = document.querySelectorAll('.nior-pillar-card');
  if (pillarCards.length) {
    pillarCards.forEach((card, index) => {
      gsap.fromTo(
        card,
        {
          y: 28,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.8,
          delay: (index % 4) * 0.08,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 88%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });
  }

  // 2. Process Step Cards: Staggered Sequential Rise
  const processSteps = document.querySelectorAll('.nior-process-step');
  if (processSteps.length) {
    processSteps.forEach((step, index) => {
      gsap.fromTo(
        step,
        {
          y: 24,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.75,
          delay: (index % 5) * 0.07,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: step,
            start: 'top 88%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });
  }

  // 3. Why Nior Advantage Cards: Architectural Elevation
  const advantageCards = document.querySelectorAll('.nior-advantage-card');
  if (advantageCards.length) {
    advantageCards.forEach((card, index) => {
      gsap.fromTo(
        card,
        {
          y: 30,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.85,
          delay: (index % 2) * 0.12,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 88%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });
  }

  // 4. Commercial Sectors Cards: Refined Ingress
  const sectorCards = document.querySelectorAll('.nior-sector-card');
  if (sectorCards.length) {
    sectorCards.forEach((card, index) => {
      gsap.fromTo(
        card,
        {
          y: 26,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.8,
          delay: (index % 4) * 0.08,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 88%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });
  }

  // 5. Featured Project & Split Content Grid Reveals
  const splitSections = document.querySelectorAll(
    '.nior-vstage-grid, .nior-inhouse-grid, .nior-about-story, .nior-contact-grid'
  );
  splitSections.forEach((section) => {
    const leftCol = section.children[0];
    const rightCol = section.children[1];

    if (leftCol) {
      gsap.fromTo(
        leftCol,
        {
          y: 24,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.85,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: section,
            start: 'top 85%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    }

    if (rightCol) {
      gsap.fromTo(
        rightCol,
        {
          y: 24,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.85,
          delay: 0.12,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: section,
            start: 'top 85%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    }
  });

  // 6. CTA Box Calm Grand Focus
  const ctaBox = document.querySelector('.nior-cta-box');
  if (ctaBox) {
    gsap.fromTo(
      ctaBox,
      {
        y: 24,
        scale: 0.98,
        opacity: 0,
      },
      {
        y: 0,
        scale: 1,
        opacity: 1,
        duration: 0.9,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: ctaBox,
          start: 'top 85%',
          toggleActions: 'play none none reverse',
        },
      }
    );
  }

  // 7. Cinematic Scenario Cards: Media and Content Ingress
  const scenarioCards = document.querySelectorAll('.nior-scenario-card');
  scenarioCards.forEach((card) => {
    const media = card.querySelector('.nior-scenario-card__media');
    const content = card.querySelector('.nior-scenario-card__content');

    if (media && content) {
      gsap.fromTo(
        media,
        {
          opacity: 0,
          y: 26,
        },
        {
          opacity: 1,
          y: 0,
          duration: 0.85,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 85%',
            toggleActions: 'play none none reverse',
          },
        }
      );

      gsap.fromTo(
        content,
        {
          opacity: 0,
          y: 20,
        },
        {
          opacity: 1,
          y: 0,
          duration: 0.85,
          delay: 0.1,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 85%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    }
  });

  // 8. Supporting Pages: Service Items & Portfolio Cards
  const serviceItems = document.querySelectorAll('.nior-service-item');
  if (serviceItems.length) {
    serviceItems.forEach((item, index) => {
      gsap.fromTo(
        item,
        {
          y: 24,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.8,
          delay: (index % 2) * 0.1,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: item,
            start: 'top 88%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });
  }

  const portfolioCards = document.querySelectorAll('.nior-portfolio-card');
  if (portfolioCards.length) {
    portfolioCards.forEach((card, index) => {
      gsap.fromTo(
        card,
        {
          y: 26,
          opacity: 0,
        },
        {
          y: 0,
          opacity: 1,
          duration: 0.8,
          delay: (index % 3) * 0.08,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: card,
            start: 'top 88%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });
  }
}
