<?php

namespace RecipeFinder\Ingredient;

use Ingredient;
use Core\Classes\AbstractFileRepository;
use League\Csv\Reader;

class CSVIngredientRepository extends AbstractFileRepository implements IngredientRepositoryInterface {

    const CSV_USEDBYDATE_FORMAT = 'j/n/Y';

    /**
     * CSV file reader
     * @var \Leage\Csv\Reader
     */
    private $csv_reader = NULL;

    /**
     * Path of the CSV file to be parsed
     * @param [type] $filepath [description]
     */
    public function __construct($filepath) {
        $this->setDatasource($filepath);
        $this->initParser();
    }

    /**
     * Return all Ingredients found in the CSV
     * @return array array of Ingredient objects
     */
    public function getAll() {
        $ingredient_rows = $reader->fetchAssoc();
        return self::getIngredientObjs($ingredient_rows);
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

        $ingredient_rows = $reader
            ->addFilter($filter_func);
            ->fetchAssoc();

        return self::getIngredientObjs($ingredient_rows);
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
     * Convert dates used in CSV to DateTime objects
     * ex: '2/12/2014' is in 'j/n/Y' format
     * @param  String $date textual representation of the date as in CSV file
     * @return DateTime     an instance of datetime object if parseable, FALSE instead
     */
    static protected function parseCSVDateFormat($date) {
        $date = DateTime::createFromFormat(
            'j/n/Y',
            $date
        );

        return $date;
    }

    /**
     * Return an array of ingredients based on CSV dataset passed in
     * @param  Array $csv_rows array of CSV row data
     * @return Array           array of ingredient objects
     */
    private static function getIngredientObjs($csv_rows) {
        $ingredients = array();

        foreach ($ingredient_rows as $row) {
            $ingredient = new Ingredient();
            $ingredient
                ->setName($row[0])
                ->setQty($row[1])
                ->setUnit($row[2])
                ->setUsedByDate(self::parseCSVDateFormat($row[3]));

            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

}
