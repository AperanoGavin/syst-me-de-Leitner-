<?php

namespace App\Entity;



interface CategoryInterface
{
    public const CATEGORY_FIRST = 'FIRST';
    public const CATEGORY_SECOND = 'SECOND';
    public const CATEGORY_THIRD = 'THIRD';
    public const CATEGORY_FOURTH = 'FOURTH';
    public const CATEGORY_FIFTH = 'FIFTH';
    public const CATEGORY_SIXTH = 'SIXTH';
    public const CATEGORY_SEVENTH = 'SEVENTH';
    public const NONE = 'NONE';
}

enum CategoryEnum: string {
    case FIRST = 'FIRST';
    case SECOND = 'SECOND';
    case THIRD = 'THIRD';
    case FOURTH = 'FOURTH';
    case FIFTH = 'FIFTH';
    case SIXTH = 'SIXTH';
    case SEVENTH = 'SEVENTH';
    case NONE = 'NONE';
}