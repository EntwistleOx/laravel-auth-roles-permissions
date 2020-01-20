# Auth module with roles and permissions

An auth and role based permissions system in laravel with TDD tests. CRUD created for manage users, roles, permissions and their relationships.

## Installation

Download or clone this repo, then:

```
$| cd projectname
$| composer install
$| php artisan key:generate
```

Create a database and inform .env, then run migrations to create and populate tables:

```
$| php artisan migrate --seed 
```

To start the app: 

```
$| php artisan serve
```

To run tests:

```
$| ./vendor/bin/phpunit
```
