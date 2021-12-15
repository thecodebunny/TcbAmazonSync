## InvoiceDetail

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**invoice_number** | **string** | The unique invoice number. |
**invoice_date** | [**\DateTime**](\DateTime.md) | Invoice date. |
**reference_number** | **string** | An additional unique reference number used for regulatory or other purposes. | [optional]
**remit_to_party** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\PartyIdentification**](PartyIdentification.md) |  |
**ship_from_party** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\PartyIdentification**](PartyIdentification.md) |  |
**bill_to_party** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\PartyIdentification**](PartyIdentification.md) |  | [optional]
**ship_to_country_code** | **string** | Ship-to country code. | [optional]
**payment_terms_code** | **string** | The payment terms for the invoice. | [optional]
**invoice_total** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\Money**](Money.md) |  |
**tax_totals** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\TaxDetail[]**](TaxDetail.md) | Individual tax details per line item. | [optional]
**additional_details** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\AdditionalDetails[]**](AdditionalDetails.md) | Additional details provided by the selling party, for tax related or other purposes. | [optional]
**charge_details** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\ChargeDetails[]**](ChargeDetails.md) | Total charge amount details for all line items. | [optional]
**items** | [**\Thecodebunny\SpApi\Model\VendorDirectFulfillmentPayments\InvoiceItem[]**](InvoiceItem.md) | Provides the details of the items in this invoice. |

[[VendorDirectFulfillmentPayments Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
