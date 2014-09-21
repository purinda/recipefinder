<?php

namespace RecipeFinder\Core\Specifications;

use RecipeFinder\Ingredient\Ingredient;
use RecipeFinder\Ingredient\IngredientRepositoryInterface;
use RecipeFinder\Core\Classes\AbstractSpecification;

class IngredientInFridgeSpecification extends AbstractSpecification {

    /**
     * Repository to be validated against
     * @var [type]
     */
    private $ingredient_repository;

    public function __construct(IngredientRepositoryInterface $ingredient_repository) {
        parent::__construct();
        $this->ingredient_repository = $ingredient_repository;
    }

    /**
     * Check if an ingredient is in the fridge or not.
     *
     * @param  Ingredient $contestant [description]
     * @return boolean                return TRUE if in the fridge or FALSE if not
     */
    public function isSatisfiedBy($contestant) {
        if ($this->ingredient_repository->findByName($contestant->getName())) {
            return TRUE;
        }

        $this->addMessage('INGREDIENTS', 'Ingredient required for the recipe is not in the fridge.');
        return FALSE;
    }
}
