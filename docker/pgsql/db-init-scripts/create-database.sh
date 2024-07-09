#!/usr/bin/env bash

# Environment variables
DB_NAME="${POSTGRES_DB:-import-app}"
DB_USER="${POSTGRES_USER}"
DB_PASSWORD="${POSTGRES_PASSWORD}"
DB_HOST="${DB_HOST:-pgsql}"  # Set default host to the service name 'pgsql'
DB_PORT="${DB_PORT:-5432}"

# Export password to avoid password prompt
export PGPASSWORD=$DB_PASSWORD

# Check if PostgresSQL is ready
until psql -h "$DB_HOST" -U "$DB_USER" -p "$DB_PORT" -c '\q'; do
  >&2 echo "PostgresSQL is unavailable - sleeping"
  sleep 1
done

# Check if the database already exists
DB_EXIST=$(psql -h "$DB_HOST" -U "$DB_USER" -p "$DB_PORT" -tc "SELECT 1 FROM pg_database WHERE datname = '$DB_NAME';")

# Create the database if it does not exist
if [ "$DB_EXIST" != "1" ]; then
    echo "Database $DB_NAME does not exist. Creating..."
    psql -h "$DB_HOST" -U "$DB_USER" -p "$DB_PORT" -c "CREATE DATABASE \"$DB_NAME\";"
    echo "Database $DB_NAME created successfully."
else
    echo "Database $DB_NAME already exists. Skipping creation."
fi

# Unset the password environment variable
unset PGPASSWORD
