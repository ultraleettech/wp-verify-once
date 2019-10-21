<?php

namespace Ultraleet\WP\VerifyOnce\Managers;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

/**
 * Class LogManager
 */
class LogManager
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var LoggerInterface
     */
    protected $callbackLogger;

    public function __construct()
    {
        if (! is_dir(ULTRALEET_VO_LOG_PATH)) {
            mkdir(ULTRALEET_VO_LOG_PATH, 0700);
        }
    }

    public function getLogger(): LoggerInterface
    {
        if (! isset($this->logger)) {
            $this->logger = $this->createLogger();
        }
        return $this->logger;
    }

    protected function createLogger(): LoggerInterface
    {
        return $this->newLogger();
    }

    public function getCallbackLogger(): LoggerInterface
    {
        if (! isset($this->callbackLogger)) {
            $this->callbackLogger = $this->createCallbackLogger();
        }
        return $this->callbackLogger;
    }

    protected function createCallbackLogger(): LoggerInterface
    {
        return $this->newLogger('callback-');
    }

    protected function newLogger(string $prefix = ''): LoggerInterface
    {
        $level = WP_DEBUG ?
            Logger::DEBUG :
            Logger::INFO;

        $logger = new Logger('verify-once');
        $formatter = new LineFormatter("[%datetime%] %level_name%: %message% %context%\n", null, true);

        $date = date('Y-m-d');
        $handler = new StreamHandler(ULTRALEET_VO_LOG_PATH . "$prefix$date.log", $level);
        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);

        if (! WP_DEBUG) {
            $date = date('Y-m-d');
            $handler = new StreamHandler(ULTRALEET_VO_LOG_PATH . "{$prefix}debug-$date.log", Logger::DEBUG);
            $handler->setFormatter($formatter);
            $logger->pushHandler($handler);
        }

        return $logger;
    }
}
