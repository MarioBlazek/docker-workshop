# Application deployment to AWS

WIP.

https://docs.aws.amazon.com/cli/latest/userguide/getting-started-install.html

https://docs.aws.amazon.com/cli/latest/userguide/cli-configure-quickstart.html#cli-configure-quickstart-config


https://github.com/docker/compose-cli/blob/main/INSTALL.md


docker context create ecs docker-workshop-ecs

docker context ls

docker context use docker-workshop-ecs

aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com

Create repositories that will hold our images:

```bash
aws ecr create-repository --repository-name docker-workshop-frontend --image-scanning-configuration scanOnPush=false --region us-east-1
aws ecr create-repository --repository-name docker-workshop-backend --image-scanning-configuration scanOnPush=false --region us-east-1
```

Build Docker images

```bash
docker-compose -f docker-compose-dev.yml build
```

Let's apply proper tag to our images

```bash
docker tag ecs-application_backend:latest AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
docker tag ecs-application_frontend:latest AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend
```

And finally push images to AWS ECR:

```bash
docker push AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
docker push AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend
```

docker push AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop


image: AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend



Removing repository:

aws ecr delete-repository --repository-name docker-workshop --force --region us-east-1


aws cloudformation delete-stack --stack-name ecs-application --retain-resources DefaultNetwork