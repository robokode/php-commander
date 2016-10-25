<?php

namespace Clue\Commander\Tokens;

use InvalidArgumentException;

class SentenceToken implements TokenInterface
{
    private $tokens;

    public function __construct(array $tokens)
    {
        if (count($tokens) < 2) {
            throw new InvalidArgumentException('Sentence must contain at least 2 tokens');
        }

        foreach ($tokens as $token) {
            if (!$token instanceof TokenInterface) {
                throw new InvalidArgumentException('Sentence must only contain valid tokens');
            } elseif ($token instanceof self) {
                throw new InvalidArgumentException('Sentence must not contain sub-sentence token');
            }
        }

        $this->tokens = $tokens;
    }

    public function matches(array &$input, array &$output)
    {
        $sinput = $input;
        $soutput = $output;

        foreach ($this->tokens as $token) {
            if (!$token->matches($input, $output)) {
                $input = $sinput;
                $output = $soutput;
                return false;
            }
        }

        return true;
    }

    public function __toString()
    {
        return implode(' ', $this->tokens);
    }
}