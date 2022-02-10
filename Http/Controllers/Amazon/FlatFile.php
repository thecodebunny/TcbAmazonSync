<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Categories as AmzCategories;

class FlatFile extends Controller
{
    public function creatProductFeed($item, $sellerId)
    {

        //Start of Headers
        $content = 'sku\t';
        $content .= 'quantity\t';
        $content .= 'prdocutid\t';
        $content .= 'product-it-type\t';
        $content .= 'condition-type\t';
        $content .= 'brand\t';
        $content .= 'product-description\t';
        if($item->asin) {
            $content .= 'ASIN-hint\t';
        }
        $content .= 'price\t';
        if($item->sale_price) {
            $content .= 'sale-price\t';
            if($item->sale_start_date) {
                $content .= 'sale-start-date\t';
            }
            if($item->sale_end_date) {
                $content .= 'sale-enddate\t';
            }
        }

        //End of Headers
        $content .= '\n';

        //Start of Product Data
        $content .= $item->sku;
        $content .= $item->quantity;
        $content .= $item->ean;
        $content .= 'ean';
        $content .= 'new_new';
        $content .= $item->brand;
        $content .= $item->description;
        if($item->asin) {
            $content .= $item->asin;
        }
        $content .= $item->price;
        if($item->sale_price) {
            if($item->sale_start_date) {
                $content .= $item->sale_start_date;
            }
            if($item->sale_end_date) {
                $content .= $item->sale_end_date;
            }
        }

        //End of Product Data
        $content .= '\n';

        return $content;
    }
}