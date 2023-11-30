#!/bin/bash

echo "⚙️ Configuring Wordpress parameters..."

wp core install \
  --url=${WORDPRESS_WEBSITE_URL_WITHOUT_HTTP} \
  --title="${WORDPRESS_WEBSITE_TITLE}" \
  --admin_user="${WORDPRESS_ADMIN_USER}" \
  --admin_password=${WORDPRESS_ADMIN_PASSWORD} \
  --admin_email=${WORDPRESS_ADMIN_EMAIL}

wp option update siteurl ${WORDPRESS_WEBSITE_URL}
wp rewrite structure ${WORDPRESS_WEBSITE_POST_URL_STRUCTURE}
wp language core install ${WORDPRESS_LOCALE} --activate
wp theme install ${WORDPRESS_THEME}
wp theme activate ${WORDPRESS_CHILD_THEME}
wp plugin activate ${WORDPRESS_PLUGINS} --allow-root --path=/var/www/html/
wp theme list
wp plugin list

echo "All done! Wordpress site has been installed. 🎉"
