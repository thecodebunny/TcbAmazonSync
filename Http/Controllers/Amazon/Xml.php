<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TcbAmazonSync\Models\Amazon\Categories as AmzCategories;

class Xml extends Controller
{

    public function creatSingleInventoryFeed($sku, $quantity, $sellerId)
    {
        return '<?xml version="1.0" encoding="utf-8" ?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amznenvelope.xsd">
            <Header>
                <DocumentVersion>1.01</DocumentVersion>
                <MerchantIdentifier>'. $sellerId .'</MerchantIdentifier>
            </Header>
            <MessageType>Inventory</MessageType>
            <Message>
                <MessageID>1</MessageID>
                <OperationType>Update</OperationType>
                <Inventory>
                    <SKU>' . $sku . '</SKU>
                    <Quantity>' . $quantity . '</Quantity>
                    <FulfillmentLatency>1</FulfillmentLatency>
                </Inventory>
            </Message>
        </AmazonEnvelope>
        ';
    }

    public function creatShippingConfirmationFeed($country, $amzOrderId, $tId, $tId2, $tId3, $tId4, $tId5, $date, $carrier, $sellerId)
    {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
            <Header>
                <DocumentVersion>1.01</DocumentVersion>
                <MerchantIdentifier>'. $sellerId .'</MerchantIdentifier>
            </Header>
            <MessageType>OrderFulfillment</MessageType>
            <Message>
                <MessageID>1</MessageID>
                <OrderFulfillment>
                    <AmazonOrderID>'. $amzOrderId .'</AmazonOrderID>
                    <FulfillmentDate>'. $date .'</FulfillmentDate>
                    <FulfillmentData>
                        <CarrierName>'. $carrier .'</CarrierName>
                        <ShipperTrackingNumber>'. $tId .'</ShipperTrackingNumber>';
                        if($tId2 && $tId2 !== 'null') {
                            $xml .= '<ShipperTrackingNumber>'. $tId2 .'</ShipperTrackingNumber>';
                        }
                        if($tId3 && $tId3 !== 'null') {
                            $xml .= '<ShipperTrackingNumber>'. $tId3 .'</ShipperTrackingNumber>';
                        }
                        if($tId4 && $tId4 !== 'null') {
                            $xml .= '<ShipperTrackingNumber>'. $tId4 .'</ShipperTrackingNumber>';
                        }
                        if($tId5 && $tId5 !== 'null') {
                            $xml .= '<ShipperTrackingNumber>'. $tId5 .'</ShipperTrackingNumber>';
                        }

                        $xml .= '</FulfillmentData>
                </OrderFulfillment>
            </Message>
        </AmazonEnvelope>
        ';

        return $xml;
    }

}