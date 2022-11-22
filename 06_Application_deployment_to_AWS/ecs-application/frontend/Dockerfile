FROM node:18.10-alpine3.16

WORKDIR /app

RUN npm install -g serve

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build


EXPOSE 80

CMD ["serve", "-p", "80", "-s", "build"]