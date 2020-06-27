<?php declare(strict_types=1);

namespace Tests\Cases;

use ExtKit\PasswordVerify\Combination\NotVerifyInitialLetterCombination;
use ExtKit\PasswordVerify\Exceptions\ShortTextException;
use ExtKit\PasswordVerify\PasswordVerify;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class PasswordVerifyTest extends TestCase
{
    public function testShortPassword(): void
    {
        $combination = new NotVerifyInitialLetterCombination();

        Assert::exception(static function () use ($combination) {
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
}

(new PasswordVerifyTest())->run();
