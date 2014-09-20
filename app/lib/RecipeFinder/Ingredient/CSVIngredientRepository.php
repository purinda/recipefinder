<?php

namespace RecipeFinder\Ingredient;

use Ingredient;
use Core\Classes\AbstractFileRepository;
use League\Csv\Reader;

class CSVIngredientRepository extends AbstractFileRepository implements IngredientRepositoryInterface {

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

    public function getAll() {

    }

    public function findById($id) {

    }

}
