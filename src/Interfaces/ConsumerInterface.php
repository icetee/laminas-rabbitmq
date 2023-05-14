<?php

declare(strict_types=1);

namespace RabbitMQ\Interfaces;

use RabbitMQ\Service\RabbitMQService;

interface ConsumerInterface
{
    public function receive(Callable $callback, RabbitMQService $rabbitMQService);
}
