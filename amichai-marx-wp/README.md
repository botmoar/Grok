# עמיחי מרקס – WordPress

Hebrew RTL site for family-economics consultant Amichai Marx. Custom theme `amichai-marx`, Docker Compose (WordPress + MySQL 8 + WP-CLI), and a seed that keeps the live slugs worth keeping.

Preview builds stay `noindex` until `AMICHAI_GO_LIVE=1`.

## Local preview

```bash
cd amichai-marx-wp
cp .env.example .env
docker compose up -d
docker compose --profile seed run --rm wpcli
```

Open http://localhost:8080

Local admin (change it): user `admin`, password `amichai-local-change-me`.

The seed is idempotent. Run the `wpcli` command again after content edits.

## What you should see

- `lang="he-IL"` and `dir="rtl"`
- White header, logo עמיחי מרקס, phone 054-2372417
- Hero: portrait, headline ייעוץ לכלכלת המשפחה וביטחון פיננסי, green לתיאום שיחת ייעוץ, outlined חייגו עכשיו
- Pages: `/אודות/`, `/צור-קשר/`, `/מן-התקשורת/`, `/כלי-עזר/`, `/מחשבון-תקציב-משפחתי/`, `/מחשבון-חיסכון-משפחתי-ליעדים/`, `/privacy-policy/`
- Contact form stores a private lead (פניות in wp-admin) and tries `wp_mail`
- `robots.txt` disallows everything, pages send `noindex`

## Content decisions

Live export: 8 pages, 71 posts, 5 categories.

- 42 posts stay on their original slugs: stories, testimonials, the three meeting pages, the long budget guide, the consulting pillar `/יועץ-לכלכלת-המשפחה/`, and the grants page.
- 20 near-duplicate posts are merged into a canonical URL. Distinct paragraphs are appended under «נקודות שנשמרו ממדריכים שאוחדו», then the old URL 301s. The consulting doorway cluster points at `/יועץ-לכלכלת-המשפחה/`. Budget duplicates point at `/ניהול-תקציב-משפחתי/`. `/כלכלת-המשפחה/` points at `/כלכלת-משפחה/`.
- 9 stale or thin posts redirect with no body merge. COVID grants, unpaid leave, isolation grants, the citizen grant, mortgage-freeze, study-fund withdrawal, and state-backed loans go to `/מענקים-לכולם-אילו-מענקים-וזכויות-מגיע/`. The thin return-to-routine note goes to `/איך-לצאת-מהמינוס/`. `/ייעוץ-כלכלי/` goes to the consulting pillar.
- WhatsApp uses 972542372417. GA4 `G-5SR358LG0Z` is a theme option (Customizer → אנליטיקס) and stays off until it is switched on. The contact form replaces Contact Form 7.
- The homepage is a landing page, not the old keyword wall.
- Every move is a 301 in `redirects.json`, with the reason in Hebrew.

Facts used on the site (phone, emails, address, company number, credentials, quotes) come from the live pages. Phone numbers in the privacy policy that were missing a digit separator were aligned to `054-2372417`. No new testimonials or performance stats were added.

## Go live

1. Point the host at the real domain and set `WP_URL` (or `siteurl` / `home`) to `https://amichai-marx.co.il`.
2. Set `AMICHAI_GO_LIVE=1` and recreate the WordPress container so `wp-config.php` picks it up.
3. Re-run the seed, or at least:

```bash
wp option update blog_public 1
wp rewrite flush --hard
```

4. Confirm `robots.txt` allows crawling and lists the sitemap, and that pages no longer send `noindex`.
5. Configure real SMTP. `wp_mail` does nothing useful until the server can send mail.
6. Replace the local admin password.

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
define('AMICHAI_GO_LIVE', false); // true only on the public domain
define('DISALLOW_FILE_EDIT', true);
```

6. Settings → Permalinks → Post name. Save once if the category archives 404.
7. Categories `מאמרים`, `כללי`, and `שירותים-שלנו` are rewritten to the site root, matching the live URLs. `ייעוץ-כלכלי` and `סיפורי-משפחות` stay as posts because those slugs already belong to content; their category archives remain under `/category/…`.
8. Turn on SMTP (cPanel email or a plugin). Test the contact form.
9. Flip `AMICHAI_GO_LIVE` and `blog_public` only when this host is the one you want indexed. Until then the mu-plugin sends `noindex` and a disallow-all robots file.

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

## Regenerating content

`tools/build_content.py` expects the REST export at `/tmp/amichai/posts.json` and `/tmp/amichai/pages.json` (`/wp-json/wp/v2/posts?per_page=100` and the pages endpoint). After it runs, seed again.
