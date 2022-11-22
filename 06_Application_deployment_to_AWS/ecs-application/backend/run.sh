#!/usr/bin/env bash

bin/console doctrine:database:create

bin/console doctrine:migrations:migrate

bin/console doctrine:fixtures:load

symfony server:ca:install
symfony serve --port=3001