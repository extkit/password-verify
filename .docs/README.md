# Password verify

## Usage

For basic use, you must first create an instance of the class `ExtKit\PasswordVerify\PasswordVerify(string $password)`. The input value is the password that the user enters into the form.

```php
$verify = new ExtKit\PasswordVerify\PasswordVerify('test');
```

### Default settings

If you do not want to set the combinations manually, it is possible to use pre-prepared ones.

These combinations provide the following:
- The last character of the password is deleted
- The first character can be written as uppercase or lowercase.

When the input password `Test.` formed following combination:
- Test.
- test.
- Test

You can set predefined combinations using the method `$verify->setDefaultCombinations()`

### Custom combinations

To create your own combination, you must implement an interface `ExtKit\PasswordVerify\Combination\Combination` which contains the `setPassword (string $password)` method for setting the password and the `__toString(): string` method for creating the resulting text.

To work with custom combinations of these methods are designed:

- `addCombination(Combination\Combination $combination, bool $skipException = false)`
- `deleteAllCombinations()`

### Verify valid passwords

To display the allowable generated passwords can be used as follows `getAllowableValues(): string[]`

If you are only interested in whether the password has passed the combination, the method is `verify(callable $verify): bool`

The callback is used to implement a custom authentication method. The return type must be bool. Otherwise, a exception is thrown.

### Sample code

```php
// Hash is test
$hashFromDatabase = '098f6bcd4621d373cade4e832627b4f6';

$verify = new ExtKit\PasswordVerify\PasswordVerify('test.');
$verify->setDefaultCombinations();
$result = $verify->verify(static function (string $value) use ($hashFromDatabase) {
    return md5($value) === $hashFromDatabase;
});
```

Because the login password was a `test.` and the correct password was `test`, the authentication return value is `true`.
