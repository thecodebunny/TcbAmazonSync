## Container

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**container_type** | **string** | The type of physical container being used. (always &#39;PACKAGE&#39;) | [optional]
**container_reference_id** | **string** | An identifier for the container. This must be unique within all the containers in the same shipment. |
**value** | [**\Thecodebunny\SpApi\Model\Shipping\Currency**](Currency.md) |  |
**dimensions** | [**\Thecodebunny\SpApi\Model\Shipping\Dimensions**](Dimensions.md) |  |
**items** | [**\Thecodebunny\SpApi\Model\Shipping\ContainerItem[]**](ContainerItem.md) | A list of the items in the container. |
**weight** | [**\Thecodebunny\SpApi\Model\Shipping\Weight**](Weight.md) |  |

[[Shipping Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
