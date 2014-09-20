<?php

namespace RecipeFinder\Core\Classes;

use Illuminate\Support\ServiceProvider;
use RecipeFinder\Ingredient;
use RecipeFinder\Recipes;

class BackendServiceProvider extends ServiceProvider {

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
            'RecipeFinder\Recipes\RecipesRepositoryInterface',
            'RecipeFinder\Recipes\JSONRecipesRepository'
        );
    }

}
