# Running multi-container Applications

In this part we are going to use the Docker Compose. It comes preinstalled with Docker Desktop. If for any reason you don't have it installed, please go to the Docker Compose install [page](https://docs.docker.com/compose/install/). To confirm that everything is installed properly, run this command:

```bash
docker-compose -v
```

It should output the version of currently installed Docker Compose.

## Intro

Our task is to create a Dockerized environment for a project that consists of three components:
- frontend - React app
- backend - Symfony app
- database - MySQL

### Cleaning up our workspace

In the previous exercises we have generated many images and containers. Most of the are quite obsolete by now. Let's check some techics which can help you with cleaning up your workspace.
First, let's see all available Docker images on our system:

```bash
docker images
```

And the running containers:

```bash
docker ps
```

To remove Docker containers we can of course use the `docker image rm` command:

```bash
docker image rm IMAGE_ID_1 IMAGE_ID_2
```

It is a bit painful to delete every image by corresponding ID. So Docker allows us to on list image id's this way:

```bash
docker image ls -q
```

And then we can pass the results of that command to the `docker image rm` command:

```bash
docker image rm -f $(docker image ls -q)
```

The same principle we apply when removing containers:

```bash
docker container -rm -f $(docker container ls -a -q)
```

### Running app without Dockerized environment

Database can be installed on a host machine, or ran as the standalone container:

```bash
docker run --name CONTAINER_NAME -p 3306:3306 -e MYSQL_ROOT_PASSWORD=supersecret mysql:latest
```

After that we need to install backend dependencies:

```bash
composer install
```

Then create the database:

```bash
bin/console doctrine:database:create
```

Create all required tables:

```bash
bin/console doctrine:migrations:migrate
```

And finally load the fixtures:

```bash
bin/console doctrine:fixtures:load
```

Database and backend setup is complete, let's process to the frontend. Frontend requires two steps, dependency installation and running web server:

```bash
npm install
```

Start web server:

```bash
npm start
```

### Enter `docker-compose.yaml` file

The Compose file is a YAML file defining services, networks, and volumes for a Docker application. The latest and recommended version of the Compose file format is defined by the [Compose Specification](https://docs.docker.com/compose/compose-file/).

The Compose file consists of six top-level elements:
- [version](https://docs.docker.com/compose/compose-file/#version-top-level-element)
- [name](https://docs.docker.com/compose/compose-file/#name-top-level-element)
- [services](https://docs.docker.com/compose/compose-file/#services-top-level-element)
- [networks](https://docs.docker.com/compose/compose-file/#networks-top-level-element)
- [volumes](https://docs.docker.com/compose/compose-file/#volumes-top-level-element)
- [configs](https://docs.docker.com/compose/compose-file/#configs-top-level-element)
- [secrets](https://docs.docker.com/compose/compose-file/#secrets-top-level-element)

Environment variables

https://docs.docker.com/compose/environment-variables/


### Building images

When we are done with the `docker-compose.yml` file, it is time for building containers:

```bash
docker-compose build
```

Or to force Docker to ignore any cached layers:

```bash
docker-compose build --no-cache
```

To inspect the final results see the images:

```bash
docker images
```

### Starting and Stopping the Application

To start containers specified in the `docker-compose.yml`, run the following:

```bash
docker-compose up
```

Or to do the same, but in the daemon mode:

```bash
docker-compose up -d
```

Let's inspect running containers:

```bash
docker-compose ps
```

To stop containers use the `stop` command:

```bash
docker-compose stop
```

Or to stop and remove containers use the `down` command:

```bash
docker-compose down
```

### Docker Networking

Inspect networking setup:

```bash
docker network ls
```

Enter container as `root`:

```bash
docker exec -it -u root CONTAINER_ID sh
```

And then use the ping utility to ping the backend container.

### Viewing Logs

This simple command can help us retrieving the container logs when running in daemon mode:

```bash
docker-compose logs
```

For more options you can check help page:

```bash
docker-compose logs --help
```