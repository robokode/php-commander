<?php

namespace Clue\Commander\Tokens;

class ArgumentToken implements TokenInterface
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function matches(array &$input, array &$output)
    {
        $dd = false;
        foreach ($input as $key => $value) {
            if ($value === '' || $value[0] !== '-' || $dd) {
                unset($input[$key]);
                $output[$this->name] = $value;
                return true;
            } elseif ($value === '--') {
                // found a double dash => following must be an argument
                $dd = true;
            }
        }

        return false;
    }

    public function __toString()
    {
        return '<' . $this->name . '>';
    }
}