<?php

namespace RecipeFinder;

use RecipeFinder\Recipe\RecipeRepositoryInterface;
use RecipeFinder\Ingredient\IngredientRepositoryInterface;
use Illuminate\Support\Collection;

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
     * This returns one or more recipes that can be cooked with
     * the ingredients in the fridge for the day.
     *
     * @return Collection returns a collection of recipes
     */
    public function preparableRecipes() {
        static $recipe_shortlist;

        // Since this function is called multiple times, return the initialised obj
        if ($recipe_shortlist !== NULL) {
            return $recipe_shortlist;
        }

        $recipe_shortlist = new Collection();
        $safe_ingredients = $this->ingredient_repository->lookupUsableIngredients();

        foreach ($this->recipe_repository->getAll() as $recipe) {

            $matched_ingredients = $recipe->getIngredients()->filter(
                function ($recipe_ingredient) use ($safe_ingredients) {

                    // Determine whether the recipe ingredient is in the fridge?
                    // If not cancel out here.
                    if (!$safe_ingredients->has($recipe_ingredient->getName())) {
                        return FALSE;
                    }

                    // Check if the required qty available in the fridge
                    $qty_available = $safe_ingredients->get($recipe_ingredient->getName())->getQty();
                    if ($recipe_ingredient->getQty() <= $qty_available) {
                        return TRUE;
                    }
                }
            );

            // If above specifications get satisfied, short list the recipe
            if ($recipe->getIngredients()->count() == $matched_ingredients->count()) {
                $recipe_shortlist->put($recipe->getName(), $recipe);
            }

        }

        return $recipe_shortlist;
    }

    /**
     * Returns the suitable recipe for the day after considering use-by-date of
     * ingredients in the fridge. The recipe with ingredients which has the closest
     * use by date will be returned.
     *
     * @return Recipe a recipe
     */
    public function todaysRecipe() {

        if ($this->preparableRecipes()->count() == 0) {
            // Throw an order take out exception
        } else if ($this->preparableRecipes()->count() == 1) {

            // Only one found
            return $this->preparableRecipes()->first();
        }


        // Sort usable ingredients by their use-by-date (asc)
        $safe_ingredients_sorted = $this->ingredient_repository->lookupUsableIngredients()->sort(
            function ($a, $b) {
                if ($a->getUsedByDate() == $b->getUsedByDate()) {
                    return 0;
                }

                return ($a->getUsedByDate() < $b->getUsedByDate()) ? -1 : 1;
            }
        );

        // Return the first occurence of the recipe with an ingredient
        // which has the closest use-by-date
        foreach ($safe_ingredients_sorted as $closest_useby_ingredient) {
            $todays_recipe = NULL;

            $this->preparableRecipes()->each(
                function($potential_recipe) use ($closest_useby_ingredient, &$todays_recipe){
                    $found = $potential_recipe->getIngredients()->offsetExists(
                        $closest_useby_ingredient->getName()
                    );

                    // Found the recipe with the closest use-by-date
                    if ($found) {
                        $todays_recipe = $potential_recipe;
                    }
                }
            );

            // Todays recipe is found
            if ($todays_recipe !== NULL) {
                break;
            }
        }

        return $todays_recipe;
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

        dd($this->todaysRecipe());
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
