## Installation
To install all dependencies, run:
```bash
docker-compose run -w /application composer install
```

To run application itself, run:
```bash
docker-compose up -d php
docker exec -w /application -it hyperdrive-php php index.php
```

To Behat run tests, run:
```bash
docker-compose up -d php
docker exec -w /application -it hyperdrive-php ./vendor/bin/behat
```

![CLI example](https://i.imgur.com/1mQFStj.png)

## The reason behind
I just wanted to check out PHP 7.4 (especially new arrow functions and typed properties), League's CLImate library, Behat testing and running entire console PHP project from Docker. It was fun.

Someday probably I'll extend _the game_ itself, just for the fun.