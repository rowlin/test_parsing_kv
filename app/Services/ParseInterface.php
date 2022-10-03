<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\DealTypeEnum;

interface ParseInterface
{
    public function __construct();

    public  function setDeal(DealTypeEnum $data ): void;

    public function getData(): array;

    public function store() : array;

    public function run(): array;

}
