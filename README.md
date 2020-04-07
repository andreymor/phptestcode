# PHP Test #

### Requirements ###
- docker and docker-compose;
- OR PHP 7.4, composer and MySQL (with proper env variables set - please check docker-compose.yml file) (if not using docker);

### How to ###

This project is mainly based on tests. Please check the code for more details.
Each folder contains specific tests to validate

If using docker:

- Initiate services

```docker-compose up -d```

- Install dependencies

```docker-compose exec php composer install```

- Run tests

```docker-compose exec php vendor/bin/phpunit```

If without docker

- Install composer

```composer install```

- Run the current DB creation (src/Database/Resources/database.sql) on your MySql instance
- Create proper env variables (check docker-compose.yml)

- Run the tests

```vendor/bin/phpunit```

- Usage of ABtesting is present at

```http://localhost:8090```


