[![Current version](https://img.shields.io/packagist/v/maatify/smseg)][pkg]
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/maatify/smseg)][pkg]
[![Monthly Downloads](https://img.shields.io/packagist/dm/maatify/smseg)][pkg-stats]
[![Total Downloads](https://img.shields.io/packagist/dt/maatify/smseg)][pkg-stats]
[![Stars](https://img.shields.io/packagist/stars/maatify/smseg)](https://github.com/maatify/smseg/stargazers)

[pkg]: <https://packagist.org/packages/maatify/smseg>
[pkg-stats]: <https://packagist.org/packages/maatify/smseg/stats>
# Installation

```shell
composer require maatify/smseg
```

# Usage

### Instance
```php
use Maatify\SmsEG\SmsEG;

require_once __DIR__ . '/vendor/autoload.php';

$sms_eg = new SmsEG(__USERNAME__, __PASSWORD__, __SENDER_NAME__); // SmsEG instance
```



#
### Check Balance
```PHP

$result = $sms_eg->CheckBalance();

print_r($result);
```
#### Response Example :
##### Success Example
>       Array
>       (
>           [type] => success
>           [message] => Your balance id 612.88L.E
>           [data] => Array
>               (
>                   [balance] => 612.88
>                   [currency] => L.E
>                   [points] => 2918
>               )
>           [success] => 1
>       )

##### Error Example
>
>       Array
>       (
>            [type] => error
>            [error] => Array
>                (
>                    [msg] => Not found username or wrong password !.
>                    [number] => 201
>                )
>            [data] => 
>            [success] => 
>        )

#

### Send SMS Message
```PHP

$result = $sms_eg->SendSms(__PHONE_NUMBER__, __SMS_MESSAGE__);

print_r($result);
```
#### Response Example :
##### Success Example
>       Array
>       (
>            [0] => Array
>                (
>                    [type] => success
>                    [msg] => Your message was sent !
>                    [data] => Array
>                        (
>                            [smsid] => 82143558
>                            [sent] => 1
>                            [failed] => 0
>                            [reciver] => __PHONE_NUMBER__
>                        )
>                )
>        
>            [success] => 1
>        )

##### Error Example
>
>       Array
>       (
>           [type] => error
>           [error] => Array
>            (
>                [msg] => Invalild Recipients Mobile Numbers !
>                [number] => 100
>            )
>        
>            [data] => 
>            [success] => 
>        )

>
>       Array
>       (
>            [type] => error
>            [error] => Array
>                (
>                    [msg] => Unapproved Sender ID !
>                    [number] => 301
>                )
>        
>            [data] => 
>            [success] => 
>        )








