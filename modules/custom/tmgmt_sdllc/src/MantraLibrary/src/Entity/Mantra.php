<?php
namespace MantraLibrary\Entity;

/**
 * Mantra class
 *
 * Wrapper class for the SDL Language Cloud Manage Transation API.
 *
 * @category class
 */
class Mantra
{

    /**
     * SDL Language Cloud base URL.
     *
     * @var string
     */
    public $sdlCloudBaseUrl;

    /**
     * SDL Language Cloud Client ID.
     *
     * @var string
     */
    public $clientId;

    /**
     * SDL Language Cloud Client Secret.
     *
     * @var string
     */
    public $clientSecret;

    /**
     * SDL Language Cloud Username.
     *
     * @var string
     */
    public $username;

    /**
     * SDL Language Cloud Password.
     *
     * @var string
     */
    public $password;

    /**
     * Creates a Mantra instance.
     *
     * @param string $username
     *            SDL Language Cloud Username.
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
    public function __construct($username, $password, $clientId, $clientSecret, $sdlCloudBaseUrl = NULL)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
        $this->sdlCloudBaseUrl = $sdlCloudBaseUrl;
        return $this;
    }
}
