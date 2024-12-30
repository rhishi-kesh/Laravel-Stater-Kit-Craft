<p align="center">
    <h1 align="center">❤️Laravel Stater Kit❤️</h1>
</p>

## Introduction 😍

<p> A Laravel stater kit with a awesome admin panel setup, user login & logout, registation, status, delete, profile settings and system information and many more. </p>

## Contributor 😎

-   <a href="https://github.com/rhishi-kesh" target="_blank">Rhishi kesh</a>

## Installation 🤷‍♂

To Install & Run This Project You Have To Follow Thoose Following Steps:

```sh
git clone https://github.com/rhishi-kesh/Laravel-Stater-Kit-Craft.git
```

```sh
cd Laravel-Stater-Kit-Craft
```

```sh
composer update
```

Open your `.env` file and change the database name (`DB_DATABASE`) to whatever you have, username (`DB_USERNAME`) and password (`DB_PASSWORD`) field correspond to your configuration

```sh
php artisan key:generate
```

```sh
php artisan migrate:fresh --seed
```

```sh
php artisan optimize:clear
```

```sh
php artisan serve
```
For Admin Login `http://127.0.0.1:8000/admin` <br>
Admin gmail = `admin@admin.com` & password = `12345678`

For User Login `http://127.0.0.1:8000/admin` <br>
Admin gmail = `user@user.com` & password = `12345678`
