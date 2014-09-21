<?php

use RecipeFinder\Ingredient\CSVIngredientRepository;
use RecipeFinder\Ingredient\Ingredient;
use Illuminate\Support\Collection;

class IngredientsTest extends TestCase {
    private $ingredients_csv;

    public function setUp() {
        parent::setup();
        $this->ingredients_csv = app_path() . '/tests/data/ingredients.csv';
    }

    public function testIngredientsRepositoryInterface() {
        $ingredient_repository = new CSVIngredientRepository();
        $this->assertInstanceOf('\RecipeFinder\Ingredient\IngredientRepositoryInterface', $ingredient_repository);
    }

    public function testCSVIngredientsRepository() {
        $ingredient_repository = new CSVIngredientRepository();
        $this->assertInstanceOf('\RecipeFinder\Ingredient\CSVIngredientRepository', $ingredient_repository);
    }

    public function testCSVIngredientsRepositoryParseable() {
        $ingredient_repository = new CSVIngredientRepository();
        $ingredient_repository->setDatasource($this->ingredients_csv);
        $ingredient_repository->getAll();
        $this->assertInstanceOf('\Illuminate\Support\Collection', $ingredient_repository->getAll());

        // Test first and last ingredients
        $this->assertEquals($ingredient_repository->getAll()->first()->getName(), 'bread');
        $this->assertEquals($ingredient_repository->getAll()->last()->getName(), 'mixed salad');
    }

    public function testSetGetIngredient() {
        $ingredient = new Ingredient();
        $ingredient
            ->setName('water')
            ->setQty('100')
            ->setUnit('litres')
            ->setUsedByDate(NULL);

        $this->assertEquals($ingredient->getName(), 'water');
        $this->assertEquals($ingredient->getUnit(), 'litres');
        $this->assertEquals($ingredient->getUsedByDate(), NULL);
    }

}
