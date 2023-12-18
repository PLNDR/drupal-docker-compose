FROM drupal:9.3.6-fpm

# Using the argument for theme location
ARG DRUPAL_THEME_LOCATION

# Copy custom theme into Drupal themes directory
COPY $DRUPAL_THEME_LOCATION /var/www/html/