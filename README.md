# Artist Portfolio - 2D & 3D Gallery

A modern, responsive portfolio website for digital artists showcasing 2D illustrations and 3D renders. Built with HTML, CSS, and JavaScript - ready for GitHub Pages deployment.

## 🎨 Features

- **Custom Cursor**: Elegant gold-accented cursor with follower effect
- **Page Loader**: Smooth loading animation
- **Responsive Design**: Works perfectly on mobile, tablet, and desktop
- **Gallery Filtering**: Filter artworks by 2D, 3D, or Video
- **Video Hover Playback**: Videos play automatically on hover
- **Lightbox Viewer**: Full-screen image/video viewer
- **Smooth Scrolling**: Navigation with smooth scroll effects
- **Dark Luxury Theme**: Professional black and gold color scheme

## 📁 Project Structure

```
artist-portfolio/
├── index.html              # Main HTML file
├── assets/
│   ├── css/
│   │   └── style.css      # All styling
│   └── js/
│       └── main.js        # Interactive functionality
├── uploads/
│   ├── 2d/                # Place your 2D artwork here
│   └── 3d/                # Place your 3D renders/videos here
└── README.md              # This file
```

## 🚀 Deployment to GitHub Pages

### Step 1: Prepare Your Repository

1. Create a new repository on GitHub (e.g., `artist-portfolio`)
2. Clone it to your local machine or push existing files:

```bash
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/artist-portfolio.git
git push -u origin main
```

### Step 2: Add Your Artwork

1. Place your 2D images in the `uploads/2d/` folder
2. Place your 3D renders and videos in the `uploads/3d/` folder
3. Update `index.html` to reference your actual files:

```html
<!-- Example: Replace placeholder paths with your actual files -->
<div class="gallery-item" data-category="2d">
    <img src="uploads/2d/your-artwork.jpg" alt="Your Artwork Title">
    <div class="overlay">
        <h3>Your Artwork Title</h3>
        <p>Description</p>
        <i class="fas fa-search-plus"></i>
    </div>
</div>
```

### Step 3: Enable GitHub Pages

1. Go to your repository on GitHub
2. Click **Settings** → **Pages** (in the left sidebar)
3. Under **Source**, select:
   - Branch: `main`
   - Folder: `/ (root)`
4. Click **Save**

Your site will be live at: `https://YOUR_USERNAME.github.io/artist-portfolio/`

## ✏️ Customization

### Update Contact Form

Since GitHub Pages is static, integrate a form service like [Formspree](https://formspree.io/):

1. Sign up at Formspree
2. Replace the form in `index.html`:

```html
<form class="contact-form" action="https://formspree.io/f/YOUR_FORM_ID" method="POST">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
    <button type="submit" class="btn">Send Message</button>
</form>
```

### Change Colors

Edit `assets/css/style.css` to customize the color scheme:

```css
:root {
    --bg-color: #0a0a0a;        /* Background */
    --text-color: #f0f0f0;      /* Text */
    --accent-color: #d4af37;    /* Gold accent - change this! */
    --secondary-bg: #151515;    /* Section backgrounds */
}
```

### Update Social Links

In `index.html`, replace `#` with your actual social media URLs:

```html
<div class="social-links">
    <a href="https://instagram.com/yourusername"><i class="fab fa-instagram"></i></a>
    <a href="https://artstation.com/yourusername"><i class="fab fa-artstation"></i></a>
    <a href="https://twitter.com/yourusername"><i class="fab fa-twitter"></i></a>
    <a href="https://linkedin.com/in/yourusername"><i class="fab fa-linkedin"></i></a>
</div>
```

## 📝 Adding More Gallery Items

Copy and paste this template in the gallery section of `index.html`:

```html
<!-- For 2D Art -->
<div class="gallery-item" data-category="2d">
    <img src="uploads/2d/your-image.jpg" alt="Artwork Title" loading="lazy">
    <div class="overlay">
        <h3>Artwork Title</h3>
        <p>Medium/Software Used</p>
        <i class="fas fa-search-plus"></i>
    </div>
</div>

<!-- For 3D Renders -->
<div class="gallery-item" data-category="3d">
    <img src="uploads/3d/your-render.jpg" alt="Render Title" loading="lazy">
    <div class="overlay">
        <h3>Render Title</h3>
        <p>Software Used (Blender/C4D/etc)</p>
        <i class="fas fa-search-plus"></i>
    </div>
</div>

<!-- For Videos -->
<div class="gallery-item video-item" data-category="video">
    <video src="uploads/3d/your-animation.mp4" muted loop playsinline></video>
    <div class="overlay">
        <h3>Animation Title</h3>
        <p>Motion Graphics</p>
        <i class="fas fa-play"></i>
    </div>
</div>
```

## 🛠️ Local Development

To preview locally:

1. Use a local server (required for some features):
   ```bash
   # If you have Python installed
   python -m http.server 8000
   
   # Or use Live Server extension in VS Code
   ```

2. Open `http://localhost:8000` in your browser

## 📄 License

This project is open source and available under the MIT License.

## 👤 Support

For issues or questions, please create an issue on the GitHub repository.

---

**Happy Creating! 🎨✨**