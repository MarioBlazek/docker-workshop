#!/usr/bin/env bash

docker run --name docker_workshop_5_db -p 3306:3306 -e MYSQL_ROOT_PASSWORD=kiflica mysql:latest