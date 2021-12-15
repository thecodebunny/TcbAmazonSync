<?php
/**
 * CurrentStatus
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  Thecodebunny\SpApi
 */

/**
 * Selling Partner APIs for Fulfillment Outbound
 *
 * The Selling Partner API for Fulfillment Outbound lets you create applications that help a seller fulfill Multi-Channel Fulfillment orders using their inventory in Amazon's fulfillment network. You can get information on both potential and existing fulfillment orders.
 *
 * The version of the OpenAPI document: 2020-07-01
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.0.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Thecodebunny\SpApi\Model\FbaOutbound;
use \Thecodebunny\SpApi\ObjectSerializer;
use \Thecodebunny\SpApi\Model\ModelInterface;

/**
 * CurrentStatus Class Doc Comment
 *
 * @category Class
 * @description The current delivery status of the package.
 * @package  Thecodebunny\SpApi
 * @group 
 */
class CurrentStatus
{
    /**
     * Possible values of this enum
     */
    const IN_TRANSIT = 'IN_TRANSIT';
    const DELIVERED = 'DELIVERED';
    const RETURNING = 'RETURNING';
    const RETURNED = 'RETURNED';
    const UNDELIVERABLE = 'UNDELIVERABLE';
    const DELAYED = 'DELAYED';
    const AVAILABLE_FOR_PICKUP = 'AVAILABLE_FOR_PICKUP';
    const CUSTOMER_ACTION = 'CUSTOMER_ACTION';
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::IN_TRANSIT,
            self::DELIVERED,
            self::RETURNING,
            self::RETURNED,
            self::UNDELIVERABLE,
            self::DELAYED,
            self::AVAILABLE_FOR_PICKUP,
            self::CUSTOMER_ACTION,
        ];
    }
}


