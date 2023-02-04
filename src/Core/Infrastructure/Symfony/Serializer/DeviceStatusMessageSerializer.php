<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Serializer;

use App\Core\Application\Message\DeviceStatus\Command;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class DeviceStatusMessageSerializer implements SerializerInterface
{
    /**
     * @param array{
     *     body: string,
     *     headers: array<string,mixed>
     * } $encodedEnvelope
     *
     * @throws \JsonException
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        /** @var array{
         *     device: array{
         *          id: string,
         *          type: string,
         *          mac: string,
         *     },
         *     actual_status: array<mixed>,
         * } $data
         */
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        return new Envelope(new Command($data));
    }

    /**
     * @return array{}
     */
    public function encode(Envelope $envelope): array
    {
        return [];
    }
}
