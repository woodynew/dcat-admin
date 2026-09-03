#!/usr/bin/env bash

set -euo pipefail

cd ./laravel-tests
mkdir -p ./storage/logs
php artisan serve --host=127.0.0.1 --port=8300 > ./storage/logs/dusk-server.log 2>&1 &

for attempt in {1..30}; do
    if curl --fail --silent http://127.0.0.1:8300 > /dev/null; then
        exit 0
    fi

    sleep 1
done

cat ./storage/logs/dusk-server.log
exit 1
