<?php

namespace App;

class Sample
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        // @codeCoverageIgnoreStart
        echo '';
        // @codeCoverageIgnoreEnd

        echo ''; // @codeCoverageIgnore
    }

    public function sample(int $sample): int
    {
        ++$sample;

        return $sample;
    }
}
