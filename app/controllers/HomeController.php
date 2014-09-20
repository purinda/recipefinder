<?php

use RecipeFinder\RecipeFinder;

class HomeController extends BaseController {

    public function __construct(RecipeFinder $recipe_finder) {

        // Test mode
        $recipe_finder->test();
    }

	public function showWelcome() {
        // $recipe_finder->setDatasources(,'');
		// return View::make('hello');
	}

}
