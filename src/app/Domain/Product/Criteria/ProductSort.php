<?php

namespace App\Domain\Product\Criteria;

enum ProductSort: string
{
    case SORT = 'sort';
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
}
