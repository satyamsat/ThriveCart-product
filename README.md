# Laravel Basket Service

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) ![Docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)

A shopping basket service implementation in Laravel with product management, delivery charge rules, and special offers.

## Table of Contents
- [Project Setup](#project-setup)
- [Running the Project](#running-the-project-with-docker)
- [Basket Service Overview](#basketservicephp-overview)
- [API Endpoints](#api-endpoints)
- [How It Works](#how-it-works)
- [Assumptions](#assumptions-made)
- [Testing](#testing)

## Project Setup
This project implements a shopping basket service in Laravel. It includes product management, delivery charge rules, and special offers.

## Running the Project with Docker
1. Start Docker containers: ```./vendor/bin/sail up -d```
2. Run database migrations and seed the database: ```./vendor/bin/sail artisan migrate --seed```

## BasketService.php Overview
The `BasketService.php` file manages the shopping basket logic, including:
- Adding products to the basket
- Calculating the total price, including discounts and delivery charges
- Applying special offers such as "Buy One Red Widget, Get the Second Half Price"

## API Endpoints
### Get Total Basket Price
```GET /api/basket?products=B01,R01,R01```
- Accepts a comma-separated list of product codes
- Returns the total cost, including applicable discounts and delivery charges

## How It Works
The basket system works by:
1. Accepting product codes via API
2. Validating the products against the database
3. Adding the products to the basket service
4. Applying any available discounts or special offers
5. Calculating delivery charges based on predefined rules
6. Returning the final total price

## Assumptions Made
- The product catalog is predefined in the database
- The "Buy One Red Widget, Get the Second Half Price" offer applies only to even-numbered purchases of R01
- Delivery charges depend on the order total, with free delivery for orders above a set amount
- Invalid product codes are not processed and return an error response

## Testing
The project includes PHPUnit test cases to verify the functionality of the basket service and API endpoints.

### Unit Tests (BasketServiceTest.php)
Unit tests focus on testing individual methods inside `BasketService.php` in isolation. The tests ensure that:
- Products are correctly added to the basket
- Discounts and promotions are applied properly
- Delivery charges are calculated based on the order amount

### Feature Tests (CartControllerTest.php)
Feature tests validate the full request-response cycle of API endpoints. These tests include:
- Checking if the correct total is returned for different basket configurations
- Ensuring validation errors occur for missing or incorrect product codes
- Verifying that invalid product codes return proper error messages
- Testing scenarios with and without special offers applied

### Running Tests
To run the tests, use: ```./vendor/bin/sail artisan test```
This command executes all unit and feature tests, verifying that the basket service and API are functioning as expected.