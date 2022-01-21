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

use \TheCodeBunny\PaApi\ObjectSerializer;

/**
 * SortBy Class Doc Comment
 *
 * @category Class
 * @package  TheCodeBunny\PaApi
 * @author   Product Advertising API team
 */
class SortBy
{
    /**
     * Possible values of this enum
     */
    const AVG_CUSTOMER_REVIEWS = 'AvgCustomerReviews';
    const FEATURED = 'Featured';
    const NEWEST_ARRIVALS = 'NewestArrivals';
    const PRICEHIGH_TO_LOW = 'Price:HighToLow';
    const PRICELOW_TO_HIGH = 'Price:LowToHigh';
    const RELEVANCE = 'Relevance';
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::AVG_CUSTOMER_REVIEWS,
            self::FEATURED,
            self::NEWEST_ARRIVALS,
            self::PRICEHIGH_TO_LOW,
            self::PRICELOW_TO_HIGH,
            self::RELEVANCE,
        ];
    }
}
