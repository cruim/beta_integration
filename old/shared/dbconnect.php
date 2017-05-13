<?php

class mysqli_ssl EXTENDS mysqli {

    public function __connect() {
        $serverSQL = 'zdorov.local.mySQL.Server';
        
        $this->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, TRUE);
        $this->ssl_set(
                __DIR__.'/../../shared/certs/zdorov.local.mySQL.Server/client-key.pem',
                __DIR__.'/../../shared/certs/zdorov.local.mySQL.Server/client-cert.pem',
                __DIR__.'/../../shared/certs/zdorov.local.mySQL.Server/ca.pem',
                NULL,
                NULL
        );
        $this->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
        $this->real_connect($serverSQL, 'landing', '123', 'integration_betapost', NULL, NULL, MYSQLI_CLIENT_SSL);
        $this->set_charset("utf8");
    }
    
    
}


?>