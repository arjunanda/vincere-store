<?php
require __DIR__ . '/vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$manager = new ImageManager(new Driver());
echo "Manager class: " . get_class($manager) . "\n";
echo "Methods: " . implode(', ', get_class_methods($manager)) . "\n";
