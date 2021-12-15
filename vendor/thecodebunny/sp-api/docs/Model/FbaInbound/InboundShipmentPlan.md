## InboundShipmentPlan

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**shipment_id** | **string** | A shipment identifier originally returned by the createInboundShipmentPlan operation. |
**destination_fulfillment_center_id** | **string** | An Amazon fulfillment center identifier created by Amazon. |
**ship_to_address** | [**\Thecodebunny\SpApi\Model\FbaInbound\Address**](Address.md) |  |
**label_prep_type** | [**\Thecodebunny\SpApi\Model\FbaInbound\LabelPrepType**](LabelPrepType.md) |  |
**items** | [**\Thecodebunny\SpApi\Model\FbaInbound\InboundShipmentPlanItem[]**](InboundShipmentPlanItem.md) | A list of inbound shipment plan item information. |
**estimated_box_contents_fee** | [**\Thecodebunny\SpApi\Model\FbaInbound\BoxContentsFeeDetails**](BoxContentsFeeDetails.md) |  | [optional]

[[FbaInbound Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
