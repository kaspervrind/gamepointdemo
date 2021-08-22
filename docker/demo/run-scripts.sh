#!/usr/bin/env bash

function run_query() {
  PGPASSWORD=$POSTGRES_PASSWORD psql -hdb --username=$POSTGRES_USER $POSTGRES_DB -c "$@"
}

# wait for postgress to have booted
until run_query "SELECT 1" &>/dev/null; do
  echo 'Waiting for the database to come up'
  sleep 1
done

/usr/local/bin/php /app/bin/console doctrine:migrations:migrate -n

if [ "$(run_query "select 'exist' from currency_conversion limit 1" | grep "exist")" != "exist" ]; then
  echo 'Loading fixtures'
  /usr/local/bin/php /app/bin/console doctrine:fixtures:load --append
fi

exec apache2-foreground "$@"
