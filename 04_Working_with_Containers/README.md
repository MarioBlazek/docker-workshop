# Working with Containers

## Prerequisites

* To have a Docker image create in the last exercise

### Starting containers

List available images on local system:

```bash
docker images
```

Check which containers are currently running:

```bash
docker ps
```

Run a new container from image that was built in the previous exercise:

```bash
docker run react-app
```

Run a new container from image that was built in the previous exercise in detach mode and set some custom name:

```bash
docker run -d --name some-cool-name react-app
```

### Viewing the Logs

Fetch the logs of a container:

```bash
docker logs CONTAINER_ID
```
Fetch the logs of a container and follow log output:

```bash
docker logs -f CONTAINER_ID
```

Number of lines to show from the end of the logs:

```bash
docker logs -n5 CONTAINER_ID
```

Number of lines to show from the end of the logs, but also show timestamps:

```bash
docker logs -n5 -t CONTAINER_ID
```

### Publishing ports

```bash
docker run -d -p LOCAL_PORT:CONTAINER_PORT --name c1 react-app
```

### Executing commands

```bash
docker exec c1 ls
```

```bash
docker exec -it c1 sh
```

### Stopping and Starting Containers

```bash
docker stop CONTAINER_ID
```

```bash
docker start CONTAINER_ID
```

### Removing containers

```bash
docker container rm CONTAINER_ID
```

```bash
docker rm CONTAINER_ID
```

```bash
docker rm -f CONTAINER_ID
```

```bash
docker ps -a
```

```bash
docker container prune
```

### Volumes

```bash
docker volume create app-data
```

```bash
docker volume inspect app-data
```

```bash
docker run -d -p 4000:3000 -v app-data:/app/data react-app
```

### Copy files between the Host and Containers

```bash
docker cp CONTAINER_ID:/app/log.txt .
```

```bash
docker cp CONTAINER_ID:/app/log.txt .
```

```bash
docker cp secret.txt CONTAINER_ID:/app
```

### Sharing source code with a container

```bash
docker run -d -p 5001:3000 -v $(pwd):/app react-app
```

```bash
docker run -d -p 3003:3000 -v $(pwd)/src:/app/src -v $(pwd)/public:/app/public react-app
```