<?php

return [

    'name'              => 'TcbAmazonSync',
    'description'       => 'Amazon Orders Synchronization',
    'amzmenu'           => 'Amazon',
    'amzdashboard'      => 'Dashboard',
    'amzsettings'       => 'Settings',
    'amzspsettings'     => 'SP API Settings',
    'amzmwssettings'    => 'MWS API Settings',
    'amzpasettings'     => 'PA API Settings',
    'amzcategories'     => 'Categories',

    'category' => [
        'path'          =>  'Amazon Category Path',
        'rootcat'       =>  'Main Category',
        'ukid'          =>  'UK ID',
        'deid'          =>  'DE ID',
        'frid'          =>  'FR ID',
        'itid'          =>  'IT ID',
        'esid'          =>  'ES ID'
    ],

    'settings' => [
        'amazon'            =>  'Amazon Settings',
        'spname'            =>  'Amazon SP API Settings',
        'paname'            =>  'Amazon PA API Settings',
        'mwsname'           =>  'Amazon MWS API Settings',
        'appname'           =>  'Application Name',
        'appid'             =>  'App ID',
        'clientid'          =>  'Client ID',
        'clientsecret'      =>  'Client Secret',
        'iasaccesskey'      =>  'IAS Access Key',
        'iasaccesstoken'    =>  'IAS Access Token',
        'eutoken'           =>  'EU Token',
        'ustoken'           =>  'USA Token',
        'endpoint'          =>  'Endpoint',
        'iamarn'            =>  'IAM ARN',
        'spapi'             =>  'Amazon SP APi',
        'mwsapi'            =>  'Amazon MWS APi',
        'paapi'             =>  'Amazon PA APi',
        'apisetting'        =>  [
            'name'          =>  'Amazon API Settings',
            'desc'          =>  'Setup API Settings here.',
            'updated'       =>  'API Settings Successfully Updated.',
            'merchant'      =>  'Merchant Token',
            'accesskeyid'   =>  'Access Key Id',
            'secretkey'     =>  'Secret Key',
            'authtoken'     =>  'Authorization Token (optional)',
            'uk'            =>  'Enable for UK?',
            'de'            =>  'Enable for Germany?',
            'fr'            =>  'Enable for France?',
            'it'            =>  'Enable for Italy?',
            'es'            =>  'Enable for Spain?',
            'se'            =>  'Enable for Sweden?',
            'nl'            =>  'Enable for Netherlands?',
            'pl'            =>  'Enable for Poland?',
            'associattaguk'     =>  'UK Associate Tag',
            'associattagde'     =>  'DE Associate Tag',
            'associattagfr'     =>  'FR Associate Tag',
            'associattagit'     =>  'IT Associate Tag',
            'associattages'     =>  'ES Associate Tag',
            'associattagse'     =>  'SE Associate Tag',
            'associattagnl'     =>  'NL Associate Tag',
            'associattagpl'     =>  'PL Associate Tag',
        ]
    ]

];