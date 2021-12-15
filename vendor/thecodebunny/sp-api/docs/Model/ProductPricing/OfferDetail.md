## OfferDetail

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**my_offer** | **bool** | When true, this is the seller&#39;s offer. | [optional]
**offer_type** | [**\Thecodebunny\SpApi\Model\ProductPricing\OfferCustomerType**](OfferCustomerType.md) |  | [optional]
**sub_condition** | **string** | The subcondition of the item. Subcondition values: New, Mint, Very Good, Good, Acceptable, Poor, Club, OEM, Warranty, Refurbished Warranty, Refurbished, Open Box, or Other. |
**seller_id** | **string** | The seller identifier for the offer. | [optional]
**condition_notes** | **string** | Information about the condition of the item. | [optional]
**seller_feedback_rating** | [**\Thecodebunny\SpApi\Model\ProductPricing\SellerFeedbackType**](SellerFeedbackType.md) |  | [optional]
**shipping_time** | [**\Thecodebunny\SpApi\Model\ProductPricing\DetailedShippingTimeType**](DetailedShippingTimeType.md) |  |
**listing_price** | [**\Thecodebunny\SpApi\Model\ProductPricing\MoneyType**](MoneyType.md) |  |
**quantity_discount_prices** | [**\Thecodebunny\SpApi\Model\ProductPricing\QuantityDiscountPriceType[]**](QuantityDiscountPriceType.md) |  | [optional]
**points** | [**\Thecodebunny\SpApi\Model\ProductPricing\Points**](Points.md) |  | [optional]
**shipping** | [**\Thecodebunny\SpApi\Model\ProductPricing\MoneyType**](MoneyType.md) |  |
**ships_from** | [**\Thecodebunny\SpApi\Model\ProductPricing\ShipsFromType**](ShipsFromType.md) |  | [optional]
**is_fulfilled_by_amazon** | **bool** | When true, the offer is fulfilled by Amazon. |
**prime_information** | [**\Thecodebunny\SpApi\Model\ProductPricing\PrimeInformationType**](PrimeInformationType.md) |  | [optional]
**is_buy_box_winner** | **bool** | When true, the offer is currently in the Buy Box. There can be up to two Buy Box winners at any time per ASIN, one that is eligible for Prime and one that is not eligible for Prime. | [optional]
**is_featured_merchant** | **bool** | When true, the seller of the item is eligible to win the Buy Box. | [optional]

[[ProductPricing Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
