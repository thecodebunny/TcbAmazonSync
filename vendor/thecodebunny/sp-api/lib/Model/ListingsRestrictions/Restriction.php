<?php
/**
 * Restriction
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  Thecodebunny\SpApi
 */

/**
 * Selling Partner API for Listings Restrictions
 *
 * The Selling Partner API for Listings Restrictions provides programmatic access to restrictions on Amazon catalog listings. For more information, see the [Listings Restrictions API Use Case Guide](https://github.com/amzn/selling-partner-api-docs/blob/main/guides/en-US/use-case-guides/listings-restrictions-api-use-case-guide/listings-restrictions-api-use-case-guide_2021-08-01.md).
 *
 * The version of the OpenAPI document: 2021-08-01
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.0.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Thecodebunny\SpApi\Model\ListingsRestrictions;

use \ArrayAccess;
use \Thecodebunny\SpApi\ObjectSerializer;
use \Thecodebunny\SpApi\Model\ModelInterface;

/**
 * Restriction Class Doc Comment
 *
 * @category Class
 * @description A listing restriction, optionally qualified by a condition, with a list of reasons for the restriction.
 * @package  Thecodebunny\SpApi
 * @group 
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null  
 */
class Restriction implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Restriction';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'marketplace_id' => 'string',
        'condition_type' => 'string',
        'reasons' => '\Thecodebunny\SpApi\Model\ListingsRestrictions\Reason[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'marketplace_id' => null,
        'condition_type' => null,
        'reasons' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'marketplace_id' => 'marketplaceId',
        'condition_type' => 'conditionType',
        'reasons' => 'reasons'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'marketplace_id' => 'setMarketplaceId',
        'condition_type' => 'setConditionType',
        'reasons' => 'setReasons',
        'headers' => 'setHeaders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'marketplace_id' => 'getMarketplaceId',
        'condition_type' => 'getConditionType',
        'reasons' => 'getReasons',
        'headers' => 'getHeaders'
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
        return self::$openAPIModelName;
    }

    const CONDITION_TYPE_NEW_NEW = 'new_new';
    const CONDITION_TYPE_NEW_OPEN_BOX = 'new_open_box';
    const CONDITION_TYPE_NEW_OEM = 'new_oem';
    const CONDITION_TYPE_REFURBISHED_REFURBISHED = 'refurbished_refurbished';
    const CONDITION_TYPE_USED_LIKE_NEW = 'used_like_new';
    const CONDITION_TYPE_USED_VERY_GOOD = 'used_very_good';
    const CONDITION_TYPE_USED_GOOD = 'used_good';
    const CONDITION_TYPE_USED_ACCEPTABLE = 'used_acceptable';
    const CONDITION_TYPE_COLLECTIBLE_LIKE_NEW = 'collectible_like_new';
    const CONDITION_TYPE_COLLECTIBLE_VERY_GOOD = 'collectible_very_good';
    const CONDITION_TYPE_COLLECTIBLE_GOOD = 'collectible_good';
    const CONDITION_TYPE_COLLECTIBLE_ACCEPTABLE = 'collectible_acceptable';
    const CONDITION_TYPE_CLUB_CLUB = 'club_club';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getConditionTypeAllowableValues()
    {
        return [
            self::CONDITION_TYPE_NEW_NEW,
            self::CONDITION_TYPE_NEW_OPEN_BOX,
            self::CONDITION_TYPE_NEW_OEM,
            self::CONDITION_TYPE_REFURBISHED_REFURBISHED,
            self::CONDITION_TYPE_USED_LIKE_NEW,
            self::CONDITION_TYPE_USED_VERY_GOOD,
            self::CONDITION_TYPE_USED_GOOD,
            self::CONDITION_TYPE_USED_ACCEPTABLE,
            self::CONDITION_TYPE_COLLECTIBLE_LIKE_NEW,
            self::CONDITION_TYPE_COLLECTIBLE_VERY_GOOD,
            self::CONDITION_TYPE_COLLECTIBLE_GOOD,
            self::CONDITION_TYPE_COLLECTIBLE_ACCEPTABLE,
            self::CONDITION_TYPE_CLUB_CLUB,
        ];
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
        $this->container['marketplace_id'] = $data['marketplace_id'] ?? null;
        $this->container['condition_type'] = $data['condition_type'] ?? null;
        $this->container['reasons'] = $data['reasons'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['marketplace_id'] === null) {
            $invalidProperties[] = "'marketplace_id' can't be null";
        }
        $allowedValues = $this->getConditionTypeAllowableValues();
        if (!is_null($this->container['condition_type']) && !in_array($this->container['condition_type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'condition_type', must be one of '%s'",
                $this->container['condition_type'],
                implode("', '", $allowedValues)
            );
        }

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
        return count($this->listInvalidProperties()) === 0;
    }

    /**
     * Gets headers, if this is a top-level response model
     *
     * @return array[string]|null
     */
    public function getHeaders()
    {
        return $this->container['headers'];
    }

    /**
     * Sets headers (only relevant to response models)
     *
     * @param array[string => string]|null $headers Associative array of response headers.
     *
     * @return self
     */
    public function setHeaders($headers)
    {
        $this->container['headers'] = $headers;

        return $this;
    }


    /**
     * Gets marketplace_id
     *
     * @return string
     */
    public function getMarketplaceId()
    {
        return $this->container['marketplace_id'];
    }

    /**
     * Sets marketplace_id
     *
     * @param string $marketplace_id A marketplace identifier. Identifies the Amazon marketplace where the restriction is enforced.
     *
     * @return self
     */
    public function setMarketplaceId($marketplace_id)
    {
        $this->container['marketplace_id'] = $marketplace_id;

        return $this;
    }

    /**
     * Gets condition_type
     *
     * @return string|null
     */
    public function getConditionType()
    {
        return $this->container['condition_type'];
    }

    /**
     * Sets condition_type
     *
     * @param string|null $condition_type The condition that applies to the restriction.
     *
     * @return self
     */
    public function setConditionType($condition_type)
    {
        $allowedValues = $this->getConditionTypeAllowableValues();
        if (!is_null($condition_type) && !in_array($condition_type, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'condition_type', must be one of '%s'",
                    $condition_type,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['condition_type'] = $condition_type;

        return $this;
    }

    /**
     * Gets reasons
     *
     * @return \Thecodebunny\SpApi\Model\ListingsRestrictions\Reason[]|null
     */
    public function getReasons()
    {
        return $this->container['reasons'];
    }

    /**
     * Sets reasons
     *
     * @param \Thecodebunny\SpApi\Model\ListingsRestrictions\Reason[]|null $reasons A list of reasons for the restriction.
     *
     * @return self
     */
    public function setReasons($reasons)
    {
        $this->container['reasons'] = $reasons;

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
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
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
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


