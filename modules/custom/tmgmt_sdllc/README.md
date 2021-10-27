NOTE : Do not uninstall and re-install the connector module. Simply follow below steps.

- If Drupal core version is >= 9.x . 

STEPS to upgrade module  : 

1. Extract zip
2. Copy tmgmt_sdllc module 
3. Replace it with the existing RWS connector module (tmgmt_sdllc)
4. Clear cache (../admin/config/development/performance)
 

###### Release Drupal RWS Connector Module on Drupal 9.2.0  on 13-Sep-2021 #####

# Update connector version and its dependency 

..\tmgmt_sdllc.info.yml

 core_version_requirement: ^8.8 || ^9
  - tmgmt:tmgmt (>=8.x-1.12)
  - drupal:datatables (>=2.0.0)

# Depricated drupal_get_user_timezone (date_default_timezone_get());

..\tmgmt_sdllc\src\FormModel\CheckoutSettingsFormModel.php

Line no 52 :  date_default_timezone_set(date_default_timezone_get());
Line no 59 :  '#date_timezone' => date_default_timezone_get(),

# Depricated drupal_get_user_timezone (date_default_timezone_get()); 

..\tmgmt_sdllc\src\Plugin\tmgmt\Translator\SdllcTranslator.php

Line no 316 :   $date = new DrupalDateTime($time, new \DateTimeZone(date_default_timezone_get()));


# Depricated file_prepare_directory($target_file_path, FILE_CREATE_DIRECTORY) instead of use filesystem

..\src\Plugin\tmgmt\Translator\SdllcTranslator.php

Line no 347 : if (prepareDirectory($dirname, FileSystemInterface::CREATE_DIRECTORY)) {             
        
#  FILE_EXISTS_REPLACE is depricated 

..\src\Plugin\tmgmt\Translator\SdllcTranslator.php

Line no 349 : $file_xlf = file_save_data($itemData, $path_xlf, \Drupal::service('file_system')::EXISTS_REPLACE);

..\tmgmt_sdllc.module

Line no 251   $saved_file_path = file_save_data($project_quote, $quote_file_path, \Drupal::service('file_system')::EXISTS_REPLACE);
Line no 279   $saved_file_path = file_save_data($target_file, $target_file_name,  \Drupal::service('file_system')::EXISTS_REPLACE);
Line no 305   $saved_file_path = file_save_data($target_file, $target_file_name,  \Drupal::service('file_system')::EXISTS_REPLACE);
Line no 319   $saved_file_path = file_save_data($target_zip, $target_file_path,  \Drupal::service('file_system')::EXISTS_REPLACE);

# Depricated drupal_basename

..\src\SdllcTranslatorUi.php

Line no 747 : '@file' => \Drupal::service('file_system')->basename($file)

# Deprecate date_iso8601($timestamp) in favour of PHP date('c', $timestamp)\

..\src\Form\AutoRetrievalSettingsForm.php

Line no 98  : '%time' => date('c', $this->state 

# Patch applied related to Mantra API call   

..\src\MantraLibrary\src\config\enviroment_config.yml

Line no 17 : APPROVE_PROJECT_URI = 'tm4lc/api/v1/projects/{projectId}';
Line no 18 : PROJECT_STATUS_URI = 'tm4lc/api/v1/projects/{projectId}';
Line no 19 : DOWNLOAD_FILE_URI = 'tm4lc/api/v1/files/{projectId}/{fileId}';
Line no 20 : PROJECT_QUOTE_URI = 'tm4lc/api/v1/projects/{projectId}/quote/';
Line no 23 : DOWNLOAD_TARGET_ZIP_URI = 'tm4lc/api/v1/projects/{projectId}/zip?types=TargetFiles';

..\src\MantraLibrary\src\Model\ConfigModel.php

Line no 29 : const APPROVE_PROJECT_URI = 'tm4lc/api/v1/projects/{projectId}';
Line no 31 : const PROJECT_STATUS_URI = 'tm4lc/api/v1/projects/{projectId}';
Line no 33 : const DOWNLOAD_FILE_URI = 'tm4lc/api/v1/files/{projectId}/{fileId}';
Line no 35 : const PROJECT_QUOTE_URI = 'tm4lc/api/v1/projects/{projectId}/quote/{format}';
Line no 41 : const DOWNLOAD_TARGET_ZIP_URI = 'tm4lc/api/v1/projects/{projectId}/zip?types=TargetFiles';


# Added condition for LC and TMS 

..\src\Plugin\tmgmt\Format\SdlXliff.php

Line no 499-502: 
        $fileTmp = glob($imported_file.'/*.xlf');
        if(count($fileTmp) == 1){
          $xml_string = file_get_contents($fileTmp[0]);
        }

