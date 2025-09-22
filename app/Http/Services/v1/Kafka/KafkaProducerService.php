<?php

namespace App\Http\Services\v1\Kafka;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class KafkaProducerService
{
    public function publish(string $topic, ?string $tenant, array $data): void
    {
        $headers = [];

        if (!empty($tenant)) {
            $headers['X-Tenant'] = $tenant;
        }

        $message = new Message(
            headers: $headers,
            body: $data,
        );

        Kafka::publish()
            ->onTopic($topic)
            ->withMessage($message)
            ->send();
    }
}
