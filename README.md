# Slatan Design - Modern WordPress Theme

A feature-rich, modern WordPress theme with advanced customization options, Page Builder support, and comprehensive plugin compatibility.

**Version**: 1.0.0  
**Author**: Slatan Design  
**License**: GPL v2 or later  
**Requires WordPress**: 5.0+  
**Requires PHP**: 5.6+  
**GitHub**: [meennnwork-pixel/Slatan-Design-Theme](https://github.com/meennnwork-pixel/Slatan-Design-Theme)

---

## 🌟 Features

### Core Features
- ✅ Fully responsive design
- ✅ Customizer-based settings (no admin pages)
- ✅ Translation ready (WPML, Polylang compatible)
- ✅ WooCommerce compatible
- ✅ Gutenberg support with custom blocks
- ✅ Custom logo & header support
- ✅ Custom background support
- ✅ SVG upload support (admin only)
- ✅ GitHub auto-updater

### Page Builder Support 🆕
- ✅ **Elementor** (Free & Pro) - Full support
- ✅ **Beaver Builder** - Full support
- ✅ **Gutenberg** - Enhanced with custom styles & patterns
- ✅ Full-width page template
- ✅ Canvas (blank) page template
- ✅ No theme conflicts

### WordPress Features 🆕
- ✅ Custom Header support
- ✅ Custom Background support
- ✅ Editor Styles (WYSIWYG)
- ✅ Block Styles (4 custom styles)
- ✅ Block Patterns (2 ready-to-use patterns)
- ✅ Color Palette (6 theme colors)

### Cookie Consent Banner
- ✅ GDPR compliant cookie consent
- ✅ Customizable text, colors, and layout
- ✅ Accept/Decline buttons
- ✅ Revoke button with Font Awesome icon support
- ✅ Conditional script loading based on consent
- ✅ No page refresh required
- ✅ localStorage for user preferences

### Floating Contact Widget
- ✅ 4-corner positioning (Top/Bottom × Left/Right)
- ✅ Up to 9 customizable contact channels
- ✅ Font Awesome or custom SVG icons
- ✅ Multiple animation styles (Pop, Slide, Fade)
- ✅ Customizable colors and spacing
- ✅ Tooltips support
- ✅ Mobile responsive

### Custom Code Injection
- ✅ Inject code in `<head>`, body start, or body end
- ✅ Granular cookie consent integration per section
- ✅ Priority control for each section
- ✅ Proper output escaping (WordPress standards)
- ✅ Support for tracking scripts, analytics, pixels

### Plugin Compatibility
- ✅ **SEO**: Yoast SEO, Rank Math, All in One SEO
- ✅ **Performance**: WP Rocket, W3 Total Cache, Autoptimize
- ✅ **Forms**: Contact Form 7, WPForms, Gravity Forms
- ✅ **Security**: Wordfence, Sucuri, iThemes Security
- ✅ **Translation**: WPML, Polylang, TranslatePress
- ✅ **Backup**: UpdraftPlus, BackWPup, Duplicator

---

## 📦 Installation

### Method 1: WordPress Admin
1. Download the theme ZIP file from [GitHub Releases](https://github.com/meennnwork-pixel/Slatan-Design-Theme/releases)
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Choose the ZIP file and click **Install Now**
4. Click **Activate**

### Method 2: FTP
1. Extract the ZIP file
2. Upload the `slatan-design` folder to `/wp-content/themes/`
3. Go to **Appearance → Themes** and activate **Slatan Design**

### Method 3: Git Clone
```bash
cd wp-content/themes/
git clone https://github.com/meennnwork-pixel/Slatan-Design-Theme.git slatan-design
```

---

## ⚙️ Configuration

### Initial Setup

1. **Go to Customizer**
   - Dashboard → Appearance → Customize

2. **Configure Cookie Consent** (Optional)
   - Cookie Consent → General & Content
   - Enable the banner and customize text
   - Cookie Consent → Revoke Button Settings
     - Enable Font Awesome icon (default: `fas fa-cookie-bite`)
     - Or upload custom SVG icon

3. **Configure Floating Contact** (Optional)
   - Floating Contact → General & Style
     - Enable the widget
     - Choose position: Top Left, Top Right, Bottom Left, or Bottom Right
     - Customize colors and icons
   - Floating Contact → Contact Channels
     - Add up to 9 contact channels (WhatsApp, Facebook, Line, etc.)

4. **Configure Custom Code** (Optional)
   - Custom Code → Head Code / Body Start / Body End
     - Add tracking scripts, analytics, or custom code
     - Enable "Require Cookie Consent" checkbox if needed

5. **Select Page Template** (For Page Builders)
   - Edit any page → Page Attributes → Template
   - Choose: **Full Width** or **Canvas (Blank)**

---

## 🎨 Page Templates

### Full Width Template
- Header and footer included
- 100% content width
- No sidebar
- Perfect for: Landing pages, Portfolio, Services

### Canvas (Blank) Template
- No header or footer
- Complete blank canvas
- Perfect for: Landing pages, Coming soon, Maintenance mode
- Full control with Page Builders

---

## 🎯 Usage Examples

### Example 1: Elementor Landing Page

1. Create a new page
2. Page Attributes → Template: **Canvas (Blank)**
3. Click **Edit with Elementor**
4. Design your landing page
5. Publish

### Example 2: Floating Contact with WhatsApp

1. Go to **Customizer → Floating Contact → General & Style**
2. Enable Floating Contact
3. Choose position: **Bottom Right**
4. Go to **Contact Channels**
5. Enable Channel 1:
   - Link: `https://wa.me/66812345678`
   - Label: `WhatsApp`
   - Font Awesome Class: `fab fa-whatsapp`
   - Background Color: `#25D366`

### Example 3: Custom Code with Consent

1. Go to **Customizer → Custom Code → Head Code**
2. Add your tracking script (e.g., Facebook Pixel)
3. Check **"Require Cookie Consent"**
4. Set priority: `999`
5. Script will only load when user accepts cookies

---

## 🔧 Advanced Configuration

### GitHub Auto-Updater

The theme is already configured to receive updates from GitHub:

```php
// In functions.php (lines 164-168)
$updater = new Slatan_Theme_Updater(
    'meennnwork-pixel',      // GitHub Username
    'Slatan-Design-Theme',   // Repository Name
    'slatan-design'          // Theme Slug
);
```

When a new release is published on GitHub, WordPress will automatically notify you in **Dashboard → Updates**.

---

## 🛠️ Development

### File Structure

```
slatan-design/
├── css/
│   ├── admin-customizer.css
│   ├── cookie-consent.css
│   ├── floating-contact.css
│   ├── editor-style.css          🆕
│   └── page-builder.css          🆕
├── js/
│   ├── cookie-consent.js
│   └── cookie-consent-reset.js
├── inc/
│   ├── customizer/
│   │   ├── cookie-consent-options.php
│   │   ├── custom-code-options.php
│   │   └── floating-contact-options.php
│   ├── frontend/
│   │   ├── cookie-consent-frontend.php
│   │   ├── custom-code-frontend.php
│   │   └── floating-contact-frontend.php
│   ├── updater/
│   │   └── class-theme-updater.php
│   ├── theme-support.php         🆕
│   └── page-builder-support.php  🆕
├── page-templates/                🆕
│   ├── template-fullwidth.php
│   └── template-canvas.php
├── template-parts/
│   ├── content.php
│   ├── content-none.php
│   ├── content-page.php
│   └── content-search.php
├── functions.php
├── header.php
├── footer.php
├── index.php
├── single.php
├── page.php
├── archive.php
├── search.php
├── 404.php
└── style.css
```

### Key Functions

- `slatan_design_setup()` - Theme setup
- `slatan_display_cookie_consent_banner()` - Cookie consent HTML
- `slatan_display_floating_contact()` - Floating contact HTML
- `slatan_should_render_custom_code()` - Check consent for custom code
- `slatan_design_register_block_styles()` - Register custom block styles
- `slatan_design_register_block_patterns()` - Register block patterns

---

## 🔒 Security

- ✅ All user inputs are sanitized
- ✅ All outputs are properly escaped using `wp_kses()`
- ✅ `ABSPATH` check in all files
- ✅ SVG upload restricted to administrators
- ✅ Custom code uses `wp_kses()` with allowed tags
- ✅ Cookie consent integration for tracking scripts
- ✅ Follows WordPress Coding Standards

---

## 🌐 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## 📝 Changelog

### Version 1.0.0 (2025-11-28)
- ✅ Initial release
- ✅ Cookie Consent Banner with GDPR compliance
- ✅ Floating Contact Widget with 4-corner positioning
- ✅ Custom Code Injection with proper escaping
- ✅ Font Awesome support for Revoke Button
- ✅ GitHub Auto-Updater
- ✅ Page Builder support (Elementor, Beaver Builder, Gutenberg)
- ✅ Custom Header & Background support
- ✅ Editor Styles
- ✅ Block Styles (4 custom styles)
- ✅ Block Patterns (2 patterns)
- ✅ Full-width & Canvas page templates
- ✅ Comprehensive plugin compatibility

---

## 🤝 Support

For support, please:
- **Issues**: [GitHub Issues](https://github.com/meennnwork-pixel/Slatan-Design-Theme/issues)
- **Website**: [https://slatan.co.th/](https://slatan.co.th/)
- **Email**: support@slatan.co.th

---

## 📄 License

This theme is licensed under the GPL v2 or later.

```
Copyright (C) 2025 Slatan Design

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

---

## 🙏 Credits

- Based on [Underscores](https://underscores.me/) starter theme
- Font Awesome icons by [Font Awesome](https://fontawesome.com/)
- Normalize.css by [Nicolas Gallagher](https://necolas.github.io/normalize.css/)

---

**Made with ❤️ by Slatan Design**
