# Laravel Basket Service

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)

A shopping basket service implementation in Laravel with product management, delivery charge rules, and special offers.

## Table of Contents
- [Project Setup](#project-setup)
- [Running the Project](#running-the-project-with-docker)
- [Basket Service Overview](#basketservicephp-overview)
- [API Endpoints](#api-endpoints)
- [How It Works](#how-it-works)
- [Assumptions](#assumptions-made)
- [Testing](#testing)
  - [Unit Tests](#unit-tests-basketservicetestphp)
  - [Feature Tests](#feature-tests-cartcontrollertestphp)
  - [Running Tests](#running-tests)

## Project Setup

This project implements a shopping basket service in Laravel. It includes product management, delivery charge rules, and special offers.

## Running the Project with Docker

1. Start Docker containers:
   ./vendor/bin/sail up -d