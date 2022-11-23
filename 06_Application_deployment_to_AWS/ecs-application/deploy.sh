#!/usr/bin/env bash

set -e

read -rp 'Enter AWS Account ID: ' AWS_ACCOUNT_ID

# set AWS account ID as the env variable for this session
export AWS_ACCOUNT_ID=$AWS_ACCOUNT_ID

# assure that we use the default context and build docker images
docker context use default
docker-compose -f docker-compose-dev.yml build

# tag images by using the AWS convention
docker tag ecs-application_backend:latest "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
docker tag ecs-application_frontend:latest "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend

# login to ECR
aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com

# push images to ECR
docker push "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
docker push "$AWS_ACCOUNT_ID".dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend

# deploy
docker context use docker-workshop-ecs
docker compose -f docker-compose-prod.yml up
docker context use default