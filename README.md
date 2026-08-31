# אהבת החי — WordPress

Production-ready WordPress rebuild of [www.ofervet.co.il](https://www.ofervet.co.il/) (currently Webflow) for **אהבת החי** (Ahavat HaChai), Dr. Ofer Shavit’s veterinary center at Yad HaMaavir 9, Hadar Yosef, Tel Aviv.

The custom theme `ahavat-hachai` is Hebrew RTL (`lang="he" dir="rtl"`), matches the live information architecture and copy, and ships with a WP-CLI seed for all 29 public URLs (pages, 17 articles, team, FAQ).

## Quick start (Docker)

Requirements: Docker and Docker Compose v2.

```bash
cp .env.example .env
docker compose up -d
docker compose exec wpcli sh /scripts/seed.sh
```

Open [http://localhost:8080](http://localhost:8080).

| | |
|---|---|
| Site | http://localhost:8080 |
| Admin | http://localhost:8080/wp-admin |
| User / password | `admin` / `admin` (override in `.env`) |

Re-run `docker compose exec wpcli sh /scripts/seed.sh` any time; the importer is idempotent (updates by slug).

Google Tag Manager is **off** locally. Set `AHAVAT_GTM_ID=GTM-5S4LVXQ6` in `.env` and in **Appearance → Customize → מעקב (GTM)** for production.

## What’s in the repo

```
bin/seed.sh                          WP-CLI install + content import
docker-compose.yml                   wordpress:latest + mysql:8 + wp-cli
seed/content.json                    Live-site copy, SEO, image aliases
seed/import.php                      Pages, posts, team CPT, FAQ CPT, media
wp-config-docker.php                 Extra defines for Docker / generic hosts
wp-content/themes/ahavat-hachai/     Custom RTL theme (no Webflow CSS/JS)
  assets/images/                     Downloaded from the live Webflow CDN
```

WordPress core and uploads live in Docker volumes, not in git.

## URLs (same slugs as live)

| Path | Content |
|---|---|
| `/` | Homepage |
| `/our-team` | Full team |
| `/our-clinic` | Clinic tour |
| `/grooming` | Grooming salon |
| `/hshyrvtym-shlnv` | Services |
| `/rpvt-khyvt-qzvtyvt` | Exotic animal medicine |
| `/alternative-treatment` | Coming soon (בקרוב) |
| `/dental-treatment` | Coming soon (בקרוב) |
| `/fqa` | FAQ (slug kept) |
| `/mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym` | Articles index |
| `/search` | Search |
| `/articles/{slug}/` | 17 Hebrew articles |
| `/rpvh-ltrntybyt-bb-ly-khyym` | 301 → `/alternative-treatment` |

## Contact (canonical)

- Clinic: [03-6472933](tel:+97236472933)
- WhatsApp: [053-3535306](https://wa.me/972533535306?text=%D7%91%D7%A8%D7%95%D7%9B%D7%99%D7%9D%20%D7%94%D7%91%D7%90%D7%99%D7%9D%20%D7%9C%D7%90%D7%94%D7%91%D7%AA%20%D7%94%D7%97%D7%99) (live site had a broken `ttps://wa.me` link; this is fixed)
- After-hours emergency / Vet-Red: [077-9579799](tel:+972779579799) — members 10% off
- Homepage emergency card also lists [054-344600](tel:+97254344600) as on the live site
- Email: vet@ofervet.co.il, office@ofervet.co.il
- Address: יד המעביר 9 הדר יוסף תל אביב (~32.10908, 34.82452)
- Hours: Sun–Thu 08:30–19:00; Fri and holiday eves 08:30–13:30; emergency from 19:00
- [Facebook](https://www.facebook.com/ofervet?locale=he_IL) · [Instagram](https://www.instagram.com/ofervet/)

There is no contact form. CTAs are phone and WhatsApp.

## Deploy to a standard WordPress host

1. Create a MySQL 8 database (utf8mb4) and a WP install (PHP 8.1+).
2. Point the domain (e.g. `ofervet.co.il`) at the host and enable HTTPS.
3. Copy `wp-content/themes/ahavat-hachai` into `wp-content/themes/`.
4. Merge the defines in `wp-config-docker.php` into `wp-config.php` (or `require` the file). Set:

   ```php
   define('WP_HOME', 'https://www.ofervet.co.il');
   define('WP_SITEURL', 'https://www.ofervet.co.il');
   define('AHAVAT_GTM_ID', 'GTM-5S4LVXQ6');
   ```

5. In wp-admin: **Settings → General** — site title `אהבת החי`, timezone `Asia/Jerusalem`, site language Hebrew. Install the `he_IL` language pack (**Dashboard → Updates** or `wp language core install he_IL && wp site switch-language he_IL`).
6. Activate **אהבת החי**.
7. **Settings → Permalinks**: custom structure `/articles/%postname%/`. Pages keep `/%pagename%/` so `/fqa` and `/our-team` still match the live site.
8. Copy `seed/` to the server and run:

   ```bash
   wp eval-file seed/import.php
   wp rewrite flush --hard
   ```

9. If the site URL changed after a database copy:

   ```bash
   wp search-replace 'http://localhost:8080' 'https://www.ofervet.co.il' --all-tables
   ```

10. **Appearance → Customize → מעקב (GTM)** — set `GTM-5S4LVXQ6`.
11. Confirm SSL, `https://www.ofervet.co.il/robots.txt` (clean allow/disallow + sitemap, not the live keyword-stuffed file), and `https://www.ofervet.co.il/wp-sitemap.xml`.

## Theme notes

- Semantic HTML + BEM-style CSS. Rubik 300–700. Brand pink `#ED2590`.
- Custom post types: `team_member`, `faq_item` (taxonomy `faq_category`). Articles are normal posts.
- SEO: unique Hebrew titles and meta descriptions (live tags where they existed; filled unique copy where Webflow left them empty), Open Graph + Twitter, canonical + hreflang, VeterinaryCare / WebSite / Article / FAQPage JSON-LD, Search Console verification. Search and coming-soon pages are `noindex`. Clean `robots.txt` + `wp-sitemap.xml`.
- Images were downloaded from `cdn.prod.website-files.com/65acc63adb24d071136d5f75/` into the theme. Do not hotlink the Webflow CDN.
- No jQuery, no Webflow JS. Lightweight slider and accordion (`<details>`).
- Branded Hebrew 404.

## License

Theme and seed content are for Ahavat HaChai / ofervet.co.il. Clinic photos and copy remain the clinic’s.
