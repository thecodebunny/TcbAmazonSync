# Thecodebunny\SpApi\ShippingApi

Method | HTTP request | Description
------------- | ------------- | -------------
[**cancelShipment()**](ShippingApi.md#cancelShipment) | **POST** /shipping/v1/shipments/{shipmentId}/cancel | 
[**createShipment()**](ShippingApi.md#createShipment) | **POST** /shipping/v1/shipments | 
[**getAccount()**](ShippingApi.md#getAccount) | **GET** /shipping/v1/account | 
[**getRates()**](ShippingApi.md#getRates) | **POST** /shipping/v1/rates | 
[**getShipment()**](ShippingApi.md#getShipment) | **GET** /shipping/v1/shipments/{shipmentId} | 
[**getTrackingInformation()**](ShippingApi.md#getTrackingInformation) | **GET** /shipping/v1/tracking/{trackingId} | 
[**purchaseLabels()**](ShippingApi.md#purchaseLabels) | **POST** /shipping/v1/shipments/{shipmentId}/purchaseLabels | 
[**purchaseShipment()**](ShippingApi.md#purchaseShipment) | **POST** /shipping/v1/purchaseShipment | 
[**retrieveShippingLabel()**](ShippingApi.md#retrieveShippingLabel) | **POST** /shipping/v1/shipments/{shipmentId}/containers/{trackingId}/label | 


## `cancelShipment()`

```php
cancelShipment($shipment_id): \Thecodebunny\SpApi\Model\Shipping\CancelShipmentResponse
```



Cancel a shipment by the given shipmentId.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$shipment_id = 'shipment_id_example'; // string

try {
    $result = $apiInstance->cancelShipment($shipment_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->cancelShipment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **shipment_id** | **string**|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\CancelShipmentResponse**](../Model/Shipping/CancelShipmentResponse.md)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `createShipment()`

```php
createShipment($body): \Thecodebunny\SpApi\Model\Shipping\CreateShipmentResponse
```



Create a new shipment.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$body = new \Thecodebunny\SpApi\Model\Shipping\CreateShipmentRequest(); // \Thecodebunny\SpApi\Model\Shipping\CreateShipmentRequest

try {
    $result = $apiInstance->createShipment($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->createShipment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Thecodebunny\SpApi\Model\Shipping\CreateShipmentRequest**](../Model/Shipping/CreateShipmentRequest.md)|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\CreateShipmentResponse**](../Model/Shipping/CreateShipmentResponse.md)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `getAccount()`

```php
getAccount(): \Thecodebunny\SpApi\Model\Shipping\GetAccountResponse
```



Verify if the current account is valid.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);

try {
    $result = $apiInstance->getAccount();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->getAccount: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\GetAccountResponse**](../Model/Shipping/GetAccountResponse.md)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `getRates()`

```php
getRates($body): \Thecodebunny\SpApi\Model\Shipping\GetRatesResponse
```



Get service rates.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$body = new \Thecodebunny\SpApi\Model\Shipping\GetRatesRequest(); // \Thecodebunny\SpApi\Model\Shipping\GetRatesRequest

try {
    $result = $apiInstance->getRates($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->getRates: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Thecodebunny\SpApi\Model\Shipping\GetRatesRequest**](../Model/Shipping/GetRatesRequest.md)|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\GetRatesResponse**](../Model/Shipping/GetRatesResponse.md)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `getShipment()`

```php
getShipment($shipment_id): \Thecodebunny\SpApi\Model\Shipping\GetShipmentResponse
```



Return the entire shipment object for the shipmentId.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$shipment_id = 'shipment_id_example'; // string

try {
    $result = $apiInstance->getShipment($shipment_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->getShipment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **shipment_id** | **string**|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\GetShipmentResponse**](../Model/Shipping/GetShipmentResponse.md)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `getTrackingInformation()`

```php
getTrackingInformation($tracking_id): \Thecodebunny\SpApi\Model\Shipping\GetTrackingInformationResponse
```



Return the tracking information of a shipment.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 1 | 1 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$tracking_id = 'tracking_id_example'; // string

try {
    $result = $apiInstance->getTrackingInformation($tracking_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->getTrackingInformation: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **tracking_id** | **string**|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\GetTrackingInformationResponse**](../Model/Shipping/GetTrackingInformationResponse.md)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `purchaseLabels()`

```php
purchaseLabels($shipment_id, $body): \Thecodebunny\SpApi\Model\Shipping\PurchaseLabelsResponse
```



Purchase shipping labels based on a given rate.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$shipment_id = 'shipment_id_example'; // string
$body = new \Thecodebunny\SpApi\Model\Shipping\PurchaseLabelsRequest(); // \Thecodebunny\SpApi\Model\Shipping\PurchaseLabelsRequest

try {
    $result = $apiInstance->purchaseLabels($shipment_id, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->purchaseLabels: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **shipment_id** | **string**|  |
 **body** | [**\Thecodebunny\SpApi\Model\Shipping\PurchaseLabelsRequest**](../Model/Shipping/PurchaseLabelsRequest.md)|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\PurchaseLabelsResponse**](../Model/Shipping/PurchaseLabelsResponse.md)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `purchaseShipment()`

```php
purchaseShipment($body): \Thecodebunny\SpApi\Model\Shipping\PurchaseShipmentResponse
```



Purchase shipping labels.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$body = new \Thecodebunny\SpApi\Model\Shipping\PurchaseShipmentRequest(); // \Thecodebunny\SpApi\Model\Shipping\PurchaseShipmentRequest

try {
    $result = $apiInstance->purchaseShipment($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->purchaseShipment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Thecodebunny\SpApi\Model\Shipping\PurchaseShipmentRequest**](../Model/Shipping/PurchaseShipmentRequest.md)|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\PurchaseShipmentResponse**](../Model/Shipping/PurchaseShipmentResponse.md)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)

## `retrieveShippingLabel()`

```php
retrieveShippingLabel($shipment_id, $tracking_id, $body): \Thecodebunny\SpApi\Model\Shipping\RetrieveShippingLabelResponse
```



Retrieve shipping label based on the shipment id and tracking id.

**Usage Plan:**

| Rate (requests per second) | Burst |
| ---- | ---- |
| 5 | 15 |

For more information, see \"Usage Plans and Rate Limits\" in the Selling Partner API documentation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// See README for more information on the Configuration object's options
$config = new Thecodebunny\SpApi\Configuration([
    "lwaClientId" => "<LWA client ID>",
    "lwaClientSecret" => "<LWA client secret>",
    "lwaRefreshToken" => "<LWA refresh token>",
    "awsAccessKeyId" => "<AWS access key ID>",
    "awsSecretAccessKey" => "<AWS secret access key>",
    "endpoint" => Thecodebunny\SpApi\Endpoint::NA  // or another endpoint from lib/Endpoints.php
]);

$apiInstance = new Thecodebunny\SpApi\Api\ShippingApi($config);
$shipment_id = 'shipment_id_example'; // string
$tracking_id = 'tracking_id_example'; // string
$body = new \Thecodebunny\SpApi\Model\Shipping\RetrieveShippingLabelRequest(); // \Thecodebunny\SpApi\Model\Shipping\RetrieveShippingLabelRequest

try {
    $result = $apiInstance->retrieveShippingLabel($shipment_id, $tracking_id, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingApi->retrieveShippingLabel: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **shipment_id** | **string**|  |
 **tracking_id** | **string**|  |
 **body** | [**\Thecodebunny\SpApi\Model\Shipping\RetrieveShippingLabelRequest**](../Model/Shipping/RetrieveShippingLabelRequest.md)|  |

### Return type

[**\Thecodebunny\SpApi\Model\Shipping\RetrieveShippingLabelResponse**](../Model/Shipping/RetrieveShippingLabelResponse.md)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Top]](#) [[API list]](../)
[[Shipping Model list]](../Model/Shipping)
[[README]](../../README.md)
