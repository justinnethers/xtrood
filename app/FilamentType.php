<?php

namespace App;

enum FilamentType: string
{
    case PLA = 'PLA';
    case PETG = 'PETG';
    case ABS = 'ABS';
    case TPU = 'TPU';
    case NYLON = 'Nylon';
    case PC = 'PC';
    case PVA = 'PVA';
    case HIPS = 'HIPS';
    case WOOD = 'Wood';
    case METAL = 'Metal';
    case CARBON_FIBER = 'Carbon Fiber';
    case GLASS_FIBER = 'Glass Fiber';
}
