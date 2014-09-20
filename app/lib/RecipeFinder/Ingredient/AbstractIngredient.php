<?php

namespace RecipeFinder\Ingredient;

abstract class AbstractIngredient {

    /**
     * Ingredient name
     * @var String
     */
    protected $name;

    /**
     * Qty available
     * @var Int
     */
    protected $qty;

    /**
     * Unit of measurement
     * @var String
     */
    protected $unit;

    /**
     * Ingredient name setter
     * @param String $name name of the ingredient
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Ingredient name getter
     * @return String name of the ingredient
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the amount for this perticular ingredient.
     * @param Int A number specifying how much/many available.
     */
    public function setQty($amount) {
        $this->qty = $amount;
        return $this;
    }

    /**
     * Getter to find out the remaining amount of a perticular
     * ingredient.
     * @return Int a number representing the remaining amount
     */
    public function getQty() {
        return $this->qty;
    }

    /**
     * Sets the measurement unit name of the ingredient.
     * @param String $unit_name name of the unit
     */
    public function setUnit($unit_name) {
        $this->unit = $unit_name;
        return $this;
    }

    /**
     * Gets the measurement unit name of the ingredient.
     * @return String name of the unit
     */
    public function getUnit() {
        return $this->unit;
    }
}
