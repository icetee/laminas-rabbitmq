<?php

declare(strict_types=1);

namespace RabbitMQ;

class Module
{
    /**
     * Retrieve default laminas-db configuration for laminas-mvc context.
     *
     * @return array
     */
    public function getConfig()
    {
        $provider = new ConfigProvider();

        return [
            'service_manager' => $provider->getDependencies(),
        ];
    }
}
