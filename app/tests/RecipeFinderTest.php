<?php

use RecipeFinder\Ingredient\CSVIngredientRepository;
use RecipeFinder\Ingredient\Ingredient;
use RecipeFinder\Recipe\JSONRecipeRepository;
use RecipeFinder\Recipe\Ingredient as RecipeIngredient;
use RecipeFinder\Recipe\Recipe;
use RecipeFinder\RecipeFinder;

use Illuminate\Support\Collection;

class RecipeFinderTest extends TestCase {

    private $recipe_finder;

    public function setUp() {
        parent::setup();

        $ingredient_repository = new CSVIngredientRepository();
        $recipe_repository     = new JSONRecipeRepository();

        $ingredient_repository->setDatasource(app_path() . '/tests/data/ingredients.csv');
        $recipe_repository->setDatasource(app_path() . '/tests/data/recipes.json');

        App::bind(
            'RecipeFinder\Ingredient\IngredientRepositoryInterface',
            'RecipeFinder\Ingredient\CSVIngredientRepository'
        );

        App::bind(
            'RecipeFinder\Recipe\RecipeRepositoryInterface',
            'RecipeFinder\Recipe\JSONRecipeRepository'
        );

        $this->recipe_finder = new RecipeFinder($recipe_repository, $ingredient_repository);
    }

    public function testRecipeForTheDay() {

        // Test 1
        $datetime_1 = \DateTime::createFromFormat('j/n/Y', '20/10/2014');
        $this->assertEquals('grilled cheese on toast', $this->recipe_finder->todaysRecipe($datetime_1)->getName());

        // Test 2 - Change year to 2013
        $datetime_2 = \DateTime::createFromFormat('j/n/Y', '20/10/2013');
        $this->assertEquals('salad sandwich', $this->recipe_finder->todaysRecipe($datetime_2)->getName());

    }

}
