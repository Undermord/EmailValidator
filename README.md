# Валидатор электронной почты

Простой PHP класс для валидации email адресов с использованием Psalm для статического анализа и PHPUnit для тестирования.

## Установка

```
composer install
```

## Использование

```php
<?php
require_once 'vendor/autoload.php';

use App\EmailValidator;

$validator = new EmailValidator();

// Проверка валидности email
$isValid = $validator->isValid('user@example.com'); // true

// Проверка, относится ли email к распространенным доменам
$isCommon = $validator->isCommonDomain('user@gmail.com'); // true
```

## Запуск тестов

```
composer test
```

## Запуск статического анализа с Psalm

```
composer psalm
```

## Запуск примера

```
php example.php
``` 