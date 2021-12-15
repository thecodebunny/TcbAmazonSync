## Shipment

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**shipment_id** | **string** | An Amazon-defined shipment identifier. |
**amazon_order_id** | **string** | An Amazon-defined order identifier, in 3-7-7 format. |
**seller_order_id** | **string** | A seller-defined order identifier. | [optional]
**item_list** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\FBMItem[]**](FBMItem.md) | The list of items to be included in a shipment. |
**ship_from_address** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\Address**](Address.md) |  |
**ship_to_address** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\Address**](Address.md) |  |
**package_dimensions** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\PackageDimensions**](PackageDimensions.md) |  |
**weight** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\Weight**](Weight.md) |  |
**insurance** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\CurrencyAmount**](CurrencyAmount.md) |  |
**shipping_service** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\ShippingService**](ShippingService.md) |  |
**label** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\Label**](Label.md) |  |
**status** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\ShipmentStatus**](ShipmentStatus.md) |  |
**tracking_id** | **string** | The shipment tracking identifier provided by the carrier. | [optional]
**created_date** | [**\DateTime**](\DateTime.md) |  |
**last_updated_date** | [**\DateTime**](\DateTime.md) |  | [optional]

[[MerchantFulfillment Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
