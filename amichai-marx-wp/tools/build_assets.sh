#!/usr/bin/env bash
# Minify theme CSS and JS into *.min.* files. The theme serves them when present.
set -euo pipefail
cd "$(dirname "$0")/../wp-content/themes/amichai-marx/assets"
for f in css/main.css css/savings.css js/main.js js/budget.js js/savings.js; do
  [ -f "$f" ] || continue
  npx --yes esbuild@0.28.2 "$f" --minify --log-level=warning --outfile="${f%.*}.min.${f##*.}"
done
