# Working with Containers

## Prerequisites

* Latest [NodeJS](https://nodejs.org/en/)
* The [npm](https://www.npmjs.com/) package manager


### Installing NodeJS and npm

To install NodeJS and npm, we are going to use the NVM (Node Version Manager). NVM is a bash script that allows you to manage multiple Node.js versions on a per-user basis. With NVM you can install and uninstall any Node.js version that you want to use or test.

First, install the NVM:

```bash
wget https://raw.githubusercontent.com/nvm-sh/nvm/master/install.sh
bash install
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

Our project is a simple React based app. It was created by the [Create React App] tool. And task in hand is to create a Docker image of this web application.

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

At this point browser should open with URL [http://localhost:3000/](http://localhost:3000/).