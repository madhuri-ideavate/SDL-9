<?php
namespace Drupal\tmgmt_sdllc\Helper;

/**
 * Job helper
 *
 * @author iflorian
 *        
 */
class FileHelper
{

    /**
     * Splits file array into multiple arrays with total filesize < 1M bytes each.
     *
     * To overcome the max payload issue.
     */
    public static function sdllc_helper_split_files(array $files)
    {
        $max_allow_size = 1000 * 1000;
        $split_files = [];

        $current_file_size = 0;
        $current_total_size = 0;
        $current_split = 0;
        $split_files[$current_split] = [];
        foreach ($files as $file) {
            $current_file_size = filesize($file);

            if ($current_file_size >= $max_allow_size) {
              \Drupal::messenger()->addMessage(t('Filesize is too large. Filename: @file', [
                    '@file' => $file
                ]), 'error');
                return NULL;
            }

            if ($current_total_size + $current_file_size < $max_allow_size) {
                $current_total_size += $current_file_size;
                $split_files[$current_split][] = $file;
            } else {
                $current_total_size = $current_file_size;
                $current_split ++;
                $split_files[$current_split] = [];
                $split_files[$current_split][] = $file;
            }
        }

        return $split_files;
    }
}
