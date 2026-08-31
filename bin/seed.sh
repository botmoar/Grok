#!/bin/sh
set -eu

cd /var/www/html

echo "Waiting for WordPress to be ready…"
i=0
until wp core is-installed --allow-root 2>/dev/null || wp db check --allow-root >/dev/null 2>&1; do
  i=$((i + 1))
  if [ "$i" -gt 60 ]; then
    echo "Database never became ready" >&2
    exit 1
  fi
  sleep 2
done

# Wait until wp-config exists and DB accepts connections.
i=0
until wp db check >/dev/null 2>&1; do
  i=$((i + 1))
  if [ "$i" -gt 60 ]; then
    echo "wp db check failed" >&2
    exit 1
  fi
  sleep 2
done

URL="${WORDPRESS_URL:-http://localhost:8080}"
ADMIN_USER="${WORDPRESS_ADMIN_USER:-admin}"
ADMIN_PASS="${WORDPRESS_ADMIN_PASSWORD:-admin}"
ADMIN_EMAIL="${WORDPRESS_ADMIN_EMAIL:-vet@ofervet.co.il}"

if ! wp core is-installed >/dev/null 2>&1; then
  echo "Installing WordPress at ${URL}…"
  wp core install \
    --url="$URL" \
    --title="אהבת החי" \
    --admin_user="$ADMIN_USER" \
    --admin_password="$ADMIN_PASS" \
    --admin_email="$ADMIN_EMAIL" \
    --skip-email
fi

wp language core install he_IL || true
wp site switch-language he_IL || wp option update WPLANG he_IL

wp theme activate ahavat-hachai
wp rewrite structure '/articles/%postname%/' --hard
wp rewrite flush --hard

wp option update blogname 'אהבת החי'
wp option update blogdescription 'מרכז וטרינרי'
wp option update timezone_string 'Asia/Jerusalem'
wp option update date_format 'd/m/Y'
wp option update start_of_week 0

wp eval-file /seed/import.php

echo "Seed finished. Open ${URL}"
echo "Admin: ${URL}/wp-admin  user=${ADMIN_USER}"
