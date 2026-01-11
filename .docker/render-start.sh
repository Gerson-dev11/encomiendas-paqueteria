#!/bin/bash
# Start PHP-FPM in background
php-fpm -D

# Start PHP built-in server on Render's port
php -S 0.0.0.0:$PORT -t public