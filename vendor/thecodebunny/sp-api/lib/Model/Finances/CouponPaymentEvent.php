<?php
/**
 * CouponPaymentEvent
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  Thecodebunny\SpApi
 */

/**
 * Selling Partner API for Finances
 *
 * The Selling Partner API for Finances helps you obtain financial information relevant to a seller's business. You can obtain financial events for a given order, financial event group, or date range without having to wait until a statement period closes. You can also obtain financial event groups for a given date range.
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

namespace Thecodebunny\SpApi\Model\Finances;

use \ArrayAccess;
use \Thecodebunny\SpApi\ObjectSerializer;
use \Thecodebunny\SpApi\Model\ModelInterface;

/**
 * CouponPaymentEvent Class Doc Comment
 *
 * @category Class
 * @description An event related to coupon payments.
 * @package  Thecodebunny\SpApi
 * @group 
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null  
 */
class CouponPaymentEvent implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'CouponPaymentEvent';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'posted_date' => '\DateTime',
        'coupon_id' => 'string',
        'seller_coupon_description' => 'string',
        'clip_or_redemption_count' => 'int',
        'payment_event_id' => 'string',
        'fee_component' => '\Thecodebunny\SpApi\Model\Finances\FeeComponent',
        'charge_component' => '\Thecodebunny\SpApi\Model\Finances\ChargeComponent',
        'total_amount' => '\Thecodebunny\SpApi\Model\Finances\Currency'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'posted_date' => 'date-time',
        'coupon_id' => null,
        'seller_coupon_description' => null,
        'clip_or_redemption_count' => 'int64',
        'payment_event_id' => null,
        'fee_component' => null,
        'charge_component' => null,
        'total_amount' => null
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
        'posted_date' => 'PostedDate',
        'coupon_id' => 'CouponId',
        'seller_coupon_description' => 'SellerCouponDescription',
        'clip_or_redemption_count' => 'ClipOrRedemptionCount',
        'payment_event_id' => 'PaymentEventId',
        'fee_component' => 'FeeComponent',
        'charge_component' => 'ChargeComponent',
        'total_amount' => 'TotalAmount'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'posted_date' => 'setPostedDate',
        'coupon_id' => 'setCouponId',
        'seller_coupon_description' => 'setSellerCouponDescription',
        'clip_or_redemption_count' => 'setClipOrRedemptionCount',
        'payment_event_id' => 'setPaymentEventId',
        'fee_component' => 'setFeeComponent',
        'charge_component' => 'setChargeComponent',
        'total_amount' => 'setTotalAmount',
        'headers' => 'setHeaders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'posted_date' => 'getPostedDate',
        'coupon_id' => 'getCouponId',
        'seller_coupon_description' => 'getSellerCouponDescription',
        'clip_or_redemption_count' => 'getClipOrRedemptionCount',
        'payment_event_id' => 'getPaymentEventId',
        'fee_component' => 'getFeeComponent',
        'charge_component' => 'getChargeComponent',
        'total_amount' => 'getTotalAmount',
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
        $this->container['posted_date'] = $data['posted_date'] ?? null;
        $this->container['coupon_id'] = $data['coupon_id'] ?? null;
        $this->container['seller_coupon_description'] = $data['seller_coupon_description'] ?? null;
        $this->container['clip_or_redemption_count'] = $data['clip_or_redemption_count'] ?? null;
        $this->container['payment_event_id'] = $data['payment_event_id'] ?? null;
        $this->container['fee_component'] = $data['fee_component'] ?? null;
        $this->container['charge_component'] = $data['charge_component'] ?? null;
        $this->container['total_amount'] = $data['total_amount'] ?? null;
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
     * Gets posted_date
     *
     * @return \DateTime|null
     */
    public function getPostedDate()
    {
        return $this->container['posted_date'];
    }

    /**
     * Sets posted_date
     *
     * @param \DateTime|null $posted_date posted_date
     *
     * @return self
     */
    public function setPostedDate($posted_date)
    {
        $this->container['posted_date'] = $posted_date;

        return $this;
    }

    /**
     * Gets coupon_id
     *
     * @return string|null
     */
    public function getCouponId()
    {
        return $this->container['coupon_id'];
    }

    /**
     * Sets coupon_id
     *
     * @param string|null $coupon_id A coupon identifier.
     *
     * @return self
     */
    public function setCouponId($coupon_id)
    {
        $this->container['coupon_id'] = $coupon_id;

        return $this;
    }

    /**
     * Gets seller_coupon_description
     *
     * @return string|null
     */
    public function getSellerCouponDescription()
    {
        return $this->container['seller_coupon_description'];
    }

    /**
     * Sets seller_coupon_description
     *
     * @param string|null $seller_coupon_description The description provided by the seller when they created the coupon.
     *
     * @return self
     */
    public function setSellerCouponDescription($seller_coupon_description)
    {
        $this->container['seller_coupon_description'] = $seller_coupon_description;

        return $this;
    }

    /**
     * Gets clip_or_redemption_count
     *
     * @return int|null
     */
    public function getClipOrRedemptionCount()
    {
        return $this->container['clip_or_redemption_count'];
    }

    /**
     * Sets clip_or_redemption_count
     *
     * @param int|null $clip_or_redemption_count The number of coupon clips or redemptions.
     *
     * @return self
     */
    public function setClipOrRedemptionCount($clip_or_redemption_count)
    {
        $this->container['clip_or_redemption_count'] = $clip_or_redemption_count;

        return $this;
    }

    /**
     * Gets payment_event_id
     *
     * @return string|null
     */
    public function getPaymentEventId()
    {
        return $this->container['payment_event_id'];
    }

    /**
     * Sets payment_event_id
     *
     * @param string|null $payment_event_id A payment event identifier.
     *
     * @return self
     */
    public function setPaymentEventId($payment_event_id)
    {
        $this->container['payment_event_id'] = $payment_event_id;

        return $this;
    }

    /**
     * Gets fee_component
     *
     * @return \Thecodebunny\SpApi\Model\Finances\FeeComponent|null
     */
    public function getFeeComponent()
    {
        return $this->container['fee_component'];
    }

    /**
     * Sets fee_component
     *
     * @param \Thecodebunny\SpApi\Model\Finances\FeeComponent|null $fee_component fee_component
     *
     * @return self
     */
    public function setFeeComponent($fee_component)
    {
        $this->container['fee_component'] = $fee_component;

        return $this;
    }

    /**
     * Gets charge_component
     *
     * @return \Thecodebunny\SpApi\Model\Finances\ChargeComponent|null
     */
    public function getChargeComponent()
    {
        return $this->container['charge_component'];
    }

    /**
     * Sets charge_component
     *
     * @param \Thecodebunny\SpApi\Model\Finances\ChargeComponent|null $charge_component charge_component
     *
     * @return self
     */
    public function setChargeComponent($charge_component)
    {
        $this->container['charge_component'] = $charge_component;

        return $this;
    }

    /**
     * Gets total_amount
     *
     * @return \Thecodebunny\SpApi\Model\Finances\Currency|null
     */
    public function getTotalAmount()
    {
        return $this->container['total_amount'];
    }

    /**
     * Sets total_amount
     *
     * @param \Thecodebunny\SpApi\Model\Finances\Currency|null $total_amount total_amount
     *
     * @return self
     */
    public function setTotalAmount($total_amount)
    {
        $this->container['total_amount'] = $total_amount;

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


