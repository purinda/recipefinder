<?php

namespace RecipeFinder\Core\Classes;

use Illuminate\Support\MessageBag;

abstract class AbstractSpecification implements SpecificationInterface {

    protected $messages;

    public function __construct() {
        $this->messages = new MessageBag();
    }

    public abstract function isSatisfiedBy($contestant);

    public function getMessages() {
        return $this->messages;
    }

    protected function clearMessages() {
        $this->messages = new MessageBag;
    }

    protected function addMessage($section, $message) {
        $this->messages->add($section, $message);
        return $this;
    }
}
