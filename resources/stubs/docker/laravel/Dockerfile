FROM dunglas/frankenphp:1-php8.5

RUN apt-get update \
  && apt-get install -y --no-install-recommends git unzip libpq-dev \
  && docker-php-ext-install pdo_pgsql \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:22.13-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22.13-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -sf ../lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
  && ln -sf ../lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

WORKDIR /workspace/app

CMD ["sh", "-lc", "[ -f .env ] || cp .env.example .env; composer install --no-interaction --prefer-dist && php artisan key:generate --force && php artisan migrate --force && frankenphp php-server -r public/ --listen 0.0.0.0:80"]
