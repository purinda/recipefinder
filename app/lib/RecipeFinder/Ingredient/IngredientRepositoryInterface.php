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

    /**
     * Lookup all ingredients by their use-by date.
     * If on or before the use-by-date this function will return them.
     *
     * @param  DateTime   $use_by date to be used by, leave empty to use current date
     * @return Collection a collection of ingredients which can be used for cooking as per $when date.
     */
    public function lookupUsableIngredients(DateTime $use_by = NULL);

}
