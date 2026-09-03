#!/usr/bin/env bash

set -euo pipefail

cp -f ./tests/resources/stubs/artisan ./laravel-tests/
cp -f ./tests/resources/stubs/ComposerConfigCommand.php ./laravel-tests/app/
mkdir -p ./laravel-tests/dcat-admin
cp -rf ./config ./laravel-tests/dcat-admin
cp -rf ./database ./laravel-tests/dcat-admin
cp -rf ./resources ./laravel-tests/dcat-admin
cp -rf ./src ./laravel-tests/dcat-admin
cp -rf ./tests ./laravel-tests/dcat-admin
cp -rf ./composer.json ./laravel-tests/dcat-admin
rm -rf ./laravel-tests/tests
cp -rf ./tests ./laravel-tests/tests
cp -f ./phpunit.dusk.xml ./laravel-tests
cp -f ./phpunit.compatibility.xml ./laravel-tests
cp -f ./.env.testing ./laravel-tests/.env
cd ./laravel-tests
php artisan admin:composer-config
composer require "woodynew/dcat-laravel-admin:*@dev" --with-all-dependencies --no-interaction --no-progress
