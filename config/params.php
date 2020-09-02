<?php

return [
    'adminEmail'    => 'fcbeweb@memphis.edu',
    'senderEmail'   => 'noreply@memphis.edu',
    'senderName'    => 'FCBE Workdesk',
    
    'cas'   =>
    [
        // Required in phpCAS config, but probably not needed in this instance
        'cas_path'      => '/phpCAS/source/',
    
        // Full Hostname of your CAS Server    
        'host'          => 'sso.memphis.edu',
        
        // Port of your CAS server. Normally for a https server it's 443
        'port'          => '443',
        
        // Context of the CAS Server
        'uri'           => '/idp/profile/cas/',
        'context'       => '/idp/profile/cas/',  // Duplicate entries for now: 2 Sept 2020
        
        // Path to the ca chain that issued the cas server certificate
        'ca_cert_path'  => 'ssl/sso-memphis-edu-chain.pem',
        
        // The "real" hosts of clustered cas server that send SAML logout messages
        // Assumes the cas server is load balanced across multiple hosts
        'cas_real_hosts' => 
        [
            'main'  => 'sso.memphis.edu',
        ],        
        
        // Client config for cookie hardening        
        'client_domain' => 'itfcbewebldev.memphis.edu',
        'client_path'   => 'phpCAS-UofM',
        'client_secure' => true,
        'client_httpOnly'   => false,
        'client_lifetime'   => 21600,
    ],
];