<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace Benz3d\OAuth2\Repositories;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Benz3d\OAuth2\Entities\UserEntity;

class UserRepository implements UserRepositoryInterface
{
    protected $db;
    public function __construct(CI_DB $db){
        $this->db = $db;
    }
    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        if ($username === 'alex' && $password === 'whisky') {
            return new UserEntity();
        }

        return;
    }
}
