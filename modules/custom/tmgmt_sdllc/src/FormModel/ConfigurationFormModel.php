<?php
namespace Drupal\tmgmt_sdllc\FormModel;

class ConfigurationFormModel
{

    public $sdllc_url;

    public $sdllc_client_id;

    public $sdllc_client_secret;

    public $sdllc_username;

    public $sdllc_password;

    public $sdllc_previously_translated_fields_options;

    public $xliff_processing;

    public $sdllc_download_as_zip;

    public function __construct($translator)
    {
        $this->sdllc_url = $this->setSdllcCurl($translator->getSetting('sdllc_url'));
        $this->sdllc_client_id = $this->setSdllcClientId($translator->getSetting('sdllc_client_id'));
        $this->sdllc_client_secret = $this->setSdllcClientSecret($translator->getSetting('sdllc_client_secret'));
        $this->sdllc_username = $this->setSdllcUsername($translator->getSetting('sdllc_username'));
        $this->sdllc_password = $this->setSdllcPassword($translator->getSetting('sdllc_password'));
        $this->sdllc_previously_translated_fields_options = $this->setSdllcPreviouslyTranslatedFieldsOptions($translator->getSetting('sdllc_previously_translated_fields_options'));
        $this->xliff_processing = $this->setXliffProcessing($translator->getSetting('xliff_processing'));
        $this->sdllc_download_as_zip = $this->setSdllcDownloadAsZip($translator->getSetting('sdllc_download_as_zip'));
    }

    public function setSdllcDownloadAsZip($data)
    {
        return [
            '#type' => 'checkbox',
            '#title' => t('Download translation as zip'),
            '#default_value' => $data,
            '#description' => t('Option to download the translation a a single zip file.')
        ];
    }

    public function setXliffProcessing($data)
    {
        return [
            '#type' => 'checkbox',
            '#title' => t('Use Xliff Processing'),
            '#default_value' => $data,
            '#description' => t('Option to export translation unit in Xliff format.')
        ];
    }

    public function setSdllcPreviouslyTranslatedFieldsOptions($data)
    {
        return [
            '#type' => 'select',
            '#title' => t('Field Export options'),
            '#options' => [
                0 => t('Do not include previously translated field content'),
                1 => t('Include previously translated field content')
            ],
            '#default_value' => $data,
            '#description' => t('Export options for previously translated field contents.'),
            '#required' => FALSE
        ];
    }

    public function setSdllcPassword($data)
    {
        return [
            '#type' => 'password',
            '#title' => t('Password'),
            '#default_value' => $data,
            '#description' => $data ? t('SDL Translation Management Password.') : t('Please enter a password.'),
            '#required' => TRUE
        ];
    }

    public function setSdllcUsername($data)
    {
        return [
            '#type' => 'textfield',
            '#title' => t('Username'),
            '#default_value' => $data,
            '#description' => t('SDL Translation Management Username.'),
            '#required' => TRUE,
            '#placeholder' => 'username'
        ];
    }

    public function setSdllcClientSecret($data)
    {
        return [
            '#type' => 'textfield',
            '#title' => t('Client Secret'),
            '#default_value' => $data,
            '#description' => t('SDL Translation Management Client Secret.'),
            '#required' => TRUE,
            '#placeholder' => 'client secret'
        ];
    }

    public function setSdllcClientId($data)
    {
        return [
            '#type' => 'textfield',
            '#title' => t('Client ID'),
            '#default_value' => $data,
            '#description' => t('SDL Translation Management Client ID.'),
            '#required' => TRUE,
            '#placeholder' => 'client id'
        ];
    }

    public function setSdllcCurl($data)
    {
        return [
            '#type' => 'textfield',
            '#title' => t('URL'),
            '#default_value' => $data,
            '#description' => t('SDL Translation Management URL.'),
            '#required' => TRUE,
            '#placeholder' => 'https://languagecloud.sdl.com'
        ];
    }
}
