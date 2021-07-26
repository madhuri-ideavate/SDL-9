<?php

namespace MantraLibrary\Services\Transaction;

use MantraLibrary\Rest\ClientRest;
use MantraLibrary\Model\ConfigModel;
use MantraLibrary\Model\PortalJobOptions;
use MantraLibrary\Model\PortalUploadedFile;
use MantraLibrary\Entity\Mantra;
use MantraLibrary\Model\TokenResponse;
use MantraLibrary\Logger\LogWriter;
use Exception;

/**
 * All the file methods go here
 *
 * @author iflorian
 *
 */
class FileService
{

  /**
   * Upload source files.
   *
   * @param \Model\TokenResponse $token_response
   *            A TokenResponse object.
   * @param string $project_options_id
   *            The Project option Id.
   * @param array $file_paths
   *            Array of file paths.
   *
   * @return bool|\Drupal\tmgmt_sdllc\Mantra\Model\PortalUploadedFile[] Array of PortalUploadedFile objects.
   */
  public function uploadFile(TokenResponse $token_response, $project_options_id, array $file_paths, Mantra $mantra)
  {
    try {
      if (!isset($token_response)) {
        throw new Exception('Authorization token is not set.');
        return;
      }

      $multiParts = [];
      /**
       * Build multiparts and send them to cloud
       */
      $file_system = \Drupal::service('file_system');
      foreach ($file_paths as $file_path) {
        $stream = $this->readFile($file_path);
        $part = [
          'name' => 'file',
          'filename' => $file_system->basename($file_path),
          'contents' => (string)$stream
        ];

        $multiParts[] = $part;
      }

      $client = new \GuzzleHttp\Client();
      /*
       * All The headers. Multipart is essential
       */
      $headers['headers'] = [];
      $headers['headers']['Accept'] = 'application/json';
      $headers['headers']['Authorization'] = 'Bearer  ' . $token_response->getAccessToken();
      $headers['Content-Type'] = 'application/x-www-form-urlencoded';
      $headers['multipart'] = $multiParts;
      $headers['http_errors'] = FALSE;
      $headers['verify'] = FALSE;
      $headers['timeout'] = 45;

      empty($mantra->sdlCloudBaseUrl) && $mantra->dlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;

      $uploaded_file_url = $mantra->sdlCloudBaseUrl . '/' . str_replace('{projectOptionsId}', $project_options_id, ConfigModel::UPLOADED_FILE_URI);

      /*
       * Make url call with all the params
       */
      $response = $client->request('POST', $uploaded_file_url, $headers);
      /*
       * Parse Request Object
       */
      $jsonResponseBody = $response->getBody();
      $responseBody = json_decode($jsonResponseBody, TRUE);

      /*
       * Search if we have some error on the api
       */
      if ($response->getStatusCode() != 201) {
        throw new Exception($responseBody['Message']);
        return;
      }

      $files = [];
      /*
       * Return full objects files
       */
      foreach ($responseBody as $key => $value) {
        $files[$key] = new PortalUploadedFile($value);
      }
    } catch (\Exception $e) {
      /*
       * Throw exception to be used on the top levels
       */
      throw $e;
      return;
    }

    return $files;
  }

  /**
   * Read a source file into a string.
   *
   * @param string $file_path
   *            String of file path.
   *
   * @return string The file content.
   */
  private function readFile($file_path)
  {
    $handle = fopen($file_path, 'r');

    $contents = '';

    if ($handle == FALSE) {
      return $contents;
    }

    while (!feof($handle)) {
      $contents .= fread($handle, 8192);
    }

    fclose($handle);

    return $contents;
  }

  /**
   * Retrieve the updated source file information.
   *
   * @param MantraLibrary\Model\TokenResponse $token_response
   *            The TokenResponse object.
   * @param string $project_options_id
   *            The project_options_id.
   *
   * @return bool|MantraLibrary\Model\PortalUploadedFile[] Array of PortalUploadedFiles.
   */
  public function getUploadedFiles(TokenResponse $token_response, $project_options_id, $sdlCloudBaseUrl)
  {
    try {
      if (!isset($token_response)) {
        throw new Exception('Authorization token is not set.');
        return;
      }

      $client = new \GuzzleHttp\Client();
      /*
       * All The headers. Multipart is essential
       */
      $headers['headers'] = [];
      $headers['headers']['Accept'] = 'application/json';
      $headers['headers']['Authorization'] = 'Bearer  ' . $token_response->getAccessToken();
      $headers['Content-Type'] = 'application/x-www-form-urlencoded';
      $headers['http_errors'] = FALSE;
      $headers['verify'] = FALSE;
      $headers['timeout'] = 45;

      empty($sdlCloudBaseUrl) && $sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;

      $uploaded_file_url = $sdlCloudBaseUrl . '/' . str_replace('{projectOptionsId}', $project_options_id, ConfigModel::UPLOADED_FILE_URI);

      /*
       * Make url call with all the params
       */
      $response = $client->request('GET', $uploaded_file_url, $headers);
      /*
       * Parse Request Object
       */
      $jsonResponseBody = $response->getBody();
      $responseBody = json_decode($jsonResponseBody, TRUE);
      /*
       * Search if we have some error on the api
       */
      if ($response->getStatusCode() != 200) {
        throw new Exception($responseBody['Message']);
        return;
      }
      $file_array = $responseBody;

      $files = [];

      foreach ($file_array as $key => $value) {
        $files[$key] = new PortalUploadedFile($value);
      }
    } catch (\Exception $e) {
      /*
       * Throw exception to be used on the top levels
       */
      throw $e;
      return;
    }

    return $files;
  }

  /**
   * Download the target file.
   *
   * @param \Drupal\tmgmt_sdllc\Mantra\Model\TokenResponse $token_response
   *            The TokenResponse object.
   * @param string $project_id
   *            The Project id.
   * @param string $fileId
   *            The file id.
   *
   * @return bool|string The response body.
   */
  public function downloadFile(TokenResponse $token_response, $project_id, $fileId, $sdlCloudBaseUrl)
  {
    try {
      if (!isset($token_response)) {
        throw new Exception('Authorization token is not set.');
        return;
      }

      $client = new \GuzzleHttp\Client();
      /*
       * Add http headers for the Auth request
       */
      $headers['headers'] = [];
      $headers['headers']['Accept'] = 'application/json';
      $headers['headers']['Authorization'] = 'Bearer  ' . $token_response->getAccessToken();
      $headers['Content-Type'] = 'application/x-www-form-urlencoded';
      $headers['http_errors'] = FALSE;
      $headers['verify'] = FALSE;
      $headers['timeout'] = 45;

      empty($sdlCloudBaseUrl) && $sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;
      $download_file_url = $sdlCloudBaseUrl . '/' . str_replace('{fileId}', $fileId, str_replace('{projectId}', $project_id, ConfigModel::DOWNLOAD_FILE_URI));

      /*
       * Make url call with all the params
       */
      $response = $client->request('GET', $download_file_url, $headers);

      /*
       * Parse Request Object
       */
      $jsonResponseBody = $response->getBody();
      $responseBody = json_decode($jsonResponseBody, TRUE);
      /*
       * Search if we have some error on the api
       */
      if ($response->getStatusCode() != 200) {
        throw new Exception($responseBody['Message']);
        return;
      }
      return $jsonResponseBody;
    } catch (\Exception $e) {
      /*
       * Throw exception to be used on the top levels
       */
      throw $e;
      return;
    }
    return $responseBody;
  }

  /**
   * Download the target file as a zip.
   *
   * @param \Drupal\tmgmt_sdllc\Mantra\Model\TokenResponse $token_response
   *            The TokenResponse object.
   * @param string $project_id
   *            The Project id.
   *
   * @return bool|string The response body.
   */
  public function downloadTargetZip(TokenResponse $token_response, $project_id, $sdlCloudBaseUrl = '')
  {
    try {
      if (!isset($token_response)) {
        throw new Exception('Authorization token is not set.');
        return;
      }

      $client = new \GuzzleHttp\Client();
      /*
       * Add http headers for the Auth request
       */
      $headers['headers'] = [];
      $headers['headers']['Accept'] = 'application/json';
      $headers['headers']['Authorization'] = 'Bearer  ' . $token_response->getAccessToken();
      $headers['Content-Type'] = 'application/x-www-form-urlencoded';
      $headers['http_errors'] = FALSE;
      $headers['verify'] = FALSE;
      $headers['timeout'] = 45;

      empty($sdlCloudBaseUrl) && $sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;
      $download_target_zip_url = $sdlCloudBaseUrl . '/' . str_replace('{projectId}', $project_id, ConfigModel::DOWNLOAD_TARGET_ZIP_URI);

      /*
       * Make url call with all the params
       */
      $response = $client->request('GET', $download_target_zip_url, $headers);

      /*
       * Parse Request Object
       */
      $jsonResponseBody = $response->getBody();
      $responseBody = json_decode($jsonResponseBody, TRUE);

      /*
       * Search if we have some error on the api
       */
      if ($response->getStatusCode() != 200) {
        throw new Exception($responseBody['Message']);
        return;
      }
      return $jsonResponseBody;
    } catch (\Exception $e) {
      /*
       * Throw exception to be used on the top levels
       */
      throw $e;
      return;
    }
    return $responseBody;
  }
}
