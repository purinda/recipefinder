<?php

use RecipeFinder\RecipeFinder;
use RecipeFinder\Core\Exceptions\OrderTakeoutException;

class HomeController extends BaseController {

    protected $recipe_finder;
    protected $layout = 'layouts.layout';

    public function __construct(RecipeFinder $recipe_finder) {
        $this->recipe_finder = $recipe_finder;
    }

    public function showWelcome() {
        return View::make('home/index');
    }

    public function upload() {
        if (!Input::hasFile('ingredients-file') || !Input::hasFile('recipes-file')) {

            // Silently redirect
            return Redirect::to('/');
        }

        $ingredients_file = Input::file('ingredients-file')->getRealPath();
        $recipes_file     = Input::file('recipes-file')->getRealPath();

        // Set files
        $this->recipe_finder->setDatasources($ingredients_file, $recipes_file);

        try {
            $recipe_name = $this->recipe_finder->todaysRecipe()->getName();
        } catch (OrderTakeoutException $e) {
            $recipe_name = 'order takeout';
        }
        return Redirect::to('/todaysRecipe')->with('recipe', $recipe_name);
    }

    public function test() {
        try {
            $recipe_name = $this->recipe_finder->test()->getName();
        } catch (OrderTakeoutException $e) {
            $recipe_name = 'order takeout';
        }

        return Redirect::to('/todaysRecipe')->with('recipe', $recipe_name);

    }

    public function todaysRecipe() {
        if (!Session::get('recipe')) {
            return Redirect::to('/');
        }

        return View::make('home/index')->with('recipe', Session::get('recipe'));
    }
}
