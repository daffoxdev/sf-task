
Steps to set up:
```shell
make up
```

```shell
make bash bin/console d:m:migrate --no-interaction
```

https://github.com/lexik/LexikJWTAuthenticationBundle/blob/2.x/Resources/doc/index.rst#generate-the-ssl-keys
```shell
make bash bin/console lexik:jwt:generate-keypair --skip-if-exists
```

```shell
make bash bin/console doctrine:fixtures:load
```

Go to `localhost:8085/api/docs`

User to use API:
username: api
password: api