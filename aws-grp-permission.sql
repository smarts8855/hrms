sudo rm -f bootstrap/cache/*.php

sudo touch /home/ubuntu/scngrp/storage/logs/laravel.log
sudo chown -R www-data:www-data /home/ubuntu/scngrp/storage
sudo chmod -R 775 /home/ubuntu/scngrp/storage


sudo mkdir -p /home/ubuntu/scngrp/bootstrap/cache
sudo chown -R www-data:www-data /home/ubuntu/scngrp/bootstrap/cache
sudo chmod -R 775 /home/ubuntu/scngrp/bootstrap/cache


php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear







cd /home/ubuntu/scngrp

sudo mkdir -p storage/logs
sudo mkdir -p bootstrap/cache

sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

sudo touch storage/logs/laravel.log
sudo chown www-data:www-data storage/logs/laravel.log
sudo chmod 664 storage/logs/laravel.log


php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
