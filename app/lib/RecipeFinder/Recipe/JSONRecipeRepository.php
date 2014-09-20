<?php

namespace RecipeFinder\Recipe;

use Recipe;
use RecipeFinder\Ingredient\Ingredient;
use RecipeFinder\Core\Classes\AbstractFileRepository;
use Illuminate\Filesystem\FileNotFoundException;

class JSONRecipeRepository extends AbstractFileRepository implements RecipeRepositoryInterface {

    /**
     * Iterator to be used for traversing multi-dimensional
     * recipes array.
     * @var RecursiveIteratorIterator
     */
    protected $recipe_iterator;

    /**
     * Path of the JSON file to be parsed
     * @param String $filepath file path
     */
    public function setDatasource($filepath) {
        if (!file_exists($filepath)) {
            throw new FileNotFoundException('Recipe JSON file not found in ' . $filepath);
        }

        parent::setDatasource($filepath);
        $json_content = file_get_contents($filepath);
        $json_recipes = json_decode($json_content, TRUE);

        $this->recipe_iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(
                $json_recipes
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        return $this;
    }

    public function getAll() {

        // Define CSV get all
    }

    public function findByName($id) {

        // Define how factory would find and return an recipe
    }

}
