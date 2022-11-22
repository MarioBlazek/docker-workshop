#!/usr/bin/env bash

set -e

read -rp 'Enter AWS Account ID: ' AWS_ACCOUNT_ID

export AWS_ACCOUNT_ID=$AWS_ACCOUNT_ID

docker context use docker-workshop-ecs
docker compose -f docker-compose-prod.yml down
