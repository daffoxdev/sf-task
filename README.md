Technologies used:
* Symfony 6
* PHP 8
* apache
* postgreSQL
* docker, docker-compose
* api-platform
* JWT
* symfony messenger
* swagger

## Steps to set up:

#### Get up dockerized containers
```shell
make up
```

#### Go into container with code
```shell
make container
```

#### Run database migrations
```shell
bin/console d:m:migrate --no-interaction
```

#### Generate the SSL keys
https://github.com/lexik/LexikJWTAuthenticationBundle/blob/2.x/Resources/doc/index.rst#generate-the-ssl-keys
```shell
bin/console lexik:jwt:generate-keypair
```

#### Fill DB with some initial data
```shell
bin/console doctrine:fixtures:load
```

#### Fill free to test api via swagger ui or using postman
Go to `localhost:8085/api/docs`

## User to use API:
* username: **api**
* password: **api**