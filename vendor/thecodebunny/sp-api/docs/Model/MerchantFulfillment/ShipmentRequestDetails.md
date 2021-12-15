## ShipmentRequestDetails

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amazon_order_id** | **string** | An Amazon-defined order identifier, in 3-7-7 format. |
**seller_order_id** | **string** | A seller-defined order identifier. | [optional]
**item_list** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\FBMItem[]**](FBMItem.md) | The list of items to be included in a shipment. |
**ship_from_address** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\Address**](Address.md) |  |
**package_dimensions** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\PackageDimensions**](PackageDimensions.md) |  |
**weight** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\Weight**](Weight.md) |  |
**must_arrive_by_date** | [**\DateTime**](\DateTime.md) |  | [optional]
**ship_date** | [**\DateTime**](\DateTime.md) |  | [optional]
**shipping_service_options** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\ShippingServiceOptions**](ShippingServiceOptions.md) |  |
**label_customization** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\LabelCustomization**](LabelCustomization.md) |  | [optional]

[[MerchantFulfillment Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
