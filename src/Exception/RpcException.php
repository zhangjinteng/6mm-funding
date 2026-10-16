<?php

declare(strict_types=1);

namespace SixMm\Funding\Exception;

use RuntimeException;

final class RpcException extends RuntimeException
{
    private string $method;

    public function __construct(string $method, int $statusCode, string $details)
    {
        $this->method = $method;
        parent::__construct('Funding RPC ' . $method . ' failed: ' . $details, $statusCode);
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
