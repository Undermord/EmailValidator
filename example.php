<?php

require_once 'vendor/autoload.php';

use App\EmailValidator;

$validator = new EmailValidator();

$testEmails = [
    'user@example.com',
    'invalid-email',
    'john.doe@gmail.com',
    'test@domain',
    'user@yahoo.com',
    'employee@microsoft.com',
    'developer@apple.com'
];

foreach ($testEmails as $email) {
    echo "Email: $email\n";
    echo "Валидный: " . ($validator->isValid($email) ? 'Да' : 'Нет') . "\n";
    
    if ($validator->isValid($email)) {
        echo "Распространенный домен: " . ($validator->isCommonDomain($email) ? 'Да' : 'Нет') . "\n";
    }
    
    echo "-------------------\n";
}

echo "Список распространенных доменов:\n";
foreach ($validator->getCommonDomains() as $domain) {
    echo "- $domain\n";
}

echo "Список коррпоротивных доменов:\n";
foreach ($validator->getCorporateDomains() as $domain) {
    echo "- $domain\n";
}
