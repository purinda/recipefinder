<?php

namespace RecipeFinder;

use RecipeFinder\Recipe\RecipeRepositoryInterface;
use RecipeFinder\Ingredient\IngredientRepositoryInterface;
use RecipeFinder\Core\Specifications\IngredientInFridgeSpecification;
use RecipeFinder\Core\Specifications\RecipeIngredientQtyAvailableSpecification;
use RecipeFinder\Core\Exceptions\OrderTakeoutException;
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
     * @param  DateTime $date override current date
     * @return Collection returns a collection of recipes based on current date or overridden date.
     */
    public function preparableRecipes(\DateTime $date = NULL) {
        $safe_ingredients = $this->ingredient_repository->lookupUsableIngredients($date);

        // Init required specifications
        $this->specIngredientInFridge = new IngredientInFridgeSpecification($this->ingredient_repository);
        $this->specRecipeQtyAvilable  = new RecipeIngredientQtyAvailableSpecification($safe_ingredients);

        $recipe_shortlist = new Collection();
        foreach ($this->recipe_repository->getAll() as $recipe) {

            $matched_ingredients_in_fridge = $recipe->getIngredients()->filter(
                function ($recipe_ingredient) use ($safe_ingredients) {

                    // Determine whether the recipe ingredient is in the fridge?
                    // If not cancel out here.
                    if (!$this->specIngredientInFridge->isSatisfiedBy($recipe_ingredient)) {
                        return FALSE;
                    }

                    // Check if the required qty available in the fridge
                    if ($this->specRecipeQtyAvilable->isSatisfiedBy($recipe_ingredient)) {
                        return TRUE;
                    }
                }
            );

            // If above specifications get satisfied, short list the recipe
            if ($recipe->getIngredients()->count() == $matched_ingredients_in_fridge->count()) {
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
     * @param  DateTime $date override current date
     * @return Recipe a recipe
     */
    public function todaysRecipe(\DateTime $date = NULL) {
        $preparable_recipes = $this->preparableRecipes($date);

        if ($preparable_recipes->count() == 0) {
            throw new OrderTakeoutException();
        } else if ($preparable_recipes->count() == 1) {

            // Only one found
            return $preparable_recipes->first();
        }

        // Sort usable ingredients by their use-by-date (asc)
        $safe_ingredients_sorted = $this->ingredient_repository->lookupUsableIngredients($date)->sort(
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

            $preparable_recipes->each(
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
