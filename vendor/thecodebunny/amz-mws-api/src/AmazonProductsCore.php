<?php

namespace Thecodebunny\AmzMwsApi;

use Config;

/*
 * Copyright 2013 CPI Group, LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 *
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Core class for Amazon Products API.
 *
 * This is the core class for all objects in the Amazon Products section.
 * It contains a few methods that all Amazon Products Core objects use.
 */
abstract class AmazonProductsCore extends AmazonCore
{
    protected $productList;
    protected $index = 0;

    /**
     * AmazonProductsCore constructor sets up key information used in all Amazon Products Core requests.
     *
     * This constructor is called when initializing all objects in the Amazon Products Core.
     * The parameters are passed by the child objects' constructors, which are
     * in turn passed to the AmazonCore constructor. See it for more information
     * on these parameters and common methods.
     *
     * @param string       $s      <p>Name for the store you want to use.</p>
     * @param bool         $mock   [optional] <p>This is a flag for enabling Mock Mode.
     *                             This defaults to <b>FALSE</b>.</p>
     * @param array|string $m      [optional] <p>The files (or file) to use in Mock Mode.</p>
     * @param string       $config [optional] <p>An alternate config file to set. Used for testing.</p>
     */
    public function __construct($s, $mock = false, $m = null, $config = null)
    {
        parent::__construct($s, $mock, $m, $config);
        include $this->env;

        if (isset($AMAZON_VERSION_PRODUCTS)) {
            $this->urlbranch = 'Products/'.$AMAZON_VERSION_PRODUCTS;
            $this->options['Version'] = $AMAZON_VERSION_PRODUCTS;
        }

        $config_options = $this->getOptions();
        //var_dump($config_options);
        $this->options['MarketplaceId'] = $config_options['MarketplaceId'];

        if (isset($THROTTLE_LIMIT_PRODUCT)) {
            $this->throttleLimit = $THROTTLE_LIMIT_PRODUCT;
        }
    }

    /**
     * Parses XML response into array.
     *
     * This is what reads the response XML and converts it into an array.
     *
     * @param SimpleXMLObject $xml <p>The XML response from Amazon.</p>
     *
     * @return bool <b>FALSE</b> if no XML data is found
     */
    protected function parseXML($xml)
    {
        if (! $xml) {
            return false;
        }

        foreach ($xml->children() as $x) {
            if ($x->getName() == 'ResponseMetadata') {
                continue;
            }
            $attributes = (array) $x->attributes();
            if (! isset($attributes['@attributes'])) {
                $attributes['@attributes'] = [];
            }
            if (isset($attributes['@attributes']['status']) && $attributes['@attributes']['status'] != 'Success') {
                $this->log('Warning: product return was not successful', 'Warning');
            }
            if (isset($x->Products)) {
                foreach ($x->Products->children() as $z) {
                    $this->productList[$this->index] = new AmazonProduct(
                        $this->storeName,
                        $z,
                        $attributes['@attributes'],
                        $this->mockMode,
                        $this->mockFiles
                    );
                    $this->index++;
                }
            } else {
                if ($x->getName() == 'GetProductCategoriesForSKUResult' || $x->getName() == 'GetProductCategoriesForASINResult') {
                    $this->productList[$this->index] = new AmazonProduct(
                        $this->storeName,
                        $x,
                        $attributes['@attributes'],
                        $this->mockMode,
                        $this->mockFiles
                    );
                    $this->index++;
                } else {
                    foreach ($x->children() as $z) {
                        if ($z->getName() == 'Error') {
                            $error = (string) $z->Message;
                            $this->productList['Error'] = $error;
                            $this->log("Product Error: $error", 'Warning');
                        } elseif ($z->getName() != 'Product') {
                            $this->productList[$z->getName()] = (string) $z;
                            $this->log('Special case: '.$z->getName(), 'Warning');
                        } else {
                            $this->productList[$this->index] = new AmazonProduct(
                                $this->storeName,
                                $z,
                                $attributes['@attributes'],
                                $this->mockMode,
                                $this->mockFiles
                            );
                            $this->index++;
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns product specified or array of products.
     *
     * See the <i>AmazonProduct</i> class for more information on the returned objects.
     *
     * @param int $num [optional] <p>List index to retrieve the value from. Defaults to 0.</p>
     *
     * @return AmazonProduct|array Product (or list of Products)
     */
    public function getProduct($num = null)
    {
        if (! isset($this->productList)) {
            return false;
        }
        if (is_numeric($num)) {
            return $this->productList[$num];
        } else {
            return $this->productList;
        }
    }
}
