<?php

namespace RecipeFinder;

use RecipeFinder\Recipe\RecipeRepositoryInterface;
use RecipeFinder\Ingredient\IngredientRepositoryInterface;

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

    /**
     * A quick way to test the system, function sets the default
     * test files to Repositories.
     */
    public function test() {
        $ingredients_csv = public_path() . '/testdata/ingredients.csv';
        $recipes_csv     = public_path() . '/testdata/recipes.json';

        $this->ingredient_repository->setDatasource($ingredients_csv);
        $this->recipe_repository->setDatasource($recipes_csv);

        // var_dump($this->recipe_repository->getAll());
        var_dump($this->ingredient_repository->lookupUsableIngredients());

    }

    /**
     * Set datasources for Ingredients and Recipe repositories
     *
     * @param String $ingredients_src [description]
     * @param String $recipes_src     [description]
     */
    public function setDatasources($ingredients_src, $recipes_src) {
        $this->ingredient_repository->setDatasource($ingredients_src);
        $this->recipe_repository->setDatasource($recipes_src);

        return $this;
    }
}
