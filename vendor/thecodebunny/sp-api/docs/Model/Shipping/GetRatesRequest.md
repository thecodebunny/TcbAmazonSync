## GetRatesRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**ship_to** | [**\Thecodebunny\SpApi\Model\Shipping\Address**](Address.md) |  |
**ship_from** | [**\Thecodebunny\SpApi\Model\Shipping\Address**](Address.md) |  |
**service_types** | [**\Thecodebunny\SpApi\Model\Shipping\ServiceType[]**](ServiceType.md) | A list of service types that can be used to send the shipment. |
**ship_date** | [**\DateTime**](\DateTime.md) | The start date and time. This defaults to the current date and time. | [optional]
**container_specifications** | [**\Thecodebunny\SpApi\Model\Shipping\ContainerSpecification[]**](ContainerSpecification.md) | A list of container specifications. |

[[Shipping Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
