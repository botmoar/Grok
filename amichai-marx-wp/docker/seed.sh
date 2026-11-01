#!/bin/sh
set -eu
cd /var/www/html

echo "Waiting for wp-config.php..."
i=0
while [ ! -f wp-config.php ]; do
  i=$((i + 1))
  if [ "$i" -gt 90 ]; then
    echo "wp-config.php was not created" >&2
    exit 1
  fi
  sleep 2
done

echo "Waiting for the database..."
i=0
while true; do
  msg=$(wp core is-installed 2>&1 || true)
  if wp core is-installed >/dev/null 2>&1; then
    break
  fi
  case "$msg" in
    *"database connection"*|*"Error establishing"*)
      i=$((i + 1))
      if [ "$i" -gt 60 ]; then
        echo "database is not reachable" >&2
        echo "$msg" >&2
        exit 1
      fi
      sleep 2
      ;;
    *)
      break
      ;;
  esac
done

if ! wp core is-installed >/dev/null 2>&1; then
  wp core install \
    --url="${WP_URL:-http://localhost:8080}" \
    --title="עמיחי מרקס" \
    --admin_user="${WP_ADMIN_USER:-admin}" \
    --admin_password="${WP_ADMIN_PASSWORD:-amichai-local-change-me}" \
    --admin_email="${WP_ADMIN_EMAIL:-marx@amichai-marx.co.il}" \
    --skip-email
fi

wp option update siteurl "${WP_URL:-http://localhost:8080}"
wp option update home "${WP_URL:-http://localhost:8080}"

if ! wp language core is-installed he_IL >/dev/null 2>&1; then
  wp language core install he_IL || echo "Hebrew language pack download failed; theme still forces lang=he-IL" >&2
fi
wp site switch-language he_IL || true

wp eval-file /seed/seed.php
wp rewrite flush --hard
echo "Seed complete: ${WP_URL:-http://localhost:8080}"
