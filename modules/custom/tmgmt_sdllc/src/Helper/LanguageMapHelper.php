<?php
namespace Drupal\tmgmt_sdllc\Helper;

/**
 * Language map for the codes
 *
 * @author iflorian
 *        
 */
class LanguageMapHelper
{

    /**
     * Language Map from SDL to Drupal.
     */
    public static function sdllc_helper_get_language_map_sdllc_to_drupal()
    {
        return [
            'ar-sa' => 'ar',
            'az-xc' => 'az',
            'en-us' => 'en',
            'fl' => 'fil',
            'in' => 'id',
            'ji' => 'yi',
            'jw' => 'jv',
            'mn-xc' => 'mn',
            'ms-my' => 'ms',
            'no-no' => 'nb',
            'no-xy' => 'nn',
            'pt' => 'pt-pt',
            'rd' => 'rn',
            'uz-xc' => 'uz',
            'zh-cn' => 'zh-hans',
            'zh-tw' => 'zh-hant'
        ];
    }

    /**
     * Language Map from Drupal to SDL.
     */
    public static function sdllc_helper_get_language_map_drupal_to_sdllc()
    {
        return [
            'ar' => 'ar-sa',
            'az' => 'az-xc',
            'en' => 'en-us',
            'fil' => 'fl',
            'id' => 'in',
            'yi' => 'ji',
            'jv' => 'jw',
            'mn' => 'mn-xc',
            'ms' => 'ms-my',
            'nb' => 'no-no',
            'nn' => 'no-xy',
            'pt-pt' => 'pt',
            'rn' => 'rd',
            'uz' => 'uz-xc',
            'zh-hans' => 'zh-cn',
            'zh-hant' => 'zh-tw'
        ];
    }

    /**
     * Remove invalid characters from a job or file name.
     *
     * @param string $job_name
     *            The job name.
     * @param int $max_length
     *            Max length value.
     *            
     * @return string Sanitized name.
     */
    public static function sdllc_helper_sanitize_name($job_name, $max_length = 0)
    {
        $bad = '/[\/:*?"<>|]/';
        $new_name = trim(preg_replace($bad, "", $job_name));
        return $max_length ? substr($new_name, 0, $max_length) : $new_name;
    }

    /**
     * Maps Mantra languages to Drupal languages.
     *
     * @param string $language
     *            SDL language code.
     *            
     * @return string Drupal language code
     */
    public static function sdllc_helper_map_language_sdllc_to_drupal($language)
    {
        $map = HelperLanguageMapHelper::sdllc_helper_get_language_map_sdllc_to_drupal();

        if (array_key_exists($language, $map)) {
            return $map[$language];
        }

        return $language;
    }
}
