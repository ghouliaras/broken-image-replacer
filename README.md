<h1 align="center">Broken Image Replacer</h1>

<p align="center">
  Automatically replaces broken images with a clean placeholder — so your site never shows a broken-image icon again.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/version-1.0.0-2563EB?style=flat-square" alt="Version 1.0.0" />
  <img src="https://img.shields.io/badge/WordPress-5.4%2B-1E293B?style=flat-square&logo=wordpress&logoColor=white" alt="WordPress 5.4+" />
  <img src="https://img.shields.io/badge/tested%20up%20to-6.6-1E293B?style=flat-square" alt="Tested up to WordPress 6.6" />
  <img src="https://img.shields.io/badge/PHP-7.2%2B-1E293B?style=flat-square&logo=php&logoColor=white" alt="PHP 7.2+" />
  <img src="https://img.shields.io/badge/license-GPL--2.0--or--later-1E293B?style=flat-square" alt="License GPL-2.0-or-later" />
</p>

---

## Why

Deleted media, expired hotlinks or a failed migration leave ugly broken-image icons all over a site. **Broken Image Replacer** catches those failures in the browser and swaps in a placeholder of your choice — instantly, without touching your content or database.

## Features

- **Automatic detection** — listens for image load errors and replaces the broken source with your placeholder
- **No infinite loops** — clears `srcset` / `sizes` on replaced images so the browser doesn't retry the broken files
- **Works with dynamic content** — images added later (AJAX, infinite scroll, sliders) are covered via `MutationObserver`
- **Choose your placeholder** from the Media Library, or keep the bundled lightweight SVG
- **Opt-out per image** with a single attribute
- **Optional admin coverage** — apply the same behaviour inside the WordPress dashboard
- **Lightweight** — one small vanilla-JS file, no jQuery on the front end, no database writes on page load
- **Clean uninstall** — removes its settings when you delete the plugin

## Requirements

| | |
| --- | --- |
| WordPress | 5.4 or higher (tested up to 6.6) |
| PHP | 7.2 or higher |

## Installation

**From a ZIP**
1. Download this repository as a ZIP (**Code → Download ZIP**).
2. In WordPress go to **Plugins → Add New → Upload Plugin**, choose the ZIP and click **Install Now**.
3. Activate **Broken Image Replacer**.

**Manually / with Git**
```bash
cd wp-content/plugins
git clone https://github.com/ghouliaras/broken-image-replacer.git
```
Then activate it from **Plugins**.

## Usage

1. Go to **Settings → Broken Image Replacer**.
2. Pick a placeholder image from the Media Library (or keep the default).
3. Optionally enable it for the admin area too.
4. Save — that's it. Broken images are now replaced automatically.

### Excluding an image

Add `data-bir-ignore="1"` to any `<img>` you never want replaced:

```html
<img src="/path/to/image.jpg" alt="" data-bir-ignore="1">
```

## FAQ

**Does it fix the broken files?**
No — it hides the symptom for visitors by showing a placeholder. The original URLs stay in your content, so you can still find and fix them.

**Will it slow my site down?**
No. It loads a single small script and does nothing until an image actually fails to load.

## Changelog

**1.0.0** — Initial release.

## License

GPL-2.0-or-later — see [LICENSE](LICENSE).

---

<p align="center">
  Built by <a href="https://github.com/ghouliaras"><b>George Chouliaras</b></a> · WordPress, WooCommerce &amp; Laravel developer ·
  <a href="https://www.flowcreations.gr/contact/">Available for projects</a>
</p>
