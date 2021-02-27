## Installation
To install all dependencies, run:
```bash
docker-compose run --rm composer install
```

To run application itself, run:
```bash
docker-compose run --rm php php index.php
```

To run Behat tests, run:
```bash
docker-compose run --rm php ./vendor/bin/behat
```

To run ECS check, run:
```bash
docker-compose run --rm php ./vendor/bin/ecs check
```

To make the changes, add --fix:
```bash
docker-compose run --rm php ./vendor/bin/ecs check --fix
```

To run Rector check, run:
```bash
docker-compose run --rm php vendor/bin/rector process src --dry-run
```

To make the changes, drop --dry-run:
```bash
docker-compose run --rm php vendor/bin/rector process src
```

![CLI example](https://i.imgur.com/1mQFStj.png)

## What's new:
_The game_ has been upgraded to PHP 8 and I checked what's new in this PHP version. While developing the application, I wanted to check out Github flow, Github Action and dependabot for myself. _The game_ has new features such as:
* Hyperspace Jumps - You can choose jump distance and then the exact planet
* Refueling a spaceship - Now you can refuel the spaceship to full
* Selection of the spaceship, difficulty level etc. - all editable in `.yaml` files
* Route map - Now you can view a list of planets
* Capital - Don't lose all your money

And more...
