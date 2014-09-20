<?php

namespace RecipeFinder\Recipe;

use Recipe;

class JSONRecipeRepository implements RecipeRepositoryInterface {

    /**
     * Path to the JSON file to be parsed to retrieve recipes.
     * @var String
     */
    protected $filepath;

    /**
     * Set recipe (JSON) file to be parsed.
     * @return String path to the file to be parsed.
     */
    private function setDatasource($filepath) {
        $this->filepath = $filepath;
        return $this;
    }

    public function getAll() {

        // Define CSV get all
    }

    public function findByName($id) {

        // Define how factory would find and return an recipe
    }

}
