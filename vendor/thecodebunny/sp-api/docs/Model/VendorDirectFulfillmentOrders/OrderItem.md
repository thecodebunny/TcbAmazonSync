## OrderItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**item_sequence_number** | **string** | Numbering of the item on the purchase order. The first item will be 1, the second 2, and so on. |
**buyer_product_identifier** | **string** | Buyer&#39;s standard identification number (ASIN) of an item. | [optional]
**vendor_product_identifier** | **string** | The vendor selected product identification of the item. | [optional]
**title** | **string** | Title for the item. | [optional]
**ordered_quantity** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentOrders\ItemQuantity**](ItemQuantity.md) |  |
**scheduled_delivery_shipment** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentOrders\ScheduledDeliveryShipment**](ScheduledDeliveryShipment.md) |  | [optional]
**gift_details** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentOrders\GiftDetails**](GiftDetails.md) |  | [optional]
**net_price** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentOrders\Money**](Money.md) |  |
**tax_details** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentOrders\OrderItemTaxDetails**](OrderItemTaxDetails.md) |  | [optional]
**total_price** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentOrders\Money**](Money.md) |  | [optional]

[[VendorDirectFulfillmentOrders Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
