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
    }

    public function sample(int $sample): int
    {
        ++$sample;
        echo ''; // @codeCoverageIgnore

        return $sample;
    }
}
