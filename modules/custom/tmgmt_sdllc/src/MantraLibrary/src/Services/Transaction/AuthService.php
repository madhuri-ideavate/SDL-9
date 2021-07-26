<?php
namespace MantraLibrary\Services\Transaction;

use MantraLibrary\Rest\ClientRest;
use MantraLibrary\Model\ConfigModel;
use MantraLibrary\Entity\Mantra;
use MantraLibrary\Model\TokenResponse;
use MantraLibrary\Logger\LogWriter;
use Exception;

/**
 * All the Authentification methods go here
 *
 * @author iflorian
 * @package MantraLibrary
 */
class AuthService
{

    /**
     * Logs in to SDL Language Cloud and retrieves the authentication token.
     *
     * @return \TokenResponse TokenResponse Object.
     *        
     */
    public function getAuthorizationToken(Mantra $mantra)
    {
        try {
            $client = new \GuzzleHttp\Client();
            /*
             * Add http headers for the Auth request
             */
            $headers['headers'] = [];
            $headers['headers']['Accept'] = 'application/json';
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
            $headers['http_errors'] = FALSE;
            $headers['verify'] = FALSE;
            $headers['timeout'] = 45;

            /*
             * Set data to the added to the Auth link
             */
            $form_params['grant_type'] = ConfigModel::DEFAULT_GRANT_TYPE;
            $form_params['username'] = $mantra->username;
            $form_params['password'] = $mantra->password;
            
            /*
             * Verify if we have clientId
             * Some API do not use clientID
             */
            ! empty($mantra->clientId) && $form_params['client_id'] = $mantra->clientId;
            ! empty($mantra->clientSecret) && $form_params['client_secret'] = $mantra->clientSecret;
            empty($mantra->sdlCloudBaseUrl) && $mantra->sdlCloudBaseUrl = ConfigModel::DEFAULT_SDL_CLOUD_PRO_URL;
            
            /*
             * Add form params to the header
             */
            $headers['form_params'] = $form_params;

            $auth_token_url = $mantra->sdlCloudBaseUrl . '/' . ConfigModel::AUTH_TOKEN_URI;

            /*
             * Make url call with all the params
             */
            $response = $client->request('POST', $auth_token_url, $headers);
            /*
             * Parse Request Object
             */
            $jsonResponseBody = $response->getBody();
            $responseBody = json_decode($jsonResponseBody, TRUE);
            //echo '<pre>';print_r($responseBody);die;
            /*
             * Search if we have some error on the api
             */  
            if ($response->getStatusCode() != 200) {
                throw new Exception($responseBody['error_description']);
                return;
            }

            $token_response = new TokenResponse($responseBody);
        } catch (Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }

        return $token_response;
    }
}
