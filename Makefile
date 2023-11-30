WPCLI := $(shell docker ps -a -q --filter "name=wpcli")

wordpress-start:
	docker-compose -f docker-compose.wordpress.yml up -d --build

wordpress-down:
	docker-compose -f docker-compose.wordpress.yml down

drupal-start: copy-drupal-data
	docker-compose -f docker-compose.drupal.yml up -d --build

drupal-down:
	docker-compose -f docker-compose.drupal.yml down

copy-drupal-data:
	docker build --no-cache --build-arg DRUPAL_THEME_LOCATION=./drupal/altalanos_template/ -f drupal.Dockerfile . -t drupal-temp 
	docker create --name dummy-drupal drupal-temp
	docker cp dummy-drupal:/var/www/html/themes ./drupal-data/
	docker cp dummy-drupal:/var/www/html/modules ./drupal-data/
	docker cp dummy-drupal:/var/www/html/profiles ./drupal-data/
	docker cp dummy-drupal:/var/www/html/sites ./drupal-data/
	docker rm -v dummy-drupal

wordpress-autoinstall: wordpress-start

drupal-autoinstall: drupal-start

autoinstall:
ifeq ($(cms),wordpress)
autoinstall: wordpress-autoinstall
else ifeq ($(cms),drupal)
autoinstall: drupal-autoinstall
else
	@echo "Please select a valid CMS (drupal or wordpress)!"
endif

cleanup:
	@echo "Cleaning up..."
	docker rm $(WPCLI)
