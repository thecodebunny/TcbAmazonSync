## InvoiceItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**item_sequence_number** | **int** | Unique number related to this line item. |
**amazon_product_identifier** | **string** | Amazon Standard Identification Number (ASIN) of an item. | [optional]
**vendor_product_identifier** | **string** | The vendor selected product identifier of the item. Should be the same as was provided in the purchase order. | [optional]
**invoiced_quantity** | [**\Thecodebunny\SpApi\Model\VendorInvoices\ItemQuantity**](ItemQuantity.md) |  |
**net_cost** | [**\Thecodebunny\SpApi\Model\VendorInvoices\Money**](Money.md) |  |
**purchase_order_number** | **string** | The Amazon purchase order number for this invoiced line item. Formatting Notes: 8-character alpha-numeric code. This value is mandatory only when invoiceType is Invoice, and is not required when invoiceType is CreditNote. | [optional]
**hsn_code** | **string** | HSN Tax code. The HSN number cannot contain alphabets. | [optional]
**credit_note_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\CreditNoteDetails**](CreditNoteDetails.md) |  | [optional]
**tax_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\TaxDetails[]**](TaxDetails.md) | Individual tax details per line item. | [optional]
**charge_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\ChargeDetails[]**](ChargeDetails.md) | Individual charge details per line item. | [optional]
**allowance_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\AllowanceDetails[]**](AllowanceDetails.md) | Individual allowance details per line item. | [optional]

[[VendorInvoices Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
