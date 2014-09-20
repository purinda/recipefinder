<?php

namespace RecipeFinder\Recipe;

use RecipeFinder\Ingredient\AbstractIngredient;
use RecipeFinder\Ingredient\Ingredient;
use Illuminate\Support\Collection;

class Recipe {

    /**
     * Recipe name
     * @var string
     */
    protected $name = '';

    /**
     * Ingredients required for the recipe is stored here.
     * @var Collection
     */
    protected $ingredients = null;

    public function __construct() {
        $this->ingredients = new Collection();
    }

    /**
     * Set recipe name
     * @param String $name set a name for the recipe
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get recipe name
     * @return String recipe name is returned
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Add an ingredient to the recipe.
     * @param AbstractIngredient $ingredient ingredient obj
     */
    public function addIngredient(AbstractIngredient $ingredient) {
        $this->ingredients->push($ingredient);
        return $this;
    }

    /**
     * Get Ingredients
     * @return Collection a collection of Ingredients
     */
    public function getIngredients() {
        return $this->ingredients;
    }

}
