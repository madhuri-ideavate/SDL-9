<?php
namespace Drupal\tmgmt_sdllc\Helper;
use Drupal\tmgmt\JobInterface;

/**
 * Job helper
 *
 * @author iflorian
 *        
 */
class JobHelper
{

    /**
     * Returns the calculated default job folder.
     */
    public static function sdllc_helper_get_job_folder(JobInterface $job)
    {
        $folder = $job->id() . '_' . $job->getTargetLangcode();

        return $job->getSetting('scheme') . '://tmgmt_sdllc_repository/' . $folder;
    }
}
