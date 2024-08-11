<?php

namespace App\Enums;

enum BrandType: string
{
    case FILAMENT = 'filament';
    case PRINTER = 'printer';
    case RESIN = 'resin';
    // Add more types as needed
}
