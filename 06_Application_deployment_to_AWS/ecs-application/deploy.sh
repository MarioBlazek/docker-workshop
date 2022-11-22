#!/usr/bin/env bash

set -e

read -rp 'Enter AWS Account ID: ' AWS_ACCOUNT_ID

export AWS_ACCOUNT_ID=$AWS_ACCOUNT_ID

docker context use default
docker-compose -f docker-compose-dev.yml build

docker tag ecs-application_backend:latest "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
docker tag ecs-application_frontend:latest "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend

aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com

docker push "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
# shellcheck disable=SC2086
docker push $AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend


docker context use docker-workshop-ecs
docker compose -f docker-compose-prod.yml up