<?php
namespace Benz3d\OAuth2\AuthorizationServer;

use Benz3d\OAuth2\Repositories\ClientRepository;
use Benz3d\OAuth2\Repositories\ScopeRepository;
use Benz3d\OAuth2\Repositories\AccessTokenRepository;

class AuthorizationServer {
    
    private $_privateKey;
    private $_encryptionKey;
    protected $db;
    protected $interval = 'PT1H'; // access tokens will expire after 1 hour
    
    public function __construct(CI_DB $db,$privateKey,$encryptionKey) {
        $this->db = $db;
        $this->_privateKey = $privateKey;
        $this->_encryptionKey = $encryptionKey;
    }
    
    public function setExpire($interval){
        $this->interval = $interval;
    }
    
    public function getInstance(){
        // Init our repositories
        $storage = $this->db;
        $clientRepository = new ClientRepository($storage) ;// instance of ClientRepositoryInterface
        $scopeRepository = new ScopeRepository($storage); // instance of ScopeRepositoryInterface
        $accessTokenRepository = new AccessTokenRepository($storage); // instance of AccessTokenRepositoryInterface
        
        // Setup the authorization server
        $server = new \League\OAuth2\Server\AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $this->_privateKey,
            $this->_encryptionKey
        );
        
        // Enable the client credentials grant on the server
        $server->enableGrantType(
            new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
            new \DateInterval($this->interval) 
        );
        
        return $server;
    }
}