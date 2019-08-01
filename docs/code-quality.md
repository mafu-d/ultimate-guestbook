# Code quality

If we're talking about best practices, we can't not talk about code quality. This is about ensuring not only that the code works, but that it's as good as it possibly can be.

## PHP Code Sniffer

[PHPCS](https://github.com/squizlabs/PHP_CodeSniffer) is an indispensable tool in a developer's arsenal. It checks your PHP code to ensure that it's [PSR-2](https://www.php-fig.org/psr/psr-2/) compliant, looking at things like indentation, where spaces are and aren't used, new lines, file encoding... all the sort of stuff that a lazy (or rushed) developer might shortcut on their own. Let's get it installed.

```bash
composer require --dev squizlabs/php_codesniffer
```

Now we can tell it which directory or file to check, and it'll tell you all the things you got wrong:

```bash
./vendor/bin/phpcs ./app
```

By default, PHPCS uses the [PEAR standard](https://pear.php.net/manual/en/standards.php). Personally, I prefer PSR-2 when I'm working with other developers. We can automate things by creating a `phpcs.xml` file in the project root, where we set which directories to check by default and what standard to test against:

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

## CSS (and SCSS)

To lint (check) our styles, we can use [stylelint](https://stylelint.io/). It doesn't set any rules out of the box, so to get up and running quickly it's best to use a preset config; in this case `stylelint-config-recommended` is a good starting point.

```bash
yarn add --dev stylelint stylelint-config-recommended
```

Now we can add a `.stylelintrc.json` file to our project root:

```json
{
    "extends": "stylelint-config-standard"
}
```

And finally run stylelint and tell it where our files are:

```bash
./node_modules/.bin/stylelint "./resources/sass/**/*.scss"
```

Like PHPCS, stylelint can also fix some errors itself.

```bash
./node_modules/.bin/stylelint "./resources/sass/**/*.scss" --fix
```

That's fine for standard CSS, but if we're using SCSS (which I do, all the time), we might need some extra rules to keep us on track. We're going to use a [Sass config](https://github.com/bjankord/stylelint-config-sass-guidelines) based on [Sass Guidelines](https://sass-guidelin.es), which refers to itself as "An opinionated styleguide for writing sane, maintainable and scalable Sass". Sounds good to me! Let's install it and add it to our `.stylelintrc.json` file.

```bash
yarn add --dev stylelint-config-sass-guidelines
```

```json
{
    "extends": [
        "stylelint-config-standard",
        "stylelint-config-sass-guidelines"
    ]
}
```

Again, it would be good to run this before each commit so you know your styles are awesome.
