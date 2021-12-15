## Shipment

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**shipment_id** | **string** | The unique shipment identifier. |
**client_reference_id** | **string** | Client reference id. |
**ship_from** | [**\Thecodebunny\SpApi\Model\Shipping\Address**](Address.md) |  |
**ship_to** | [**\Thecodebunny\SpApi\Model\Shipping\Address**](Address.md) |  |
**accepted_rate** | [**\Thecodebunny\SpApi\Model\Shipping\AcceptedRate**](AcceptedRate.md) |  | [optional]
**shipper** | [**\Thecodebunny\SpApi\Model\Shipping\Party**](Party.md) |  | [optional]
**containers** | [**\Thecodebunny\SpApi\Model\Shipping\Container[]**](Container.md) | A list of container. |

[[Shipping Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
