ARG WORDPRESS_VERSION
FROM wordpress:${WORDPRESS_VERSION}

# Copy php config to directory
COPY ./config/php.conf.ini /usr/local/etc/php/conf.d/php.ini

# Production image #
# 1. Embed content
# 2. Add custom entrypoint to re-ensure init of /var/www/html
# 3. Drop wp-admin

# Cleanout built-in themes and plugins.
# RUN  rm -R $(ls -1 -d /usr/src/wordpress/wp-content/plugins/*) \
#     && rm -R $(ls -1 -d /usr/src/wordpress/wp-content/themes/*)

# Inject our Plugins, themes, etc. into the image.
COPY themes/ /usr/src/wordpress/wp-content/themes
COPY plugins/ /usr/src/wordpress/wp-content/plugins
COPY config/.htaccess /usr/src/wordpress/.htaccess
COPY docker-entrypoint-override.sh /usr/local/bin

ENTRYPOINT ["/usr/local/bin/docker-entrypoint-override.sh"]
CMD ["apache2-foreground"]