<?php

use RecipeFinder\Recipe\JSONRecipeRepository;
use RecipeFinder\Recipe\Ingredient;
use RecipeFinder\Recipe\Recipe;
use Illuminate\Support\Collection;

class RecipesTest extends TestCase {
    private $recipes_json;

    public function setUp() {
        parent::setup();
        $this->recipes_json = app_path() . '/tests/data/recipes.json';
    }

    public function testRecipesRepositoryInterface() {
        $recipes_repository = new JSONRecipeRepository();
        $this->assertInstanceOf('\RecipeFinder\Recipe\RecipeRepositoryInterface', $recipes_repository);
    }

    public function testJSONRecipesRepository() {
        $recipes_repository = new JSONRecipeRepository();
        $this->assertInstanceOf('\RecipeFinder\Recipe\JSONRecipeRepository', $recipes_repository);
    }

    public function testJSONRepositoryParseable() {
        $recipes_repository = new JSONRecipeRepository();
        $recipes_repository->setDatasource($this->recipes_json);
        $recipes_repository->getAll();
        $this->assertInstanceOf('\Illuminate\Support\Collection', $recipes_repository->getAll());

        // Test first and last ingredients
        $this->assertEquals($recipes_repository->getAll()->first()->getName(), 'grilled cheese on toast');
        $this->assertEquals($recipes_repository->getAll()->last()->getName(), 'salad sandwich');
    }

    public function testSetGetRecipeIngredients() {
        $ingredient = new Ingredient();
        $ingredient
            ->setName('water')
            ->setQty('100')
            ->setUnit('litres');

        $recipe = new Recipe();
        $recipe->addIngredient($ingredient);

        $this->assertEquals($recipe->getIngredients()->first()->getName(), 'water');
        $this->assertEquals($recipe->getIngredients()->first()->getUnit(), 'litres');
        $this->assertEquals($recipe->getIngredients()->first()->getQty(), '100');
    }

}
