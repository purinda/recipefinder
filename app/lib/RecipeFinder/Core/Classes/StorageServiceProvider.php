<?php

namespace RecipeFinder\Core\Classes;

use Illuminate\Support\ServiceProvider;
use RecipeFinder\Ingredient;
use RecipeFinder\Recipe;

class StorageServiceProvider extends ServiceProvider {

    /**
     * Bind repository interfaces to actual repository objects.
     *
     * @return NULL NULL
     */
    public function register() {
        $this->app->bind(
            'RecipeFinder\Ingredient\IngredientRepositoryInterface',
            'RecipeFinder\Ingredient\CSVIngredientRepository'
        );

        $this->app->bind(
            'RecipeFinder\Recipe\RecipeRepositoryInterface',
            'RecipeFinder\Recipe\JSONRecipeRepository'
        );
    }

}
