<?php

namespace RecipeFinder\Recipe;

use RecipeFinder\Recipe\Recipe;
use RecipeFinder\Ingredient\Ingredient;
use RecipeFinder\Core\Classes\AbstractFileRepository;
use Illuminate\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;

class JSONRecipeRepository extends AbstractFileRepository implements RecipeRepositoryInterface {

    /**
     * multi-dimensional recipes array.
     * @var mixed
     */
    protected $json_recipes;

    /**
     * Path of the JSON file to be parsed
     * @param String $filepath file path
     */
    public function setDatasource($filepath) {
        if (!file_exists($filepath)) {
            throw new FileNotFoundException('Recipe JSON file not found in ' . $filepath);
        }

        parent::setDatasource($filepath);
        $json_content       = file_get_contents($filepath);
        $this->json_recipes = json_decode($json_content, TRUE);

        return $this;
    }

    /**
     * Return all recipes found in the datasource
     * @return Collection collection of recipe objects
     */
    public function getAll() {
        $recipes = new Collection();

        foreach ($this->json_recipes as $name => $recipe_ingredients) {

            // Not interested in just names
            if (!is_array($recipe_ingredients)) {
                continue;
            }

            $recipe           = new Recipe();
            $ingredients_json = $recipe_ingredients['ingredients'];
            $recipe->setName($recipe_ingredients['name']);

            foreach ($ingredients_json as $ingredient_json) {
                $ingredient = new Ingredient();
                $ingredient
                    ->setName($ingredient_json['item'])
                    ->setQty($ingredient_json['amount'])
                    ->setUnit($ingredient_json['unit']);

                $recipe->addIngredient($ingredient);
            }

            $recipes->push($recipe);
        }

        return $recipes;
    }

    public function lookupByIngredients() {

        // Define CSV get all
    }

    public function findByName($id) {

        // Define how factory would find and return an recipe
    }

}
