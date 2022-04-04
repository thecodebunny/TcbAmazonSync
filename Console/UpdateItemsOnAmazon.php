<?php

namespace Modules\TcbAmazonSync\Console;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

//Core NameSpaces
use App\Models\Common\Item;
use App\Models\Common\Company;
use App\Models\Common\Contact;
use App\Models\Setting\Currency;
use App\Models\Banking\Transaction;

//Module NameSpaces
use Modules\TcbAmazonSync\Models\Amazon\Issue;
use Modules\TcbAmazonSync\Models\Amazon\Setting;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Asin as AmzAsin;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Orders;

//SP API NameSpaces
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\ListingsApi;

//API NameSpaces

class UpdateItemsOnAmazon extends Command
{

    private $request;
    private $config;
    private $company_id;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:update-items {country}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Amazon Items';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $companies = Company::all();
        $country = $this->argument('country');
        foreach ($companies as $company) {
            $settings = SpApiSetting::where('company_id', $company->id)->first();
            if ($country == 'Us' || $country == 'Ca') {
                $endpoint = Endpoint::NA;
            } else {
                $endpoint = Endpoint::EU;
            }
            $config = new Configuration([
                "lwaClientId" => $settings->client_id,
                "lwaClientSecret" => $settings->client_secret,
                "lwaRefreshToken" => $settings->eu_token,
                "awsAccessKeyId" => $settings->ias_access_key,
                "awsSecretAccessKey" => $settings->ias_access_token,
                "endpoint" => $endpoint,
                "roleArn" => $settings->iam_arn
            ]);
            if ($settings && !empty($settings)) {
                if ($country == 'Uk') {
                    $mpIds = 'A1F83G8C2ARO7P';
                }
                if ($country == 'De') {
                    $mpIds = ['A1PA6795UKMFR9'];
                }
                if ($country == 'Fr') {
                    $mpIds = ['A13V1IB3VIYZZH'];
                }
                if ($country == 'It') {
                    $mpIds = ['APJ6JRA9NG5V4'];
                }
                if ($country == 'Es') {
                    $mpIds = ['A1RKKUPIHCS9HS'];
                }
                if ($country == 'Se') {
                    $mpIds = ['A2NODRKZP88ZB9'];
                }
                if ($country == 'Nl') {
                    $mpIds = ['A1805IZSGTT6HS'];
                }
                if ($country == 'Pl') {
                    $mpIds = ['A1C3SOZRARQ6R3'];
                }
                if ($country == 'Us') {
                    $mpIds = ['ATVPDKIKX0DER'];
                }
                if ($country == 'Ca') {
                    $mpIds = ['A2EUQ1WTGCTBG2'];
                }
                $items = AmzItem::where('company_id', $company->id)->where('country', $country)->get();
                $seller_id = $settings->seller_id;
                $marketplace_ids = $mpIds;
                $included_data = ['summaries','attributes','issues','offers'];
                $issue_locale = 'en_US';
                try {
                    if (count($items)) {
                        foreach ($items as $item) {
                            $apiInstance = new ListingsApi($config);
                            try {
                                $result = $apiInstance->getListingsItem($seller_id, $item->sku, $mpIds, $issue_locale, $included_data);
                                $this->updateAmazonItem($company->id, $result, $item);
                            } catch (Exception $e) {
                                echo 'Error updating item on Amazon in Country' . $country . ' For SKU ' . $item->sku . ' ERROR: ' . $e->getMessage() . '';
                                continue;
                            }
                            sleep(15);
                        }
                    }

                } catch (Exception $e) {
                    echo 'Error updating item on Amazon in Country' . $country . ' For SKU ' . $item->sku . ' ERROR: ' . $e->getMessage() . '';
                    continue;
                }
            }
        }
    }

    public function updateAmazonItem($companyId, $item, $dbItem)
    {
        $basesettings = Setting::where( 'company_id', $companyId )->first();
        $summary = $item->getSummaries();
        $fulfill = $item->getFulfillmentAvailability();
        $attributes = $item->getAttributes();
        $issues = $item->getIssues();
        $offers = $item->getOffers();
        $dbItem->product_type = $summary[0]->getProductType();
        if ($attributes && !empty($attributes)) {
            if (array_key_exists('brand', $attributes)) {
                $dbItem->brand = $attributes['brand'][0]->value;
            }
            if (array_key_exists('externally_assigned_product_identifier', $attributes)) {
                if ($attributes['externally_assigned_product_identifier'][0]->type == 'ean') {
                    $dbItem->ean = $attributes['externally_assigned_product_identifier'][0]->value;
                }
            }
            if (array_key_exists('generic_keyword', $attributes)) {
                $dbItem->keywords = $attributes['generic_keyword'][0]->value;
            }
            if ($fulfill && !empty($fulfill)) {
                $dbItem->quantity = $fulfill[0]->getQuantity();
            } else {
                if (array_key_exists('fulfillment_availability', $attributes)) {
                    if(isset($attributes['fulfillment_availability'][0]->quantity)) {
                        $dbItem->quantity = $attributes['fulfillment_availability'][0]->quantity;
                    }
                    if(array_key_exists('lead_time_to_ship_max_days', $attributes['fulfillment_availability'][0])) {
                        $dbItem->lead_time_to_ship_max_days = $attributes['fulfillment_availability'][0]->lead_time_to_ship_max_days;
                    }
                }
            }
            if (array_key_exists('recommended_browse_nodes', $attributes)) {
                $dbItem->category_id = $attributes['recommended_browse_nodes'][0]->value;
            }
            if (array_key_exists('bullet_point', $attributes)) {
                if (isset($attributes['bullet_point'][0])) {
                    $dbItem->bullet_point_1 = $attributes['bullet_point'][0]->value;
                } else {
                    $dbItem->bullet_point_1 = NULL;
                }
                if (isset($attributes['bullet_point'][1])) {
                    $dbItem->bullet_point_2 = $attributes['bullet_point'][1]->value;
                } else {
                    $dbItem->bullet_point_2 = NULL;
                }
                if (isset($attributes['bullet_point'][2])) {
                    $dbItem->bullet_point_3 = $attributes['bullet_point'][2]->value;
                } else {
                    $dbItem->bullet_point_3 = NULL;
                }
                if (isset($attributes['bullet_point'][3])) {
                    $dbItem->bullet_point_4 = $attributes['bullet_point'][3]->value;
                } else {
                    $dbItem->bullet_point_4 = NULL;
                }
                if (isset($attributes['bullet_point'][4])) {
                    $dbItem->bullet_point_5 = $attributes['bullet_point'][4]->value;
                } else {
                    $dbItem->bullet_point_5 = NULL;
                }
                if (isset($attributes['bullet_point'][5])) {
                    $dbItem->bullet_point_6 = $attributes['bullet_point'][5]->value;
                } else {
                    $dbItem->bullet_point_6 = NULL;
                }
            }
            if (array_key_exists('item_name', $attributes)) {
                $dbItem->title = $attributes['item_name'][0]->value;
            }
            if (array_key_exists('color', $attributes)) {
                $dbItem->color = $attributes['color'][0]->value;
            }
            if (array_key_exists('product_description', $attributes)) {
                $dbItem->description = $attributes['product_description'][0]->value;
            }
            if (array_key_exists('country_of_origin', $attributes)) {
                $dbItem->country_of_origin = $attributes['country_of_origin'][0]->value;
            }
            if (array_key_exists('main_product_image_locator', $attributes)) {
                $mainPic = file_get_contents($attributes['main_product_image_locator'][0]->media_location);
                $mainName = 'main-' . basename($attributes['main_product_image_locator'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->main_picture));
                Storage::disk('do')->put($picFolder . '/' . $mainName, $mainPic);
                $dbItem->main_picture = $basesettings->url . '/'. $picFolder .'/'. $mainName;
            }
            if (array_key_exists('other_product_image_locator_1', $attributes)) {
                $fileContent = file_get_contents($attributes['other_product_image_locator_1'][0]->media_location);
                $fileName = '1-' . basename($attributes['other_product_image_locator_1'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->picture_1));
                Storage::disk('do')->put($picFolder . '/' . $fileName, $fileContent);
                $dbItem->picture_1 = $basesettings->url . '/'. $picFolder .'/'. $fileName;
            }
            if (array_key_exists('other_product_image_locator_2', $attributes)) {
                $fileContent = file_get_contents($attributes['other_product_image_locator_2'][0]->media_location);
                $fileName = '2-' . basename($attributes['other_product_image_locator_2'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->picture_2));
                Storage::disk('do')->put($picFolder . '/' . $fileName, $fileContent);
                $dbItem->picture_2 = $basesettings->url . '/'. $picFolder .'/'. $fileName;
            }
            if (array_key_exists('other_product_image_locator_3', $attributes)) {
                $fileContent = file_get_contents($attributes['other_product_image_locator_3'][0]->media_location);
                $fileName = '3-' . basename($attributes['other_product_image_locator_3'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->picture_3));
                Storage::disk('do')->put($picFolder . '/' . $fileName, $fileContent);
                $dbItem->picture_3 = $basesettings->url . '/'. $picFolder .'/'. $fileName;
            }
            if (array_key_exists('other_product_image_locator_4', $attributes)) {
                $fileContent = file_get_contents($attributes['other_product_image_locator_4'][0]->media_location);
                $fileName = '4-' . basename($attributes['other_product_image_locator_4'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->picture_4));
                Storage::disk('do')->put($picFolder . '/' . $fileName, $fileContent);
                $dbItem->picture_4 = $basesettings->url . '/'. $picFolder .'/'. $fileName;
            }
            if (array_key_exists('other_product_image_locator_5', $attributes)) {
                $fileContent = file_get_contents($attributes['other_product_image_locator_5'][0]->media_location);
                $fileName = '5-' . basename($attributes['other_product_image_locator_5'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->picture_5));
                Storage::disk('do')->put($picFolder . '/' . $fileName, $fileContent);
                $dbItem->picture_5 = $basesettings->url . '/'. $picFolder .'/'. $fileName;
            }
            if (array_key_exists('other_product_image_locator_6', $attributes)) {
                $fileContent = file_get_contents($attributes['other_product_image_locator_6'][0]->media_location);
                $fileName = '6-' . basename($attributes['other_product_image_locator_6'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->picture_6));
                Storage::disk('do')->put($picFolder . '/' . $fileName, $fileContent);
                $dbItem->picture_6 = $basesettings->url . '/'. $picFolder .'/'. $fileName;
            }
            if (array_key_exists('other_product_image_locator_7', $attributes)) {
                $fileContent = file_get_contents($attributes['other_product_image_locator_7'][0]->media_location);
                $fileName = basename($attributes['other_product_image_locator_7'][0]->media_location);
                $picFolder = $basesettings->folder . '/' . $dbItem->asin . '/' . $dbItem->country;
                Storage::disk('do')->delete(str_replace($basesettings->url,'',$dbItem->picture_7));
                Storage::disk('do')->put($picFolder . '/' . $fileName, $fileContent);
                $dbItem->picture_7 = $basesettings->url . '/'. $picFolder .'/'. $fileName;
            }
            if (array_key_exists('purchasable_offer', $attributes)) {
                if (isset($attributes['purchasable_offer'][0]->our_price)) {
                    $dbItem->currency_code = $attributes['purchasable_offer'][0]->currency;
                }
                if (isset($attributes['purchasable_offer'][0]->our_price)) {
                    $dbItem->price = $attributes['purchasable_offer'][0]->our_price[0]->schedule[0]->value_with_tax;
                    if (isset($attributes['purchasable_offer'][0]->discounted_price)) {
                        if ($attributes['purchasable_offer'][0]->discounted_price && $attributes['purchasable_offer'][0]->discounted_price[0]->schedule[0]->value_with_tax < $attributes['purchasable_offer'][0]->our_price[0]->schedule[0]->value_with_tax) {
                            $dbItem->price = $attributes['purchasable_offer'][0]->discounted_price[0]->schedule[0]->value_with_tax;
                        }
                    }
                }
            }
        }

        $dbItem->save();
        Issue::where('amz_item_id', $dbItem->id)->delete();
        if( $issues && !empty($issues) ) {
            foreach ($issues as $issue) {
                $dbIssue = new Issue;
                $dbIssue->item_id = $dbItem->item_id;
                $dbIssue->amz_item_id = $dbItem->id;
                $dbIssue->code = $issue->getCode();
                $dbIssue->message = $issue->getMessage();
                $dbIssue->severity = $issue->getSeverity();
                if($issue->getAttributeNames() > 1) {
                    $dbIssue->attribute_names = implode(',', $issue->getAttributeNames());
                } else {
                    $dbIssue->attribute_names = $issue->getAttributeNames();
                }
                $dbIssue->save();
            }
        }
        if($summary) {
            $offerResponse['statusmessage'] = 'SUCCESS';
            $offerResponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
            $offerResponse['message'] = 'Sale Price Successfully Updated.';
        } else {
            $offerResponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
            $offerResponse['message'] = 'There has been an error while updating sale price.<br>';
            if($item['issues']) {
                foreach($item['issues'] as $issue) {
                    $offerResponse['message'] .= $issue->message. '<br>';
                    $offerResponse['message'] .= $issue->attribute_names[0] . '<br>';
                }
            }
        }
        //dump($item);
        return $offerResponse;
    }
}
