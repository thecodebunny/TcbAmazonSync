<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TcbAmazonSync\Models\Amazon\Categories as AmzCategories;

class Xml extends Controller
{

    public function creatSingleInventoryFeed($sku, $quantity)
    {
        return '<?xml version="1.0" encoding="utf-8" ?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amznenvelope.xsd">
            <Header>
                <DocumentVersion>1.01</DocumentVersion>
                <MerchantIdentifier>M_SELLER_354577</MerchantIdentifier>
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

}