<?php
namespace Drupal\tmgmt_sdllc\MantraLibrary;

use MantraLibrary\Services\Transaction\AuthService;
use MantraLibrary\Services\Transaction\ProjectService;
use MantraLibrary\Services\Transaction\FileService;
use MantraLibrary\Rest\ClientRest;
use MantraLibrary\Entity\Mantra;
use MantraLibrary\Logger\LogWriter;
use MantraLibrary\Model\PortalJobParams;

/**
 * MantraTranslationAPI class.
 *
 * Wrapper class for the SDL Language Cloud Manage Transation API.
 *
 * @category class
 */
class MantraTranslationAPI
{

    /*
     * MantraLibrary\Entity\Mantra;
     */
    protected $mantra;

    /*
     *
     */
    protected $token;

    /**
     *
     * Here will be the initialization of the API
     * The only Class that will be used in plugins
     *
     * * @param string $username
     * SDL Language Cloud Username.
     *
     * @param string $password
     *            SDL Language Cloud Password.
     * @param string $clientId
     *            SDL Language Cloud Client Id.
     * @param string $clientSecret
     *            SDL Language Cloud Client secret.
     * @param string $sdlCloudBaseUrl
     *            SDL Language Cloud base URL. If not defined, the
     *            DEFAULT_SDL_CLOUD_PRO_URL value is used
     *            The $httpClient property is also initialized with the default
     *            http connection.
     */
    public function connect($username, $password, $clientId = '', $clientSecret = '', $sdlCloudBaseUrl = NULL)
    {
        //$clientId = '';
        //$clientSecret = '';
        //$sdlCloudBaseUrl = '';
        try {
            $loader = require __DIR__ . '/vendor/autoload.php';
            /*
             * Call the Auth Service
             */
            $authService = new AuthService();
            /**
             * Init the Mantra model.
             * This will be stocked on
             */
            $this->mantra = new Mantra($username, $password, $clientId, $clientSecret, $sdlCloudBaseUrl);
            /*
             * We got a token so we can make authorization calls
             */
            $this->token = $authService->getAuthorizationToken($this->mantra);

            //echo '<pre>';print_r($this);die;
        } catch (Exception $e) {
            /*
             * Throw exception to be used on the top levels
             */
            throw $e;
            return;
        }
        return $this;
    }

    /**
     * Returns Project Create Options
     * This will be used before creating a project
     *
     * @throws Exception
     * @return void|unknown
     */
    public function getProjectCreationOptions()
    {
        try {
            /*
             * Call the Project Service
             */
            $projectService = new ProjectService();
            /*
             * Get project create options based on memory variables
             */
            $result = $projectService->getProjectCreationOptions($this->token, $this->mantra);
            //echo '<pre>';print_r($result);die;
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    /**
     *
     * Upload files by multipart strategy
     *
     * @see FileService
     *
     * @param unknown $project_options_id
     * @param array $file_paths
     * @throws Exception
     * @return void|unknown
     */
    public function uploadFile($project_options_id, array $file_paths)
    {
        try {
            /*
             * Call the File Service
             */
            $fileService = new FileService();
            /*
             * Uploud file to the SDL cloud
             */
            $result = $fileService->uploadFile($this->token, $project_options_id, $file_paths, $this->mantra);

        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    public function createProject($project_options_id, $name, $description, $dueDate, $srcLang, $fileIds, $targetLanguage)
    {
        try {
            /*
             * Call the File Service
             */
            $projectService = new ProjectService();

            /*
             * Let's make a PortalJobParams object
             */
            $job_params = new PortalJobParams();
            $job_params->setJobOptions($project_options_id);
            $job_params->setName($name);
            $job_params->setDescription($description);
            $job_params->setDueDate($dueDate);
            $job_params->setSrcLang($srcLang);
            $job_params->setFileIds($fileIds, $targetLanguage);

            /*
             * Uploud file to the SDL cloud
             */
            $result = $projectService->createProject($this->token, $job_params, $this->mantra);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    /**
     *
     * Approve Project base on a projectId
     *
     * @param TokenResponse $token_response
     * @param unknown $project_id
     * @param string $sdlCloudBaseUrl
     * @throws Exception
     * @return void|unknown
     */
    public function approveProject($project_id)
    {
        try {
            /*
             * Call the File Service
             */
            $projectService = new ProjectService();

            /*
             * Approve Project
             */
            $result = $projectService->approveProject($this->token, $project_id, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    /**
     *
     * Cancel Project base on a projectId
     *
     * @param TokenResponse $token_response
     * @param unknown $project_id
     * @param string $sdlCloudBaseUrl
     * @throws Exception
     * @return void|unknown
     */
    public function cancelProject($project_id)
    {
        try {
            /*
             * Call the File Service
             */
            $projectService = new ProjectService();

            /*
             * Approve Project
             */
            $result = $projectService->cancelProject($this->token, $project_id, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    /**
     *
     * Get uplouded files from a project option ID
     *
     * @param unknown $project_options_id
     * @throws Exception
     * @return void|unknown
     */
    public function getUploadedFiles($project_options_id)
    {
        try {
            /*
             * Call the File Service
             */
            $fileService = new FileService();

            /*
             * Approve Project
             */
            $result = $fileService->getUploadedFiles($this->token, $project_options_id, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    /**
     * Get a project status
     *
     * @param unknown $project_id
     * @throws Exception
     * @return void|unknown
     */
    public function getProjectStatus($project_id)
    {
        try {
            /*
             * Call the File Service
             */
            $projectService = new ProjectService();

            /*
             * Get Project Status
             */
            $result = $projectService->getProjectStatus($this->token, $project_id, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    public function getProjectsList()
    {
        try {
            /*
             * Call the File Service
             */
            $projectService = new ProjectService();

            /*
             * Approve Project
             */
            $result = $projectService->getProjectsList($this->token, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    public function getProjectQuote($project_id)
    {
        try {
            /*
             * Call the File Service
             */
            $projectService = new ProjectService();

            /*
             * Get Project Status
             */
            $result = $projectService->getProjectQuote($this->token, $project_id, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    public function downloadFile($project_id, $fileId)
    {
        try {
            /*
             * Call the File Service
             */
            $fileService = new FileService();

            /*
             * Download File
             */
            $result = $fileService->downloadFile($this->token, $project_id, $fileId, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }

    public function downloadTargetZip($project_id)
    {
        try {
            /*
             * Call the File Service
             */
            $fileService = new FileService();

            /*
             * Download File
             */
            $result = $fileService->downloadTargetZip($this->token, $project_id, $this->mantra->sdlCloudBaseUrl);
        } catch (Exception $e) {
            throw $e;
            return;
        }
        return $result;
    }
}