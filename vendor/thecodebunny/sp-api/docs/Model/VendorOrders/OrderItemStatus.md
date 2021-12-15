## OrderItemStatus

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**item_sequence_number** | **string** | Numbering of the item on the purchase order. The first item will be 1, the second 2, and so on. |
**buyer_product_identifier** | **string** | Buyer&#39;s Standard Identification Number (ASIN) of an item. | [optional]
**vendor_product_identifier** | **string** | The vendor selected product identification of the item. | [optional]
**net_cost** | [**\Thecodebunny\SpApi\Model\VendorOrders\Money**](Money.md) |  | [optional]
**list_price** | [**\Thecodebunny\SpApi\Model\VendorOrders\Money**](Money.md) |  | [optional]
**ordered_quantity** | [**\Thecodebunny\SpApi\Model\VendorOrders\OrderItemStatusOrderedQuantity**](OrderItemStatusOrderedQuantity.md) |  | [optional]
**acknowledgement_status** | [**\Thecodebunny\SpApi\Model\VendorOrders\OrderItemStatusAcknowledgementStatus**](OrderItemStatusAcknowledgementStatus.md) |  | [optional]

[[VendorOrders Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
