# Application deployment to AWS

## Prerequisites

### The AWS account

Go to the AWS and create your [account](https://aws.amazon.com/console/) there. Please be advised, running this exercise may incur some costs on your credit card.

### AWS Command Line Interface

The AWS Command Line Interface (AWS CLI) is a unified tool to manage your AWS services. With just one tool to download and configure, you can control multiple AWS services from the command line and automate them through scripts.

Check [this](https://docs.aws.amazon.com/cli/latest/userguide/getting-started-install.html) guide for install instructions, and [this](https://docs.aws.amazon.com/cli/latest/userguide/cli-configure-quickstart.html#cli-configure-quickstart-config) one for configuring it.

### Docker Compose CLI

This Compose CLI tool makes it easy to run Docker containers and Docker Compose applications in the cloud using either. Please follow the install [instructions](https://github.com/docker/compose-cli/blob/main/INSTALL.md) for setting it up.


## Building the cloud environment

> The example assumes the us-east-1 AWS Region.

Create a new Docker context that is of type `ecs`:

```shell
docker context create ecs docker-workshop-ecs
```

More info about Docker Context can be found [here](https://docs.docker.com/engine/context/working-with-contexts/).

To confirm that we have successfully create our custom Docker Context, run the following command:

```shell
docker context ls
```

And finally, switch to the new Docker Context:

```shell
docker context use docker-workshop-ecs
```

Login to the ECR from the local Docker daemon:

> Replace the AWS_ACCOUNT_ID with your AWS account ID

```shell
aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com
```

Create repositories that will hold our images:

```shell
aws ecr create-repository --repository-name docker-workshop-frontend --image-scanning-configuration scanOnPush=false --region us-east-1
aws ecr create-repository --repository-name docker-workshop-backend --image-scanning-configuration scanOnPush=false --region us-east-1
```

Build Docker images:

```shell
docker context use default
docker-compose -f docker-compose-dev.yml build
```

Let's apply proper tag to our images:

```shell
docker tag ecs-application_backend:latest AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
docker tag ecs-application_frontend:latest AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend
```

And finally push images to the AWS ECR:

```shell
docker push AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-backend
docker push AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/docker-workshop-frontend
```

From this point we are ready to launch our application. Let's switch the context and fire up the `Docker Compose`:

> We are using the prod version of docker-compose file here

```shell
docker context use docker-workshop-ecs
docker compose -f docker-compose-prod.yml up
```

That's it. Login to the AWS account, search for `EC2`, and from the left menu select the `Load Balancers` section. There should be your newly created load balancer and its public URL, something like this http://ecs-a-loadb-91sn7c43pqld-7f66682b4a2bbbd3.elb.us-east-1.amazonaws.com. And Voila!

In case when you need to deploy newly create changes to the AWS, repeat the process and the Fargate will do a Rolling update of your app.

To shutdown everything just run the `down` command:

```shell
docker context use docker-workshop-ecs
docker compose -f docker-compose-prod.yml down
```

## Cleanup

To remove the ECR repository with all published images:

```shell
aws ecr delete-repository --repository-name docker-workshop --force --region us-east-1
```

In case if something goes wrong, use this command as the safeguard (it will remove all AWS resources):

```shell
aws cloudformation delete-stack --stack-name ecs-application --retain-resources DefaultNetwork
```