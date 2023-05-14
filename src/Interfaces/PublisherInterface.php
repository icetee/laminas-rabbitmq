<?php

declare(strict_types=1);

namespace RabbitMQ\Interfaces;

use RabbitMQ\Service\RabbitMQService;

interface PublisherInterface
{
    public function push(JobInterface $job, RabbitMQService $rabbitMQService): void;
}
