<?php
/*
 * Routing items
 * 
 * is $key => $value array
 * Values:
 * @param string key - unique identifier of route
 * @param string type - "api" or "web"
 * @param string address - route addres, for example "product"
 * @param string namespace - namespace, where system finds class of controller
 * @param int paramsCount - params in URL,
 * @param string namespaceSystem (optional) reserve namespace for controller place
 * 
 * if namespaceSystem is empty, system will set default namespace by type
 */
return array(
    'admin' => [
        'key' => 'admin',
        'type' => 'web',
        'address' => 'admin',
        'namespace' => 'le7\Web\Admin',
        'paramsCount' => 7,
        'namespaceSystem' => ''
    ],
    'apiv1' => [
        'key' => 'apiv1',
        'type' => 'api',
        'address' => 'api/v1',
        'namespace' => 'le7\Api\v1',
        'paramsCount' => 7,
        'namespaceSystem' => ''
    ]
);
