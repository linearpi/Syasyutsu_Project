#!/bin/bash
cp .env.sqlite .env
php artisan config:clear
echo "Switched to SQLite"
