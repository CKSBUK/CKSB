document.addEventListener('DOMContentLoaded', () => {

  // ── Header Scroll Effect ─────────────────────────────────────────────────
  const header = document.getElementById('main-header');
  const scrollThreshold = 50;

  const checkScroll = () => {
    if (!header) return;
    if (window.scrollY > scrollThreshold) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', checkScroll, { passive: true });
  checkScroll();

  // ── Mobile Navigation Toggle ─────────────────────────────────────────────
  const navToggle = document.querySelector('.nav-toggle');
  const navLinks  = document.querySelector('.nav-links');

  if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
      navToggle.classList.toggle('open');
      navLinks.classList.toggle('open');

      if (navLinks.classList.contains('open')) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    });

    // Close menu when any link is clicked
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navToggle.classList.remove('open');
        navLinks.classList.remove('open');
        document.body.style.overflow = '';
      });
    });
  }

  // ── Scroll Reveal Animations ─────────────────────────────────────────────
  const revealElements = document.querySelectorAll('.reveal');

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.15,
      rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(el => observer.observe(el));
  } else {
    // Fallback for old browsers
    revealElements.forEach(el => el.classList.add('active'));
  }

  // ── Vacancy "Apply Now" → pre-populate contact form ─────────────────────
  // Works with both the static mailto form and Contact Form 7.
  document.querySelectorAll('.apply-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const instrument = e.currentTarget.getAttribute('data-instrument');

      // Generic field selectors (works with CF7, Fluent Forms, WPForms, etc.)
      const subjectFields = document.querySelectorAll('input[name*="subject"], input[name*="Subject"], #subject, input[name*="Subject"]');
      const messageFields = document.querySelectorAll('textarea');

      const subjectValue = `Vacancy Application: ${instrument}`;
      const messageValue = `Hi Crosskeys Silver Band,\n\nI would like to apply for the ${instrument} vacancy. Here is a bit about my playing experience:\n\n[Add details here]`;

      subjectFields.forEach(field => {
        field.value = subjectValue;
        field.dispatchEvent(new Event('input', { bubbles: true }));
        field.dispatchEvent(new Event('change', { bubbles: true }));
      });
      
      messageFields.forEach(field => {
        field.value = messageValue;
        field.dispatchEvent(new Event('input', { bubbles: true }));
        field.dispatchEvent(new Event('change', { bubbles: true }));
      });
    });
  });

  // ── Email decode (used on footer email icon if href is still '#') ────────
  document.querySelectorAll('.decode-email').forEach(el => {
    const user   = el.getAttribute('data-user');
    const domain = el.getAttribute('data-domain');
    if (user && domain) {
      const email = `${user}@${domain}`;
      el.href = `mailto:${email}`;
      if (el.children.length === 0 && (el.textContent.trim() === '' || el.textContent.includes('[at]'))) {
        el.textContent = email;
      }
    }
  });

});
