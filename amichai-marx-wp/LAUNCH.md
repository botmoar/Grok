# Go-live: amichai-marx.co.il

Moves the reviewed staging build onto the public domain. Every command runs over SSH from the WordPress root on the server that serves the site (WP-CLI 2.x). Replace `STAGING_URL` with the staging address, for example `https://staging.amichai-marx.co.il`, with no trailing slash. Do it at a quiet time, with whoever controls DNS and hosting reachable.

## 0. Before the day

- [ ] Staging was approved by the client: copy, photos, menu, contact form.
- [ ] SMTP details are available: a mailbox on the domain (cPanel email) or a transactional provider. The domain's SPF and DKIM records include that sender.
- [ ] Search Console access for `amichai-marx.co.il` is confirmed (owner or full user).
- [ ] `tools/live-urls.txt` holds the 82 URLs from the current live sitemap and needs no edits. Every one of them must still resolve after launch.
- [ ] Optional: lower the DNS TTL to 300 a day ahead if the site is moving to a new server.

## 1. Back up the current live site

Keep the backup off the server, and don't delete it for at least 30 days.

```bash
wp db export ~/backup-live-$(date +%F).sql
tar czf ~/backup-live-files-$(date +%F).tgz --exclude=wp-content/cache .
```

If WP-CLI isn't installed yet, use cPanel → Backup → full account backup instead. Download both files and check that they open.

## 2. Put the new code in place

From this repository:

| Copy | To (on the server) |
| --- | --- |
| `wp-content/themes/amichai-marx/` | `wp-content/themes/amichai-marx/` |
| `wp-content/mu-plugins/amichai-preview.php` | `wp-content/mu-plugins/amichai-preview.php` |
| `content/` (including `.htaccess` and `index.php`) | `wp-content/amichai-data/` |
| `redirects.json` | `wp-content/amichai-data/redirects.json` |
| `docker/seed.php` | outside the web root, for example `~/seed.php` |

Don't copy `tools/`, `docker/`, `server/`, `README.md`, `LAUNCH.md` or `.env*` into the web root.

## 3. Move the staging database and media

Staging is the version the client approved, so move it as is:

```bash
# on staging
wp db export ~/staging.sql
tar czf ~/staging-uploads.tgz wp-content/uploads

# on production, after both files are copied over
wp db import ~/staging.sql
tar xzf ~/staging-uploads.tgz
```

Then switch every stored URL to the public domain. Run the dry run first and read the counts:

```bash
wp search-replace 'STAGING_URL' 'https://amichai-marx.co.il' --all-tables --precise --skip-columns=guid --dry-run
wp search-replace 'STAGING_URL' 'https://amichai-marx.co.il' --all-tables --precise --skip-columns=guid
wp search-replace 'http://amichai-marx.co.il' 'https://amichai-marx.co.il' --all-tables --precise --skip-columns=guid
wp option get home      # https://amichai-marx.co.il
wp option get siteurl   # https://amichai-marx.co.il
```

The content JSON uses relative internal links. Only WordPress's own records hold the host: menus, attachments and options.

## 4. Seed once on production, then flush

The seed is idempotent. It brings pages, posts, menu, site icon and options to the exact content of this repository, and it leaves `blog_public` alone on this host.

```bash
wp theme activate amichai-marx
wp eval-file ~/seed.php
wp rewrite flush --hard
wp cache flush
```

Settings → Permalinks must show "Post name". Saving that screen once also rewrites `.htaccess`.

## 5. Server configuration (Apache `.htaccess`)

Paste `server/htaccess-performance.conf` from this repository into the site root `.htaccess`, above `# BEGIN WordPress`. It adds compression, a year of caching for static files, security headers, a deny list for files that must never be served, and turns off directory listings.

Turn on HTTPS for the domain, plus the host's "Force HTTPS" option. `http://` and `www.` must each reach `https://amichai-marx.co.il/` in one 301:

```bash
curl -sI http://amichai-marx.co.il/ | grep -i '^location'
curl -sI https://www.amichai-marx.co.il/ | grep -i '^location'
```

## 6. Remove-on-launch checklist

- [ ] `wp-config.php` contains `define('WP_DEBUG', false);`, and nothing defines `WP_DEBUG_DISPLAY` true or `SCRIPT_DEBUG` true.
- [ ] `define('DISALLOW_FILE_EDIT', true);` is in `wp-config.php`.
- [ ] Delete `wp-content/debug.log` if it exists.
- [ ] Delete the default files: `rm readme.html license.txt wp-config-sample.php`. The `.htaccess` rules block them anyway, but WordPress updates bring them back.
- [ ] Remove the unused themes and plugins: `wp theme list`, then `wp theme delete twentytwentythree twentytwentyfour twentytwentyfive` (whichever are present). Also run `wp plugin delete hello akismet`, plus any plugin left over from the old site (Yoast, Contact Form 7).
- [ ] No local or test helpers are in `wp-content/mu-plugins/`. The only file there is `amichai-preview.php`.
- [ ] The staging admin account has a new strong password, or a new admin replaces it. `wp user list` shows no test users.
- [ ] Delete test leads: wp-admin → פניות.
- [ ] Remove `~/seed.php`, `~/staging.sql` and `~/staging-uploads.tgz` from the server once launch is verified.
- [ ] Staging stays protected: password or basic auth, with `blog_public` at 0. Never point staging at the public domain.

## 7. Turn on indexing

Indexing has a single switch: Settings → Reading → "Discourage search engines" **unchecked**. Or:

```bash
wp option update blog_public 1
```

The mu-plugin follows this option only. With it on, `robots.txt` allows crawling and lists `/wp-sitemap.xml`, and pages drop the `noindex` meta and `X-Robots-Tag` header. Turning it off reverses all three.

## 8. Mail and the contact form

1. Configure SMTP: a plugin such as WP Mail SMTP, or the host's mail service. Send its test email.
2. Leads go to `marx@amichai-marx.co.il`. To change that address, add a filter in a small mu-plugin: `add_filter('amichai_lead_recipient', fn() => 'other@…');`.
3. Fill in the form on `/צור-קשר/` from a phone. You should see the green confirmation, and the email should arrive with Reply-To set to the visitor. The lead also appears under פניות. Delete it afterwards.

## 9. Verify

From any machine with this repository:

```bash
python3 tools/verify_launch.py https://amichai-marx.co.il
```

It checks the following and must print `OK`:

- Every old live URL in `tools/live-urls.txt` and every `redirects.json` source reaches a 200 in at most one 301.
- `robots.txt` allows crawling and lists the sitemap, and the home page has no `noindex`.
- `/wp-sitemap.xml` loads.
- `readme.html`, `license.txt`, `debug.log`, the seed data and the public user list are not readable.

Then check mobile Safari rendering (Playwright WebKit, iPhone 13 at 390px) for every sitemap URL. It must report `0 with problems`:

```bash
npm i --no-save playwright && npx playwright install --with-deps webkit
node tools/webkit_check.mjs https://amichai-marx.co.il
```

Then by hand:

- [ ] Home, `/דיור-ומשכנתאות/`, one mortgage topic, one story, `/צור-קשר/` and `/הצהרת-נגישות/` load on a phone, and the mega menu works.
- [ ] View source on the home page: one `<link rel="canonical">` with `https://amichai-marx.co.il/`, `og:url` on the same host, and no `localhost` or staging host anywhere. `curl -s https://amichai-marx.co.il/ | grep -cE 'localhost|staging'` must print 0.
- [ ] Browser tab and phone home screen show the logo icon.
- [ ] [Rich Results Test](https://search.google.com/test/rich-results) on the home page and on one mortgage topic page: LocalBusiness, Person, Service and FAQ are detected with no errors.
- [ ] PageSpeed Insights (mobile) for the home page: all four categories at 90 or above.
- [ ] GA4: turn it on only once the client approves. Customizer → אנליטיקס → enable; the ID `G-5SR358LG0Z` is prefilled. Check Realtime in GA.

## 10. Search Console

1. Open the `amichai-marx.co.il` property (Domain property preferred).
2. Sitemaps: remove `sitemap_index.xml` if it is listed, then submit `https://amichai-marx.co.il/wp-sitemap.xml`. The old Yoast sitemap URLs 301 to it, so stale fetches still work.
3. URL Inspection → "Request indexing" for the home page, `/דיור-ומשכנתאות/`, `/יועץ-לכלכלת-המשפחה/` and `/אודות/`.
4. Over the next two weeks, check Pages → "Not indexed" and the 404 report. Any old URL that shows up there and isn't in `redirects.json` gets a rule. To add one, edit `tools/build_content.py`, run it, and redeploy `redirects.json`.

## Rollback

If the new site is broken and can't be fixed quickly:

```bash
wp db import ~/backup-live-YYYY-MM-DD.sql
tar xzf ~/backup-live-files-YYYY-MM-DD.tgz
wp rewrite flush --hard
```

Then open the home page and one old post to confirm the old site is back.

## After a CSS or JS change

The theme serves `assets/css/*.min.css` and `assets/js/*.min.js` unless `SCRIPT_DEBUG` is on. After editing the source files, run `tools/build_assets.sh` and deploy the `.min` files with them.
