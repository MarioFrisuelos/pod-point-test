# Podpoint API

In order to isntall the api run the following commands in that order.
I assume the db has been created already. 

## Install

```
  composer install
  php bin/console doctrine:migrations:migrate
```

## Run the fixtures with: 

```
  php bin/console doctrine:fixtures:load
```

## About you

* **First name:** `Mario`
* **Last name:** `Frisuelos`