<?php

namespace RecipeFinder;

class RecipeFinder {

    /**
     * Used-by-date of an ingredient.
     * Not defined in abstract class as some ingredients may not have an expiry
     * date.
     * @var DateTime
     */
    protected $used_by_date;

    /**
     * Set used-by-date
     * @param Datetime $date a date to be set.
     */
    public function setUsedByDate(DateTime $date = null) {
        $this->used_by_date = $date;
        return $this;
    }

    /**
     * Get used-by-date of the ingredient
     * @return  DateTime used-by-date of the ingredient.
     */
    public function getUsedByDate() {
        return $this->used_by_date;
    }

}
