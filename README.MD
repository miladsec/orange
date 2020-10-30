# kavenegar sms

![image](https://panel.kavenegar.com/public/images/Kavenegar-Newface.png)

[![Latest Stable Version](https://poser.pugx.org/miladzamir/orange/v)](//packagist.org/packages/miladzamir/orange) [![Total Downloads](https://poser.pugx.org/miladzamir/orange/downloads)](//packagist.org/packages/miladzamir/orange) [![Latest Unstable Version](https://poser.pugx.org/miladzamir/orange/v/unstable)](//packagist.org/packages/miladzamir/orange) [![License](https://poser.pugx.org/miladzamir/orange/license)](//packagist.org/packages/miladzamir/orange)

### Installation:
```
composer require miladzamir/orange

php artisan vendor:publish

php artisan migrate

add KAVENEGAR_API_KEY="API TOKEN" to .env

```

### Example Usage:

###### send sms to one or more with sender
```php
use MiladZamir\Orange\Orange;

Orange::smsSend(['091312345678', '09031234567'],'sms content');

Orange::smsSend(['091312345678'],'Hi my brother!', '10000001');

```

<br>

###### send lookup sms with template
```php
use MiladZamir\Orange\Orange;

Orange::smsLookup('091312345678','','','','verify');

```

<br>

###### sms receive
```php
use MiladZamir\Orange\Orange;

Orange::smsLookup('091312345678','','','','verify');Orange::smsReceive('100000000005',true);
```
