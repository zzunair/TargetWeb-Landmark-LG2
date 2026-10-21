=== TargetWeb - Landmark ===
Author: TargetWeb
Author URI: https://www.idealcomputersystems.com/targetweb
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
License: GPLv2 or later

A standalone WordPress theme for outdoor power equipment dealers, built to
match the Greenline Power Equipment landing page design 1:1 — no parent
theme, no page builder, no plugin dependency.

Every piece of repeatable content (equipment categories, services, why-
choose-us tiles, testimonials, FAQs) is managed as add/remove/reorder rows
directly inside Appearance > Customize — the same mental model as Shopify's
or Wix's theme editor. There are no separate "Equipment Categories" or
"Testimonials" admin screens to hunt through; everything lives in one place.

== Installation ==
1. Go to Appearance > Themes > Add New > Upload Theme in wp-admin and upload
   greenline-power-theme.zip. Activate it. On activation the theme
   automatically: sets the homepage, creates About Us / Careers / Community
   / Blog pages, adds 3 sample blog posts, and creates + assigns the
   Primary Menu and all 3 footer menus. The site is fully browsable
   immediately — nothing to import by hand.
2. Go to Appearance > Menus and create a "Primary Menu" (assign it to the
   Primary Menu location). Optionally create Footer Shop / Footer Services /
   Footer Company menus for the footer columns.
3. Go to Appearance > Customize > ⚙ TargetWeb - Landmark Theme Options. This single
   panel contains every editable piece of the site:
     - Colors — 9 color pickers controlling the entire palette
     - Header, Hero, Trust Bar, Section Titles
     - 🧩 Equipment Categories — add/remove/reorder category cards, each
       with a name, photo, badge (Best Seller / New / Seasonal), and link
     - 🧩 Services ("What We Do") — add/remove/reorder cards, each with a
       title, description, icon picker, and link
     - 🧩 Why Choose Us Tiles — add/remove/reorder feature tiles
     - Financing CTA, Service & Repair Band
     - 🧩 Testimonials — add/remove/reorder, each with name, role, star
       rating, quote, and photo
     - 🧩 FAQs — add/remove/reorder question/answer pairs
     - Contact Info, Showroom, Footer
   Click any row to expand it, use the ↑ / ↓ buttons to reorder, and the
   trash icon to remove it. Nothing here requires touching code.
4. Add real photos: click "Upload" on any Photo field (hero, categories,
   testimonials, service & repair, showroom) inside the Customizer — it
   opens the normal WordPress media library. Until you do, each image slot
   shows a clean placeholder rather than shipping stock photography you
   don't have rights to.
5. (Optional) Set your site logo under Customize > Site Identity, and set
   the small tagline text there too.
6. If you ever want to start over, go to Appearance > TargetWeb - Landmark Setup and
   click "Reset Content Blocks" to restore the original demo rows.

== What's included ==
- Full Customizer panel ("⚙ TargetWeb - Landmark Theme Options") covering colors,
  header, hero, trust bar, section titles, financing CTA, service & repair
  band, contact info, showroom, and footer.
- ↕ Homepage Section Order — reorder or hide any of the 11 homepage
  sections from the Customizer, no code required.
- A custom repeater control (inc/class-repeater-control.php) powering 5
  add/remove/reorder content blocks — Equipment Categories, Services, Why
  Choose Us Tiles, Testimonials, FAQs — each with image upload and an
  icon picker (including a "None" option and a custom-icon-image override).
  No ACF, no page builder, no custom post types to manage separately.
- Original demo artwork (assets/images/) — 9 flat-illustration category
  cards, a hero yard scene, a service/repair illustration, and a storefront
  illustration, all hand-built SVG so nothing is licensed stock photography.
  Every image field defaults to this artwork and can be replaced with a
  real photo at any time via the Customizer's normal media uploader.
- On activation, the theme automatically creates: the homepage, 4 pages
  (About Us, Careers, Community, Blog), 3 sample blog posts, and a Primary
  Menu plus 3 footer menus (Shop / Services / Company) — all wired to real
  URLs. Re-run any of this anytime from Appearance > TargetWeb - Landmark Setup.
- A working "Get My Free Quote" form that emails the address set in
  Customize > Contact Info (or falls back to your WP admin email).
- Fully responsive layout, mobile nav, animated FAQ accordion, and an
  auto-advancing testimonial slider — all in vanilla JS, no jQuery.

== Notes ==
- Color palette (editable in Customizer > Colors): cream background,
  deep forest green, bright green accent, signal orange, near-black
  header/footer — matching the source design.
- No dependency on any other theme: this is a full standalone theme,
  not a child theme.
