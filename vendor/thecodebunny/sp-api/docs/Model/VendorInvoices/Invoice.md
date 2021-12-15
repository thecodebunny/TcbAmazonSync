## Invoice

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**invoice_type** | **string** | Identifies the type of invoice. |
**id** | **string** | Unique number relating to the charges defined in this document. This will be invoice number if the document type is Invoice or CreditNote number if the document type is Credit Note. Failure to provide this reference will result in a rejection. |
**reference_number** | **string** | An additional unique reference number used for regulatory or other purposes. | [optional]
**date** | [**\DateTime**](\DateTime.md) | Defines a date and time according to ISO8601. |
**remit_to_party** | [**\Thecodebunny\SpApi\Model\VendorInvoices\PartyIdentification**](PartyIdentification.md) |  |
**ship_to_party** | [**\Thecodebunny\SpApi\Model\VendorInvoices\PartyIdentification**](PartyIdentification.md) |  | [optional]
**ship_from_party** | [**\Thecodebunny\SpApi\Model\VendorInvoices\PartyIdentification**](PartyIdentification.md) |  | [optional]
**bill_to_party** | [**\Thecodebunny\SpApi\Model\VendorInvoices\PartyIdentification**](PartyIdentification.md) |  | [optional]
**payment_terms** | [**\Thecodebunny\SpApi\Model\VendorInvoices\PaymentTerms**](PaymentTerms.md) |  | [optional]
**invoice_total** | [**\Thecodebunny\SpApi\Model\VendorInvoices\Money**](Money.md) |  |
**tax_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\TaxDetails[]**](TaxDetails.md) | Total tax amount details for all line items. | [optional]
**additional_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\AdditionalDetails[]**](AdditionalDetails.md) | Additional details provided by the selling party, for tax related or other purposes. | [optional]
**charge_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\ChargeDetails[]**](ChargeDetails.md) | Total charge amount details for all line items. | [optional]
**allowance_details** | [**\Thecodebunny\SpApi\Model\VendorInvoices\AllowanceDetails[]**](AllowanceDetails.md) | Total allowance amount details for all line items. | [optional]
**items** | [**\Thecodebunny\SpApi\Model\VendorInvoices\InvoiceItem[]**](InvoiceItem.md) | The list of invoice items. | [optional]

[[VendorInvoices Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
