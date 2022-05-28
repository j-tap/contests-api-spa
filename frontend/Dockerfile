FROM node:14.17.1 AS nodebuild

ADD package.json yarn.lock /tmp/

RUN cd /tmp && yarn
RUN mkdir -p /srv/app/ && cd /srv/app/ && ln -s /tmp/node_modules

COPY . /srv/app/
WORKDIR /srv/app/

ARG VUE_APP_API_URL=http://localhost:8000/api/v1

RUN yarn build

# -----
FROM nginx:1.17.8

COPY --from=nodebuild /srv/app/dist /var/www/html

EXPOSE 80
