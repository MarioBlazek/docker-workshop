# Building images

## Prerequisites

* Latest [NodeJS](https://nodejs.org/en/)
* The [npm](https://www.npmjs.com/) package manager


### Installing NodeJS and npm

To install NodeJS and npm, we are going to use the NVM (Node Version Manager). NVM is a bash script that allows you to manage multiple Node.js versions on a per-user basis. With NVM you can install and uninstall any Node.js version that you want to use or test.

First, install the NVM:

```bash
wget https://raw.githubusercontent.com/nvm-sh/nvm/master/install.sh
chmod +x install.sh
bash install.sh
source ~/.bashrc
```

Confirm that NVM is working fine:

```bash
nvm -v
```

Should output the current NVM's version.

And finally, install the lastest NodeJS:

```bash
nvm install node
```

Both NodeJS and npm should be install by the previous command. To confirm that, run the following:

```bash
node -v
npm -v
```

That's it.

## Project

Our project is a simple React based app. It was created by the [Create React App](https://create-react-app.dev/) tool. And task in hand is to create a Docker image of this web application.

### Initialize application

To initialize the application, run the following:

```bash
npm init react-app YOUR_APP_NAME
```

Enter the `YOUR_APP_NAME` directory and start the web server:

```bash
cd YOUR_APP_NAME
npm start
```

Alternatively, you can create a production [build](https://create-react-app.dev/docs/deployment#static-server) an use the `serve` tool to server the assets.

At this point browser should open with URL [http://localhost:3000/](http://localhost:3000/).


### Dockerfile instructions

Complete Dockerfile reference can be found [here](https://docs.docker.com/engine/reference/builder/).

Some interesting instructions:

* [FROM](https://docs.docker.com/engine/reference/builder/#from) - Specifies a base image 
* [RUN](https://docs.docker.com/engine/reference/builder/#run) - Executes operating system commands 
* [CMD](https://docs.docker.com/engine/reference/builder/#cmd) - Command that should be executed when we start a container
* [EXPOSE](https://docs.docker.com/engine/reference/builder/#expose) - Defines container port 
* [ENV](https://docs.docker.com/engine/reference/builder/#env) - Set's an environment variable
* [COPY](https://docs.docker.com/engine/reference/builder/#copy) - Used for adding files and directories from host  
* [ADD](https://docs.docker.com/engine/reference/builder/#add) - Same as COPY, with posibility of adding files from the remote URLs
* [ENTRYPOINT](https://docs.docker.com/engine/reference/builder/#entrypoint) - Same as CMD, but this one can't be easily overriden with docker command argument
* [USER](https://docs.docker.com/engine/reference/builder/#user) - Specifies user that should run the app 
* [WORKDIR](https://docs.docker.com/engine/reference/builder/#workdir) - Defines a working directory     

### Node images

We can check on Node Docker Hub [page](https://hub.docker.com/_/node) to find version of Node image that would suit us best. I have filtered two most interesting, the one based on [Debian](https://www.debian.org/), and the other one based on [Alpine Linux](https://www.alpinelinux.org/):

* [node:18-buster](https://hub.docker.com/layers/library/node/18-buster/images/sha256-75618980bd17e77fccfb6343064bc250f10c37a1229cd5492098e6c4d56f029f?context=explore)
* [node:18-alpine](https://hub.docker.com/layers/library/node/18-alpine/images/sha256-d51f2f5ce2dc7dfcc27fc2aa27a6edc66f6b89825ed4c7249ed0a7298c20a45a?context=explore)

### Building image

To build the image, from the current Docker context, run the following:

```bash
docker build -t YOUR_IMAGE_NAME .
```

After the successful build, inspect your image list:

```bash
docker images ls
```

or simply:

```bash
docker images
```

It is always good thing to inspect the layers of a Docker image, it can be done by running the `history` command:

```bash
docker history YOUR_IMAGE_NAME
```

### Starting container

To the container from previously built images, run:

```bash
docker run -it -p 3000:3000 YOUR_IMAGE_NAME
```

Open the [http://0.0.0.0:3000](http://0.0.0.0:3000) URL in your browser and you should be able to see React logo.

You can enter directly to a shell session:

```bash
docker run -it YOUR_IMAGE_NAME sh
```

Notice the `sh` as the shell identifier. This is because we are using the Alping Linux which promotes minimalism and doesn't have `bash` installed by default.

And finally to see which containers are running on your system, run:

```bash
docker ps
```

### Tagging images

There two ways to tag the image. First, we can do it while building an image:

```bash
docker build -t YOUR_IMAGE_NAME:VERSION .
```

Or anytime afer by running: 

```bash
docker image tag YOUR_IMAGE_NAME YOUR_IMAGE_NAME:VERSION
```

### Removing images

List images:

```bash
docker images
```

Remove all stopped containers:

```bash
docker container prune
```

Remove all dangling images:

```bash
docker image prune
```

Remove specific image:

```bash
docker image rm YOUR_IMAGE_NAME
```

You can also remove image by the image id (long hash string), just replace `YOUR_IMAGE_NAME` with id in the previous command.

Clear build cache:

```bash
docker builder prune
```

Do a clean slate:

```bash
docker system prune -a
```


### Homework

Application uses root user currently. From the security perspective this is not exceptable. Introduce a new user for installing dependecies and serving static files.

Hints: `adduser`, `chmod`, `USER`.