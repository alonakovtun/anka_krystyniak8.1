<?php

declare (strict_types=1);
namespace WGPayuVendor\WPDesk\Logger;

use WGPayuVendor\Monolog\Handler\HandlerInterface;
use WGPayuVendor\Monolog\Handler\NullHandler;
use WGPayuVendor\Monolog\Logger;
use WGPayuVendor\Monolog\Handler\ErrorLogHandler;
use WGPayuVendor\WPDesk\Logger\WC\WooCommerceHandler;
final class SimpleLoggerFactory implements \WGPayuVendor\WPDesk\Logger\LoggerFactory
{
    /** @var Settings */
    private $options;
    /** @var string */
    private $channel;
    /** @var Logger */
    private $logger;
    public function __construct(string $channel, \WGPayuVendor\WPDesk\Logger\Settings $options = null)
    {
        $this->channel = $channel;
        $this->options = $options ?? new \WGPayuVendor\WPDesk\Logger\Settings();
    }
    public function getLogger($name = null) : \WGPayuVendor\Monolog\Logger
    {
        if ($this->logger) {
            return $this->logger;
        }
        $logger = new \WGPayuVendor\Monolog\Logger($this->channel);
        if ($this->options->use_wc_log && \function_exists('wc_get_logger')) {
            $logger->pushHandler(new \WGPayuVendor\WPDesk\Logger\WC\WooCommerceHandler(\wc_get_logger(), $this->channel));
        }
        // Adding WooCommerce logger may have failed, if so add WP by default.
        if ($this->options->use_wp_log || empty($logger->getHandlers())) {
            $logger->pushHandler($this->get_wp_handler());
        }
        return $this->logger = $logger;
    }
    private function get_wp_handler() : \WGPayuVendor\Monolog\Handler\HandlerInterface
    {
        if (\defined('WGPayuVendor\\WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            return new \WGPayuVendor\Monolog\Handler\ErrorLogHandler(\WGPayuVendor\Monolog\Handler\ErrorLogHandler::OPERATING_SYSTEM, $this->options->level);
        }
        return new \WGPayuVendor\Monolog\Handler\NullHandler();
    }
}
