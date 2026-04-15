<?php declare(strict_types=1);

namespace Sd\RequestLogger\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\ScopeInterface;
// use Sd\RequestLogger\Service\RequestLoggerInterface;

class LogRequest implements ObserverInterface
{
    private const XML_PATH_ENABLED = 'sd_mage_request_logger/sd_mage_request_logger_settings/enabled';
    private const XML_PATH_ENDPOINT_WHITELIST = 'sd_mage_request_logger/sd_mage_request_logger_settings/endpoint_whitelist';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        // private readonly RequestLoggerInterface $requestLogger,
    ) {}

    public function execute(Observer $observer): void
    {
        if (!$this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE)) {
            return;
        }

        $request = $observer->getEvent()->getRequest();

        if (!$this->isPathWhitelisted($request->getPathInfo())) {
            return;
        }

        // $this->requestLogger->log($request);
    }

    private function isPathWhitelisted(string $path): bool
    {
        $whitelist = json_decode(
            (string) $this->scopeConfig->getValue(self::XML_PATH_ENDPOINT_WHITELIST, ScopeInterface::SCOPE_STORE),
            true
        );

        if (!is_array($whitelist) || empty($whitelist)) {
            return false;
        }

        foreach ($whitelist as $pattern) {
            if ($this->matchesPattern($path, $pattern)) {
                return true;
            }
        }

        return false;
    }

    private function matchesPattern(string $path, string $pattern): bool
    {
        $regex = '/^' . str_replace('\*', '.*', preg_quote($pattern, '/')) . '$/i';
        return (bool) preg_match($regex, $path);
    }
}
