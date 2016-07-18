<?php
namespace Ftob\OAuth2\Client\Providers;


use Ftob\OAuth2\Client\Providers\Exceptions\OAuthIdentityException;
use League\OAuth2\Client\Provider\AbstractProvider;

use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class OAuthProvider extends AbstractProvider
{

    use BearerAuthorizationTrait;

    /** @var string  */
    protected $domain = 'http://example.com';
    /** @var string  */
    protected $detailUrl = '/api/v1/user';
    /** @var string  */
    protected $baseAuthUrl = '/login/oauth/authorize';
    /** @var string  */
    protected $baseAccessTokenUrl = '/login/oauth/access_token';

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param string $detailUrl
     */
    public function setDetailUrl($detailUrl)
    {
        $this->detailUrl = $detailUrl;
    }

    /**
     * @param string $baseAuthUrl
     */
    public function setBaseAuthUrl($baseAuthUrl)
    {
        $this->baseAuthUrl = $baseAuthUrl;
    }

    /**
     * @param string $baseAccessTokenUrl
     */
    public function setBaseAccessTokenUrl($baseAccessTokenUrl)
    {
        $this->baseAccessTokenUrl = $baseAccessTokenUrl;
    }



    /**
     * @return string
     */
    public function getDomain()
    {
        if (function_exists('config')) {
            $this->domain = config('oauth.domain');
        }

        return $this->domain;
    }

    /**
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        if (function_exists('config')) {
            $this->baseAuthUrl = config('oauth.url.auth');
        }
        return $this->getDomain() . $this->baseAuthUrl;
    }

    /**
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        if (function_exists('config')) {
            $this->baseAccessTokenUrl = config('oauth.url.access_token');
        }

        return $this->getDomain() . $this->baseAccessTokenUrl;
    }

    /**
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        if (function_exists('config')) {
            $this->detailUrl = config('oauth.url.detail_url');
        }
        return $this->getDomain() . $this->detailUrl;
    }

    /**
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * @param ResponseInterface $response
     * @param array|string $data
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw OAuthIdentityException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw OAuthIdentityException::oauthException($response, $data);
        }
    }

    /**
     * @param array $response
     * @param AccessToken $token
     * @return \Ftob\OAuth2\Providers\OAuthResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $user = new OAuthResourceOwner($response);
        return $user->setDomain($this->domain);
    }


}