# Bot Factory

## Installation

- Clone Repo
- Create a Database called `bot_factory`
- Clone `.env.example` to `.env` and add your database credentials
- Open a Terminal / Command Prompt window at repo root
- Run `composer install`
- Run `php artisan migrate`
- Run `npm run dev`
- Run `php artisan serve` in another window or run a XAMPP / NGINX / Apache server yourself
- Navigate to `http://localhost` / `http://localhost:3000` / `http://localhost:8000` or `/public` if the public folder is not configured on your server (check your server requirements as defined by the server documentation)
- If you get the Laravel Welcome page then the site is running successfully
- For additional tests run `./vendor/bin/phpunit` from repo root

## Usage

You will need to import data first. This can be done by executing the following commands from the command line at the repo root:

```
php artisan import:api
php artisan import:csv
```
Note: The orders.csv file will need to be placed in the storage folder to import. One has been provided in the repo

- You can then navigate to any of the following URLs:

```
http://localhost/customers
http://localhost/customer/{id}/orders
http://localhost/order/{id}
```

- The customers page lists all customers (each customer has 1 order except customer: 530 which has 2)
- The order page details the order information including total weight, products in an order and allows editting the Bot Name by clicking `EDIT` and saving by clicking `SAVE` next to the bot name.
