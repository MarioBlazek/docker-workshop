#!/usr/bin/env bash

set -e

docker context use docker-workshop-ecs
docker compose -f docker-compose-prod.yml down
