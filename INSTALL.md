## Start app in Docker

> ./vendor/bin/sail up
> 
> ./vendor/bin/sail artisan migrate
> 
>  ./vendor/bin/sail artisan db:seed

## Stop Docker

> ./vendor/bin/sail stop

## Get wallet balance

> GET http://localhost/api/wallet/1

## Credit or debit wallet

> POST http://localhost/api/wallet/1
> 
```json
{
    "amount": 50.0,
    "currency": "USD|RUB",
    "type": "credit|debit",
    "reason": "stock|refund|gift"
}
```

## Command to update currency rates

> ./vendor/bin/sail artisan app:update-currency-rates
