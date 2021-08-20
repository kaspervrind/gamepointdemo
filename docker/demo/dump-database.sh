#!/usr/bin/env bash

pg_dump --dbname=postgresql://${POSTGRES_USER}:${POSTGRES_PASSWORD}@db:5432/${POSTGRES_DB} --file=/app/tmp/dump.sql
echo "Database exported to tmp/dump.sql"
