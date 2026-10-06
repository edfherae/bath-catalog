<?php

namespace App\DTO;

class ProjectFilter {
    public function __construct(
        public ?int $areaMin = null,
        public ?int $areaMax = null,
        public array $floors = [],
        public ?bool $hasPool = null,
    ) {}
}