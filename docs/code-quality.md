# Code quality

If we're talking about best practices, we can't not talk about code quality. This is about ensuring not only that the code works, but that it's as good as it possibly can be.

## PHP Code Sniffer

This is an indispensable tool in a developer's arsenal. It checks your PHP code to ensure that it's PSR-2 compliant, looking at things like indentation, where spaces are and aren't used, new lines, file encoding... all the sort of stuff that a lazy (or rushed) developer might shortcut on their own. Let's get it installed.

```bash
composer require --dev squizlabs/php_codesniffer
```

Now we can tell it which directory or file to check, and it'll tell you all the things you got wrong:

```bash
./vendor/bin/phpcs ./app
```

By default, PHPCS uses the PEAR standard. Personally, I prefer PSR-2 when I'm working with other developers. We can automate things by creating a `phpcs.xml` file in the project root, where we set which directories to check by default and what standard to test against:

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<ruleset>
    <file>app</file>
    <file>routes</file>
    <file>tests</file>
    <file>config</file>
    <rule ref="PSR2"/>
</ruleset>
```

```bash
./vendor/bin/phpcs
```

We can now work our way through all the errors until PHPCS is happy. There is also an extra little tool that can fix some (but not all) of these errors for you automatically:

```bash
./vendor/bin/phpcbf
```

It's a good idea to run this before committing. You could even set up a git hook to automate this.
