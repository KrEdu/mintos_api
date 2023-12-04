Whats needed - composer and docker installed
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

1. ['GET']/api/account/{account_id}  - Gets specific account
2. ['GET']/api/account/{account_id}/transactions - Gets all transactions. Possible params 'limit' and 'offset'
3. ['POST']/api/account/{account_id}/transfer-funds - Transfer funds to another account.
                                                     Params needed:
                                                         'account_to' - other account id,
                                                         'amount' - number, '
                                                         currency' - 3 letter currency like EUR
