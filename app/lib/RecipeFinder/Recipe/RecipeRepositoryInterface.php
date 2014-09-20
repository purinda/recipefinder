<?php

namespace RecipeFinder\Recipe;

interface RecipeRepositoryInterface {

    /**
     * Return all recipes after from the datasource, no filters used.
     * @return Collection collection of recipes
     */
    public function getAll();

}
