# Sales Taxes Solution

This file explains the solution applied to the Sales Taxes Problem described in the [PROBLEM.md](./PROBLEM.md) file.  

## Application Implementation

### Value Objects

I have identified some Value Object represented by:  

- `Category`: A basic enum with a list of all product categories.
- `BasicTax`: The basic sales tax applicable to all products except the specified categories.
- `ImportDuty`: The import duty applicable to imported products.

### Entities

I have identified some entities in this problem, so I have implemented the following Entity classes:  

- `Product`: A Product represented by `name`, `price`, `category` and a flag to indicate if the product has been `imported`.
- `ShoppingItem`: A Shopping Item represented by a `Product` and by the `quantity` of such product added in the Shopping Basket.
- `ShoppingBasket`: A Shopping Basket represented by a `ShoppingItem` list in the Shopping Basket.
- `SalesItem`: A Sales Item represented by `name`, `quantity`, `taxes` and `total` price (including tax) of a product for sale.
- `SalesReceipt`: A Sales Receipt represented by a `Sales Item` list of products sold.

Note that Entities are immutable objects, so they cannot be modified after they are created.  

### Interfaces

I have defined the following interfaces:  

- `RoundingInterface`: Interface used to round taxes.
- `TaxableInterface`: Interface implemented by taxable products.
- `TaxInterface`: Interface of a generic tax.

### Services

I have implemented three services:

- `TaxEngine`: Engine to apply any sales tax (**Basic Tax** and **Import Duty**) calculated in a deacoupled way.
- `RoundingUp005`: Rounding service that implements the required rounding of taxes.
- `Cashier`: Execute the checkout returning a `SalesReceipt` from a `ShoppingBasket`.

### Exceptions

The application may throw some InvalidArgumentException.

### Application

Finally, I have put togheter all little bricks in the `index.php` file that, as required:

- includes the list of the predefined `ShoppingBasket`
- executes the checkout to generate a `SalesReceipt` for each `ShoppingBasket`
- print the input data `ShoppingBasket` and the output data `SalesReceipt`

`php public/index.php`

```bash
INPUT

Input 1:
2 book at 12.49
1 music CD at 14.99
1 chocolate bar at 0.85

Input 2:
1 imported box of chocolates at 10.00
1 imported bottle of perfume at 47.50

Input 3:
1 imported bottle of perfume at 27.99
1 bottle of perfume at 18.99
1 packet of headache pills at 9.75
3 imported box of chocolates at 11.25


OUTPUT

Output 1:
2 book: 24.98
1 music CD: 16.49
1 chocolate bar: 0.85
Sales Taxes: 1.50
Total: 42.32

Output 2:
1 imported box of chocolates: 10.50
1 imported bottle of perfume: 54.65
Sales Taxes: 7.65
Total: 65.15

Output 3:
1 imported bottle of perfume: 32.19
1 bottle of perfume: 20.89
1 packet of headache pills: 9.75
3 imported box of chocolates: 35.55
Sales Taxes: 7.90
Total: 98.38
```

## Application Testing

I have also implemented some unit test using PHPUnit to test all classes (included the exceptions) in the application:  

- tests/ValueObject/CategoryTest.php
- tests/Entity/ProductTest.php
- tests/Entity/ShoppingItemTest.php
- tests/Entity/ShoppingBasketTest.php
- tests/Entity/SalesItemTest.php
- tests/Entity/SalesReceiptTest.php
- tests/Service/RoundingUp005Test.php
- tests/ApplicationTest.php

The last unit test has the goal to test the correctness of all the example output in the specifications.  

`./vendor/bin/phpunit --testdox`

```bash
PHPUnit 9.5.4 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.0.6
Configuration: /var/www/phpunit.xml

Category
 ✔ Name  144 ms
 ✔ Value  1 ms
 ✔ Is equal  23 ms

Product
 ✔ Name  52 ms
 ✔ Price  1 ms
 ✔ Price must be greater than zero  24 ms
 ✔ Category  1 ms
 ✔ Imported  1 ms
 ✔ Is equal  1 ms

Shopping Item
 ✔ Quantity  8 ms
 ✔ Quantity must be greater than zero  1 ms
 ✔ Product  1 ms

Shopping Basket
 ✔ Constructor accept only shopping items  8 ms
 ✔ Shopping items count  13 ms

Sales Item
 ✔ Name  9 ms
 ✔ Quantity  1 ms
 ✔ Quantity must be greater than zero  1 ms
 ✔ Taxes  1 ms
 ✔ Total  1 ms

Sales Receipt
 ✔ Items count  8 ms

Rounding Up005
 ✔ Round  16 ms

Application
 ✔ Receipt 1  59 ms
 ✔ Receipt 2  1 ms
 ✔ Receipt 3  1 ms

Time: 00:00.403, Memory: 6.00 MB
```
