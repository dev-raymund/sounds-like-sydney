# Sounds Like Sydney 2026

A modern editorial / news-magazine WordPress theme. Built as a **classic
PHP-template theme** and deliberately structured so **Advanced Custom Fields
(ACF)** can be layered in later without refactoring. The homepage reproduces a
magazine grid: hero, editor's choice, recent posts with a sidebar, a dark video
section, latest posts and trending articles.

- **Works with zero ACF installed** — every section self-populates from core
  queries and native fields.
- **ACF-ready** — Local JSON, an Options page, and auto-registered ACF Blocks
  are all wired up and guarded behind `function_exists()`, so activating ACF
  progressively "lights up" editable controls.

Requires WordPress 6.0+ and PHP 7.4+ (tested on WP 7.0 / PHP 8.5).

---

## File hierarchy

```
soundslikesydney2026/
├── style.css                  Theme header + fallback design tokens
├── functions.php              Thin bootstrap → requires inc/*
├── index.php                  Universal fallback template
├── front-page.php             Homepage (composes homepage/* parts; ACF Flexible Content aware)
├── home.php                   Blog posts index (+ sidebar)
├── single.php                 Single post
├── page.php                   Single page
├── archive.php                Category / tag / taxonomy / date / CPT archives
├── search.php                 Search results
├── 404.php                    Not found
├── header.php                 <head> + header shell
├── footer.php                 Footer shell
├── sidebar.php                Primary sidebar (widgets)
├── comments.php               Comments + comment form
├── searchform.php             Custom search form markup
├── screenshot.png             Theme thumbnail (add your own 1200×900)
├── README.md                  This file
├── .gitignore
│
├── acf-json/                  ◀ ACF LOCAL JSON — field groups auto-save here
│   ├── README.md              How Local JSON works (sync workflow)
│   └── group_article_meta.json  Example field group (deck, featured, media type…)
│
├── languages/
│   └── soundslikesydney2026.pot   Translation template
│
├── assets/
│   ├── css/
│   │   ├── main.css           Front-end styles (the real design)
│   │   └── editor.css         Block-editor styles (keeps ACF blocks WYSIWYG)
│   └── js/
│       ├── navigation.js      Mobile menu + search toggle
│       └── main.js            Progressive enhancements
│
├── inc/                       ◀ ALL PHP LOGIC lives here (functions.php only loads these)
│   ├── setup.php              Theme supports, menus, image sizes, content width
│   ├── enqueue.php            Styles & scripts (front-end + editor)
│   ├── template-tags.php      Output helpers: byline, meta, kicker, thumbnail…
│   ├── template-functions.php Body classes, excerpt, menu fallback
│   ├── widgets.php            Sidebar + 4 footer widget areas
│   ├── custom-post-types.php  Podcast + Video CPTs, Format taxonomy
│   └── acf.php                ◀ ACF INTEGRATION: Local JSON, Options pages, Blocks, helpers
│
└── template-parts/           ◀ Reusable, ACF-friendly partials
    ├── header/
    │   ├── top-bar.php        Social + top-bar menu
    │   ├── site-branding.php  Logo / wordmark + search toggle
    │   ├── navigation.php     Primary menu
    │   └── trending-bar.php   "Trending" ticker (ACF-curatable)
    ├── footer/
    │   ├── footer-widgets.php Brand + widget columns + newsletter
    │   └── footer-bottom.php  Copyright + footer/social menus
    ├── homepage/             One file per homepage section
    │   ├── hero.php
    │   ├── editors-choice.php
    │   ├── ad-banner.php
    │   ├── recent-posts.php
    │   ├── recent-video.php
    │   ├── latest-posts.php
    │   └── trending-articles.php
    ├── content/              Loop items + shared card variants
    │   ├── content.php            Default archive/index item
    │   ├── content-card.php       Horizontal card (Recent Posts)
    │   ├── content-single.php     Single post body
    │   ├── content-page.php       Page body
    │   ├── content-none.php       Empty-state
    │   ├── card-overlay.php       Image w/ overlaid headline (hero/feature)
    │   ├── card-stacked.php       Image over title (grid cards)
    │   └── card-mini.php          Thumb + headline (lists / playlists)
    └── blocks/               ◀ ACF BLOCKS (auto-registered from block.json)
        └── featured-grid/
            ├── block.json    Block manifest (category: "Sounds Like Sydney")
            └── render.php     Server render callback
```

---

## How ACF integration works

Everything below is inert until the ACF (or ACF Pro) plugin is active — see
[`inc/acf.php`](inc/acf.php).

### 1. Null-safe field access
Templates never call `get_field()` directly. They use wrappers that return a
fallback when ACF is absent, so the theme can't fatal:

```php
$deck = sls2026_field( 'deck' );                 // current post
$tag  = sls2026_option( 'topbar_text' );         // options page
```

### 2. Local JSON (`acf-json/`)
`inc/acf.php` sets this folder as ACF's **save** and **load** point. Create or
edit a field group in the admin and ACF writes `group_XXXX.json` here — commit
it and the field definitions travel with the theme. A starter group,
`group_article_meta.json`, is included; delete it once you build your own.

### 3. Options pages (ACF Pro)
A **Theme Settings** menu with **Header**, **Footer** and **Homepage** sub-pages
is registered. Suggested fields (read by the templates already):

| Field name | Used in |
| --- | --- |
| `topbar_text` | header top bar |
| `trending_posts` | trending ticker |
| `hero_posts` | homepage hero |
| `editors_choice` | Editor's Choice section |
| `ad_banner_html` | homepage ad strip |
| `homepage_sections` | Flexible Content — reorder/toggle homepage sections |
| `newsletter_title` / `newsletter_text` / `newsletter_embed` | footer |
| `footer_about` / `footer_copyright` | footer |

Create these as an ACF **Options** location field group; the templates pick
them up automatically.

### 4. ACF Blocks (ACF Pro)
Any folder under `template-parts/blocks/<name>/` containing a `block.json` is
auto-registered. `featured-grid` is a working example — bind a field group to
block type `sls2026/featured-grid` (fields `heading`, `posts`) and it renders
the magazine card layout. Add more blocks by copying the folder.

### 5. Flexible homepage
`front-page.php` checks for an ACF Flexible Content field `homepage_sections`
(on the options page). If present, editors control section order/visibility;
otherwise the default order renders. Layout names map 1:1 to the files in
`template-parts/homepage/`.

---

## Setup

1. Copy this folder to `wp-content/themes/soundslikesydney2026/` (already here).
2. **Appearance → Themes → Activate** "Sounds Like Sydney 2026".
3. **Appearance → Menus**: assign menus to *Primary*, *Top Bar*, *Footer*,
   *Social Links*.
4. **Settings → Reading**: set a static homepage to use `front-page.php`, and a
   Posts page for the blog index.
5. **Appearance → Widgets**: fill *Primary Sidebar* and *Footer Columns 1–4*.
6. *(Optional)* Install **Advanced Custom Fields**. The admin dashboard shows a
   reminder; once active, *Custom Fields → Field Groups* will offer to **Sync**
   the bundled Local JSON.

## Conventions

- **Prefix:** functions `sls2026_`, constants `SLS2026_`, CSS classes `sls-`,
  text domain `soundslikesydney2026`.
- **Escaping:** all output is escaped at the point of output.
- **No build step required.** Add a bundler later if you want; enqueue handles
  are already in place.

---

_Homepage layout inspired by a standard news-magazine grid. All code is original
and GPL-2.0-or-later; replace the sample content, colours and logo with your own._
