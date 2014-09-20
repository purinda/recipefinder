<?php

namespace RecipeFinder\Ingredient;

interface IngredientRepositoryInterface {

    /**
     * Return all ingredients after from the datasource, no filters used.
     * @return Collection collection of ingredients
     */
    public function getAll();

    /**
     * Find an ingredient by name
     * @param  String $name name of the ingredient
     * @return Ingredient   an instance of ingredient
     */
    public function findByName($name);

}
