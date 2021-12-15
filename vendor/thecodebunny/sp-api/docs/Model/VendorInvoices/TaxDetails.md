## TaxDetails

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**tax_type** | **string** | Type of the tax applied. |
**tax_rate** | **string** | A decimal number with no loss of precision. Useful when precision loss is unacceptable, as with currencies. Follows RFC7159 for number representation. &lt;br&gt;**Pattern** : &#x60;^-?(0|([1-9]\\d*))(\\.\\d+)?([eE][+-]?\\d+)?$&#x60;. | [optional]
**tax_amount** | [**\Thecodebunny\SpApi\Model\VendorInvoices\Money**](Money.md) |  |
**taxable_amount** | [**\Thecodebunny\SpApi\Model\VendorInvoices\Money**](Money.md) |  | [optional]

[[VendorInvoices Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
