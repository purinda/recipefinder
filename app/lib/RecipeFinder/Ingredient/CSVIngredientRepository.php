<?php

namespace RecipeFinder\Ingredient;

use Ingredient;

class CSVIngredientRepository implements IngredientRepositoryInterface {

    /**
     * Path to the CSV file to be parsed to retrieve ingredients.
     * @var String
     */
    protected $filepath;

    /**
     * Set ingredients (CSV) file to be parsed.
     * @return String path to the file to be parsed.
     */
    private function setDatasource($filepath) {
        $this->filepath = $filepath;
        return $this;
    }

    public function getAll() {

        // Define CSV get all

    }

    public function findById($id) {

        // Define how factory would find and return an ingridient
    }

}
