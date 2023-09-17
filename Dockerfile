FROM php:8.0-apache
WORKDIR /var/www/html

COPY . .

# Common extensions
RUN apt update
RUN apt install zip libzip-dev -y
RUN docker-php-ext-install pdo_mysql zip

# Enable mod_rewrite for images with apache
RUN if command -v a2enmod >/dev/null 2>&1; then \
       a2enmod rewrite headers \
   ;fi

# Composer install
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.json
RUN composer install --no-dev

COPY --from=python:3.9 /usr/bin/python3 /usr/bin/python3
RUN apt install pip python3-venv -y

ENV VIRTUAL_ENV=/var/www/html/env
RUN python3 -m venv $VIRTUAL_ENV
ENV PATH="$VIRTUAL_ENV/bin:$PATH"
RUN pip install nltk tensorflow
RUN python -m nltk.downloader punkt stopwords omw-1.4 wordnet
RUN cp -r /root/nltk_data /var/www/nltk_data

EXPOSE 80
EXPOSE 443
EXPOSE 3306