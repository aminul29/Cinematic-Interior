/**
 * 'Our Clients' Physics Falling Logos Engine
 * Staggered drop from top with realistic gravity, rotation offsets, and soft organic bounce.
 */

export function initFallingLogos() {
  const arena = document.getElementById('niorFallingArena');
  const chips = document.querySelectorAll('.nior-logo-chip');
  if (!arena || !chips.length) return;

  const { gsap, ScrollTrigger } = window;
  if (!gsap || !ScrollTrigger) return;

  // Initial random rotation offsets for natural organic feel
  const rotations = [-7, 6, -5, 7, -8, 4, -6, 8, -4, 5, -6];

  chips.forEach((chip, i) => {
    const rot = rotations[i % rotations.length];
    chip.style.setProperty('--chip-init-rot', `${rot}deg`);
  });

  // Staggered physics drop animation
  gsap.fromTo(
    chips,
    {
      y: (i) => -320 - (i % 3) * 60,
      scale: 0.6,
      opacity: 0,
      rotate: (i) => rotations[i % rotations.length],
      filter: 'blur(8px)',
    },
    {
      y: 0,
      scale: 1,
      opacity: 1,
      rotate: 0,
      filter: 'blur(0px)',
      duration: 1.25,
      stagger: {
        amount: 0.85,
        from: 'random',
      },
      ease: 'bounce.out',
      scrollTrigger: {
        trigger: arena,
        start: 'top 75%',
        end: 'bottom 15%',
        toggleActions: 'play reverse play reverse',
      },
    }
  );
}
