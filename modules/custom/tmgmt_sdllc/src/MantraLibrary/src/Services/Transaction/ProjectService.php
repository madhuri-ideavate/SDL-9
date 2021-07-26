<?php
namespace MantraLibrary\Services\Transaction;

use MantraLibrary\Rest\ClientRest;
use MantraLibrary\Model\ConfigModel;
use MantraLibrary\Model\PortalJobOptions;
use MantraLibrary\Model\PortalJobParams;
use MantraLibrary\Model\PortalCreateProjectResponse;
use MantraLibrary\Model\PortalJobStatus;
use MantraLibrary\Entity\Mantra;
use MantraLibrary\Model\TokenResponse;
use MantraLibrary\Logger\LogWriter;
use Exception;

/**
 * All the project related methods go here
 *
 * @author iflorian
 *        
 */
class ProjectService
{

    /**
     * Create a translation project.
     *
     * @param MantraLibrary\Model\TokenResponse $token_response
     *            A TokenResponse object.
     * @param \Drupal\tmgmt_sdllc\Mantra\Model\PortalJobParams $job_params
     *            A PortalJobParams object.
     *            
     * @return bool|MantraLibrary\Model\PortalCreateProjectResponse A PortalCreateProjectResponse object.
     */
    public function createProject(TokenResponse $token_response, $job_params, Mantra $mantra)
    {
        try {
            if (! isset($token_response)) {
                throw new Exception('Authorization token is not set.');
                return;
            }

            if (! isset($job_params)) {
                throw new Exception('Job option params are not set.');
                return;
            }
            /*
             * Send params in the body
             */
            $content = $job_params->__toString();

            $client = new \GuzzleHttp\Client();
            /*
             * Add http headers for the Auth request
             */
            $headers['headers'] = [];
            $headers['headers']['Accept'] = 'application/json';
            $headers['headers']['Authorization'] = 'Bearer  ' . $token_response->getAccessToken();
            $headers['headers']['Content-Type'] = 'application/json';
            $headers['body'] = $content;
            $headers['http_errors'] = FALSE;
            $headers['verify'] = FALSE;
            $headers['timeout'] = 45;

            empty($mantra->sdlCloudBaseUrl) && $mantra->sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;

            $create_project_url = $mantra->sdlCloudBaseUrl . ConfigModel::CREATE_PROJECT_URI;

            /*
             * Make url call with all the params
             */
            $response = $client->request('POST', $create_project_url, $headers);
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

            $create_project_response = new PortalCreateProjectResponse($responseBody);
        } catch (\Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }

        return $create_project_response;
    }

    /**
     * Retrieve Project Creation Options.
     *
     * @param MantraLibrary\Model\TokenResponse $token_response
     *            The TokenResponse Object.
     *            
     * @throws \Exception
     *
     * @return bool|MantraLibrary\Model\PortalJobOptions[] array of PortalJobOptions.
     */
    public function getProjectCreationOptions(TokenResponse $token_response, Mantra $mantra)
    {
        try {

            if (! isset($token_response)) {
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

            empty($mantra->sdlCloudBaseUrl) && $mantra->sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;

            $project_creation_options_url = $mantra->sdlCloudBaseUrl . '/' . ConfigModel::PROJECT_CREATION_OPTIONS_URI;

            /*
             * Make url call with all the params
             */
            $response = $client->request('GET', $project_creation_options_url, $headers);
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

            /*
             * Make all the project options as an object
             */
            $portalJobOptions = [];

            foreach ($responseBody as $key => $value) {
                $portalJobOptions[$key] = new PortalJobOptions($value);
            }

            $portalJobOptionArray = $response;
        } catch (\Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }

        return $portalJobOptions;
    }

    /**
     * Approve the translation project.
     *
     * @param MantraLibrary\Model\TokenResponse $token_response
     *            A TokenResponse object.
     * @param string $project_id
     *            The Project Id.
     *            
     * @return bool|array Array of response code.
     */
    public function approveProject(TokenResponse $token_response, $project_id, $sdlCloudBaseUrl = '')
    {
        try {

            if (! isset($token_response)) {
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
            $approve_project_url = $sdlCloudBaseUrl . '/' . str_replace('{projectId}', $project_id, ConfigModel::APPROVE_PROJECT_URI);

            /*
             * Make url call with all the params
             */
            $response = $client->request('POST', $approve_project_url, $headers);
            /*
             * Parse Request Object
             */
            $jsonResponseBody = $response->getBody();
            $responseBody = json_decode($jsonResponseBody, TRUE);
            /*
             * Search if we have some error on the api
             */
            if ($response->getStatusCode() != 204) {
                throw new Exception($responseBody['Message']);
                return;
            }
        } catch (\Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }

        return [
            'StatusCode' => $response->getStatusCode()
        ];
    }

    /**
     * Cancel the translation project.
     *
     * @param MantraLibrary\Model\TokenResponse $token_response
     *            A TokenResponse object.
     * @param string $project_id
     *            The Project Id.
     *            
     * @return bool|array Array of response code.
     */
    public function cancelProject(TokenResponse $token_response, $project_id, $sdlCloudBaseUrl = '')
    {
        try {

            if (! isset($token_response)) {
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
            $cancel_project_url = $sdlCloudBaseUrl . '/' . str_replace('{projectId}', $project_id, ConfigModel::APPROVE_PROJECT_URI);

            /*
             * Make url call with all the params
             */
            $response = $client->request('DELETE', $cancel_project_url, $headers);
            /*
             * Parse Request Object
             */
            $jsonResponseBody = $response->getBody();
            $responseBody = json_decode($jsonResponseBody, TRUE);
            /*
             * Search if we have some error on the api
             */
            if ($response->getStatusCode() != 204) {
                throw new Exception($responseBody['Message']);
                return;
            }
        } catch (\Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }

        return [
            'StatusCode' => $response->getStatusCode()
        ];
    }

    /**
     * Retrieve status of a project.
     *
     * @param \Drupal\tmgmt_sdllc\Mantra\Model\TokenResponse $token_response
     *            The TokenResponse object.
     * @param string $project_id
     *            The Project Id.
     *            
     * @throws \Exception
     *
     * @return bool|\Drupal\tmgmt_sdllc\Mantra\Model\PortalJobStatus The PortalJobStatus object.
     */
    public function getProjectStatus(TokenResponse $token_response, $project_id, $sdlCloudBaseUrl = '')
    {
        try {
            if (! isset($token_response)) {
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
            $headers['http_errors'] = FALSE;
            $headers['verify'] = FALSE;
            $headers['timeout'] = 45;
            empty($sdlCloudBaseUrl) && $sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;
            $project_status_url = $sdlCloudBaseUrl . '/' . str_replace('{projectId}', $project_id, ConfigModel::PROJECT_STATUS_URI);

            /*
             * Make url call with all the params
             */
            $response = $client->request('GET', $project_status_url, $headers);
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

            $project_status_response = new PortalJobStatus($responseBody);

            return $project_status_response;
        } catch (\Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }
        return $project_status_response;
    }

    /**
     * Gets a simple list of all projects.
     *
     * @param \Drupal\tmgmt_sdllc\Mantra\Model\TokenResponse $token_response
     *            The TokenResponse object.
     *            
     * @return bool|\Drupal\tmgmt_sdllc\Mantra\Model\PortalJobStatus[] Array of PortalJobStatus.
     */
    public function getProjectsList(TokenResponse $token_response, $sdlCloudBaseUrl = '')
    {
        try {
            if (! isset($token_response)) {
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
            $projects_list_url = $sdlCloudBaseUrl . '/' . ConfigModel::PROJECTS_LIST_URI;

            /*
             * Make url call with all the params
             */
            $response = $client->request('GET', $projects_list_url, $headers);

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

            $projects = [];
            foreach ($responseBody as $job) {
                $projects[] = new PortalJobStatus($job);
            }

            return $projects;
        } catch (\Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }
        return $projects;
    }

    /**
     * Download the translation quote.
     *
     * @param \Drupal\tmgmt_sdllc\Mantra\Model\TokenResponse $token_response
     *            The TokenResponse object.
     * @param string $project_id
     *            The Project id.
     *            
     * @return bool|string The response body.
     */
    public function getProjectQuote(TokenResponse $token_response, $project_id, $sdlCloudBaseUrl = ''
        )
    {
        try {
            if (! isset($token_response)) {
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
            $headers['http_errors'] = FALSE;
            $headers['verify'] = FALSE;
            $headers['timeout'] = 45;

            empty($sdlCloudBaseUrl) && $sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;
            $project_quote_url = $sdlCloudBaseUrl . '/' . str_replace('{projectId}', $project_id, ConfigModel::PROJECT_QUOTE_URI) . 'xls';

            /*
             * Make url call with all the params
             */
            $response = $client->request('GET', $project_quote_url, $headers);

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
        return $jsonResponseBody;
    }
}