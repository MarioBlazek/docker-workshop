#!/bin/sh

# Wait for database container and mysql service
./wait-for-it.sh db:3306

# Create database
bin/console doctrine:database:create --if-not-exists

# Create database structure
bin/console doctrine:migrations:migrate --no-interaction

# Run database fixture
bin/console doctrine:fixtures:load --no-interaction

# Start Symfony CLI webserver
symfony server:ca:install
symfony server:start --port=3001 --allow-http