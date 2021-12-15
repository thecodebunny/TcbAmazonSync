<?php
/**
 * Label
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  Thecodebunny\SpApi
 */

/**
 * Selling Partner API for Merchant Fulfillment
 *
 * The Selling Partner API for Merchant Fulfillment helps you build applications that let sellers purchase shipping for non-Prime and Prime orders using Amazon’s Buy Shipping Services.
 *
 * The version of the OpenAPI document: v0
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.0.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Thecodebunny\SpApi\Model\MerchantFulfillment;

use \ArrayAccess;
use \Thecodebunny\SpApi\ObjectSerializer;
use \Thecodebunny\SpApi\Model\ModelInterface;

/**
 * Label Class Doc Comment
 *
 * @category Class
 * @description Data for creating a shipping label and dimensions for printing the label.
 * @package  Thecodebunny\SpApi
 * @group 
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null  
 */
class Label implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Label';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'custom_text_for_label' => 'string',
        'dimensions' => '\Thecodebunny\SpApi\Model\MerchantFulfillment\LabelDimensions',
        'file_contents' => '\Thecodebunny\SpApi\Model\MerchantFulfillment\FileContents',
        'label_format' => '\Thecodebunny\SpApi\Model\MerchantFulfillment\LabelFormat',
        'standard_id_for_label' => '\Thecodebunny\SpApi\Model\MerchantFulfillment\StandardIdForLabel'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'custom_text_for_label' => null,
        'dimensions' => null,
        'file_contents' => null,
        'label_format' => null,
        'standard_id_for_label' => null
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
        'custom_text_for_label' => 'CustomTextForLabel',
        'dimensions' => 'Dimensions',
        'file_contents' => 'FileContents',
        'label_format' => 'LabelFormat',
        'standard_id_for_label' => 'StandardIdForLabel'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'custom_text_for_label' => 'setCustomTextForLabel',
        'dimensions' => 'setDimensions',
        'file_contents' => 'setFileContents',
        'label_format' => 'setLabelFormat',
        'standard_id_for_label' => 'setStandardIdForLabel',
        'headers' => 'setHeaders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'custom_text_for_label' => 'getCustomTextForLabel',
        'dimensions' => 'getDimensions',
        'file_contents' => 'getFileContents',
        'label_format' => 'getLabelFormat',
        'standard_id_for_label' => 'getStandardIdForLabel',
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
        $this->container['custom_text_for_label'] = $data['custom_text_for_label'] ?? null;
        $this->container['dimensions'] = $data['dimensions'] ?? null;
        $this->container['file_contents'] = $data['file_contents'] ?? null;
        $this->container['label_format'] = $data['label_format'] ?? null;
        $this->container['standard_id_for_label'] = $data['standard_id_for_label'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if (!is_null($this->container['custom_text_for_label']) && (mb_strlen($this->container['custom_text_for_label']) > 14)) {
            $invalidProperties[] = "invalid value for 'custom_text_for_label', the character length must be smaller than or equal to 14.";
        }

        if ($this->container['dimensions'] === null) {
            $invalidProperties[] = "'dimensions' can't be null";
        }
        if ($this->container['file_contents'] === null) {
            $invalidProperties[] = "'file_contents' can't be null";
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
     * Gets custom_text_for_label
     *
     * @return string|null
     */
    public function getCustomTextForLabel()
    {
        return $this->container['custom_text_for_label'];
    }

    /**
     * Sets custom_text_for_label
     *
     * @param string|null $custom_text_for_label Custom text to print on the label. Note: Custom text is only included on labels that are in ZPL format (ZPL203). FedEx does not support CustomTextForLabel.
     *
     * @return self
     */
    public function setCustomTextForLabel($custom_text_for_label)
    {
        if (!is_null($custom_text_for_label) && (mb_strlen($custom_text_for_label) > 14)) {
            throw new \InvalidArgumentException('invalid length for $custom_text_for_label when calling Label., must be smaller than or equal to 14.');
        }

        $this->container['custom_text_for_label'] = $custom_text_for_label;

        return $this;
    }

    /**
     * Gets dimensions
     *
     * @return \Thecodebunny\SpApi\Model\MerchantFulfillment\LabelDimensions
     */
    public function getDimensions()
    {
        return $this->container['dimensions'];
    }

    /**
     * Sets dimensions
     *
     * @param \Thecodebunny\SpApi\Model\MerchantFulfillment\LabelDimensions $dimensions dimensions
     *
     * @return self
     */
    public function setDimensions($dimensions)
    {
        $this->container['dimensions'] = $dimensions;

        return $this;
    }

    /**
     * Gets file_contents
     *
     * @return \Thecodebunny\SpApi\Model\MerchantFulfillment\FileContents
     */
    public function getFileContents()
    {
        return $this->container['file_contents'];
    }

    /**
     * Sets file_contents
     *
     * @param \Thecodebunny\SpApi\Model\MerchantFulfillment\FileContents $file_contents file_contents
     *
     * @return self
     */
    public function setFileContents($file_contents)
    {
        $this->container['file_contents'] = $file_contents;

        return $this;
    }

    /**
     * Gets label_format
     *
     * @return \Thecodebunny\SpApi\Model\MerchantFulfillment\LabelFormat|null
     */
    public function getLabelFormat()
    {
        return $this->container['label_format'];
    }

    /**
     * Sets label_format
     *
     * @param \Thecodebunny\SpApi\Model\MerchantFulfillment\LabelFormat|null $label_format label_format
     *
     * @return self
     */
    public function setLabelFormat($label_format)
    {
        $this->container['label_format'] = $label_format;

        return $this;
    }

    /**
     * Gets standard_id_for_label
     *
     * @return \Thecodebunny\SpApi\Model\MerchantFulfillment\StandardIdForLabel|null
     */
    public function getStandardIdForLabel()
    {
        return $this->container['standard_id_for_label'];
    }

    /**
     * Sets standard_id_for_label
     *
     * @param \Thecodebunny\SpApi\Model\MerchantFulfillment\StandardIdForLabel|null $standard_id_for_label standard_id_for_label
     *
     * @return self
     */
    public function setStandardIdForLabel($standard_id_for_label)
    {
        $this->container['standard_id_for_label'] = $standard_id_for_label;

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


