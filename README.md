# Hexlet PSR Linter

[![Build Status](https://travis-ci.org/deeem/hexlet-psr-linter.svg?branch=master)](https://travis-ci.org/deeem/hexlet-psr-linter)
[![Code Climate](https://codeclimate.com/github/deeem/hexlet-psr-linter/badges/gpa.svg)](https://codeclimate.com/github/deeem/hexlet-psr-linter)
[![Test Coverage](https://codeclimate.com/github/deeem/hexlet-psr-linter/badges/coverage.svg)](https://codeclimate.com/github/deeem/hexlet-psr-linter/coverage)
[![Issue Count](https://codeclimate.com/github/deeem/hexlet-psr-linter/badges/issue_count.svg)](https://codeclimate.com/github/deeem/hexlet-psr-linter)

## About

Линтер, проверяющий php-код на соответствие некоторому набору правил и выводящий отчёт о нарушениях с возможностью исправить код (если функция для исправления описана в правиле). Проект в рамках стажировки на hexlet.io

## Requirements

* PHP >= 7.0
* Composer

## Install

1. Установка клонированием git-репозитория
```
git clone https://github.com/deeem/hexlet-psr-linter
cd hexlet-psr-linter
make install
```
2. Установка с использованием composer
```
composer require deeem/hexlet-psr-linter
```
3. Установка с использованием composer.json
```json
"require": {
    "deeem/hexlet-psr-linter": "*"
}
```

## Использование командой строки

Например, проверка кода в директории `myProject` правилами, перечисленными в `ruleset.json`, загруженными из директории `~/mySniffs`
```
bin/psr-linter myProject --sniffs ~/mySniffs --ruleset ruleset.json
```
Формат json-файла - обычный массив
```json
[
  "FunctionsNamingForCamelCase",
  "VariablesNamingForCamelCase",
  "VariablesNamingForLeadUnderscore"
]
```
Дополнительные параметры описывает справка
```
bin/psr-linter --help
```
Для удобство вызова, в случае, если psr-linter установлен глобально, можно сделать ссылку на bin-файл
```
ln -s path-to-bin/psr-linter /usr/local/bin/psr-linter
```
После чего его можно вызывать набрав
```
psr-linter
```

## Использование библиотеки

За создание линтера отвечает функция `makeLinter`, которая принимает в качестве аргументов массив объектов наследников RulesInterface и флага автофикса и возвращает функцию, которая в качестве аргумента принимает исходный код в виде строки. А возвращает массив, содержащий ошибки и исправленный код, если был передан такой аргумент.

```php
<?php
$code = file_get_contents('tests/fixtures/sniffs/variablesNamingForLeadingUnderscore.wrong.php');

require_once 'sniffs/VariablesNamingForLeadUnderscore.php';
$lint = makeLinter([new Rules\VariablesNamingForLeadUnderscore()]);
$linterReport = $lint($code);
```

## Создание правил
Изначально идёт с несколькими правилами, носящими демонстрационный характер. Для реальной работы необходимо создать свой набор правил для проверки

Правила делятся на 2 категории, по возможности применения автоисправления нарушения:
* определяют нарушение, которые нельзя исправить автоматически (например, сайд-эфект)
* определяют нарушение и исправляют автоматически (например, приведение имени переменной к соответсвующему виду)

Для создания нового правила, нужно создать создать инстанс соответствующего класса: `CheckersTemplate` - в первом случае или `FixersTemplate`, в случае, если есть возможность добавить автофикс для данного правила.

Пример правила, для проверки имени переменной на соответствие стандарта именования camelCase:

```php
<?php

namespace PsrLinter\Rules;

class VariablesNamingForCamelCase extends FixersTemplate implements RulesInterface
{
    public function check(\PhpParser\Node $node)
    {
        if (( $node instanceof \PhpParser\Node\Expr\Variable ) &&
            (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $node->name))) {
            $this->addError($node, 'error', 'Names MUST be declared in camelCase.');

            return true;
        }
    }

    public function fix(\PhpParser\Node $node)
    {
        $camelize = function ($word) {
            $allWordsAreUpperCased = implode(array_map(function ($word) {
                return ucfirst(strtolower($word));
            }, explode('_', $word)));

            return lcfirst($allWordsAreUpperCased);
        };

        $node->name = $camelize($node->name);
    }
}
```

Другие примеры находятся в директории `shiffs`
