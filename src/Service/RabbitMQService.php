<?php

declare(strict_types=1);

namespace RabbitMQ\Service;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMQ\Interfaces\ConsumerInterface;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Interfaces\PublisherInterface;
use RabbitMQ\Interfaces\RabbitMQServiceInterface;

class RabbitMQService implements RabbitMQServiceInterface
{
    private AMQPStreamConnection $connection;

    private AMQPChannel $channel;

    private AMQPTable $table;

    private PublisherInterface $publisher;

    private ConsumerInterface $consumer;

    public function __construct(
        private array $config
    ) {
        $this->table = new AMQPTable();
        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['login'],
            $config['password']
        );

        $this->channel = $this->connection->channel();
    }

    public function push(JobInterface $job): void
    {
        if (is_null($this->publisher)) {
            throw new \DomainException('Publisher not defined.');
        }

        $this->publisher->push($job, $this);
    }

    public function receive(Callable $callback): void
    {
        $this->consumer->receive($callback, $this);
    }

    public function setPublisher(PublisherInterface $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function setConsumer(ConsumerInterface $consumer): void
    {
        $this->consumer = $consumer;
    }

    public function getTable(): AMQPTable
    {
        return $this->table;
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    public function __destruct(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
