<?php

declare(strict_types=1);

namespace RabbitMQ;

use RabbitMQ\Interfaces\RabbitMQServiceInterface;
use RabbitMQ\Service\RabbitMQServiceFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'    => [],
            'invokables' => [],
            'factories'  => [
                RabbitMQServiceInterface::class => RabbitMQServiceFactory::class,
            ],
        ];
    }
}
