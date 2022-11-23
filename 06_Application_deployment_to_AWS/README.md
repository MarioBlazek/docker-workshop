# Application deployment to AWS

### Prerequisites

#### AWS Command Line Interface

The AWS Command Line Interface (AWS CLI) is a unified tool to manage your AWS services. With just one tool to download and configure, you can control multiple AWS services from the command line and automate them through scripts.

Check [this](https://docs.aws.amazon.com/cli/latest/userguide/getting-started-install.html) guide for install instructions, and [this](https://docs.aws.amazon.com/cli/latest/userguide/cli-configure-quickstart.html#cli-configure-quickstart-config) one for configuring it.

#### Docker Compose CLI

This Compose CLI tool makes it easy to run Docker containers and Docker Compose applications in the cloud using either. Please follow the install [instructions](https://github.com/docker/compose-cli/blob/main/INSTALL.md) for setting it up.


### Building the cloud environment

Create a new Docker context that is of type `ecs`:

```bash
docker context create ecs docker-workshop-ecs
```

More info about Docker Context can be found [here](https://docs.docker.com/engine/context/working-with-contexts/).

To confirm that we have successfully create our custom Docker Context, run the following command:

```bash
docker context ls
```

And finally, switch to the new Docker Context:

```bash
docker context use docker-workshop-ecs
```

```bash
aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com
```

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

In case if something goes wrong, use this command as the safeguard (it will remove all AWS resources):

```bash
aws cloudformation delete-stack --stack-name ecs-application --retain-resources DefaultNetwork
```