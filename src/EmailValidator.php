<?php

declare(strict_types=1);

namespace App;

/**
 * Класс для валидации email адресов
 */
class EmailValidator
{
    /**
     * Проверяет, является ли строка корректным email адресом
     *
     * @param string $email Email адрес для проверки
     * @return bool Результат проверки
     */
    public function isValid(string $email): bool
    {
        // Обрезаем пробелы по краям
        $email = trim($email);
        
        // Проверяем на пустоту
        if (empty($email)) {
            return false;
        }
        
        // Проверяем максимальную длину 
        if (strlen($email) > 254) {
            return false;
        }
        
        // Проверяем формат с помощью встроенной функции PHP
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        // Дополнительная проверка: домен состоит из двух частей
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return false;
        }

        // Дополнительная проверка: домен должен иметь как минимум одну точку
        $domain = $parts[1];
        if (strpos($domain, '.') === false) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Возвращает список часто используемых доменов для email
     *
     * @return array<string> Список доменов
     */
    public function getCommonDomains(): array
    {
        return [
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'outlook.com',
            'icloud.com',
            'mail.ru',
            'yandex.ru'
        ];
    }
    
    /**
     * Проверяет, является ли домен email одним из распространенных
     *
     * @param string $email Email адрес для проверки
     * @return bool Результат проверки
     */
    public function isCommonDomain(string $email): bool
    {
        if (!$this->isValid($email)) {
            return false;
        }
        
        $parts = explode('@', $email);
        $domain = $parts[1];
        
        return in_array($domain, $this->getCommonDomains(), true);
    }

    /**
     * Вовращает список коррпоротивных доменов для email
     *
     * @return array<string> Список доменов
     */
    public function getCorporateDomains(): array
    {
        return [
            'microsoft.com',
            'apple.com',
            'google.com',
            'amazon.com',
            'meta.com',
            'oracle.com',
            'ibm.com',
            'intel.com',
            'cisco.com',
            'adobe.com'
        ];
    }

    /**
     * Проверяет, является ли домен email одним из коррпоротивных
     *
     * @param string $email Email адрес для проверки
     * @return bool Результат проверки
     */
    public function isCorporateDomain(string $email): bool
    {
        if (!$this->isValid($email)) {
            return false;
        }

        $parts = explode('@', $email);
        $domain = $parts[1];

        return in_array($domain, $this->getCorporateDomains(), true);
    }
} 