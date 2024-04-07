<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
/**
 * Kernel de l'application.
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
