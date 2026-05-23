<?php
// Load works from uploads folders
function getWorks($folder) {
    $dir = __DIR__ . '/uploads/' . $folder . '/';
    $allowed = ['jpg','jpeg','png','gif','webp','mp4','webm','mov'];
    $files = [];
    if (is_dir($dir)) {
        foreach (glob($dir . '*') as $f) {
            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $files[] = [
                    'name' => pathinfo($f, PATHINFO_FILENAME),
                    'file' => basename($f),
                    'ext'  => $ext,
                    'type' => in_array($ext, ['mp4','webm','mov']) ? 'video' : 'image',
                    'path' => 'uploads/' . $folder . '/' . basename($f),
                ];
            }
        }
    }
    return $files;
}

$works2d = getWorks('2d');
$works3d = getWorks('3d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Portfolio — Artist</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<!-- ░░ CURSOR ░░ -->
<div class="cursor" id="cursor"></div>
<div class="cursor-dot" id="cursorDot"></div>

<!-- ░░ LOADER ░░ -->
<div class="loader" id="loader">
  <div class="loader-text">
    <span>A</span><span>R</span><span>T</span><span>I</span><span>S</span><span>T</span>
  </div>
</div>

<!-- ░░ NAV ░░ -->
<nav class="nav" id="nav">
  <a href="#" class="nav-logo">ARTISTÉ</a>
  <div class="nav-links">
    <a href="#about">About</a>
    <a href="#works-2d">2D</a>
    <a href="#works-3d">3D</a>
    <a href="#contact">Contact</a>
  </div>
  <button class="nav-menu-btn" id="menuBtn" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- ░░ MOBILE MENU ░░ -->
<div class="mobile-menu" id="mobileMenu">
  <a href="#about" class="mm-link">About</a>
  <a href="#works-2d" class="mm-link">2D Works</a>
  <a href="#works-3d" class="mm-link">3D Works</a>
  <a href="#contact" class="mm-link">Contact</a>
</div>

<!-- ░░ HERO ░░ -->
<section class="hero" id="home">
  <div class="hero-bg">
    <div class="hero-grain"></div>
    <div class="hero-orb hero-orb--1"></div>
    <div class="hero-orb hero-orb--2"></div>
  </div>
  <div class="hero-content">
    <p class="hero-eyebrow">Traditional · Digital · 3D</p>
    <h1 class="hero-title">
      <span class="line">Where Vision</span>
      <span class="line italic">Becomes Form</span>
    </h1>
    <p class="hero-sub">Multidisciplinary artist exploring the boundaries between the drawn line and the sculpted dimension.</p>
    <div class="hero-cta">
      <a href="#works-2d" class="btn btn--primary">View Works</a>
      <a href="#contact" class="btn btn--ghost">Get in Touch</a>
    </div>
  </div>
  <div class="hero-scroll">
    <span>Scroll</span>
    <div class="hero-scroll-line"></div>
  </div>
</section>

<!-- ░░ ABOUT ░░ -->
<section class="about section" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-left">
        <span class="section-label">About</span>
        <h2 class="section-title">Crafting stories<br><em>through every medium</em></h2>
      </div>
      <div class="about-right">
        <p class="about-text">I am a multidisciplinary artist bridging the worlds of traditional drawing, digital illustration, and three-dimensional creation. Each piece is a conversation between imagination and technique.</p>
        <p class="about-text">Whether it's the texture of graphite on paper, the infinite possibilities of a digital canvas, or the depth of a sculpted 3D environment — I believe every medium has its own language.</p>
        <div class="about-stats">
          <div class="stat">
            <span class="stat-num">2D</span>
            <span class="stat-label">Traditional &amp; Digital</span>
          </div>
          <div class="stat">
            <span class="stat-num">3D</span>
            <span class="stat-label">Modeling &amp; Render</span>
          </div>
          <div class="stat">
            <span class="stat-num">∞</span>
            <span class="stat-label">Creative Vision</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ░░ 2D WORKS ░░ -->
<section class="works-section section" id="works-2d">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Portfolio</span>
      <h2 class="section-title">2D Works</h2>
      <p class="section-desc">Traditional drawings, paintings, and digital illustrations</p>
    </div>

    <div class="gallery-filter">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="image">Illustrations</button>
      <button class="filter-btn" data-filter="video">Videos</button>
    </div>

    <div class="gallery" id="gallery2d">
      <?php if (empty($works2d)): ?>
        <div class="gallery-empty">
          <div class="gallery-empty-icon">🎨</div>
          <p>No works uploaded yet.</p>
          <a href="admin/upload.php" class="btn btn--primary btn--sm">Upload Works</a>
        </div>
      <?php else: ?>
        <?php foreach ($works2d as $w): ?>
          <div class="gallery-item" data-type="<?= $w['type'] ?>">
            <?php if ($w['type'] === 'video'): ?>
              <div class="gallery-media video-wrap">
                <video src="<?= htmlspecialchars($w['path']) ?>" loop muted preload="none"
                       data-src="<?= htmlspecialchars($w['path']) ?>"></video>
                <div class="gallery-overlay">
                  <span class="gallery-play">▶</span>
                  <span class="gallery-name"><?= htmlspecialchars($w['name']) ?></span>
                </div>
              </div>
            <?php else: ?>
              <div class="gallery-media" onclick="openLightbox('<?= htmlspecialchars($w['path']) ?>', '<?= htmlspecialchars($w['name']) ?>')">
                <img src="<?= htmlspecialchars($w['path']) ?>" alt="<?= htmlspecialchars($w['name']) ?>" loading="lazy" />
                <div class="gallery-overlay">
                  <span class="gallery-zoom">⤢</span>
                  <span class="gallery-name"><?= htmlspecialchars($w['name']) ?></span>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ░░ 3D WORKS ░░ -->
<section class="works-section works-section--3d section" id="works-3d">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Portfolio</span>
      <h2 class="section-title">3D Works</h2>
      <p class="section-desc">Modeling, sculpting, rendering, and animations</p>
    </div>

    <div class="gallery-filter">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="image">Renders</button>
      <button class="filter-btn" data-filter="video">Animations</button>
    </div>

    <div class="gallery" id="gallery3d">
      <?php if (empty($works3d)): ?>
        <div class="gallery-empty">
          <div class="gallery-empty-icon">🧊</div>
          <p>No works uploaded yet.</p>
          <a href="admin/upload.php" class="btn btn--primary btn--sm">Upload Works</a>
        </div>
      <?php else: ?>
        <?php foreach ($works3d as $w): ?>
          <div class="gallery-item" data-type="<?= $w['type'] ?>">
            <?php if ($w['type'] === 'video'): ?>
              <div class="gallery-media video-wrap">
                <video src="<?= htmlspecialchars($w['path']) ?>" loop muted preload="none"
                       data-src="<?= htmlspecialchars($w['path']) ?>"></video>
                <div class="gallery-overlay">
                  <span class="gallery-play">▶</span>
                  <span class="gallery-name"><?= htmlspecialchars($w['name']) ?></span>
                </div>
              </div>
            <?php else: ?>
              <div class="gallery-media" onclick="openLightbox('<?= htmlspecialchars($w['path']) ?>', '<?= htmlspecialchars($w['name']) ?>')">
                <img src="<?= htmlspecialchars($w['path']) ?>" alt="<?= htmlspecialchars($w['name']) ?>" loading="lazy" />
                <div class="gallery-overlay">
                  <span class="gallery-zoom">⤢</span>
                  <span class="gallery-name"><?= htmlspecialchars($w['name']) ?></span>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ░░ SERVICES ░░ -->
<section class="services section" id="services">
  <div class="container">
    <div class="section-header">
      <span class="section-label">What I Offer</span>
      <h2 class="section-title">Services</h2>
    </div>
    <div class="services-grid">
      <div class="service-card">
        <div class="service-icon">✏️</div>
        <h3>Illustration</h3>
        <p>Custom illustrations for editorial, publishing, branding, or personal projects — traditional or digital.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">🖌️</div>
        <h3>Digital Art</h3>
        <p>Concept art, character design, environment art, and digital painting for games, film, and media.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">🧊</div>
        <h3>3D Modeling</h3>
        <p>Product visualization, character modeling, architectural renders, and animated 3D sequences.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">🎬</div>
        <h3>Motion &amp; Animation</h3>
        <p>2D and 3D animated content for social media, advertising, and creative storytelling.</p>
      </div>
    </div>
  </div>
</section>

<!-- ░░ CONTACT ░░ -->
<section class="contact section" id="contact">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-left">
        <span class="section-label">Let's Work Together</span>
        <h2 class="section-title">Start a<br><em>Conversation</em></h2>
        <p class="contact-intro">Have a project in mind? I'd love to hear about it. Fill in the form or reach me directly.</p>
        <div class="contact-info">
          <a href="mailto:hello@yourname.com" class="contact-link">hello@yourname.com</a>
          <a href="https://instagram.com/yourhandle" target="_blank" class="contact-link">@yourhandle</a>
          <a href="https://behance.net/yourprofile" target="_blank" class="contact-link">Behance</a>
        </div>
      </div>
      <div class="contact-right">
        <form action="includes/send_mail.php" method="POST" class="contact-form" id="contactForm">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" placeholder="Your name" required />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="your@email.com" required />
            </div>
          </div>
          <div class="form-group">
            <label for="subject">Subject</label>
            <select id="subject" name="subject">
              <option value="">— Select a service —</option>
              <option value="illustration">Illustration</option>
              <option value="digital">Digital Art</option>
              <option value="3d">3D Modeling</option>
              <option value="animation">Motion & Animation</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Tell me about your project..." required></textarea>
          </div>
          <button type="submit" class="btn btn--primary btn--full">Send Message →</button>
          <div class="form-feedback" id="formFeedback"></div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ░░ FOOTER ░░ -->
<footer class="footer">
  <div class="container footer-inner">
    <span class="footer-logo">ARTISTÉ</span>
    <p class="footer-copy">© <?= date('Y') ?> All rights reserved.</p>
    <div class="footer-links">
      <a href="admin/upload.php">Admin</a>
    </div>
  </div>
</footer>

<!-- ░░ LIGHTBOX ░░ -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <button class="lightbox-close" onclick="closeLightbox()">✕</button>
  <div class="lightbox-inner" onclick="event.stopPropagation()">
    <img src="" alt="" id="lightboxImg" />
    <p class="lightbox-caption" id="lightboxCaption"></p>
  </div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
