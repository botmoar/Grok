// Mobile Safari check (Playwright WebKit, iPhone 13 at 390px) for every URL in the WordPress sitemap.
// Fails on any inline SVG without width/height attributes or rendered larger than 64px,
// and on horizontal overflow.
//
//   npm i --no-save playwright && npx playwright install --with-deps webkit
//   node tools/webkit_check.mjs http://localhost:8080
import { webkit, devices } from "playwright";

const base = (process.argv[2] || "http://localhost:8080").replace(/\/$/, "");
const locs = async (url) => [...(await (await fetch(url)).text()).matchAll(/<loc>([^<]+)<\/loc>/g)].map((m) => m[1]);

const urls = [];
for (const sitemap of await locs(`${base}/wp-sitemap.xml`)) urls.push(...(await locs(sitemap)));

const browser = await webkit.launch();
const page = await (await browser.newContext({ ...devices["iPhone 13"], viewport: { width: 390, height: 844 } })).newPage();
let failures = 0;
for (const url of urls) {
  await page.goto(url, { waitUntil: "load" });
  const result = await page.evaluate(() => ({
    svgs: [...document.querySelectorAll("svg")]
      .map((svg) => {
        const box = svg.getBoundingClientRect();
        const unsized = !svg.getAttribute("width") || !svg.getAttribute("height");
        return unsized || box.width > 64 || box.height > 64
          ? `${Math.round(box.width)}x${Math.round(box.height)} in .${svg.parentElement.className}`
          : null;
      })
      .filter(Boolean),
    overflow: document.documentElement.scrollWidth > window.innerWidth,
  }));
  if (result.svgs.length || result.overflow) {
    failures++;
    console.log("FAIL", decodeURIComponent(url), result.overflow ? "horizontal overflow" : "", result.svgs.join("; "));
  }
}
await browser.close();
console.log(`${urls.length} URLs, ${failures} with problems`);
process.exit(failures ? 1 : 0);
