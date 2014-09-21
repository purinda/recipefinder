<?php

namespace RecipeFinder\Core\Specifications;

use RecipeFinder\Ingredient\Ingredient;
use RecipeFinder\Core\Classes\AbstractSpecification;
use Illuminate\Support\Collection;

class RecipeIngredientQtyAvailableSpecification extends AbstractSpecification {

    /**
     * Collection of ingredients to be validated against
     * @var [type]
     */
    private $usable_ingredients;

    public function __construct(Collection $ingredients) {
        parent::__construct();
        $this->usable_ingredients = $ingredients;
    }

    /**
     * Check if the recipe ingredient qty is available in the
     * ridge or not.
     *
     * @param  Ingredient $contestant [description]
     * @return boolean                return TRUE if qty can be met, FALSE if not
     */
    public function isSatisfiedBy($contestant) {
        $qty_available = 0;
        if ($this->usable_ingredients->count()) {
            if ($this->usable_ingredients->get($contestant->getName())) {
                $qty_available = $this->usable_ingredients->get($contestant->getName())->getQty();
            }
        }

        if ($contestant->getQty() <= $qty_available) {
            return TRUE;
        }

        $this->addMessage('INGREDIENTS', 'Required amount of ingredients is not available in the fridge.');
        return FALSE;
    }
}
