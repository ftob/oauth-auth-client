<?php
namespace Ftob\OAuth2\Client\Grants;

use League\OAuth2\Client\Grant\AbstractGrant;

class ClientCredentials extends AbstractGrant
{
    public function __toString()
    {
        return '';
    }

    protected function getName()
    {
        // TODO: Implement getName() method.
    }

    protected function getRequiredRequestParameters()
    {
        // TODO: Implement getRequiredRequestParameters() method.
    }

}