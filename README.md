# Slatan Design - Modern WordPress Theme

A feature-rich, modern WordPress theme with advanced customization options, Page Builder support, and comprehensive plugin compatibility.

**Version**: 1.0.4  
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

### Page Builder Support
- ✅ **Elementor** (Free & Pro) - Full support with Theme Builder Pro
- ✅ **Beaver Builder** - Full support
- ✅ **Brizy** - Full support
- ✅ **Gutenberg** - Enhanced with custom styles & patterns
- ✅ Full-width page template
- ✅ Canvas (blank) page template
- ✅ Conditional asset loading for better performance

### Security Features
- ✅ Security Headers (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection)
- ✅ Login attempt limiting (brute force protection)
- ✅ XML-RPC disabled by default
- ✅ WordPress version hidden
- ✅ File editing disabled in admin

### Performance Optimizations
- ✅ Resource hints (preconnect, preload)
- ✅ Deferred JavaScript loading
- ✅ Lazy loading for images
- ✅ Query string removal from static resources
- ✅ Emoji scripts disabled (optional)
- ✅ WooCommerce script optimization

### Cookie Consent Banner
- ✅ GDPR compliant cookie consent
- ✅ Customizable text, colors, and layout
- ✅ Accept/Decline buttons
- ✅ Revoke button with Font Awesome icon support
- ✅ Conditional script loading based on consent
- ✅ No page refresh required

### Floating Contact Widget
- ✅ 4-corner positioning (Top/Bottom × Left/Right)
- ✅ **Unlimited contact channels** (Repeater field)
- ✅ Font Awesome or custom SVG icons
- ✅ Multiple animation styles (Pop, Slide, Fade)
- ✅ Customizable colors and spacing
- ✅ Tooltips support
- ✅ Mobile responsive

### Custom Code Injection
- ✅ Inject code in `<head>`, body start, or body end
- ✅ Custom CSS section with minify option
- ✅ Custom JavaScript section with defer option
- ✅ Granular cookie consent integration per section
- ✅ Priority control for each section

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

---

## ⚙️ Configuration

### Initial Setup

1. **Go to Customizer**
   - Dashboard → Appearance → Customize

2. **Configure Cookie Consent** (Optional)
   - Cookie Consent → General & Content
   - Enable the banner and customize text

3. **Configure Floating Contact** (Optional)
   - Floating Contact → General & Style
   - Floating Contact → Contact Channels (use Add Channel button)

4. **Configure Custom Code** (Optional)
   - Custom Code → Custom CSS / Custom JavaScript
   - Custom Code → Head Code / Body Start / Body End

5. **Select Page Template** (For Page Builders)
   - Edit any page → Page Attributes → Template
   - Choose: **Full Width** or **Canvas (Blank)**

---

## 🎨 Page Templates

| Template | Description |
|----------|-------------|
| **Full Width** | Header/footer included, 100% content width, no sidebar |
| **Canvas (Blank)** | No header/footer, complete blank canvas for page builders |

---

## 📝 Changelog

### Version 1.0.4 (2025-12-12)
- ✅ Added Dynamic Repeater for Floating Contact channels (unlimited channels)
- ✅ Added Security headers and login protection
- ✅ Added Performance optimizations (defer, lazy load, resource hints)
- ✅ Added Elementor Theme Builder Pro support
- ✅ Added Brizy page builder support
- ✅ Added Custom CSS/JS sections with minify/defer options
- ✅ Improved Page Builder compatibility
- ✅ Removed Code Snippets feature (use plugin instead for security)
- ✅ Fixed Customizer Code Editor back button issue

### Version 1.0.3
- ✅ Page Builder support improvements
- ✅ Block patterns and styles
- ✅ Editor styles

### Version 1.0.0 (2025-11-28)
- ✅ Initial release

---

## 🔒 Security

- ✅ All user inputs are sanitized
- ✅ All outputs are properly escaped
- ✅ `ABSPATH` check in all files
- ✅ SVG upload restricted to administrators with sanitization
- ✅ Custom code uses capability checks (`unfiltered_html`)
- ✅ Follows WordPress Coding Standards

---

## 🤝 Support

- **Issues**: [GitHub Issues](https://github.com/meennnwork-pixel/Slatan-Design-Theme/issues)
- **Website**: [https://slatan.co.th/](https://slatan.co.th/)

---

## 📄 License

This theme is licensed under the GPL v2 or later.

---

**Made with ❤️ by Slatan Design**
