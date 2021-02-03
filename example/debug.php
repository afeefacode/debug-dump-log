<?php

require_once __DIR__ . '/../vendor/autoload.php';

$string = 'This is a text string';

class Animal
{
    public $name = 'camel';
    protected $version = '2 humps';
    private $hidden = 'do not feed';
}

$object = (object) [
    'key' => 'value',
    'foos' => [
        'bar1',
        'bar2'
    ]
];

debug_dump($string, $object, new Animal());
