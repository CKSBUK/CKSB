document.addEventListener('DOMContentLoaded', () => {
  // --- Header Scroll Effect ---
  const header = document.querySelector('header');
  const scrollThreshold = 50;

  const checkScroll = () => {
    if (window.scrollY > scrollThreshold) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', checkScroll);
  checkScroll(); // Initial check

  // --- Mobile Navigation Toggle ---
  const navToggle = document.querySelector('.nav-toggle');
  const navLinks = document.querySelector('.nav-links');

  if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
      navToggle.classList.toggle('open');
      navLinks.classList.toggle('open');
      
      // Prevent scrolling behind mobile menu when open
      if (navLinks.classList.contains('open')) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    });

    // Close menu when clicking link
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navToggle.classList.remove('open');
        navLinks.classList.remove('open');
        document.body.style.overflow = '';
      });
    });
  }

  // --- Scroll Reveal Animations ---
  const revealElements = document.querySelectorAll('.reveal');
  
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          // Once revealed, no need to keep observing
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.15,
      rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(el => observer.observe(el));
  } else {
    // Fallback if observer is not supported
    revealElements.forEach(el => el.classList.add('active'));
  }

  // --- Dynamic Vacancies Rendering ---
  const vacanciesList = document.getElementById('vacancies-list');
  
  if (vacanciesList) {
    fetch('data/vacancies.json')
      .then(response => {
        if (!response.ok) {
          throw new Error('Vacancies file not found or failed to load');
        }
        return response.json();
      })
      .then(vacancies => {
        renderVacancies(vacancies);
      })
      .catch(error => {
        console.error('Error loading vacancies:', error);
        renderNoVacancies();
      });
  }

  function renderVacancies(vacancies) {
    if (!vacancies || vacancies.length === 0) {
      renderNoVacancies();
      return;
    }

    vacanciesList.innerHTML = '';
    vacancies.forEach(vacancy => {
      const card = document.createElement('div');
      card.className = 'glass-card vacancy-card reveal';
      
      // Formatting date
      let formattedDate = '';
      if (vacancy.dateAdded) {
        const dateObj = new Date(vacancy.dateAdded);
        formattedDate = dateObj.toLocaleDateString('en-GB', {
          day: 'numeric',
          month: 'short',
          year: 'numeric'
        });
      }

      card.innerHTML = `
        <div class="vacancy-header">
          <h3 class="vacancy-instrument">${escapeHTML(vacancy.instrument)}</h3>
          <span class="vacancy-badge">${escapeHTML(vacancy.section || 'General')}</span>
        </div>
        <p class="vacancy-desc">${escapeHTML(vacancy.description)}</p>
        <div class="vacancy-footer">
          <span>Added: ${escapeHTML(formattedDate)}</span>
          <a href="#contact" class="btn btn-outline btn-sm apply-btn" data-instrument="${escapeHTML(vacancy.instrument)}">Apply Now</a>
        </div>
      `;
      vacanciesList.appendChild(card);
      
      // Apply IntersectionObserver to newly added elements
      if (window.IntersectionObserver) {
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('active');
              observer.unobserve(entry.target);
            }
          });
        });
        observer.observe(card);
      } else {
        card.classList.add('active');
      }
    });

    // Add click handler to auto-populate subject line in contact form
    document.querySelectorAll('.apply-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const instrument = e.target.getAttribute('data-instrument');
        const subjectField = document.getElementById('subject');
        const messageField = document.getElementById('message');
        
        if (subjectField) {
          subjectField.value = `Vacancy Application: ${instrument}`;
        }
        if (messageField) {
          messageField.value = `Hi Crosskeys Silver Band,\n\nI would like to apply for the ${instrument} vacancy. Here is a bit about my playing experience:\n\n[Add details here]`;
        }
      });
    });
  }

  function renderNoVacancies() {
    vacanciesList.innerHTML = `
      <div class="glass-card no-vacancies-card reveal active">
        <div class="no-vacancies-icon">📯</div>
        <h3>No Current Vacancies</h3>
        <p class="section-subtitle" style="margin-bottom: 1.5rem; max-width: 100%;">
          We don't have any specific player vacancies at the moment. However, we are a friendly and welcoming band, and we always love to meet new players. 
        </p>
        <p class="section-subtitle" style="margin-bottom: 2rem; max-width: 100%;">
          If you play a brass or percussion instrument and want to join us for a rehearsal, please contact us or drop by!
        </p>
        <a href="#contact" class="btn btn-primary">Get In Touch</a>
      </div>
    `;
  }

  // --- Contact Form Handler ---
  const contactForm = document.getElementById('contact-form');
  const formStatus = document.getElementById('form-status');

  if (contactForm && formStatus) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      // Collect form details
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const subject = document.getElementById('subject').value;
      const message = document.getElementById('message').value;

      if (!name || !email || !message) {
        showStatus('Please fill in all required fields.', 'error');
        return;
      }

      // Since this is a static site without a backend, we simulate sending 
      // but also provide a fallback to open the user's mail client.
      showStatus('Sending message...', 'info');

      // Simple artificial delay for a premium feel
      setTimeout(() => {
        showStatus('Thank you for your message! Since this is a static website, we have also prepared an email for you. Click "Send Email via Client" below if you wish to send it manually, or we will receive your simulated contact in this demo!', 'success');
        
        // Add a helper mailto button for real sending (obfuscated in code)
        const u = 'secretary';
        const d = 'crosskeysband.co.uk';
        const mailtoUrl = `mailto:${u}@${d}?subject=${encodeURIComponent(subject || 'Contact from website')}&body=${encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\n${message}`)}`;
        
        const mailtoBtn = document.createElement('a');
        mailtoBtn.href = mailtoUrl;
        mailtoBtn.className = 'btn btn-primary';
        mailtoBtn.style.marginTop = '1rem';
        mailtoBtn.innerText = 'Send Email via Client';
        mailtoBtn.id = 'mailto-fallback-btn';
        
        // Remove old fallback button if exists
        const oldBtn = document.getElementById('mailto-fallback-btn');
        if (oldBtn) oldBtn.remove();
        
        formStatus.appendChild(document.createElement('br'));
        formStatus.appendChild(mailtoBtn);
        
        contactForm.reset();
      }, 1200);
    });
  }

  // --- Email Obfuscation Decoder ---
  document.querySelectorAll('.decode-email').forEach(el => {
    const user = el.getAttribute('data-user');
    const domain = el.getAttribute('data-domain');
    if (user && domain) {
      const email = `${user}@${domain}`;
      el.href = `mailto:${email}`;
      
      // Only set text if the element has no child HTML tags (like icons) and is empty/placeholder
      if (el.children.length === 0 && (el.textContent.trim() === '' || el.textContent.includes('[at]'))) {
        el.textContent = email;
      }
    }
  });

  function showStatus(msg, type) {
    formStatus.className = 'form-status';
    formStatus.innerText = msg;
    
    if (type === 'success') {
      formStatus.classList.add('success');
    } else if (type === 'error') {
      formStatus.classList.add('error');
    } else {
      formStatus.style.display = 'block';
      formStatus.style.background = 'rgba(255, 215, 0, 0.05)';
      formStatus.style.color = 'var(--color-gold)';
      formStatus.style.border = '1px solid var(--border-glass)';
    }
  }

  // --- Helper to escape HTML to prevent XSS ---
  function escapeHTML(str) {
    if (!str) return '';
    return str.replace(/[&<>'"]/g, 
      tag => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#39;',
        '"': '&quot;'
      }[tag] || tag)
    );
  }
});
