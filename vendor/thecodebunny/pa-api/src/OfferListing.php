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
 * OfferListing Class Doc Comment
 *
 * @category Class
 * @package  TheCodeBunny\PaApi
 * @author   Product Advertising API team
 */
class OfferListing implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'OfferListing';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'availability' => '\TheCodeBunny\PaApi\OfferAvailability',
        'condition' => '\TheCodeBunny\PaApi\OfferCondition',
        'deliveryInfo' => '\TheCodeBunny\PaApi\OfferDeliveryInfo',
        'id' => 'string',
        'isBuyBoxWinner' => 'bool',
        'loyaltyPoints' => '\TheCodeBunny\PaApi\OfferLoyaltyPoints',
        'merchantInfo' => '\TheCodeBunny\PaApi\OfferMerchantInfo',
        'price' => '\TheCodeBunny\PaApi\OfferPrice',
        'programEligibility' => '\TheCodeBunny\PaApi\OfferProgramEligibility',
        'promotions' => '\TheCodeBunny\PaApi\OfferPromotion[]',
        'savingBasis' => '\TheCodeBunny\PaApi\OfferPrice',
        'violatesMAP' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'availability' => null,
        'condition' => null,
        'deliveryInfo' => null,
        'id' => null,
        'isBuyBoxWinner' => null,
        'loyaltyPoints' => null,
        'merchantInfo' => null,
        'price' => null,
        'programEligibility' => null,
        'promotions' => null,
        'savingBasis' => null,
        'violatesMAP' => null
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
        'availability' => 'Availability',
        'condition' => 'Condition',
        'deliveryInfo' => 'DeliveryInfo',
        'id' => 'Id',
        'isBuyBoxWinner' => 'IsBuyBoxWinner',
        'loyaltyPoints' => 'LoyaltyPoints',
        'merchantInfo' => 'MerchantInfo',
        'price' => 'Price',
        'programEligibility' => 'ProgramEligibility',
        'promotions' => 'Promotions',
        'savingBasis' => 'SavingBasis',
        'violatesMAP' => 'ViolatesMAP'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'availability' => 'setAvailability',
        'condition' => 'setCondition',
        'deliveryInfo' => 'setDeliveryInfo',
        'id' => 'setId',
        'isBuyBoxWinner' => 'setIsBuyBoxWinner',
        'loyaltyPoints' => 'setLoyaltyPoints',
        'merchantInfo' => 'setMerchantInfo',
        'price' => 'setPrice',
        'programEligibility' => 'setProgramEligibility',
        'promotions' => 'setPromotions',
        'savingBasis' => 'setSavingBasis',
        'violatesMAP' => 'setViolatesMAP'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'availability' => 'getAvailability',
        'condition' => 'getCondition',
        'deliveryInfo' => 'getDeliveryInfo',
        'id' => 'getId',
        'isBuyBoxWinner' => 'getIsBuyBoxWinner',
        'loyaltyPoints' => 'getLoyaltyPoints',
        'merchantInfo' => 'getMerchantInfo',
        'price' => 'getPrice',
        'programEligibility' => 'getProgramEligibility',
        'promotions' => 'getPromotions',
        'savingBasis' => 'getSavingBasis',
        'violatesMAP' => 'getViolatesMAP'
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
        $this->container['availability'] = isset($data['availability']) ? $data['availability'] : null;
        $this->container['condition'] = isset($data['condition']) ? $data['condition'] : null;
        $this->container['deliveryInfo'] = isset($data['deliveryInfo']) ? $data['deliveryInfo'] : null;
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['isBuyBoxWinner'] = isset($data['isBuyBoxWinner']) ? $data['isBuyBoxWinner'] : null;
        $this->container['loyaltyPoints'] = isset($data['loyaltyPoints']) ? $data['loyaltyPoints'] : null;
        $this->container['merchantInfo'] = isset($data['merchantInfo']) ? $data['merchantInfo'] : null;
        $this->container['price'] = isset($data['price']) ? $data['price'] : null;
        $this->container['programEligibility'] = isset($data['programEligibility']) ? $data['programEligibility'] : null;
        $this->container['promotions'] = isset($data['promotions']) ? $data['promotions'] : null;
        $this->container['savingBasis'] = isset($data['savingBasis']) ? $data['savingBasis'] : null;
        $this->container['violatesMAP'] = isset($data['violatesMAP']) ? $data['violatesMAP'] : null;
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
     * Gets availability
     *
     * @return \TheCodeBunny\PaApi\OfferAvailability
     */
    public function getAvailability()
    {
        return $this->container['availability'];
    }

    /**
     * Sets availability
     *
     * @param \TheCodeBunny\PaApi\OfferAvailability $availability availability
     *
     * @return $this
     */
    public function setAvailability($availability)
    {
        $this->container['availability'] = $availability;

        return $this;
    }

    /**
     * Gets condition
     *
     * @return \TheCodeBunny\PaApi\OfferCondition
     */
    public function getCondition()
    {
        return $this->container['condition'];
    }

    /**
     * Sets condition
     *
     * @param \TheCodeBunny\PaApi\OfferCondition $condition condition
     *
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->container['condition'] = $condition;

        return $this;
    }

    /**
     * Gets deliveryInfo
     *
     * @return \TheCodeBunny\PaApi\OfferDeliveryInfo
     */
    public function getDeliveryInfo()
    {
        return $this->container['deliveryInfo'];
    }

    /**
     * Sets deliveryInfo
     *
     * @param \TheCodeBunny\PaApi\OfferDeliveryInfo $deliveryInfo deliveryInfo
     *
     * @return $this
     */
    public function setDeliveryInfo($deliveryInfo)
    {
        $this->container['deliveryInfo'] = $deliveryInfo;

        return $this;
    }

    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets isBuyBoxWinner
     *
     * @return bool
     */
    public function getIsBuyBoxWinner()
    {
        return $this->container['isBuyBoxWinner'];
    }

    /**
     * Sets isBuyBoxWinner
     *
     * @param bool $isBuyBoxWinner isBuyBoxWinner
     *
     * @return $this
     */
    public function setIsBuyBoxWinner($isBuyBoxWinner)
    {
        $this->container['isBuyBoxWinner'] = $isBuyBoxWinner;

        return $this;
    }

    /**
     * Gets loyaltyPoints
     *
     * @return \TheCodeBunny\PaApi\OfferLoyaltyPoints
     */
    public function getLoyaltyPoints()
    {
        return $this->container['loyaltyPoints'];
    }

    /**
     * Sets loyaltyPoints
     *
     * @param \TheCodeBunny\PaApi\OfferLoyaltyPoints $loyaltyPoints loyaltyPoints
     *
     * @return $this
     */
    public function setLoyaltyPoints($loyaltyPoints)
    {
        $this->container['loyaltyPoints'] = $loyaltyPoints;

        return $this;
    }

    /**
     * Gets merchantInfo
     *
     * @return \TheCodeBunny\PaApi\OfferMerchantInfo
     */
    public function getMerchantInfo()
    {
        return $this->container['merchantInfo'];
    }

    /**
     * Sets merchantInfo
     *
     * @param \TheCodeBunny\PaApi\OfferMerchantInfo $merchantInfo merchantInfo
     *
     * @return $this
     */
    public function setMerchantInfo($merchantInfo)
    {
        $this->container['merchantInfo'] = $merchantInfo;

        return $this;
    }

    /**
     * Gets price
     *
     * @return \TheCodeBunny\PaApi\OfferPrice
     */
    public function getPrice()
    {
        return $this->container['price'];
    }

    /**
     * Sets price
     *
     * @param \TheCodeBunny\PaApi\OfferPrice $price price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->container['price'] = $price;

        return $this;
    }

    /**
     * Gets programEligibility
     *
     * @return \TheCodeBunny\PaApi\OfferProgramEligibility
     */
    public function getProgramEligibility()
    {
        return $this->container['programEligibility'];
    }

    /**
     * Sets programEligibility
     *
     * @param \TheCodeBunny\PaApi\OfferProgramEligibility $programEligibility programEligibility
     *
     * @return $this
     */
    public function setProgramEligibility($programEligibility)
    {
        $this->container['programEligibility'] = $programEligibility;

        return $this;
    }

    /**
     * Gets promotions
     *
     * @return \TheCodeBunny\PaApi\OfferPromotion[]
     */
    public function getPromotions()
    {
        return $this->container['promotions'];
    }

    /**
     * Sets promotions
     *
     * @param \TheCodeBunny\PaApi\OfferPromotion[] $promotions promotions
     *
     * @return $this
     */
    public function setPromotions($promotions)
    {
        $this->container['promotions'] = $promotions;

        return $this;
    }

    /**
     * Gets savingBasis
     *
     * @return \TheCodeBunny\PaApi\OfferPrice
     */
    public function getSavingBasis()
    {
        return $this->container['savingBasis'];
    }

    /**
     * Sets savingBasis
     *
     * @param \TheCodeBunny\PaApi\OfferPrice $savingBasis savingBasis
     *
     * @return $this
     */
    public function setSavingBasis($savingBasis)
    {
        $this->container['savingBasis'] = $savingBasis;

        return $this;
    }

    /**
     * Gets violatesMAP
     *
     * @return bool
     */
    public function getViolatesMAP()
    {
        return $this->container['violatesMAP'];
    }

    /**
     * Sets violatesMAP
     *
     * @param bool $violatesMAP violatesMAP
     *
     * @return $this
     */
    public function setViolatesMAP($violatesMAP)
    {
        $this->container['violatesMAP'] = $violatesMAP;

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
