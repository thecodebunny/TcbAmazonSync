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

namespace PaApi\Configuration;

use PaApi\Request\RequestInterface;
use PaApi\ResponseTransformer\ResponseTransformerInterface;

interface ConfigurationInterface
{
    /**
     * Gets the country
     *
     * @return string
     */
    public function getCountry();

    /**
     * Gets the accesskey
     *
     * @return string
     */
    public function getAccessKey();

    /**
     * Gets the secretkey
     *
     * @return string
     */
    public function getSecretKey();

    /**
     * Gets the associatetag
     *
     * @return string
     */
    public function getAssociateTag();

    /**
     * Gets the requestclass
     *
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Gets the responsetransformerclass
     *
     * @return ResponseTransformerInterface
     */
    public function getResponseTransformer();
}
