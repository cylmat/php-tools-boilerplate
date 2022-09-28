<?php

declare(strict_types=1);

namespace App;

class Sample
{
    public function __construct()
    {
    }

    public function sample(int $sample): int
    {
        return $sample + 1;
    }
}
