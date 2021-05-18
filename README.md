# Sales Taxes (Kata)

This is a Kata on the sales taxes problem.  

The main issue of the problem is to calculate the selling price of various products, including the *Basic Sales Tax* and the *Import Duty* when applicable.  
The ultimate goal is to write an application that prints out the receipt details for three predefined shopping baskets.

You can find more details about the problem and the solution respectively in the [PROBLEM.md](./PROBLEM.md) and [SOLUTION.md](./SOLUTION.md) files.  

## Technical Information

This Kata was written in **PHP Language**.  
The source code was fixed using [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) and checked by static analysis tools such as [Psalm](https://psalm.dev) and [PHPStan](https://github.com/phpstan/phpstan), and also includes a test suite in [PHPUnit](https://phpunit.de).  

The application run inside an environment based on 🐳 **Docker** (`docker` containers built used `docker-compose`).  

## Quick start

Install all dependencies and start the application server:

```bash
make install
```

_The installation could be fails due conflicts with the ports used by the application and by your host.  
In this case you can solve by changing such ports in the `.env` file (see [Customizations](#Customizations))._

For further details about the `make` commands:

```bash
make help
```

The application will be available opening the browser at this URL address:

- [http://localhost](http://localhost)

Now, you can enter inside the app docker container shell to interact from command line:  

```bash
make shell
```

In alternative, if you use Visual Studio Code, you can work directly inside the docker container:  

- press F1: "> Remote-Containers: Reopen in Container"

_(For further details see `.devcontainer/devcontainer.json` file)_

From the docker container shell, you can execute other commands.  

Run the application from the the terminal:

```bash
php public/index.php
```

Fix the source code:  

```bash
./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
```

Check the source code with static analysis with Psalm and PHPStan:  

```bash
./vendor/bin/psalm --show-info=true
./vendor/bin/phpstan analyse src tests --memory-limit 256M
```

Test the application with PHPUnit:  

```bash
./vendor/bin/phpunit --testdox
```

## How To

### Customizations

You can customize the configuration of the docker containers changing the variables in the .env file.  

| Key                 | Description             | Current value   |
|---------------------|-------------------------|:---------------:|
| APP_NAME            | Application name        | sales-taxes     |
| NGINX_VERSION       | NGINX version           | 1.19            |
| NGINX_HOST          | NGINX server_name       | localhost       |
| NGINX_ROOT          | NGINX root              | /var/www        |
| NGINX_PORT_HTTP     | NGINX http port         | 80              |
| NGINX_PORT_HTTPS    | NGINX https port        | 443             |
| PHP_VERSION         | PHP version             | 8               |
| PHP_SYSTEM_TZ       | PHP timezone            | Europe/Rome     |
| PHP_PORT            | PHP port                | 9000            |
| XDEBUG_MODE         | Xdebug mode             | off             |
| XDEBUG_CLIENT_PORT  | Xdebug client port      | 9003            |
| XDEBUG_CLIENT_HOST  | Xdebug client host      | localhost       |

## Initial Setup

### Installations

Install PHP CS Fixer:

```bash
mkdir --parents tools/php-cs-fixer
composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer
```

Install Psalm:

```bash
composer require --dev vimeo/psalm
```

Install PHPStan:

```bash
composer require --dev phpstan/phpstan
```

Install PHPUnit:  

```bash
composer require --dev phpunit/phpunit
```

### Configurations

Config Psalm adding the `psalm.xml` file (or executing `./vendor/bin/psalm --init`):

```xml
<?xml version="1.0"?>
<psalm
    errorLevel="3"
    resolveFromConfigFile="true"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
>
    <projectFiles>
        <directory name="public" />
        <directory name="src" />
        <ignoreFiles>
            <file name="public/autoload.php" />
            <directory name="tests" />
            <directory name="vendor" />
        </ignoreFiles>
    </projectFiles>
</psalm>
```

Config PHPStan adding the `phpstan.neon` file:

```neon
parameters:
    level: 6
    paths:
        - public
        - src
        - tests
```

Config PHPUnit adding the `phpunit.xml` file:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
        colors="true"
        stopOnError="false"
        stopOnFailure="false"
        stopOnIncomplete="false"
        stopOnSkipped="false"
        stopOnRisky="true"
        verbose="true">
  <testsuites>
    <testsuite name="ValueObject">
      <file>tests/ValueObject/CategoryTest.php</file>
    </testsuite>
    <testsuite name="Entity">
      <file>tests/Entity/ProductTest.php</file>
      <file>tests/Entity/ShoppingItemTest.php</file>
      <file>tests/Entity/ShoppingBasketTest.php</file>
      <file>tests/Entity/SalesItemTest.php</file>
      <file>tests/Entity/SalesReceiptTest.php</file>
    </testsuite>
    <testsuite name="Service">
      <file>tests/Service/RoundingUp005Test.php</file>
    </testsuite>
    <testsuite name="Application">
      <file>tests/ApplicationTest.php</file>
    </testsuite>
  </testsuites>
</phpunit>
```
