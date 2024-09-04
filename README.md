# FrankenPHP Demo

A demo app using [FrankenPHP](https://frankenphp.dev) that uses
Symfony and API Platform.

## Installation

### Composer

Install composer dependencies:

```console
docker run --rm -it -v $PWD:/app composer:latest install
```

Or if you have composer installed locally:

```console
composer install
```

```console
docker run --rm -it -v $PWD:/app composer:latest require nelmio/api-doc-bundle

docker compose exec frankenphp-admin /bin/sh -c 'chmod +x bin/console'
docker compose exec frankenphp-admin /bin/sh -c 'php bin/console doctrine:schema:update --dump-sql --complete'

docker compose exec frankenphp-admin /bin/sh -c 'php bin/console cache:clear'
```

### The project

Run the project with Docker (worker mode):

```console
docker run \
    -e FRANKENPHP_CONFIG="worker ./public/index.php" \
    -v $PWD:/app \
    -p 80:80 -p 443:443/tcp -p 443:443/udp \
    --name FrankenPHP-admin \
    dunglas/frankenphp
```

**PS**: Docker is optional; you can also compile
[FrankenPHP](https://github.com/dunglas/frankenphp/blob/main/docs/compile.md)
by yourself.

Create the database (It uses a local SQLite database stored in `var/data.db`):

```console
docker exec -it FrankenPHP-admin php bin/console doctrine:migrations:migrate --no-interaction
```

Then you can access the application:

* [Hello world page](https://localhost)
* [API Platform](https://localhost/api)
* [API Platform: collection of monsters (GET/JSON-LD)](https://localhost/api/monsters.jsonld)

This demo is a standard Symfony application and works without FrankenPHP.
Therefore, you can serve it with the Symfony CLI:

```console
symfony serve
```

The repository also includes [a benchmark](benchmark) comparing FrankenPHP and PHP-FPM.

### Composer SonataAdminBundle
* [Sonata admin page](https://localhost/admin)

```console
docker run --rm -it -v $PWD:/app composer:latest require sonata-project/admin-bundle
docker run --rm -it -v $PWD:/app composer:latest require sonata-project/doctrine-orm-admin-bundle
docker exec -it FrankenPHP-admin php bin/console cache:clear
docker exec -it FrankenPHP-admin php bin/console assets:install

docker exec -it FrankenPHP-admin php bin/console doctrine:schema:update --dump-sql
docker exec -it FrankenPHP-admin php bin/console doctrine:schema:update --dump-sql --force
docker exec -it FrankenPHP-admin php bin/console doctrine:schema:create
```
or
```console
docker run --rm -it -v $PWD:/app composer:latest install
```

## Package as a Standalone Binary

The demo app can be packaged as a self-contained binary containing
the Symfony app, FrankenPHP and the PHP extensions used by the app.

To do so, the easiest way is to use the provided `Dockerfile`:

```console
docker build -t static-app -f static-build.Dockerfile .
docker cp $(docker create --name static-app-tmp static-app):/go/src/app/dist/frankenphp-linux-x86_64 frankenphp-demo ; docker rm static-app-tmp
```

The resulting binary is the `frankenphp-demo` file in the current directory.
It can be started with the following commands:

```console
chmod +x ./frankenphp-demo
./frankenphp-demo php-server
```

It's also possible to run commands with `./frankenphp-demo php-cli bin/console`.
