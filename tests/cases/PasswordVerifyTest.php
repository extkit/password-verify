<?php declare(strict_types=1);

namespace Tests\Cases;

use ExtKit\PasswordVerify\Combination\NotVerifyInitialLetterCombination;
use ExtKit\PasswordVerify\Exceptions\RuntimeException;
use ExtKit\PasswordVerify\Exceptions\ShortTextException;
use ExtKit\PasswordVerify\PasswordVerify;
use Tester\Assert;
use Tester\TestCase;
use Throwable;
use TypeError;

require_once __DIR__ . '/../bootstrap.php';

final class PasswordVerifyTest extends TestCase
{
    public function testShortPassword(): ?Throwable
    {
        $combination = new NotVerifyInitialLetterCombination();

        return Assert::exception(static function () use ($combination): void {
            $combination->setPassword('.');
        }, ShortTextException::class);
    }

    public function testPermissibleValues(): void
    {
        $verify = new PasswordVerify('Test.');
        $verify->setDefaultCombinations();

        $values = ['Test.', 'test.', 'Test'];

        Assert::equal($values, $verify->getAllowableValues());
    }

    public function testAddCombination(): ?Throwable
    {
        $verify = new PasswordVerify('.');

        return Assert::exception(static function () use ($verify): void {
            $verify->addCombination(new NotVerifyInitialLetterCombination());
        }, RuntimeException::class);
    }

    public function testVerify(): ?Throwable
    {
        $verify = new PasswordVerify('test.');
        $verify->setDefaultCombinations();

        $result = $verify->verify(static function (string $value): bool {
            return md5($value) === md5('test');
        });

        Assert::true($result);

        $result = $verify->verify(static function (string $value): bool {
            return md5($value) === '...';
        });

        Assert::false($result);

        $verify->deleteAllCombinations();

        $result = $verify->verify(static function (string $value): bool {
            return md5($value) === md5('test');
        });

        Assert::false($result);

        return Assert::exception(static function () use ($verify): void {
            $verify->verify(static function (): void {
            });
        }, TypeError::class);
    }
}

(new PasswordVerifyTest())->run();
