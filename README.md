Whats needed - composer and docker installed <br>
How to launch me: 
1. Copy this project content into your folder
2. Launch trough your terminal inside source folder: composer install
3. Launch: docker compose up -d
4. Launch: symfony console doctrine:migrations:migrate
5. Launch: symfony server:start


API endpoints: (BASE URL localhost:8000)

1. ['GET']/api/clients  - Gets list of all clients
2. ['GET']/api/clients/{client_id} - Gets specific client
3. ['GET']/api/clients/{client_id}/accounts  - Gets accounts for that client


1. ['GET']/api/accounts/{account_id}  - Gets specific account
2. ['GET']/api/accounts/{account_id}/transactions - Gets all transactions. Possible params 'limit' and 'offset'
3. ['POST']/api/accounts/{account_id}/transfer-funds - Transfer funds to another account.<br>
                                                     Params needed:<br>
                                                         'account_to' - other account id,<br>
                                                         'amount' - number, <br>
                                                         'currency' - 3 letter currency like EUR<br>

POSSIBLE PROBLEMS:
1. If database url is changed (like port) could brake all of this. IF so then change the port in .env file.
2. Api key might not be working. Can be generated here https://v6.exchangerate-api.com/, and needs to be added under .env as EXCHANGE_CURRENCY_API_KEY variable


What else needed to be done - 
1. Transfer the project itself into a docker conteiner
2. Write some tests :)
3. Make something like a cron job so that transactions that are left on pending status (my way of making sure, that even if the exchange api is down, the transaction is still viable) are actually processed later when the exchange api is up
