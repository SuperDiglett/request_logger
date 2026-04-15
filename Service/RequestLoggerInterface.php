<?php declare(strict_types=1);

namespace Sd\RequestLogger\Service;

use Magento\Framework\App\RequestInterface;

interface RequestLoggerInterface
{
    public function log(RequestInterface $request): void;
}
