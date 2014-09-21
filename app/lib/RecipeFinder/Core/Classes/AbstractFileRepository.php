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
    public function setDatasource($filepath) {
        $this->filepath = $filepath;
        return $this;
    }

    /**
     * Get file to be parsed.
     * @return String path to the file to be parsed.
     */
    public function getDatasource() {
        return $this->filepath;
    }

}
