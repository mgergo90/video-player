# ------------------------- PRODUCTION ------------------------------------
FROM node:carbon-jessie as production

WORKDIR /srv/app

RUN npm install -g laravel-echo-server

COPY build/websocket/laravel-echo-server.json /srv/app

RUN laravel-echo-server start
CMD ["tail", " -f /dev/null"]
