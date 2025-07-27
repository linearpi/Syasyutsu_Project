#!/bin/bash
cp .env.mysql .env
php artisan config:clear
echo "Switched to MySQL"
