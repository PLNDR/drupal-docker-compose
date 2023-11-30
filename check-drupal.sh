#!/bin/bash

id=$(docker create drupal:10)
docker cp $id:/var/www/html/themes ./drupal-data/themes
docker cp $id:/var/www/html/modules ./drupal-data/modules
docker cp $id:/var/www/html/profiles ./drupal-data/profiles
docker cp $id:/var/www/html/sites ./drupal-data/sites
docker rm -v $id