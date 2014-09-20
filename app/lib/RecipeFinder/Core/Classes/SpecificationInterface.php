<?php

namespace RecipeFinder\Core\Classes;

interface SpecificationInterface {

    public function isSatisfiedBy($contestant);

    public function getMessages();

}
