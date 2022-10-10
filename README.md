# Cupola Fullstack Assessment

## Installation

Clone the repo locally:

```sh
git clone https://github.com/epessine/cupola-fullstack-assessment.git cupola-fullstack-assessment
cd cupola-fullstack-assessment
```

Setup configuration:

```sh
cp .env.example .env
```

Create an SQLite database.

```sh
touch database/database.sqlite
```

Install PHP dependencies:

```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Run Laravel Sail:

```sh
./vendor/bin/sail up
```

Install NPM dependencies:

```sh
./vendor/bin/sail npm ci
```

Build assets:

```sh
./vendor/bin/sail npm run build
```

Generate application key:

```sh
./vendor/bin/sail artisan key:generate
```

Run database migrations and seeders:

```sh
./vendor/bin/sail artisan migrate:fresh --seed
```

You're ready to go (http://localhost/)! Login with:

-   **Username:** assessment@cupola.com
-   **Password:** password

#

## Running tests

To run tests, run:

```
./vendor/bin/sail test
```
