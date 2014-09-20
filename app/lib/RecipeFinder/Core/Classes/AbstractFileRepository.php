<?php

namespace RecipeFinder\Core\Classes;

abstract class AbstractFileRepository {

    /**
     * Path to the file to be parsed to retrieve content.
     * @var String
     */
    protected $filepath;

    /**
     * Set file to be parsed.
     * @return String path to the file to be parsed.
     */
    private function setDatasource($filepath) {
        $this->filepath = $filepath;
        return $this;
    }

}
