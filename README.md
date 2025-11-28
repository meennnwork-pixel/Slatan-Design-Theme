# Slatan Design - WordPress Theme

A modern, feature-rich WordPress theme with advanced customization options including Cookie Consent, Floating Contact Widget, and Custom Code injection.

**Version**: 1.0.0  
**Author**: Slatan Design  
**License**: GPL v2 or later  
**Requires WordPress**: 5.0+  
**Requires PHP**: 5.6+

---

## 🌟 Features

### Core Features
- ✅ Fully responsive design
- ✅ Customizer-based settings (no admin pages)
- ✅ Translation ready
- ✅ WooCommerce compatible
- ✅ Gutenberg support
- ✅ Custom logo support
- ✅ SVG upload support (admin only)

### Cookie Consent Banner
- ✅ GDPR compliant cookie consent banner
- ✅ Customizable text, colors, and layout
- ✅ Accept/Decline buttons
- ✅ Revoke button with **Font Awesome icon support** 🆕
- ✅ Conditional script loading based on consent
- ✅ No page refresh required
- ✅ localStorage for user preferences

### Floating Contact Widget
- ✅ **4-corner positioning** (Top Left, Top Right, Bottom Left, Bottom Right) 🆕
- ✅ Up to 9 customizable contact channels
- ✅ Font Awesome or custom SVG icons
- ✅ Multiple animation styles (Pop, Slide, Fade)
- ✅ Customizable colors and spacing
- ✅ Tooltips support
- ✅ Mobile responsive

### Custom Code Injection
- ✅ Inject code in `<head>`, body start, or body end
- ✅ **Granular cookie consent integration** per section
- ✅ Priority control for each section
- ✅ Code editor with syntax highlighting
- ✅ Support for tracking scripts, analytics, pixels

### GitHub Auto-Updater
- ✅ Automatic theme updates from GitHub releases
- ✅ Easy configuration

---

## 📦 Installation

### Method 1: WordPress Admin
1. Download the theme ZIP file
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
   - Cookie Consent → Revoke Button Settings
     - Enable Font Awesome icon (default: `fas fa-cookie-bite`)
     - Or upload custom SVG icon

3. **Configure Floating Contact** (Optional)
   - Floating Contact → General & Style
     - Enable the widget
     - Choose position: **Top Left, Top Right, Bottom Left, or Bottom Right** 🆕
     - Customize colors and icons
   - Floating Contact → Contact Channels
     - Add up to 9 contact channels (WhatsApp, Facebook, Line, etc.)

4. **Configure Custom Code** (Optional)
   - Custom Code → Head Code / Body Start / Body End
     - Add tracking scripts, analytics, or custom code
     - Enable "Require Cookie Consent" checkbox if needed

---

## 🎨 Customizer Options

### Cookie Consent Panel
- **General & Content**: Banner text, buttons, policy link
- **Layout & Spacing**: Position, padding, border radius
- **Color Settings**: All colors for banner and buttons
- **Revoke Button Settings**: Icon (Font Awesome or SVG), position, colors 🆕

### Floating Contact Panel
- **General & Style**: Enable, position (4 corners 🆕), colors, icons, animations
- **Contact Channels**: 9 customizable channel slots

### Custom Code Panel
- **Head Code**: Code before `</head>` + priority + consent checkbox
- **Body Start Code**: Code after `<body>` + priority + consent checkbox
- **Body End Code**: Code before `</body>` + priority + consent checkbox

---

## 🆕 What's New in This Version

### 1. Floating Contact - 4 Corner Positioning
- Added **Top Left** and **Top Right** position options
- Separate horizontal and vertical offset controls
- Dynamic CSS generation for all 4 corners

### 2. Cookie Consent Revoke Button - Font Awesome Support
- Added Font Awesome class input field
- Default icon: `fas fa-cookie-bite`
- Icon priority: Custom Icon → Font Awesome → Default SVG
- Supports 4 corner positioning

### 3. Custom Code - Cookie Consent Integration
- Granular consent control per section (Head, Body Start, Body End)
- Each section has its own "Require Cookie Consent" checkbox
- Scripts only load when consent is accepted

---

## 🔧 Advanced Configuration

### GitHub Auto-Updater

Edit `functions.php` (lines 157-159):

```php
$updater = new Slatan_Theme_Updater(
    'your-github-username',  // Replace with your GitHub username
    'your-repo-name',        // Replace with your repository name
    'slatan-design'          // Theme slug (don't change)
);
```

### Google Analytics Integration

Edit `inc/frontend/cookie-consent-frontend.php` (line 201):

```php
// Replace 'YOUR-GA-ID-HERE' with your actual GA tracking ID
gtag('config', 'YOUR-GA-ID-HERE');
```

---

## 🎯 Usage Examples

### Example 1: Floating Contact with WhatsApp

1. Go to **Customizer → Floating Contact → General & Style**
2. Enable Floating Contact
3. Choose position: **Bottom Right**
4. Go to **Contact Channels**
5. Enable Channel 1:
   - Link: `https://wa.me/66812345678`
   - Label: `WhatsApp`
   - Font Awesome Class: `fab fa-whatsapp`
   - Background Color: `#25D366`

### Example 2: Cookie Consent with Custom Revoke Icon

1. Go to **Customizer → Cookie Consent → Revoke Button Settings**
2. Enable Revoke Button
3. Font Awesome Class: `fas fa-cog` (or any FA icon)
4. Position: **Bottom Left**
5. Customize colors as needed

### Example 3: Custom Code with Consent

1. Go to **Customizer → Custom Code → Head Code**
2. Add your tracking script (e.g., Facebook Pixel)
3. Check **"Require Cookie Consent"**
4. Set priority: `999`
5. Script will only load when user accepts cookies

---

## 🛠️ Development

### File Structure

```
slatan-design/
├── css/
│   ├── admin-customizer.css
│   ├── cookie-consent.css
│   └── floating-contact.css
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
│   └── updater/
│       └── class-theme-updater.php
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

---

## 🔒 Security

- ✅ All user inputs are sanitized
- ✅ All outputs are escaped
- ✅ `ABSPATH` check in all files
- ✅ SVG upload restricted to administrators
- ✅ Custom code requires `unfiltered_html` capability
- ✅ Cookie consent integration for tracking scripts

---

## 🌐 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## 📝 Changelog

### Version 1.0.0
- Initial release
- Cookie Consent Banner with GDPR compliance
- Floating Contact Widget with 4-corner positioning
- Custom Code Injection with cookie consent integration
- Font Awesome support for Revoke Button
- GitHub Auto-Updater

---

## 🤝 Support

For support, please contact:
- Website: [https://slatan.co.th/](https://slatan.co.th/)
- Email: support@slatan.co.th

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
