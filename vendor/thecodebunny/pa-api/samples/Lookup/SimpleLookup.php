<?php
/*
 * Copyright 2016 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Config.php';

use PaApi\PaApi;
use PaApi\Configuration\GenericConfiguration;
use PaApi\Configuration\Country;
use PaApi\Operations\Lookup;

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \PaApi\Request\GuzzleRequest($client);

try {
    $conf
        ->setCountry(Country::GERMANY)
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG)
        ->setRequest($request)
        ->setResponseTransformer(new \PaApi\ResponseTransformer\XmlToDomDocument());
} catch (\Exception $e) {
    echo $e->getMessage();
}
$paApi = new PaApi($conf);

$lookup = new Lookup();
$lookup->setItemId('B0040PBK32,B00MEKHLLA');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $paApi->runOperation($lookup);

var_dump($formattedResponse);
