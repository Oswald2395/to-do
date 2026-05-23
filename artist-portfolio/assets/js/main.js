/* ============================================
   ARTIST PORTFOLIO — MAIN JS
============================================ */

// ░░ LOADER ░░
window.addEventListener('load', () => {
  setTimeout(() => {
    document.getElementById('loader')?.classList.add('hidden');
  }, 1400);
});

// ░░ CUSTOM CURSOR ░░
const cursor    = document.getElementById('cursor');
const cursorDot = document.getElementById('cursorDot');
if (cursor && window.innerWidth > 600) {
  let mx = 0, my = 0, cx = 0, cy = 0;
  document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
  cursorDot.style.transition = 'none';
  (function animate() {
    cx += (mx - cx) * 0.12;
    cy += (my - cy) * 0.12;
    cursor.style.left = cx + 'px';
    cursor.style.top  = cy + 'px';
    cursorDot.style.left = mx + 'px';
    cursorDot.style.top  = my + 'px';
    requestAnimationFrame(animate);
  })();
}

// ░░ NAV SCROLL ░░
const nav = document.getElementById('nav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 40);
}, { passive: true });

// ░░ MOBILE MENU ░░
const menuBtn    = document.getElementById('menuBtn');
const mobileMenu = document.getElementById('mobileMenu');
let menuOpen = false;
menuBtn?.addEventListener('click', () => {
  menuOpen = !menuOpen;
  mobileMenu.classList.toggle('open', menuOpen);
  const spans = menuBtn.querySelectorAll('span');
  if (menuOpen) {
    spans[0].style.transform = 'translateY(6.5px) rotate(45deg)';
    spans[1].style.opacity = '0';
    spans[2].style.transform = 'translateY(-6.5px) rotate(-45deg)';
  } else {
    spans.forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
  }
});
mobileMenu?.querySelectorAll('.mm-link').forEach(link => {
  link.addEventListener('click', () => {
    menuOpen = false;
    mobileMenu.classList.remove('open');
    menuBtn.querySelectorAll('span').forEach(s => { s.style.transform=''; s.style.opacity=''; });
  });
});

// ░░ GALLERY FILTER ░░
document.querySelectorAll('.works-section').forEach(section => {
  const filterBtns = section.querySelectorAll('.filter-btn');
  const items       = section.querySelectorAll('.gallery-item');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      items.forEach(item => {
        const match = filter === 'all' || item.dataset.type === filter;
        item.classList.toggle('hidden', !match);
      });
    });
  });
});

// ░░ VIDEO HOVER PLAY ░░
document.querySelectorAll('.video-wrap').forEach(wrap => {
  const vid = wrap.querySelector('video');
  if (!vid) return;
  wrap.addEventListener('mouseenter', () => { vid.play().catch(() => {}); });
  wrap.addEventListener('mouseleave', () => { vid.pause(); vid.currentTime = 0; });
});

// ░░ LIGHTBOX ░░
const lightbox        = document.getElementById('lightbox');
const lightboxImg     = document.getElementById('lightboxImg');
const lightboxCaption = document.getElementById('lightboxCaption');

window.openLightbox = (src, caption) => {
  lightboxImg.src = src;
  lightboxCaption.textContent = caption;
  lightbox.classList.add('open');
  document.body.style.overflow = 'hidden';
};
window.closeLightbox = () => {
  lightbox.classList.remove('open');
  document.body.style.overflow = '';
  setTimeout(() => { lightboxImg.src = ''; }, 300);
};
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeLightbox();
});

// ░░ SCROLL REVEAL ░░
const revealEls = document.querySelectorAll(
  '.about-grid, .service-card, .gallery-item, .section-header, .contact-grid, .stat'
);
revealEls.forEach(el => el.classList.add('reveal'));

const io = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      setTimeout(() => entry.target.classList.add('visible'), i * 60);
      io.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });

revealEls.forEach(el => io.observe(el));

// ░░ CONTACT FORM (AJAX) ░░
const form = document.getElementById('contactForm');
const fb   = document.getElementById('formFeedback');
form?.addEventListener('submit', async e => {
  e.preventDefault();
  const btn = form.querySelector('button[type=submit]');
  btn.textContent = 'Sending…';
  btn.disabled = true;
  try {
    const res  = await fetch('includes/send_mail.php', {
      method: 'POST',
      body: new FormData(form),
    });
    const text = await res.text();
    if (res.ok && text.trim() === 'ok') {
      fb.className = 'form-feedback success';
      fb.textContent = '✓ Message sent! I\'ll be in touch soon.';
      form.reset();
    } else {
      throw new Error(text);
    }
  } catch {
    fb.className = 'form-feedback error';
    fb.textContent = '✕ Something went wrong. Please try again or email me directly.';
  }
  btn.textContent = 'Send Message →';
  btn.disabled = false;
});
