# Running multi-container Applications

## Intro

- explain project setup


docker-compose --version


- explain removing images and containers


docker images

docker image ls -q

docker image rm -f $(docker image ls -q)

docker container -rm -f $(docker container ls -a -q)

### Installing docker-compose


```bash
docker run --name CONTAINER_NAME -p 3306:3306 -e MYSQL_ROOT_PASSWORD=supersecret mysql:latest
```