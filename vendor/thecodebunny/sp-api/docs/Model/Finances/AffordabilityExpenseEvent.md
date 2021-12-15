## AffordabilityExpenseEvent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amazon_order_id** | **string** | An Amazon-defined identifier for an order. | [optional]
**posted_date** | [**\DateTime**](\DateTime.md) |  | [optional]
**marketplace_id** | **string** | An encrypted, Amazon-defined marketplace identifier. | [optional]
**transaction_type** | **string** | Indicates the type of transaction. 

Possible values:

* Charge - For an affordability promotion expense.

* Refund - For an affordability promotion expense reversal. | [optional]
**base_expense** | [**\Thecodebunny\SpApi\Model\Finances\Currency**](Currency.md) |  | [optional]
**tax_type_cgst** | [**\Thecodebunny\SpApi\Model\Finances\Currency**](Currency.md) |  |
**tax_type_sgst** | [**\Thecodebunny\SpApi\Model\Finances\Currency**](Currency.md) |  |
**tax_type_igst** | [**\Thecodebunny\SpApi\Model\Finances\Currency**](Currency.md) |  |
**total_expense** | [**\Thecodebunny\SpApi\Model\Finances\Currency**](Currency.md) |  | [optional]

[[Finances Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
