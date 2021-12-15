## PurchaseShipmentRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**client_reference_id** | **string** | Client reference id. |
**ship_to** | [**\Thecodebunny\SpApi\Model\Shipping\Address**](Address.md) |  |
**ship_from** | [**\Thecodebunny\SpApi\Model\Shipping\Address**](Address.md) |  |
**ship_date** | [**\DateTime**](\DateTime.md) | The start date and time. This defaults to the current date and time. | [optional]
**service_type** | [**\Thecodebunny\SpApi\Model\Shipping\ServiceType**](ServiceType.md) |  |
**containers** | [**\Thecodebunny\SpApi\Model\Shipping\Container[]**](Container.md) | A list of container. |
**label_specification** | [**\Thecodebunny\SpApi\Model\Shipping\LabelSpecification**](LabelSpecification.md) |  |

[[Shipping Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
