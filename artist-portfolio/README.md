# 🎨 Artist Portfolio — Setup Guide

A professional 2D + 3D artist portfolio powered by PHP.  
**Laragon-ready** — no build tools, no Node.js, pure PHP + HTML/CSS/JS.

---

## ⚡ Quick Start (Laragon)

1. **Copy the folder** into your Laragon `www/` directory:
   ```
   C:\laragon\www\artist-portfolio\
   ```

2. **Start Laragon** (Apache + PHP — no MySQL needed for basic use).

3. Open in browser:
   ```
   http://artist-portfolio.test/
   ```
   *(Laragon auto-creates `.test` virtual hosts)*

4. **Upload your works** at:
   ```
   http://artist-portfolio.test/admin/upload.php
   ```

---

## 🔐 Admin Panel

**Default password:** `artist2024`

**Change it** in `admin/upload.php` line 3:
```php
define('ADMIN_PASSWORD', 'your-new-password');
```

---

## 📁 Project Structure

```
artist-portfolio/
├── index.php               ← Main portfolio page
├── .htaccess               ← Apache config
│
├── admin/
│   └── upload.php          ← Admin: upload & manage files
│
├── assets/
│   ├── css/style.css       ← All styles
│   └── js/main.js          ← All scripts
│
├── includes/
│   └── send_mail.php       ← Contact form mail handler
│
└── uploads/
    ├── 2d/                 ← Your 2D works go here
    └── 3d/                 ← Your 3D works go here
```

---

## ✉️ Contact Form

Edit `includes/send_mail.php` line 4:
```php
define('RECIPIENT', 'your@email.com');
```

For Laragon (local), mail() won't send real emails.  
To test in production, make sure PHP `mail()` is configured, or swap for **PHPMailer + SMTP**.

---

## 🎨 Customization

| What                 | Where                           |
|----------------------|---------------------------------|
| Your name / brand    | `index.php` → search "ARTISTÉ"  |
| Email & social links | `index.php` → `#contact` section|
| Colors / fonts       | `assets/css/style.css` `:root`  |
| Admin password       | `admin/upload.php` line 3       |
| Recipient email      | `includes/send_mail.php` line 4 |

---

## 📸 Supported File Types

| Category | Formats                          | Max Size |
|----------|----------------------------------|----------|
| Images   | JPG, JPEG, PNG, GIF, WEBP        | 200 MB   |
| Video    | MP4, WEBM, MOV                   | 200 MB   |

---

## 🌐 Going Live

1. Upload files to your hosting (shared host, VPS, etc.)
2. Point your domain to the folder
3. Ensure PHP 7.4+ is installed
4. Update `RECIPIENT` email in `includes/send_mail.php`
5. Done!

---

Made with ❤️ for artists who create in every dimension.
