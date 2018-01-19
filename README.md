# Dotenv

[![Build Status](https://travis-ci.org/NeonXP/Dotenv.svg?branch=master)](https://travis-ci.org/NeonXP/Dotenv)
[![Codecov](https://img.shields.io/codecov/c/github/neonxp/dotenv.svg)](https://codecov.io/gh/NeonXP/Dotenv)
[![GitHub issues](https://img.shields.io/github/issues/neonxp/dotenv.svg)](https://github.com/neonxp/dotenv/issues)
[![GitHub forks](https://img.shields.io/github/forks/neonxp/dotenv.svg)](https://github.com/neonxp/dotenv/network)
[![GitHub stars](https://img.shields.io/github/stars/neonxp/dotenv.svg)](https://github.com/neonxp/dotenv/stargazers)
[![GitHub license](https://img.shields.io/github/license/neonxp/dotenv.svg)](https://github.com/neonxp/dotenv)

## What is it?

Small library, that automaticaly loads `.env` (or any other) file to applications environment.

## Why not XXX?

Because this library is pretty simple, without external dependencies and highly customizable.

## Installation

```
composer require neonxp/dotenv
``` 

## Usage

Basic usage:

```php
use NeonXP\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(); // You can specify file to load at first argument

print $dotenv->get('KEY', 'default') . PHP_EOL;
print $dotenv['KEY'] . PHP_EOL;
foreach ($dotenv as $key => $value) {
    print "$key = $value" . PHP_EOL;
}
```

## .env file syntax

Here examples of syntax:

```
# This is a comment

# Empty lines also ignored
export KEY1=VALUE1
KEY2 = VALUE2 # Inline comment
KEY3 = 'VALUE3 # This is not comment'
KEY4 = "VALUE4 # And this value too"
KEY5 = ${KEY1} -> ${KEY2} # Compilled from another variables
```

and we will get:

```php
[
    'KEY1' => 'VALUE1',
    'KEY2' => 'VALUE2',
    'KEY3' => 'VALUE3 # This is not comment',
    'KEY4' => 'VALUE4 # And this value too',
    'KEY5' => 'VALUE1 -> VALUE2',
]
```