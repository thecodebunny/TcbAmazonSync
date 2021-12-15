## SearchContentDocumentsResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**warnings** | [**\Thecodebunny\SpApi\Model\AplusContent\Error[]**](Error.md) | A set of messages to the user, such as warnings or comments. | [optional]
**next_page_token** | **string** | A page token that is returned when the results of the call exceed the page size. To get another page of results, call the operation again, passing in this value with the pageToken parameter. | [optional]
**content_metadata_records** | [**\Thecodebunny\SpApi\Model\AplusContent\ContentMetadataRecord[]**](ContentMetadataRecord.md) | A list of A+ Content metadata records. |

[[AplusContent Models]](../) [[API list]](../../Api) [[README]](../../../README.md)
