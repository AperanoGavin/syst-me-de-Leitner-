<?php 
namespace App\Entity;

enum CategoryEnum: string {
    case FIRST = 'FIRST';
    case SECOND = 'SECOND';
    case THIRD = 'THIRD';
    case FOURTH = 'FOURTH';
    case FIFTH = 'FIFTH';
    case SIXTH = 'SIXTH';
    case SEVENTH = 'SEVENTH';
    case DONE = 'DONE';

    public  function getNext(): self
    {
        $values = self::cases();
        $currentIndex = array_search($this, $values, true);

        if ($currentIndex === count($values) - 1) {
            return $values[0]; 
        }

        return $values[$currentIndex + 1];
    }
}