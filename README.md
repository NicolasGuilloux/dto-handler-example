# DTO Handler example

This is an example of the [DTO Handler Bundle](https://github.com/chaplean/dto-handler-bundle) maintained by me.

A live example is available over there: [http://dto-handler.nicolasguilloux.eu](http://dto-handler.nicolasguilloux.eu)

## Installation

Start the docker image. You will need the port 80 to be available.

```
docker-compose up -d
```

Install the libraries using composer inside the container (or prepend the command with `docker-compose exec application`).

```
composer install
```

Create the database, execute the migrations and populate it by executing the following command in the container (or prepend each commands with `docker-compose exec application`.

```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
```