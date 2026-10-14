# עמיחי מרקס – WordPress

Hebrew RTL site for family-economics consultant Amichai Marx. Custom theme `amichai-marx`, Docker Compose (WordPress + MySQL 8 + WP-CLI), and a seed that keeps the live slugs worth keeping.

Indexing follows one switch, WordPress's `blog_public` option (Settings → Reading). The seed turns it off on every host except `amichai-marx.co.il` and never turns it on. Go-live steps: [LAUNCH.md](LAUNCH.md).

## Local preview

```bash
cd amichai-marx-wp
cp .env.example .env
docker compose up -d
docker compose --profile seed run --rm wpcli
```

Open http://localhost:8080

Local admin (change it): user `admin`, password `amichai-local-change-me`.

The seed is idempotent. Run the `wpcli` command again after content edits. Each run rebuilds the primary menu (service items and submenus) and overwrites page and post bodies from `content/`, including the privacy policy. A staging deploy needs that one seed run; until then the theme fallback shows the same links and WordPress still serves the previous page body.

## What you should see

- `lang="he-IL"` and `dir="rtl"`
- White header, logo עמיחי מרקס, phone 054-2372417
- Hero: Amichai's real headshot (from the live site), headline ייעוץ לכלכלת המשפחה ומשכנתאות, בליווי צמוד, green לתיאום שיחת היכרות
- Main menu: a highlighted משכנתאות item that opens a mega menu (four groups, 13 topics); in the mobile drawer every group is an accordion
- Mortgage hub `/דיור-ומשכנתאות/` with the association certificate, plus 13 topic pages (listed below)
- Pages: `/אודות/`, `/צור-קשר/`, `/מן-התקשורת/`, `/כלי-עזר/`, `/מחשבון-תקציב-משפחתי/`, `/מחשבון-חיסכון-משפחתי-ליעדים/`, `/privacy-policy/`
- Contact form stores a private lead (פניות in wp-admin) and tries `wp_mail`
- With `blog_public` at 0: `robots.txt` disallows everything, and pages send `noindex` (meta and `X-Robots-Tag`)

## Content decisions

Live export: 8 pages, 71 posts, 5 categories.

- 42 live posts stay on their original slugs: stories, testimonials, the three meeting pages, the long budget guide, the consulting pillar `/יועץ-לכלכלת-המשפחה/`, and the grants page.
- 20 near-duplicate posts are merged into a canonical URL. Distinct paragraphs are appended under «נקודות שנשמרו ממדריכים שאוחדו», then the old URL 301s. The consulting doorway cluster points at `/יועץ-לכלכלת-המשפחה/`. Budget duplicates point at `/ניהול-תקציב-משפחתי/`. `/כלכלת-המשפחה/` points at `/כלכלת-משפחה/`.
- 9 stale or thin posts redirect with no body merge. COVID grants, unpaid leave, isolation grants, the citizen grant, mortgage-freeze, study-fund withdrawal, and state-backed loans go to `/מענקים-לכולם-אילו-מענקים-וזכויות-מגיע/`. The thin return-to-routine note goes to `/איך-לצאת-מהמינוס/`. `/ייעוץ-כלכלי/` goes to the consulting pillar.
- WhatsApp uses 972542372417. GA4 `G-5SR358LG0Z` is a theme option (Customizer → אנליטיקס) and stays off until it is switched on. The contact form replaces Contact Form 7.
- The homepage is a landing page, not the old keyword wall.
- Every move is a 301 in `redirects.json`, with the reason in Hebrew.

### Mortgage pillar (October 2026 revision)

`tools/mortgage_topics.py` holds the 13 topic pages the client asked for. Each one is a post in the `משכנתאות` category, rendered by `parts/mortgage-topic.php`. Every page covers who it is for, common problems, the step-by-step process, what to prepare, and a short FAQ. The FAQ is stored as `_amichai_faq` post meta and emitted as `FAQPage` JSON-LD next to a `Service` node. The `/משכנתאות/` category archive 301s to the hub and is left out of the sitemap. Groups and menu labels come from `amichai_mortgage_groups()` in `functions.php`. That one function feeds the mega menu, the homepage and hub topic maps, and the topic-page sidebars. The footer links only the hub and four key topics; its columns come from `amichai_footer_columns()`.

| Group | Slugs |
| --- | --- |
| קונים בית | `יועץ-משכנתאות-לזוגות-צעירים`, `משכנתא-למשפרי-דיור`, `משכנתא-לבנייה-עצמית`, `משכנתא-לשיפוץ` |
| חוסכים במשכנתא | `מחזור-משכנתא`, `חיסכון-בעלויות-המשכנתא`, `איחוד-הלוואות` |
| מקרים מיוחדים | `יועץ-משכנתאות-למסורבים`, `משכנתא-למבוגרים`, `משכנתא-הפוכה` |
| ייעוץ אישי | `יועץ-משכנתאות-פרטי`, `יועץ-הלוואות-פרטי`, `יועץ-משכנתאות-בצפון` |

The copy stays general: there are no rates, no approval promises, and no numbers beyond the ones on the live site (the 260,000 ₪ in the Salomon story).

Facts used on the site (phone, emails, address, company number, credentials, quotes) come from the live pages. The published phone is `054-2372417`. The privacy page states it as the contact number. No new testimonials or performance stats were added. Client-confirmed facts (October 2026): 15 years accompanying families, over 20 years in finance, an intro meeting of about an hour and a half, and mortgage advisor with membership in התאחדות יועצי המשכנתאות בישראל. The certificate scans in `assets/images/certs/` have the ID number blurred in the image files themselves.

## Go live

Follow [LAUNCH.md](LAUNCH.md): backup, database and media move, search-replace, seed, server config, the remove-on-launch checklist, indexing, mail, verification (`tools/verify_launch.py`), Search Console, and rollback.

Sitemap URL after go-live: `/wp-sitemap.xml`. Core WordPress sitemaps are enabled in code even on preview, but preview `robots.txt` disallows the whole host.

## cPanel

Requirements: PHP 8.2+, MySQL 8, WordPress 6.8, pretty permalinks, SSL.

1. Install WordPress on the account. Set the language to עברית (`he_IL`) and the timezone to `Asia/Jerusalem`.
2. Upload `wp-content/themes/amichai-marx` and `wp-content/mu-plugins/amichai-preview.php`.
3. Upload `content/` to `wp-content/amichai-data/` and place `redirects.json` in that same folder.
4. Copy `docker/seed.php` onto the server and run, from the WordPress root:

```bash
wp theme activate amichai-marx
wp eval-file /path/to/seed.php
wp rewrite flush --hard
```

5. In `wp-config.php`, before “stop editing”:

```php
define('DISALLOW_FILE_EDIT', true);
```

6. Settings → Permalinks → Post name. Save once if the category archives 404.
7. Categories `מאמרים`, `כללי`, and `שירותים-שלנו` are rewritten to the site root, matching the live URLs. `ייעוץ-כלכלי` and `סיפורי-משפחות` stay as posts because those slugs already belong to content; their category archives remain under `/category/…`.
8. Turn on SMTP (cPanel email or a plugin). Test the contact form.
9. Turn on `blog_public` only when this host is the one you want indexed. Until then the mu-plugin sends `noindex` and a disallow-all robots file.

## Layout of this folder

| Path | Role |
| --- | --- |
| `docker-compose.yml` | WordPress, MySQL 8, optional WP-CLI seed |
| `docker/seed.sh` | Install core, Hebrew locale, run the seed |
| `docker/seed.php` | Pages, posts, menu, front page |
| `content/posts.json` | Kept and rewritten posts |
| `content/pages.json` | The eight public pages |
| `content/classification.json` | keep / rewrite / redirect for every live post |
| `redirects.json` | 301 map |
| `wp-content/themes/amichai-marx` | Theme |
| `tools/build_content.py` | Rebuilds the JSON from a WP REST export (optional) |
| `tools/editorial_overrides.json` | Hand edits made after the first build, re-applied on every build |
| `tools/revision_2026.py` | October 2026 client revision: facts, mortgage/growth/support hubs, cross-links |
| `tools/mortgage_topics.py` | The 13 mortgage topic pages |
| `tools/build_assets.sh` | Minifies theme CSS/JS into the `.min` files the theme serves |
| `tools/verify_launch.py` | Post-deploy checks: old live URLs, redirects, robots/noindex, blocked files |
| `tools/webkit_check.mjs` | Mobile Safari (Playwright WebKit, 390px) check of every sitemap URL: unsized or oversized SVGs, horizontal overflow |
| `tools/live-urls.txt` | Every URL in the live sitemap before the migration |
| `server/htaccess-performance.conf` | Apache compression, caching, security headers, file deny list |
| `LAUNCH.md` | Go-live runbook |

## Regenerating content

`tools/build_content.py` expects the REST export at `/tmp/amichai/posts.json` and `/tmp/amichai/pages.json` (`/wp-json/wp/v2/posts?per_page=100` and the pages endpoint). It applies, in order: the export rules, `editorial_overrides.json`, `revision_2026.py`, and `mortgage_topics.py`. The output is deterministic, so a rebuild reproduces the committed JSON. After it runs, seed again.
