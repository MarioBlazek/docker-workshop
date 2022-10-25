FROM node:18.10-alpine3.16

WORKDIR /app

RUN npm install -g serve

COPY package*.json .
RUN npm install

COPY . .

RUN npm run build

ENV API_URL=http://api.myapp.com

EXPOSE 3000


CMD ["serve", "-s", "build"]