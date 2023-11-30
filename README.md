# Deploy Wordpress on Localhost and in Production using Docker Compose

The installation tool kit, provided here, include:

- Nginx web server
- MariaDB/MySQL used for Wordpress database
- phpMyAdmin interface to connect to your MySQL database
- WP-Cli: Wordpress Command Line Interface
- Makefile directives for automatization.

You can automatically deploy a local docker wordpress site in 5 minutes
using the following commands:

```bash
# Download a wordpress docker-compose example
git clone <your repository>
cd wordpress-docker-compose
# Manual build
docker-compose up -d --build
# Automated wordpress installation
make autoinstall cms=wordpress
# Clean up wordpress installation
make cleanup
```

Visit your site at <http://localhost:8000> and your database via phpMyAdmin
at <http://localhost:8001>.

# Drupal installation

```
composer create-project drupal-composer/drupal-project:10.x-dev drupal --no-interaction --ignore-platform-req=ext-gd
```
