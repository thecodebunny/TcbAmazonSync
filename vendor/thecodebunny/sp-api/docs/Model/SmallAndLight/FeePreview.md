## FeePreview

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**asin** | **string** | The Amazon Standard Identification Number (ASIN) value used to identify the item. | [optional]
**price** | [**\Thecodebunny\SpApi\Model\SmallAndLight\MoneyType**](MoneyType.md) |  | [optional]
**fee_breakdown** | [**\Thecodebunny\SpApi\Model\SmallAndLight\FeeLineItem[]**](FeeLineItem.md) | A list of the Small and Light fees for the item. | [optional]
**total_fees** | [**\Thecodebunny\SpApi\Model\SmallAndLight\MoneyType**](MoneyType.md) |  | [optional]
**errors** | [**\Thecodebunny\SpApi\Model\SmallAndLight\Error[]**](Error.md) | One or more unexpected errors occurred during the getSmallAndLightFeePreview operation. | [optional]

[[SmallAndLight Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
