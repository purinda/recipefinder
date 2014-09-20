<?php

namespace RecipeFinder\Ingredient;

interface IngredientRepositoryInterface {

    /**
     * Set the datasource to be used in the child IngredientRepository
     * @param Any $source Implement type in extended class.
     */
    public function setDatasource($source);

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
