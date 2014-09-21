<?php

namespace RecipeFinder\Ingredient;

use RecipeFinder\Ingredient\Ingredient;
use RecipeFinder\Core\Classes\AbstractFileRepository;
use League\Csv\Reader;
use Illuminate\Support\Collection;

class CSVIngredientRepository extends AbstractFileRepository implements IngredientRepositoryInterface {

    const CSV_USEDBYDATE_FORMAT = 'j/n/Y';

    /**
     * CSV file reader
     * @var \Leage\Csv\Reader
     */
    private $csv_reader = NULL;

    /**
     * Path of the CSV file to be parsed
     * @param String $filepath file path
     */
    public function setDatasource($filepath) {
        parent::setDatasource($filepath);
        $this->initParser();

        return $this;
    }

    /**
     * Initialises the League CSV Reader if not initialised yet.
     * @return Boolean return TRUE if gets initialised or
     *                 FALSE if already initialised
     */
    private function initParser() {
        if ($this->csv_reader !== NULL) {
            return FALSE;
        }

        $this->csv_reader = Reader::createFromPath($this->getDatasource());
        return TRUE;
    }

    /**
     * Return all Ingredients found in the CSV
     * @return Collection collection of Ingredient objects
     */
    public function getAll() {
        $ingredient_rows = $this->csv_reader->fetchAll();
        return self::getIngredientCollection($ingredient_rows);
    }

    /**
     * Find ingredient by name.
     * @param  String $name name of the ingredient
     * @return Ingredient   an instance of the ingredient object if found or NULL if doesn't
     */
    public function findByName($name) {

        // Define the filter to be used for finding the match
        $filter_func = function($row) use ($name) {
            return $row[0] == $name;
        };

        // Filter CSV data using the above filter
        $ingredient_rows = $this->csv_reader
            ->addFilter($filter_func)
            ->fetchAll();

        return self::getIngredientCollection($ingredient_rows)->first();
    }

    /**
     * Lookup all ingredients by their use-by date.
     * If an ingredient expiry is on or before the use-by-date
     * this function will return them. Filters safe items
     * to be consumed.
     *
     * @param  DateTime   $use_by date to be used by, leave empty to use current date
     * @return Collection a collection of ingredients which can be used
     *                    for cooking as per $when date.
     */
    public function lookupUsableIngredients(\DateTime $use_by = NULL) {

        // If not defines use current date
        if ($use_by === NULL) {
            var_dump($use_by);
            $use_by = new \DateTime();
        }

        // Define the filter to be used for finding the match
        $filter_func = function($row) use ($use_by) {
            if (empty($row) || !isset($row[3])) {
                return FALSE;
            }

            return $use_by <= self::parseCSVDateFormat($row[3]);
        };

        // Filter CSV data using the above filter
        $ingredient_rows = $this->csv_reader
            ->addFilter($filter_func)
            ->fetchAll();

        return self::getIngredientCollection($ingredient_rows);
    }


    /**
     * Convert dates used in CSV to DateTime objects
     * ex: '2/12/2014' is in 'j/n/Y' format
     * @param  String $date textual representation of the date as in CSV file
     * @return DateTime     an instance of datetime object if parseable, FALSE instead
     */
    static protected function parseCSVDateFormat($date) {
        $date = \DateTime::createFromFormat(
            'j/n/Y',
            $date
        );

        return $date;
    }

    /**
     * Return an array of ingredients based on CSV dataset passed in
     * @param  Array $csv_rows array of CSV row data
     * @return Collection      array of ingredient objects
     */
    private static function getIngredientCollection($csv_rows) {
        $ingredients = new Collection();

        foreach ($csv_rows as $row) {

            // Ignore whitespace/eof chars
            if (empty(trim($row[0]))) {
                continue;
            }

            $ingredient = new Ingredient();
            $ingredient
                ->setName($row[0])
                ->setQty($row[1])
                ->setUnit($row[2])
                ->setUsedByDate(self::parseCSVDateFormat($row[3]));

            $ingredients->put($ingredient->getName(), $ingredient);
        }

        return $ingredients;
    }

}
