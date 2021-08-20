#!/usr/bin/env bash

set -x

function run_query() {
    /usr/local/bin/php /app/bin/console dbal:run-sql "$@"
}

# wait for postgress to have booted
until run_query "SELECT 1" &>/dev/null; do
    sleep 1
done

/usr/local/bin/php /app/bin/console doctrine:migrations:migrate -n

exec apache2-foreground "$@"
