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

echo '<pre>';
print_r($string);
echo '<br><br>';
print_r($object);
echo '<br><br>';
print_r(new Animal());
echo '</pre>';
