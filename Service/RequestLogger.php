<?php declare(strict_types=1);

namespace Sd\RequestLogger\Service;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\App\ResourceConnection;
// use Sd\RequestLogger\Service\SanitizerInterface;

class RequestLogger implements RequestLoggerInterface
{
    private AdapterInterface $connection;

    public function __construct(
        ResourceConnection $resourceConnection,
        // private readonly SanitizerInterface $sanitizer,
    ) {
        $this->connection = $resourceConnection->getConnection();
    }

    public function log(RequestInterface $request): void
    {
        $headers = $request->getHeaders()->toArray();
        $body = $request->getContent();

        // $headers = $this->sanitizer->sanitizeHeaders($headers);
        // $body = $this->sanitizer->sanitizeBody($body, $headers);

        $this->connection->insert(
            $this->connection->getTableName('sd_request_log'),
            [
                'direction'       => 'incoming',
                'endpoint'        => $request->getPathInfo(),
                'http_method'     => $request->getMethod(),
                'request_headers' => json_encode($headers),
                'request_body'    => $body,
            ]
        );
    }
}
