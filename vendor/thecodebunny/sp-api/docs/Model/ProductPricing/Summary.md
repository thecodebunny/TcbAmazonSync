## Summary

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**total_offer_count** | **int** | The number of unique offers contained in NumberOfOffers. |
**number_of_offers** | [**\Thecodebunny\SpApi\Model\ProductPricing\OfferCountType[]**](OfferCountType.md) |  | [optional]
**lowest_prices** | [**\Thecodebunny\SpApi\Model\ProductPricing\LowestPriceType[]**](LowestPriceType.md) |  | [optional]
**buy_box_prices** | [**\Thecodebunny\SpApi\Model\ProductPricing\BuyBoxPriceType[]**](BuyBoxPriceType.md) |  | [optional]
**list_price** | [**\Thecodebunny\SpApi\Model\ProductPricing\MoneyType**](MoneyType.md) |  | [optional]
**competitive_price_threshold** | [**\Thecodebunny\SpApi\Model\ProductPricing\MoneyType**](MoneyType.md) |  | [optional]
**suggested_lower_price_plus_shipping** | [**\Thecodebunny\SpApi\Model\ProductPricing\MoneyType**](MoneyType.md) |  | [optional]
**sales_rankings** | [**\Thecodebunny\SpApi\Model\ProductPricing\SalesRankType[]**](SalesRankType.md) | A list of sales rank information for the item, by category. | [optional]
**buy_box_eligible_offers** | [**\Thecodebunny\SpApi\Model\ProductPricing\OfferCountType[]**](OfferCountType.md) |  | [optional]
**offers_available_time** | [**\DateTime**](\DateTime.md) | When the status is ActiveButTooSoonForProcessing, this is the time when the offers will be available for processing. | [optional]

[[ProductPricing Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
