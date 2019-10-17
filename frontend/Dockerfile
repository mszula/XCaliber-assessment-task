FROM node:lts-alpine as build-stage

RUN npm install -g yarn

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN yarn build


FROM nginx:1.15-alpine as production-stage

COPY nginx.conf /etc/nginx/conf.d/default.conf

COPY --from=build-stage /app/dist /app/public

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]