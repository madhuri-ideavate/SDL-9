<?php

namespace MantraLibrary\Model;

use MantraLibrary\Model\PortalObject;

/**
 * TokenResponse class.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class TokenResponse extends PortalObject
{

    /**
     * Array of property to type mappings.Used for (de)serialization.
     *
     * @var string[]
     */
    public static $propertyTypes = [
        'access_token' => 'string',
        'token_type' => 'string',
        'expires_in' => 'int',
        'refresh_token' => 'string'
    ];

    /**
     * Array of attributes where the key is the local, the value is original name.
     *
     * @var string[]
     */
    public static $attributeMap = [
        'accessToken' => 'access_token',
        'tokenType' => 'token_type',
        'expiresIn' => 'expires_in',
        'refreshToken' => 'refresh_token'
    ];

    /**
     * Gets the property type map.
     *
     * {@inheritdoc}
     *
     * @see \MantraLibrary\Model\PortalObject::getPropertyTypes()
     */
    protected function getPropertyTypes()
    {
        return self::$propertyTypes;
    }

    /**
     * Gets the property name map.
     *
     * {@inheritdoc}
     *
     * @see \MantraLibrary\Model\PortalObject::getPropertyMaps()
     */
    protected function getPropertyMaps()
    {
        return self::$attributeMap;
    }

    /**
     * Access_token Gets or sets the access token.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Gets or sets the type of the token.
     *
     * @var string
     */
    protected $tokenType;

    /**
     * Gets or sets the token lifetime in seconds.
     *
     * @var int
     */
    protected $expiresIn;

    /**
     * Gets or sets the token lifetime in seconds.
     *
     * @var int
     */
    protected $refreshToken;

    /**
     * Constructor.
     *
     * @param mixed[] $data
     *            Associated array of property value initalizing the model.
     */
    public function __construct(array $data = NULL)
    {
        if ($data != NULL) {
            $this->populate($data);
        }
    }

    /**
     * For deserialization from Json data.
     *
     * @param array $data
     *            Associated array of property value initalizing the model.
     */
    private function populate(array $data)
    {
        foreach ($data as $property => $value) {
            $object_property = $this->getProperty($property);
            $object_type = $this->getPropertyType($property);

            if (! property_exists($this, $object_property)) {
                continue;
            }

            if ($object_property == 'expiresIn') {
                settype($value, $object_type);
            }

            $this->$object_property = $value;
        }
    }

    /**
     * Gets accessToken.
     *
     * @return string The access token.
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Sets accessToken.
     *
     * @param string $accessToken
     *            Gets or sets the access token.
     *            
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * Gets tokenType.
     *
     * @return string The token type.
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * Sets tokenType.
     *
     * @param string $tokenType
     *            Gets or sets the type of the token.
     *            
     * @return $this
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
        return $this;
    }

    /**
     * Gets expiresIn.
     *
     * @return int The token type.
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * Sets expiresIn.
     *
     * @param int $expiresIn
     *            Gets or sets the token lifetime in seconds.
     *            
     * @return $this
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }
    
    
    /**
     * Gets accessToken.
     *
     * @return string The access token.
     */
    public function getRefreshToken()
    {
        return $this->refreshTokenn;
    }
    
    /**
     * Sets accessToken.
     *
     * @param string $accessToken
     *            Gets or sets the access token.
     *
     * @return $this
     */
    public function setRefreshToken($refreshTokenn)
    {
        $this->refreshTokenn = $refreshTokenn;
        return $this;
    }
    
    
    
}
