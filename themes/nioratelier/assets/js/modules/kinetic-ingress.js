/**
 * Two-Way Bidirectional 3D Kinetic ScrollTrigger Ingress Recipes
 * Spiraling ingress, 3D convergence, and explosive center scale-up.
 */

export function initKineticIngress() {
  const { gsap, ScrollTrigger } = window;
  if (!gsap || !ScrollTrigger) return;

  // 1. Value Pillar Cards: Spiraling Ingress
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

  // 2. Process Step Cards: Staggered Ingress
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

  // 3. Featured Project & Split Grid 3D Convergence
  const splitSections = document.querySelectorAll('.nior-vstage-grid, .nior-inhouse-grid');
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

  // 4. CTA Box Explosive Scale-Up
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
}
