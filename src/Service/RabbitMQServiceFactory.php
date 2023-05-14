<?php

declare(strict_types=1);

namespace RabbitMQ\Service;

use Psr\Container\ContainerInterface;

final class RabbitMQServiceFactory
{
    public function __invoke(ContainerInterface $container): RabbitMQService
    {
        $config = $container->has('config') ? $container->get('config') : [];

        return new RabbitMQService(
            $config['rabbitmq'],
        );
    }
}
