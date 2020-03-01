[Go Back](INDEX.md)

## Recurring Feeding
For recurring feeding ability there is a command called `recurring:feeding`

When deploying on server make sure you schedule a cron job running daily basis 

    0 0 * * * php /project/artisan recurring:feeding

Or for local test run this command

    php artisan recurring:feeding
