<?php
/**
 * Copyright 2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
namespace TheCodeBunny\PaApi;

use \ArrayAccess;
use \TheCodeBunny\PaApi\ObjectSerializer;

/**
 * ProductInfo Class Doc Comment
 *
 * @category Class
 * @package  TheCodeBunny\PaApi
 * @author   Product Advertising API team
 */
class ProductInfo implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ProductInfo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'color' => '\TheCodeBunny\PaApi\SingleStringValuedAttribute',
        'isAdultProduct' => '\TheCodeBunny\PaApi\SingleBooleanValuedAttribute',
        'itemDimensions' => '\TheCodeBunny\PaApi\DimensionBasedAttribute',
        'releaseDate' => '\TheCodeBunny\PaApi\SingleStringValuedAttribute',
        'size' => '\TheCodeBunny\PaApi\SingleStringValuedAttribute',
        'unitCount' => '\TheCodeBunny\PaApi\SingleIntegerValuedAttribute'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'color' => null,
        'isAdultProduct' => null,
        'itemDimensions' => null,
        'releaseDate' => null,
        'size' => null,
        'unitCount' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'color' => 'Color',
        'isAdultProduct' => 'IsAdultProduct',
        'itemDimensions' => 'ItemDimensions',
        'releaseDate' => 'ReleaseDate',
        'size' => 'Size',
        'unitCount' => 'UnitCount'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'color' => 'setColor',
        'isAdultProduct' => 'setIsAdultProduct',
        'itemDimensions' => 'setItemDimensions',
        'releaseDate' => 'setReleaseDate',
        'size' => 'setSize',
        'unitCount' => 'setUnitCount'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'color' => 'getColor',
        'isAdultProduct' => 'getIsAdultProduct',
        'itemDimensions' => 'getItemDimensions',
        'releaseDate' => 'getReleaseDate',
        'size' => 'getSize',
        'unitCount' => 'getUnitCount'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['color'] = isset($data['color']) ? $data['color'] : null;
        $this->container['isAdultProduct'] = isset($data['isAdultProduct']) ? $data['isAdultProduct'] : null;
        $this->container['itemDimensions'] = isset($data['itemDimensions']) ? $data['itemDimensions'] : null;
        $this->container['releaseDate'] = isset($data['releaseDate']) ? $data['releaseDate'] : null;
        $this->container['size'] = isset($data['size']) ? $data['size'] : null;
        $this->container['unitCount'] = isset($data['unitCount']) ? $data['unitCount'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        return true;
    }


    /**
     * Gets color
     *
     * @return \TheCodeBunny\PaApi\SingleStringValuedAttribute
     */
    public function getColor()
    {
        return $this->container['color'];
    }

    /**
     * Sets color
     *
     * @param \TheCodeBunny\PaApi\SingleStringValuedAttribute $color color
     *
     * @return $this
     */
    public function setColor($color)
    {
        $this->container['color'] = $color;

        return $this;
    }

    /**
     * Gets isAdultProduct
     *
     * @return \TheCodeBunny\PaApi\SingleBooleanValuedAttribute
     */
    public function getIsAdultProduct()
    {
        return $this->container['isAdultProduct'];
    }

    /**
     * Sets isAdultProduct
     *
     * @param \TheCodeBunny\PaApi\SingleBooleanValuedAttribute $isAdultProduct isAdultProduct
     *
     * @return $this
     */
    public function setIsAdultProduct($isAdultProduct)
    {
        $this->container['isAdultProduct'] = $isAdultProduct;

        return $this;
    }

    /**
     * Gets itemDimensions
     *
     * @return \TheCodeBunny\PaApi\DimensionBasedAttribute
     */
    public function getItemDimensions()
    {
        return $this->container['itemDimensions'];
    }

    /**
     * Sets itemDimensions
     *
     * @param \TheCodeBunny\PaApi\DimensionBasedAttribute $itemDimensions itemDimensions
     *
     * @return $this
     */
    public function setItemDimensions($itemDimensions)
    {
        $this->container['itemDimensions'] = $itemDimensions;

        return $this;
    }

    /**
     * Gets releaseDate
     *
     * @return \TheCodeBunny\PaApi\SingleStringValuedAttribute
     */
    public function getReleaseDate()
    {
        return $this->container['releaseDate'];
    }

    /**
     * Sets releaseDate
     *
     * @param \TheCodeBunny\PaApi\SingleStringValuedAttribute $releaseDate releaseDate
     *
     * @return $this
     */
    public function setReleaseDate($releaseDate)
    {
        $this->container['releaseDate'] = $releaseDate;

        return $this;
    }

    /**
     * Gets size
     *
     * @return \TheCodeBunny\PaApi\SingleStringValuedAttribute
     */
    public function getSize()
    {
        return $this->container['size'];
    }

    /**
     * Sets size
     *
     * @param \TheCodeBunny\PaApi\SingleStringValuedAttribute $size size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->container['size'] = $size;

        return $this;
    }

    /**
     * Gets unitCount
     *
     * @return \TheCodeBunny\PaApi\SingleIntegerValuedAttribute
     */
    public function getUnitCount()
    {
        return $this->container['unitCount'];
    }

    /**
     * Sets unitCount
     *
     * @param \TheCodeBunny\PaApi\SingleIntegerValuedAttribute $unitCount unitCount
     *
     * @return $this
     */
    public function setUnitCount($unitCount)
    {
        $this->container['unitCount'] = $unitCount;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
