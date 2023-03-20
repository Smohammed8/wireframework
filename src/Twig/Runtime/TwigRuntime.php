<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;
use App\Twig\Extension\TwigExtension;

class TwigRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function doSomething($value)
    {
        // ...
    }
}
