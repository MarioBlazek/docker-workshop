#!/bin/sh

# Create database
bin/console doctrine:database:create --if-not-exists

# Create database structure
bin/console doctrine:migrations:migrate --no-interaction

# Run database fixture
bin/console doctrine:fixtures:load --no-interaction

# Start Symfony CLI webserver
symfony server:ca:install
symfony server:start --port=81 --allow-http