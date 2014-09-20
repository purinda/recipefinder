<?php

namespace RecipeFinder;

use RecipeFinder\Ingredient\IngredientRepositoryInterface;
use RecipeFinder\Ingredient\RecipeRepositoryInterface;

class RecipeFinder {

    /**
     * An implementation of IngredientRepositoryInterface
     * @var [type]
     */
    protected $ingredient_repository;

    /**
     * An implementation of RecipeRepositoryInterface
     * @var [type]
     */
    protected $recipe_repository;

    public function __construct(RecipeRepositoryInterface $recipe_repository, IngredientRepositoryInterface $ingredient_repository) {
        $this->recipe_repository     = $recipe_repository;
        $this->ingredient_repository = $ingredient_repository;
    }


    public function setDatasources($ingredients_src, $recipes_src) {

    }
}
