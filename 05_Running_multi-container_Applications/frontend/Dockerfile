FROM node:18.10-alpine3.16

RUN addgroup quser && adduser -S -G quser quser

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN chown -R quser:quser /app
USER quser
ENV API_URL=http://api.myapp.com

EXPOSE 3000

CMD ["npm", "start"]