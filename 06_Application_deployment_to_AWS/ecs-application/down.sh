#!/usr/bin/env bash

set -e

read -rp 'Enter AWS Account ID: ' AWS_ACCOUNT_ID

# set AWS account ID as the env variable for this session
export AWS_ACCOUNT_ID=$AWS_ACCOUNT_ID

# shutdown our infrastructure, like it never was
docker context use docker-workshop-ecs
docker compose -f docker-compose-prod.yml down
docker context use default
