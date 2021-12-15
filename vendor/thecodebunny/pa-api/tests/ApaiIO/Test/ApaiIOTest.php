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

namespace PaApi\Test;

use PaApi\PaApi;
use PaApi\Configuration\GenericConfiguration;
use PaApi\Operations\Search;
use PHPUnit\Framework\TestCase;

class PaApiTest extends TestCase
{
    public function testPaApiRequestPerfomOperation()
    {
        $conf = new GenericConfiguration();
        $operation = new Search();

        $request = $this->prophesize('\PaApi\Request\RequestInterface');
        $request
            ->perform($operation, $conf)
            ->shouldBeCalledTimes(1)
            ->willReturn();

        $conf->setRequest($request->reveal());

        $paApi = new PaApi($conf);
        $paApi->runOperation($operation);
    }

    public function testPaApiTransformResponse()
    {
        $conf = new GenericConfiguration();
        $operation = new Search();

        $request = $this->prophesize('\PaApi\Request\RequestInterface');
        $request
            ->perform($operation, $conf)
            ->shouldBeCalledTimes(1)
            ->willReturn(['a' => 'b']);

        $conf->setRequest($request->reveal());

        $responseTransformer = $this->prophesize('\PaApi\ResponseTransformer\ResponseTransformerInterface');
        $responseTransformer
            ->transform(['a' => 'b'])
            ->shouldBeCalledTimes(1);

        $conf->setResponseTransformer($responseTransformer->reveal());

        $paApi = new PaApi($conf);
        $paApi->runOperation($operation);
    }
}
