<?php

declare(strict_types=1);

namespace RabbitMQ\Interfaces;

interface JobInterface
{
    public function getJsonString(): string|bool;
    public function getJson(): array;
}
