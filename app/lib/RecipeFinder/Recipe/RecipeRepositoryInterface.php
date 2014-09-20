<?php

namespace RecipeFinder\Recipe;

interface RecipeRepositoryInterface {

    /**
     * Set the datasource to be used in the child RecipeRepository
     * @param Any $source Implement type in extended class.
     */
    public function setDatasource($source);

    /**
     * Return all recipes after from the datasource, no filters used.
     * @return Collection collection of recipes
     */
    public function getAll();

    /**
     * Find an recipe by name
     * @param  String $name name of the recipe
     * @return Recipe       an instance of recipe
     */
    public function findByName($name);

}
