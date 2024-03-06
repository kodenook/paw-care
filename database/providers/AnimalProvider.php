<?php

namespace Database\Providers;

use faker\Provider\Base;

class AnimalProvider extends Base
{
    /* The `species` is a static property that holds an array of animal species. Each
    animal specie represents a possible value that can be returned by the `specieAnimal()` method in the
    `AnimalProvider` class. */
    protected static $species = [
        'Lion', 'Tiger', 'Elephant', 'Giraffe', 'Rhinoceros',
        'Zebra', 'Hippopotamus', 'Leopard', 'Bear', 'Wolf',
        'Fox', 'Coyote', 'Jaguar', 'Puma', 'Gorilla',
        'Chimpanzee', 'Orangutan', 'Mandrill', 'Bonobo', 'Baboon',
        'Dolphin', 'Whale', 'Orca', 'Shark', 'Swordfish',
        'Tuna', 'Salmon', 'Trout', 'Frog', 'Toad',
        'Salamander', 'Turtle', 'Crocodile', 'Alligator', 'Sea turtle',
        'Freshwater turtle', 'Eagle', 'Hawk', 'Owl', 'Raven',
        'Peacock', 'Duck', 'Goose', 'Swan', 'Vulture',
        'Buffalo', 'Kangaroo', 'Koala', 'Wombat',
    ];

    /**
     * The function returns a random element from an array of species.
     *
     * @return string
     */
    public static function specieAnimal()
    {
        return static::randomElement(static::$species);
    }
}
