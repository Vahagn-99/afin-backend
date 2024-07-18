SELECT 'CREATE DATABASE afin_db'
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'afin_db')\gexec
