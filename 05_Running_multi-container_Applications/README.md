# Running multi-container Applications

In this part we are going to use the Docker Compose. It comes preinstalled with Docker Desktop. If for any reason you don't have it installed, please go to the Docker Compose install [page](https://docs.docker.com/compose/install/). To confim that every is installed properly, run this command:

```bash
docker-compose -v
```

It should output the version of currently installed Docker Compose.

## Intro

Our task is to create a Dockerized environment for project that consists of three components:
- frontend
- backend
- database

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

#### Enter `docker-compose.yaml` file

The Compose file is a YAML file defining services, networks, and volumes for a Docker application. The latest and recommended version of the Compose file format is defined by the [Compose Specification](https://docs.docker.com/compose/compose-file/).

Versioning

https://docs.docker.com/compose/compose-file/compose-versioning/

Environment variables

https://docs.docker.com/compose/environment-variables/


### Building images


```bash
docker-compose build
```

```bash
docker-compose build --no-cache
```

```bash
docker images
```

### Starting and Stopping the Application

```bash
docker-compose up
```

```bash
docker-compose up -d
```

```bash
docker-compose ps
```


```bash
docker-compose down
```

### Docker Networking

```bash
docker network ls
```

```bash
docker exec -it -u root CONTAINER_ID sh
```

And then use the ping utility to ping the backend container.

ifconfig

### Viewing Logs

```bash
docker-compose logs
```

```bash
docker-compose logs --help
```

```bash
docker-compose logs --help
```

### Migrating the Database

### Running Tests