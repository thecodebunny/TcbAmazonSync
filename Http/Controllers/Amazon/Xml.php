<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Categories as AmzCategories;

class Xml extends Controller
{

    public function creatProductFeed($item, $sellerId)
    {
        $xml = '<?xml version="1.0" encoding="utf-8" ?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amznenvelope.xsd">
            <Header>
                <DocumentVersion>1.01</DocumentVersion>
                <MerchantIdentifier>'. $sellerId .'</MerchantIdentifier>
            </Header>
            <MessageType>Product</MessageType>
            <Message>
                <MessageID>1</MessageID>
                <OperationType>PartialUpdate</OperationType>
                <Product>
                    <SKU>' . $item->sku . '</SKU>
                    <Condition>new_new</Condition>
                    <DescriptionData>
                        <Title>' . $item->title . '</Title>
                        <Brand>' . $item->brand . '</Brand>
                        <Description>' . $item->description . '</Description>';
                        if($item->bullet_point_1) { $xml .=  '<BulletPoint>' . $item->bullet_point_1 . '</BulletPoint>';}
                        if($item->bullet_point_2) { $xml .=  '<BulletPoint>' . $item->bullet_point_2 . '</BulletPoint>';}
                        if($item->bullet_point_3) { $xml .=  '<BulletPoint>' . $item->bullet_point_3 . '</BulletPoint>';}
                        if($item->bullet_point_4) { $xml .=  '<BulletPoint>' . $item->bullet_point_4 . '</BulletPoint>';}
                        if($item->bullet_point_5) { $xml .=  '<BulletPoint>' . $item->bullet_point_5 . '</BulletPoint>';}
                        if($item->keywords) { $xml .=  '<SearchTerms>' . $item->keywords . '</SearchTerms>';}
                        if($item->weight) { $xml .=  '<ItemWeight unitOfMeasure="' . $item->weight_measure . '">' . $item->weight . '</ItemWeight>';}
                        if($item->country_of_origin) { $xml .=  '<CountryOfOrigin>' . $item->country_of_origin . '</CountryOfOrigin>';}
                        if($item->size) { $xml .=  '<SizeName>' . $item->size . '</SizeName>';}
                        if($item->length || $item->width || $item->height || $item->weight) {
                            $xml .=  '<ItemDimensions>
                                            <Dimensions>';
                                        if ($item->length) {
                                            $xml .= '<Length unitOfMeasure="' . $item->length_measure . '">' . $item->length . '</Length>';
                                        }
                                        if ($item->width) {
                                            $xml .= '<Width unitOfMeasure="' . $item->width_measure . '">' . $item->width . '</Width>';
                                        }
                                        if ($item->height) {
                                            $xml .= '<Height unitOfMeasure="' . $item->height_measure . '">' . $item->height . '</Height>';
                                        }
                                        if ($item->weight) {
                                            $xml .= '<Weight unitOfMeasure="' . $item->weight_measure . '">' . $item->weight . '</Weight>';
                                        }
                            $xml .=  '</Dimensions>
                                </ItemDimensions>';
                        }
                        $xml .= '<IsExpirationDatedProduct>false</IsExpirationDatedProduct>
                        <RecommendedBrowseNode>' . $item->category_id . '</RecommendedBrowseNode>
                    </DescriptionData>
                </Product>
            </Message>
        </AmazonEnvelope>
        ';
        return $xml;
    }

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

    public function createImagesFeed($id, $sellerId)
    {
        $item = AmzItem::where('id', $id)->first();
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
            <Header>
                <DocumentVersion>1.01</DocumentVersion>
                <MerchantIdentifier>'. $sellerId .'</MerchantIdentifier>
            </Header>
            <MessageType>ProductImage</MessageType>';
            if ($item->main_picture) { 
                $xml .= '
                <Message>
                    <MessageID>1</MessageID>
                    <OperationType>Update</OperationType>
                    <ProductImage>
                        <SKU>'. $item->sku .'</SKU>
                        <ImageType>Main</ImageType>
                        <ImageLocation>' . asset('/public/' . $item->main_picture) . '</ImageLocation>
                    </ProductImage>
                </Message>
                ';
            }
            if ($item->picture_1) {
                $xml .= '
                <Message>
                    <MessageID>2</MessageID>
                    <OperationType>Update</OperationType>
                    <ProductImage>
                        <SKU>'. $item->sku .'</SKU>
                        <ImageType>MainOfferImage</ImageType>
                        <ImageLocation>' . asset('/public/' . $item->picture_1) . '</ImageLocation>
                    </ProductImage>
                </Message>
                ';
            }
            if ($item->picture_2) { 
                $xml .= '
                <Message>
                    <MessageID>2</MessageID>
                    <OperationType>Update</OperationType>
                    <ProductImage>
                        <SKU>'. $item->sku .'</SKU>
                        <ImageType>OfferImage1</ImageType>
                        <ImageLocation>' . asset('/public/' . $item->picture_2) . '</ImageLocation>
                    </ProductImage>
                </Message>
                ';
            }
            if ($item->picture_3) { 
                $xml .= '
                <Message>
                    <MessageID>2</MessageID>
                    <OperationType>Update</OperationType>
                    <ProductImage>
                        <SKU>'. $item->sku .'</SKU>
                        <ImageType>OfferImage2</ImageType>
                        <ImageLocation>' . asset('/public/' . $item->picture_3) . '</ImageLocation>
                    </ProductImage>
                </Message>
                ';
            }
            if ($item->picture_4) {
                $xml .= '
                <Message>
                    <MessageID>2</MessageID>
                    <OperationType>Update</OperationType>
                    <ProductImage>
                        <SKU>'. $item->sku .'</SKU>
                        <ImageType>OfferImage3</ImageType>
                        <ImageLocation>' . asset('/public/' . $item->picture_4) . '</ImageLocation>
                    </ProductImage>
                </Message>
                ';
            }
            if ($item->picture_5) {
                $xml .= '
                <Message>
                    <MessageID>2</MessageID>
                    <OperationType>Update</OperationType>
                    <ProductImage>
                        <SKU>'. $item->sku .'</SKU>
                        <ImageType>OfferImage4</ImageType>
                        <ImageLocation>' . asset('/public/' . $item->picture_5) . '</ImageLocation>
                    </ProductImage>
                </Message>
                ';
            }
            if ($item->picture_6) {
                $xml .= '
                <Message>
                    <MessageID>2</MessageID>
                    <OperationType>Update</OperationType>
                    <ProductImage>
                        <SKU>'. $item->sku .'</SKU>
                        <ImageType>OfferImage5</ImageType>
                        <ImageLocation>' . asset('/public/' . $item->picture_6) . '</ImageLocation>
                    </ProductImage>
                </Message>
                '
                ;
            }
            $xml .= '</AmazonEnvelope>';

        return $xml;
    }

    public function createPricingFeed($item, $sellerId)
    {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
            <Header>
                <DocumentVersion>1.01</DocumentVersion>
                <MerchantIdentifier>'. $sellerId .'</MerchantIdentifier>
            </Header>
            <MessageType>Price</MessageType>
            <Message>
                <MessageID>1</MessageID>
                <Price>
                    <SKU>' . $item->sku . '</SKU>
                    <StandardPrice currency="' . $item->currency_code . '">' . $item->price . '</StandardPrice>';
        if($item->sale_price && $item->sale_start_date && $item->sale_end_date) {
            $xml .= '
            <Sale>
                <StartDate>' . $item->sale_start_date . '</StartDate>
                <EndDate>' . $item->sale_end_date . '</EndDate>
                <SalePrice currency="' . $item->currency_code . '">' . $item->sale_price . '</SalePrice>
            </Sale>';
        }

        $xml .= '</Price>
            </Message>
        </AmazonEnvelope>
        ';

        return $xml;
    }

}