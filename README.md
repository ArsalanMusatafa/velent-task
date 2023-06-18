# Setup and configuring the project

-   Run `composer install`
-   Run `cp .env.example .env`
-   Run `php artisan key:generate`

Make sure to update database credentials and set the APP_URL.


-   Run `php artisan optimize:clear`
-   Run `php artisan migrate` (Run `php artisan migrate:fresh` for fresh migrations)
-   Run `php artisan db:seed`
-   Run `php artisan serve`