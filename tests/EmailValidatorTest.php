<?php

declare(strict_types=1);

namespace Tests;

use App\EmailValidator;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    private EmailValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new EmailValidator();
    }

    /**
     * @dataProvider validEmailProvider
     */
    public function testIsValidWithValidEmails(string $email): void
    {
        $this->assertTrue($this->validator->isValid($email));
    }

    /**
     * @dataProvider invalidEmailProvider
     */
    public function testIsValidWithInvalidEmails(string $email): void
    {
        $this->assertFalse($this->validator->isValid($email));
    }

    public function testGetCommonDomains(): void
    {
        $domains = $this->validator->getCommonDomains();
        $this->assertIsArray($domains);
        $this->assertNotEmpty($domains);
        $this->assertContains('gmail.com', $domains);
    }

    /**
     * @dataProvider commonDomainEmailProvider
     */
    public function testIsCommonDomainWithCommonDomains(string $email): void
    {
        $this->assertTrue($this->validator->isCommonDomain($email));
    }

    /**
     * @dataProvider nonCommonDomainEmailProvider
     */
    public function testIsCommonDomainWithNonCommonDomains(string $email): void
    {
        $this->assertFalse($this->validator->isCommonDomain($email));
    }

    public function testGetCorporateDomains(): void
    {
        $domains = $this->validator->getCorporateDomains();
        $this->assertIsArray($domains);
        $this->assertNotEmpty($domains);
        $this->assertContains('microsoft.com', $domains);
    }

    /**
     * @dataProvider corporateDomainEmailProvider
     */
    public function testIsCorporateDomainWithCorporateDomains(string $email): void
    {
        $this->assertTrue($this->validator->isCorporateDomain($email));
    }

    /**
     * @dataProvider nonCorporateDomainEmailProvider
     */
    public function testIsCorporateDomainWithNonCorporateDomains(string $email): void
    {
        $this->assertFalse($this->validator->isCorporateDomain($email));
    }

    public function validEmailProvider(): array
    {
        return [
            ['test@example.com'],
            ['john.doe@gmail.com'],
            ['user+tag@domain.com'],
            ['a@b.co'],
            ['1234567890@domain.com'],
            ['email@domain-with-hyphen.com'],
            ['email@domain.co.jp'],
            [' test@example.com '], // с пробелами, которые должны обрезаться
        ];
    }

    public function invalidEmailProvider(): array
    {
        return [
            [''],
            [' '],
            ['plaintext'],
            ['@domain.com'],
            ['user@'],
            ['user@domain'],
            ['user@.com'],
            ['user@domain..com'],
            ['user name@domain.com'],
            [str_repeat('a', 255) . '@example.com'], // слишком длинный email
        ];
    }

    public function commonDomainEmailProvider(): array
    {
        return [
            ['test@gmail.com'],
            ['user@yahoo.com'],
            ['john@hotmail.com'],
            ['jane@outlook.com'],
            ['ivan@mail.ru'],
            ['maria@yandex.ru'],
        ];
    }

    public function nonCommonDomainEmailProvider(): array
    {
        return [
            ['test@example.com'],
            ['user@unknown.org'],
            ['invalid-email'],
        ];
    }

    public function corporateDomainEmailProvider(): array
    {
        return [
            ['employee@microsoft.com'],
            ['user@apple.com'],
            ['dev@google.com'],
            ['manager@amazon.com'],
            ['designer@adobe.com'],
            ['analyst@ibm.com'],
        ];
    }

    public function nonCorporateDomainEmailProvider(): array
    {
        return [
            ['test@example.com'],
            ['user@gmail.com'],
            ['john@hotmail.com'],
            ['invalid-email'],
        ];
    }
}