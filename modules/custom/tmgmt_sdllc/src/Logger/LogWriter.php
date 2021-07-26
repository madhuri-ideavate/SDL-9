<?php
namespace Drupal\tmgmt_sdllc\Logger;

/**
 *
 * @author iflorian
 *        
 */
class LogWriter
{

    /**
     * Info method (write info message)
     *
     * @param string $message
     * @return void
     */
    public static function info($message)
    {
        \Drupal::logger('tmgmt_sdllc')->info($message);
    }

    /**
     * Error method (write error message)
     *
     * @param string $message
     * @return void
     */
    public static function error($message)
    {
        \Drupal::logger('tmgmt_sdllc')->error($message);
    }
}