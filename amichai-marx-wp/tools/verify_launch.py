#!/usr/bin/env python3
"""Post-deploy checks against one host (read-only GET requests).

    python3 tools/verify_launch.py https://amichai-marx.co.il          # expects indexing on
    python3 tools/verify_launch.py https://staging.example --staging   # expects noindex

Checks: every URL from the pre-migration live sitemap (tools/live-urls.txt) and every
redirects.json source reaches 200 in at most one 301; robots/noindex match the mode;
sitemap is served; files that must not be public are blocked.
"""
import json
import pathlib
import re
import sys
import urllib.error
import urllib.parse
import urllib.request

HERE = pathlib.Path(__file__).resolve().parent
UA = {"User-Agent": "amichai-launch-check"}


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *args, **kwargs):
        return None


opener = urllib.request.build_opener(NoRedirect)


def fetch(url):
    try:
        r = opener.open(urllib.request.Request(url, headers=UA), timeout=30)
        return r.status, r.headers, r.read().decode("utf-8", "replace")
    except urllib.error.HTTPError as e:
        return e.code, e.headers, ""


def absolute(base, path):
    return base + urllib.parse.quote(path)


def chain(base, path):
    url, codes = absolute(base, path), []
    for _ in range(4):
        code, headers, _ = fetch(url)
        codes.append(code)
        loc = headers.get("Location") if headers else None
        if code in (301, 302, 307, 308) and loc:
            url = loc if loc.startswith("http") else base + loc
            continue
        break
    return codes


def main():
    if len(sys.argv) < 2:
        sys.exit(__doc__)
    base = sys.argv[1].rstrip("/")
    staging = "--staging" in sys.argv
    failures = []

    paths = [p for p in (HERE / "live-urls.txt").read_text(encoding="utf-8").split("\n") if p]
    redirects = json.loads((HERE.parent / "redirects.json").read_text(encoding="utf-8"))
    paths += [r["from"] for r in redirects]
    for path in dict.fromkeys(paths):
        codes = chain(base, path)
        if codes[-1] != 200 or codes.count(301) > 1 or any(c in (302, 307) for c in codes):
            failures.append(f"{path}: {codes}")
    print(f"URLs checked: {len(dict.fromkeys(paths))}")

    code, _, robots = fetch(base + "/robots.txt")
    blocked = bool(re.search(r"^Disallow:\s*/\s*$", robots, re.M))
    if code != 200 or blocked != staging:
        failures.append(f"robots.txt: status {code}, disallow-all={blocked}")
    if not staging and "wp-sitemap.xml" not in robots:
        failures.append("robots.txt does not list the sitemap")

    code, headers, html = fetch(base + "/")
    noindex = "noindex" in (headers.get("X-Robots-Tag") or "") or bool(
        re.search(r"<meta[^>]+name=['\"]robots['\"][^>]+noindex", html)
    )
    if code != 200 or noindex != staging:
        failures.append(f"home: status {code}, noindex={noindex}")

    code, _, _ = fetch(base + "/wp-sitemap.xml")
    if code != 200:
        failures.append(f"/wp-sitemap.xml: status {code}")

    for path in ("/readme.html", "/license.txt", "/wp-config.php.bak", "/wp-content/debug.log",
                 "/wp-content/amichai-data/posts.json", "/wp-json/wp/v2/users"):
        code, _, _ = fetch(base + path)
        if code == 200:
            failures.append(f"{path} is publicly readable")

    for line in failures:
        print("FAIL", line)
    print("OK" if not failures else f"{len(failures)} failure(s)")
    sys.exit(1 if failures else 0)


if __name__ == "__main__":
    main()
