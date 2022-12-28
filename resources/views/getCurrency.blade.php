<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <a href="getfromapi" class="btn btn-xs btn-info pull-right">Request data from API</a>
        <?php
        foreach($exchangeRates as $currency){
            echo '<p>name = '.$currency['name'].', currency_code = '.$currency['currency_code'].', exchange_rate = '.$currency['exchange_rate'].'</p>';
        }
        ?>
    </body>
</html>
