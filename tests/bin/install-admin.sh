#!/usr/bin/env bash

set -euo pipefail

cd ./laravel-tests
php artisan admin:publish --force
php artisan admin:install
php artisan migrate:rollback --force
cp -f ./tests/routes.php ./app/Admin/
cp -rf ./tests/resources/config ./config/
