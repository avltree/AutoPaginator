FROM php:5.5-alpine

RUN apk update && apk add bash
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir /paginator
WORKDIR /paginator

CMD ["php", "-a"]
