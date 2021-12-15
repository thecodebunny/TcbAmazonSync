## FBMItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**order_item_id** | **string** | An Amazon-defined identifier for an individual item in an order. |
**quantity** | **int** | The number of items. |
**item_weight** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\Weight**](Weight.md) |  | [optional]
**item_description** | **string** | The description of the item. | [optional]
**transparency_code_list** | **string[]** | A list of transparency codes. | [optional]
**item_level_seller_inputs_list** | [**\Thecodebunny\SpApi\Model\MerchantFulfillment\AdditionalSellerInputs[]**](AdditionalSellerInputs.md) | A list of additional seller input pairs required to purchase shipping. | [optional]

[[MerchantFulfillment Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
