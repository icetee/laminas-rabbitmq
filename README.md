# laminas-rabbitmq
Laminas Module for RabbitMQ

## Install

`composer require dimkamonster/laminas-rabbitmq`


## Configure

create configuration with `rabbitmq` key as described below:

```php
<?php

return [
    'rabbitmq' => [
        'host'     => 'localhost',
        'port'     => 5672,
        'login'    => 'guest',
        'password' => 'guest',
    ],
]
```

Make sure the module enabled and try an example below.

### Send message

```php
<?php

/**
 * @var \RabbitMQ\Interfaces\RabbitMQServiceInterface $mq
 * @var \Psr\Container\ContainerInterface $container
 */

$mq = $container->get(\RabbitMQ\Interfaces\RabbitMQServiceInterface::class);
$publisher = new \RabbitMQ\Publisher\WorkQueuePublisher('test_work_queue');
$job = new \RabbitMQ\Job\Job(['some' => 'data']);

$mq->setPublisher($publisher);
$mq->push($job);
```

### Receive message

```php
<?php

/**
 * @var \RabbitMQ\Interfaces\RabbitMQServiceInterface $mq
 * @var \Psr\Container\ContainerInterface $container
 */

$mq = $container->get(\RabbitMQ\Interfaces\RabbitMQService::class);
$consumer = new \RabbitMQ\Consumer\WorkQueueConsumer('test_work_queue');
$mq->setConsumer($consumer);

$mq->receive(function (\RabbitMQ\Consumer\Message $message) {
    echo $message->getBody();

    $message->ack();
});
```
