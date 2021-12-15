<?php
/**
 * Stop
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  Thecodebunny\SpApi
 */

/**
 * Selling Partner API for Retail Procurement Shipments
 *
 * The Selling Partner API for Retail Procurement Shipments provides programmatic access to retail shipping data for vendors.
 *
 * The version of the OpenAPI document: v1
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.0.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Thecodebunny\SpApi\Model\VendorShipping;

use \ArrayAccess;
use \Thecodebunny\SpApi\ObjectSerializer;
use \Thecodebunny\SpApi\Model\ModelInterface;

/**
 * Stop Class Doc Comment
 *
 * @category Class
 * @description Contractual or operational port or point relevant to the movement of the cargo.
 * @package  Thecodebunny\SpApi
 * @group 
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null  
 */
class Stop implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Stop';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'function_code' => 'string',
        'location_identification' => '\Thecodebunny\SpApi\Model\VendorShipping\Location',
        'arrival_time' => '\DateTime',
        'departure_time' => '\DateTime'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'function_code' => null,
        'location_identification' => null,
        'arrival_time' => 'date-time',
        'departure_time' => 'date-time'
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
        'function_code' => 'functionCode',
        'location_identification' => 'locationIdentification',
        'arrival_time' => 'arrivalTime',
        'departure_time' => 'departureTime'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'function_code' => 'setFunctionCode',
        'location_identification' => 'setLocationIdentification',
        'arrival_time' => 'setArrivalTime',
        'departure_time' => 'setDepartureTime',
        'headers' => 'setHeaders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'function_code' => 'getFunctionCode',
        'location_identification' => 'getLocationIdentification',
        'arrival_time' => 'getArrivalTime',
        'departure_time' => 'getDepartureTime',
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

    const FUNCTION_CODE_PORT_OF_DISCHARGE = 'PortOfDischarge';
    const FUNCTION_CODE_FREIGHT_PAYABLE_AT = 'FreightPayableAt';
    const FUNCTION_CODE_PORT_OF_LOADING = 'PortOfLoading';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getFunctionCodeAllowableValues()
    {
        return [
            self::FUNCTION_CODE_PORT_OF_DISCHARGE,
            self::FUNCTION_CODE_FREIGHT_PAYABLE_AT,
            self::FUNCTION_CODE_PORT_OF_LOADING,
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
        $this->container['function_code'] = $data['function_code'] ?? null;
        $this->container['location_identification'] = $data['location_identification'] ?? null;
        $this->container['arrival_time'] = $data['arrival_time'] ?? null;
        $this->container['departure_time'] = $data['departure_time'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['function_code'] === null) {
            $invalidProperties[] = "'function_code' can't be null";
        }
        $allowedValues = $this->getFunctionCodeAllowableValues();
        if (!is_null($this->container['function_code']) && !in_array($this->container['function_code'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'function_code', must be one of '%s'",
                $this->container['function_code'],
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
     * Gets function_code
     *
     * @return string
     */
    public function getFunctionCode()
    {
        return $this->container['function_code'];
    }

    /**
     * Sets function_code
     *
     * @param string $function_code Provide the function code.
     *
     * @return self
     */
    public function setFunctionCode($function_code)
    {
        $allowedValues = $this->getFunctionCodeAllowableValues();
        if (!in_array($function_code, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value '%s' for 'function_code', must be one of '%s'",
                    $function_code,
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['function_code'] = $function_code;

        return $this;
    }

    /**
     * Gets location_identification
     *
     * @return \Thecodebunny\SpApi\Model\VendorShipping\Location|null
     */
    public function getLocationIdentification()
    {
        return $this->container['location_identification'];
    }

    /**
     * Sets location_identification
     *
     * @param \Thecodebunny\SpApi\Model\VendorShipping\Location|null $location_identification location_identification
     *
     * @return self
     */
    public function setLocationIdentification($location_identification)
    {
        $this->container['location_identification'] = $location_identification;

        return $this;
    }

    /**
     * Gets arrival_time
     *
     * @return \DateTime|null
     */
    public function getArrivalTime()
    {
        return $this->container['arrival_time'];
    }

    /**
     * Sets arrival_time
     *
     * @param \DateTime|null $arrival_time Date and time of the arrival of the cargo.
     *
     * @return self
     */
    public function setArrivalTime($arrival_time)
    {
        $this->container['arrival_time'] = $arrival_time;

        return $this;
    }

    /**
     * Gets departure_time
     *
     * @return \DateTime|null
     */
    public function getDepartureTime()
    {
        return $this->container['departure_time'];
    }

    /**
     * Sets departure_time
     *
     * @param \DateTime|null $departure_time Date and time of the departure of the cargo.
     *
     * @return self
     */
    public function setDepartureTime($departure_time)
    {
        $this->container['departure_time'] = $departure_time;

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


