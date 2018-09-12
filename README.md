# rest-api-symfony4
Test project for REST API using Symfony 4

### Working solutions to this problem:
https://docs.google.com/document/d/11tb8EX_XpGsUChkhvIlvGpwaSXey7wJq4HCsxRLEYlA/edit


### Run migrations
php bin/console doctrine:migrations:migrate

### Run fixtures
php bin/console doctrine:fixtures:load

## JWT Authentication Bundle:
https://github.com/lexik/LexikJWTAuthenticationBundle

You have to crete user/password for JWT authentication and get token. Just follow these instructions:
https://github.com/chalasr/lexik-jwt-authentication-sandbox

Use the token for all your API calls.

### PHPUnit
php bin/phpunit tests/Controller/Api/


### Resources
- https://restfulapi.net/resource-naming/
- https://knpuniversity.com/screencast/rest/intro
- https://knpuniversity.com/screencast/symfony-rest
- https://knpuniversity.com/screencast/symfony-rest2
- https://knpuniversity.com/screencast/symfony-rest3
- https://knpuniversity.com/screencast/symfony-rest4
- https://knpuniversity.com/screencast/symfony-rest5

##### (c) 2018 * Peter Dolinaj