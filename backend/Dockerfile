FROM alpine:3.10
LABEL Maintainer="Tim de Pater <code@trafex.nl>" \
      Description="Lightweight container with Nginx 1.16 & PHP-FPM 7.3 based on Alpine Linux."

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-pdo php7-pdo_mysql php7-mysqli php7-opcache php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-tokenizer php7-xmlreader php7-ctype php7-session php7-iconv \
    php7-mbstring php7-gd php7-simplexml nginx supervisor curl

# Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Configure nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY docker/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY docker/php.ini /etc/php7/conf.d/zzz_custom.ini

# Configure supervisord
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/tmp/nginx && \
  chown -R nobody.nobody /var/log/nginx

RUN mkdir /app && \
  mkdir /.composer && \
  chown -R nobody.nobody /app && \
  chown -R nobody.nobody /.composer

# Add application
WORKDIR /app

COPY --chown=nobody . .

# Switch to use a non-root user from here on
USER nobody

RUN composer install

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping