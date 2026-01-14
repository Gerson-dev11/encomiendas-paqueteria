#!/bin/bash

# Iniciar PHP-FPM en background
php-fpm -D

# Iniciar Nginx en primer plano
nginx -g 'daemon off;'