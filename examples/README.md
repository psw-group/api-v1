# Examples

In order to run the examples modify the file _client.php_ and insert your client ID and your client secret:

``` php
return new TestClient(
    '[yourClientId]',
    '[yourClientSecret]'
);
```

Some example require an existing certificate or an existing order:

| Example                                   |  Requirements         |
|-------------------------------------------|-----------------------|
| _load-certificate-chain.php_              | valid certificate     |
| _load-certificate-csr-data.php_           | any certificate       |
| _load-certificate-validation-data.php_    | any SSL certificate   |
| _load-certificate-validation-data.php_    | any SSL certificate   |
| _load-certificate-validation-methods.php_ | any SSL certificate   |
| _load-order-items.php_                    | any order             |
