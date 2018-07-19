<?php

namespace ElasticExportIdealoDEmmv2\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExport\Helper\ElasticExportPriceHelper;
use ElasticExport\Helper\ElasticExportShippingHelper;
use ElasticExport\Helper\ElasticExportStockHelper;
use ElasticExport\Services\FiltrationService;
use ElasticExportIdealoDEmmv2\Helper\PropertyHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;

use Plenty\Plugin\Log\Loggable;

// *********************************** START AL 02.05.2018
use Plenty\Modules\Order\Currency\Contracts\CurrencyRepositoryContract;
use Plenty\Modules\Item\VariationSalesPrice\Contracts\VariationSalesPriceRepositoryContract;
// TAG 03.05.2018
use Plenty\Modules\Tag\Repositories\TagRelationshipRepository;
use Plenty\Modules\Tag\Contracts\TagRepositoryContract;

//use Plenty\Modules\Tag\Contracts;
//use Plenty\Modules\Tag\Repositories\TagRepositoryContract;
//use Plenty\Modules\Tag\Models;
// *********************************** ENDE AL 02.05.2018


/**
 * Class IdealoDE
 * @package ElasticExportIdealoDE\Generator
 */
class IdealoDE extends CSVPluginGenerator
{
	use Loggable;

	const IDEALO_DE = 121.00;
	const IDEALO_CHECKOUT = 121.02;

	const DELIMITER = "\t"; // tab

	const DEFAULT_PAYMENT_METHOD = 'vorkasse';

	const SHIPPING_COST_TYPE_FLAT = 'flat';
	const SHIPPING_COST_TYPE_CONFIGURATION = 'configuration';

	const PROPERTY_IDEALO_DIREKTKAUF = 'CheckoutApproved';
	const PROPERTY_IDEALO_SPEDITION = 'FulfillmentType:Spedition';
	const PROPERTY_IDEALO_PAKETDIENST = 'FulfillmentType:Paketdienst';

// *********************************** START AL 02.05.2018
	private $CurrencyRepositoryContract;
	private $VariationSalesPriceRepositoryContract;
	// TAG 03.05.2018
	//private $Contracts;
	private $TagRelationshipRepository;

	private $TagRepositoryContract;
	//private $TagRepositoryContract;
	//private $Models;

// *********************************** ENDE AL 02.05.2018

	/**
	 * @var ElasticExportCoreHelper $elasticExportCoreHelper
	 */
	private $elasticExportCoreHelper;

	/**
	 * @var ArrayHelper $arrayHelper
	 */
	private $arrayHelper;

	/**
	 * @var PropertyHelper
	 */
	private $propertyHelper;

	/**
	 * @var ElasticExportStockHelper $elasticExportStockHelper
	 */
	private $elasticExportStockHelper;

	/**
	 * @var ElasticExportPriceHelper $elasticExportPriceHelper
	 */
	private $elasticExportPriceHelper;

	/**
	 * @var FiltrationService
	 */
	private $filtrationService;

	/**
	 * @var ElasticExportShippingHelper
	 */
	private $elasticExportShippingHelper;

	/**
	 * IdealoDE constructor.
	 *
	 * @param ArrayHelper $arrayHelper
	 * @param PropertyHelper $propertyHelper
	 */

	// *********************************** START AL 02.05.2018
	// , CurrencyRepositoryContract $CurrencyRepositoryContract (hinzugefügt)
	// , VariationSalesPriceRepositoryContract $VariationSalesPriceRepositoryContract (hinzugefügt)
	// UND
	// $this->CurrencyRepositoryContract = $CurrencyRepositoryContract;
	// $this->VariationSalesPriceRepositoryContract = $VariationSalesPriceRepositoryContract;
	// *********************************** ENDE AL 02.05.2018
	public function __construct(
		ArrayHelper $arrayHelper
		, PropertyHelper $propertyHelper
		, CurrencyRepositoryContract $CurrencyRepositoryContract
		, VariationSalesPriceRepositoryContract $VariationSalesPriceRepositoryContract
		, TagRelationshipRepository $TagRelationshipRepository
		, TagRepositoryContract $TagRepositoryContract
	)
	{
		$this->arrayHelper = $arrayHelper;
		$this->propertyHelper = $propertyHelper;
		$this->CurrencyRepositoryContract = $CurrencyRepositoryContract;
		$this->VariationSalesPriceRepositoryContract = $VariationSalesPriceRepositoryContract;
		$this->TagRelationshipRepository = $TagRelationshipRepository;
		$this->TagRepositoryContract = $TagRepositoryContract;
	}

	/**
	 * Generates and populates the data into the CSV file.
	 *
	 * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
	 * @param array $formatSettings
	 * @param array $filter
	 */
	protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
	{


		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

		$this->filtrationService = pluginApp(FiltrationService::class, [$settings, $filter]);
		$this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);
		$this->elasticExportCoreHelper = pluginApp(ElasticExportCoreHelper::class);
		$this->elasticExportPriceHelper = pluginApp(ElasticExportPriceHelper::class);
		$this->elasticExportShippingHelper = pluginApp(ElasticExportShippingHelper::class);

		$this->elasticExportStockHelper->setAdditionalStockInformation($settings);

		$this->setDelimiter(self::DELIMITER);

		$this->addCSVContent($this->head($settings));

		// Initiate the variables needed for grouping variations
		$currentItemId = null;
		$previousItemId = null;
		$variations = array();

		if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
		{
			// Set the documents per shard for a faster processing
			$elasticSearch->setNumberOfDocumentsPerShard(250);

			// Initiate the counter for the variations limit
			$limit = 0;
			$limitReached = false;
			$shardIterator = 0;

			do
			{
				if($limitReached === true)
				{
					break;
				}

				// Get the data from Elastic Search
				$resultList = $elasticSearch->execute();

				$shardIterator++;

				// Log the amount of the elasticsearch result once
				if($shardIterator == 1)
				{
					$this->getLogger(__METHOD__)->addReference('total', (int)$resultList['total'])->info('ElasticExportIdealoDEmmv2::item.esResultAmount');
				}

				if(count($resultList['error']) > 0)
				{
					$this->getLogger(__METHOD__)->addReference('failedShard', $shardIterator)->error('ElasticExportIdealoDEmmv2::item.occurredElasticSearchErrors', [
						'error message' => $resultList['error'],
					]);
				}

				if(is_array($resultList['documents']) && count($resultList['documents']) > 0)
				{
					// Filter and create the grouped variations array
					foreach($resultList['documents'] as $variation)
					{
						// Stop and set the flag if limit is reached
						if($limit == $filter['limit'])
						{
							$limitReached = true;
							break;
						}

						$attributes = $this->elasticExportCoreHelper->getAttributeValueSetShortFrontendName($variation, $settings, '|');

						// Skip main variations without attributes
						if(strlen($attributes) <= 0 && $variation['variation']['isMain'] === false)
						{
							continue;
						}

						// If filtered by stock is set and stock is negative, then skip the variation
						if ($this->filtrationService->filter($variation))
						{
							continue;
						}

						// Check if it's the first item from the resultList
						if ($currentItemId === null)
						{
							$previousItemId = $variation['data']['item']['id'];
						}

						$currentItemId = $variation['data']['item']['id'];

						// Check if it's the same item and add it to the grouper
						if ($currentItemId == $previousItemId)
						{
							// Add the new variation to the grouper
							$variations[] = $variation;
						}
						else
						{
							$this->constructData($settings, $variations);

							// Pass the items to the CSV printer
							$variations = array();
							$variations[] = $variation;
							$previousItemId = $variation['data']['item']['id'];
						}

						// New line was added
						$limit += 1;
					}
				}

			} while ($elasticSearch->hasNext());

			// Write the last batch of variations
			if (is_array($variations) && count($variations) > 0)
			{
				$this->constructData($settings, $variations);
			}
		}
	}

	/**
	 * Creates the Header of the CSV file.
	 *
	 * @param KeyValue $settings
	 * @return array
	 */
	private function head(KeyValue $settings):array
	{
		$data = [
			'article_id',
			'deeplink',
			'name',
			'short_description',
			'description',
			'article_no',
			'producer',
			'model',
			'availability',
			'ean',
			'isbn',
			'fedas',
			'warranty',
			'price',
			'price_old',
			'repricer_min',
            'gutschein_text',
            'gutschein_datum',
            'gutschein_rabatt',
			'weight',
			'category1',
			'category2',
			'category3',
			'category4',
			'category5',
			'category6',
			'category_concat',
			'image_url_preview',
			'image_url',
			'base_price',
			'v_vorkasse',
			'v_paypal',
			'v_kreditkarte',
			'v_amazonpay',
			'v_rechnung',
			'v_lastschrift',
			'v_nachnahme',
			'free_text_field',
			'checkoutApproved',
			'itemsInStock',
			'fulfillmentType',
			'twoManHandlingPrice',
			'disposalPrice'
		];

		$shippingHeaderList = $this->elasticExportShippingHelper->shippingHeader($settings, $this->elasticExportCoreHelper);

		foreach($shippingHeaderList as $shippingHeader)
		{
			$data[] = $shippingHeader;
		}

		return array_unique($data);
	}

	/**
	 * Creates the variation rows and prints them into the CSV file.
	 *
	 * @param KeyValue $settings
	 * @param array $variationGroup
	 */
	private function constructData(KeyValue $settings, $variationGroup)
	{
		// Printing the group of variations rows
		foreach($variationGroup as $variation)
		{
			try
			{
				$this->buildRow($settings, $variation);
			}
			catch (\Throwable $throwable)
			{
				$this->getLogger(__METHOD__)->error('ElasticExportIdealoDEmmv2::item.fillRowError', [
					'error message' => $throwable->getMessage(),
					'error line'    => $throwable->getLine(),
					'VariationId'   => (string)$variation['id']
				]);
			}
		}
	}

	/**
	 * Creates the item row and prints it into the CSV file.
	 *
	 * @param KeyValue $settings
	 * @param array $variation
	 */
	private function buildRow(KeyValue $settings, $variation)
	{
		// get the price list
		$priceList = $this->getPriceList($variation, $settings);

		// only variations with the Retail Price greater than zero will be handled
		if(!is_null($priceList['price']) && (float)$priceList['price'] > 0)
		{
			// get variation name
			$variationName = $this->elasticExportCoreHelper->getAttributeValueSetShortFrontendName($variation, $settings);

			// calculate stock
			$stock = $this->elasticExportStockHelper->getStock($variation);

			//getImages
			$imageDataList = $this->elasticExportCoreHelper->getImageListInOrder($variation, $settings, 1, ElasticExportCoreHelper::VARIATION_IMAGES, 'normal', true);

			// get the checkout approved property
			$checkoutApproved = $this->propertyHelper->getCheckoutApproved($variation);

			// TAG 03.05.2018
			// $variation_sales_price = $this->VariationSalesPriceRepositoryContract->show($p_ID,$variationId);	// geht

			$TAGID = 29;
			$TAGID_arr[] = 29;
			$tagtyp = 'item';
			$TAG_NAME = 'GI';
			$TAG_LANG = 'DE';
			$NR = 3;
			$tag_erg['name'] = 'test_603_';
			$itemID = $variation['data']['item']['id'];

			//$tag = $this->TagRelationshipRepository->findByValueId($itemID); // liefert -> [{"tagId":"29","tagType":"item","relationshipValue":"5980"}]
			//$tag = $this->TagRelationshipRepository->findByTagId($TAGID);

			// OK
			//$tag = $this->TagRelationshipRepository->findRelationship($TAGID,$itemID,$tagtyp); // liefert {"tagId":"29","tagType":"item","relationshipValue":"5980"}
			//$tag = $this->TagRelationshipRepository->findByName($TAG_NAME, $TAG_LANG);

			// Stefen 406 410
			//$getById = $contract->getTagById($TAGID);
			// 416
			//$getById = $this->TagRepositoryContract->getTagById($TAGID); // geht!!!! aber nur der Name wird geliefert!!!
			// 417
			//$getById = $this->TagRepositoryContract->getTagByName($TAG_NAME); // geht aber {"id":29,"tagName":"GI"}

			//$getById = $this->TagRepositoryContract->listTags(); // liefert nur DE name und id aller TAGs
			//$getById = $this->contract->getTagById($TAGID);
			//$getById = $this->TagRepositoryContract->getTagById($TAGID);
			//$this->getLogger('Stefan')->alert(json_encode($getById));
			//$tag = $this->TagRepositoryContract->getTagById($TAGID);// geht nicht
			//$tag = $this->TagRepositoryContract->getTagsByIds($TAGID_arr); // geht nicht

			// 419 geht nicht
			//$getById = $this->TagRepositoryContract->findByName($TAG_NAME,$TAG_LANG);
			// 420 geht nicht
			//$getById = $this->TagRepositoryContract->findByValueId($itemID);
			// 422 OK
			//$getById = $this->TagRelationshipRepository->findByValueId($itemID);
			//423 OK
			//$getById = $this->TagRelationshipRepository->findByValueId($itemID);

			// ********************************
			// OK WICHTIG !!!
			$tag = $this->TagRelationshipRepository->findRelationship($TAGID,$itemID,$tagtyp);

			if($tag != '')
			{
				// GUTSCHEIN IST DA!

				$getById = $this->TagRepositoryContract->getTagById($TAGID,['names']);

				$rohdaten = $getById; // ein string in json-format
				$rohdaten = str_replace('"', '', $rohdaten);
				$start = '[';
				$ende = ']';

				//$getById_test = json_decode($getById); // kake

				$rohdaten1 = substr($rohdaten, strpos($rohdaten,$start)+strlen($start));
				//$rohdaten2 = substr($rohdaten1, strrevpos($rohdaten1,$ende)+strlen($ende));

				$roh_arr1 = explode('},{',$rohdaten1);

				$j = 0;
				foreach($roh_arr1 AS $k1 => $w1)
				{
					$roh_arr2 = explode(',',$w1);

					$i = 0;
					foreach($roh_arr2 AS $k2 => $w2)
					{
						if($i == $NR)
						{
							$i = 0;
							$roh_arr3 = explode(':',$w2);

							foreach($roh_arr3 AS $k3 => $w3)
							{

								if($k3 == 1)
								{
									$w3 = str_replace('"','',$w3);
									$w3 = str_replace('}]}','',$w3);
									$test_de .= ' ' . $w3;
									//$gutschein[] = str_replace('"','',$w3);
									$gutschein[] = $w3;
								}

							}
						}
						$i++;
					}
					$j++;
				}



				// *******************************
				/*
				if($getById != '')
				{
					$test_de = '';
					//foreach($getById[29]['GI'] AS $key => $wert_arr)
					// 507
					foreach($getById_test AS $key => $wert_arr)
					{
						//$test_de .= $wert_arr['tagName'];
						//510
						// 514
						if($key == 'names')
						{
							foreach($wert_arr AS $key1 => $wert_arr2)
							{
								$test_de .= '[' . $key1 . ']' . '[' . $wert_arr2 . ']';
							}
						}
					}
				}
				else
				{
					$test_de .= " mist";
				}
				*/


					// WENN 2 TAGS -> test_423_[{"tagId":"29","tagType":"item","relationshipValue":"5980"},{"tagId":"38","tagType":"item","relationshipValue":"5980"}]
					//$gutschein_text = implode('_',$gutschein); // zum testen was so drin ist

				$gutschein_text = $gutschein[2];

				$utf8_ansi2 = array(
    			"\u00c0" =>"À",
    			"\u00c1" =>"Á",
    			"\u00c2" =>"Â",
    			"\u00c3" =>"Ã",
    			"\u00c4" =>"Ä",
    			"\u00c5" =>"Å",
    			"\u00c6" =>"Æ",
    			"\u00c7" =>"Ç",
    			"\u00c8" =>"È",
    			"\u00c9" =>"É",
    			"\u00ca" =>"Ê",
    			"\u00cb" =>"Ë",
    			"\u00cc" =>"Ì",
    			"\u00cd" =>"Í",
    			"\u00ce" =>"Î",
    			"\u00cf" =>"Ï",
    			"\u00d1" =>"Ñ",
    			"\u00d2" =>"Ò",
    			"\u00d3" =>"Ó",
    			"\u00d4" =>"Ô",
    			"\u00d5" =>"Õ",
    			"\u00d6" =>"Ö",
	 			"\u00d8" =>"Ø",
	    		"\u00d9" =>"Ù",
    			"\u00da" =>"Ú",
    			"\u00db" =>"Û",
    			"\u00dc" =>"Ü",
    			"\u00dd" =>"Ý",
    			"\u00df" =>"ß",
    			"\u00e0" =>"à",
    			"\u00e1" =>"á",
    			"\u00e2" =>"â",
    			"\u00e3" =>"ã",
    			"\u00e4" =>"ä",
    			"\u00e5" =>"å",
    			"\u00e6" =>"æ",
    			"\u00e7" =>"ç",
    			"\u00e8" =>"è",
    			"\u00e9" =>"é",
    			"\u00ea" =>"ê",
    			"\u00eb" =>"ë",
    			"\u00ec" =>"ì",
    			"\u00ed" =>"í",
    			"\u00ee" =>"î",
    			"\u00ef" =>"ï",
    			"\u00f0" =>"ð",
    			"\u00f1" =>"ñ",
    			"\u00f2" =>"ò",
    			"\u00f3" =>"ó",
    			"\u00f4" =>"ô",
    			"\u00f5" =>"õ",
    			"\u00f6" =>"ö",
    			"\u00f8" =>"ø",
    			"\u00f9" =>"ù",
    			"\u00fa" =>"ú",
    			"\u00fb" =>"û",
    			"\u00fc" =>"ü",
    			"\u00fd" =>"ý",
    			"\u00ff" =>"ÿ");

				foreach($utf8_ansi2 AS $key => $wert)
				{
					$gutschein_text = str_replace($key,$wert,$gutschein_text);
				}

				/*
				STRUKTUR
				$gutschein[0] = Idealo Gutschein
				$gutschein[1] = Gutscheinname (10% Rabatt - g\u00fcltig bis zum TT.MM.JJJJ)
				$gutschein[2] = HappyMocavi (10% Rabatt - g\u00fcltig bis zum 30.06.2018)
				$gutschein[3] = Ablaufdatum (JJJJ-MM-TT)
				$gutschein[4] = der Rabatt
				$gutschein[5] = 10 // RABETT IN %
				$gutschein[6] = 2018-06-30
				*/
			}
			else
			{
				if(isSet($gutschein))
				{
					unset($gutschein);
				}
			}

			// Prüfung der Preise **************** START
			if(isSet($gutschein))
			{
				$priceList['price'] = $priceList['price'] * (1 - $gutschein[5]/100);
				if($priceList['price'] < $priceList['price_70'])
				{
					$priceList['price_70'] = $priceList['price'];
				}
			}
			// Prüfung der Preise **************** ENDE


			$data = [
				'article_id'        => '',
				'deeplink'          => $this->elasticExportCoreHelper->getMutatedUrl($variation, $settings, true, false),
				'name'              => $this->elasticExportCoreHelper->getMutatedName($variation, $settings) . (strlen($variationName) ? ' ' . $variationName : ''),
				'short_description' => $this->elasticExportCoreHelper->getMutatedPreviewText($variation, $settings),
				'description'       => $this->elasticExportCoreHelper->getMutatedDescription($variation, $settings),
				'article_no'        => $variation['data']['variation']['number'],
				'producer'          => $this->elasticExportCoreHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
				'model'             => $variation['data']['variation']['model'],
				'availability'      => $this->elasticExportCoreHelper->getAvailability($variation, $settings),
				'ean'               => $this->elasticExportCoreHelper->getBarcodeByType($variation, $settings->get('barcode')),
				'isbn'              => $this->elasticExportCoreHelper->getBarcodeByType($variation, ElasticExportCoreHelper::BARCODE_ISBN),
				'fedas'             => $variation['data']['item']['amazonFedas'],
				'warranty'          => '',
				'price'             => $priceList['price'],
				'price_old' 		=> $priceList['price_old'],
				'repricer_min'		=> $priceList['price_70'],
            	'gutschein_text' 	=> $gutschein_text,
            	'gutschein_datum'	=> $gutschein[6],
            	'gutschein_rabatt'	=> $gutschein[5],
				'weight'            => $variation['data']['variation']['weightG'],
				'category1'         => $this->elasticExportCoreHelper->getCategoryBranch((int)$variation['data']['defaultCategories'][0]['id'], $settings, 1),
				'category2'         => $this->elasticExportCoreHelper->getCategoryBranch((int)$variation['data']['defaultCategories'][0]['id'], $settings, 2),
				'category3'         => $this->elasticExportCoreHelper->getCategoryBranch((int)$variation['data']['defaultCategories'][0]['id'], $settings, 3),
				'category4'         => $this->elasticExportCoreHelper->getCategoryBranch((int)$variation['data']['defaultCategories'][0]['id'], $settings, 4),
				'category5'         => $this->elasticExportCoreHelper->getCategoryBranch((int)$variation['data']['defaultCategories'][0]['id'], $settings, 5),
				'category6'         => $this->elasticExportCoreHelper->getCategoryBranch((int)$variation['data']['defaultCategories'][0]['id'], $settings, 6),
				'category_concat'   => $this->elasticExportCoreHelper->getCategory((int)$variation['data']['defaultCategories'][0]['id'], $settings->get('lang'), $settings->get('plentyId')),
				'image_url_preview' => $this->elasticExportCoreHelper->getImageUrlBySize($imageDataList[0], ElasticExportCoreHelper::SIZE_PREVIEW),
				'image_url'         => $this->elasticExportCoreHelper->getImageUrlBySize($imageDataList[0], ElasticExportCoreHelper::SIZE_NORMAL),
				'base_price'        => $this->elasticExportPriceHelper->getBasePrice($variation, $priceList['price'], $settings->get('lang'), '/', false, true, $priceList['currency']),
				'v_vorkasse'		=> number_format(0.00,2),
				'v_paypal'			=> number_format(0.00,2),
				'v_kreditkarte'		=> number_format(0.00,2),
				'v_amazonpay'		=> number_format(0.00,2),
				'v_rechnung'		=> number_format(0.00,2),
				'v_lastschrift'		=> number_format(0.00,2),
				'v_nachnahme'		=> number_format(0.00,2),
				'free_text_field'   => $this->propertyHelper->getFreeText($variation),
				'checkoutApproved'  => $checkoutApproved,
			];

			/**
			 * if the article is available for idealo DK further fields will be set depending on the properties of the article.
			 *
			 * Be sure to set the price in twoManHandlingPrice and disposalPrice with a dot instead of a comma for idealo DK
			 * will only except it that way.
			 *
			 * The properties twoManHandlingPrice and disposalPrice will also only be set if the property fulfillmentType is 'Spedition'
			 * otherwise these two properties will be ignored.
			 */
			if($checkoutApproved == 'true')
			{
				if($variation['data']['skus']['sku'] != null)
				{
					$sku = $variation['data']['skus']['sku'];
				}
				else
				{
					$sku = $this->elasticExportCoreHelper->generateSku($variation['id'], self::IDEALO_CHECKOUT, 0, $variation['id']);
				}

				$data['article_id'] = $sku;
				$data['itemsInStock'] = $stock;

				$data['fulfillmentType'] = '';
				$data['twoManHandlingPrice'] = '';
				$data['disposalPrice'] = '';

				if($this->propertyHelper->getProperty($variation, self::PROPERTY_IDEALO_SPEDITION) === true)
				{
					$data['fulfillmentType'] = 'Spedition';

					$twoManHandling = $this->propertyHelper->getProperty($variation, 'TwoManHandlingPrice');
					$twoManHandling = number_format((float)$twoManHandling, 2, ',', '');

					$disposal = $this->propertyHelper->getProperty($variation, 'DisposalPrice');
					$disposal = number_format((float)$disposal, 2, ',', '');

					$data['twoManHandlingPrice'] = ($twoManHandling > 0) ? $twoManHandling : '';

					if($data['twoManHandlingPrice'] > 0)
					{
						$data['disposalPrice'] = ($disposal > 0) ? $disposal : '';
					}
				}
				elseif($this->propertyHelper->getProperty($variation, self::PROPERTY_IDEALO_PAKETDIENST) === true)
				{
					$data['fulfillmentType'] = 'Paketdienst';
				}
			}
			else
			{
				if($variation['data']['skus']['sku'] != null)
				{
					$sku = $variation['data']['skus']['sku'];
				}
				else
				{
					$sku = $this->elasticExportCoreHelper->generateSku($variation['id'], self::IDEALO_DE, 0, $variation['id']);
				}

				$data['article_id'] = $sku;
				$data['itemsInStock'] = '';
				$data['fulfillmentType'] = '';
				$data['twoManHandlingPrice'] = '';
				$data['disposalPrice'] = '';
			}

			$shippingData = $this->elasticExportShippingHelper->getPaymentMethodCosts($variation, $priceList['price'], $this->elasticExportCoreHelper, $settings);

			if(!is_array($shippingData) || count($shippingData) == 0)
			{
				$data[self::DEFAULT_PAYMENT_METHOD] = 0.00;
			}
			else
			{
				foreach($shippingData as $paymentMethod => $costs)
				{
					$data[$paymentMethod] = $costs;
				}
			}

			// Get the values and print them in the CSV file
			$this->addCSVContent(array_values($data));
		}
	}

	/**
	 * Get the price list.
	 *
	 * @param  array    $variation
	 * @param  KeyValue $settings
	 * @return array
	 */
	private function getPriceList(array $variation, KeyValue $settings):array
	{
		$rrp = '';
		// *********************************** START AL 02.05.2018
		$countryId = 1;						// 1 für Deutschland
		$p_ID = 70;							// ID des Preises - idealo.de
		$variationId = $variation['id'];	// OK nur eine Nummer! ID
		$currency = $this->CurrencyRepositoryContract->getCountryCurrency($countryId)->currency;
		// *********************************** ENDE AL 02.05.2018
		$herkunft = $settings->get('referrerId');

		$priceList = $this->elasticExportPriceHelper->getPriceList($variation, $settings, 2, '.');

		if($priceList['specialPrice'] < $priceList['price'] && $priceList['specialPrice'] > 0)
		{
			$price = $priceList['specialPrice'];
		}
		else
		{
			$price = $priceList['price'];
		}

		if($priceList['recommendedRetailPrice'] > $priceList['price'] && $priceList['recommendedRetailPrice'] > $price)
		{
			$rrp = $priceList['recommendedRetailPrice'];
		}
		elseif($priceList['price'] > $price)
		{
			$rrp = $priceList['price'];
		}

		// **********
		$rrp = $priceList['recommendedRetailPrice'];

		$variation_sales_price = $this->VariationSalesPriceRepositoryContract->show($p_ID,$variationId);	// geht
		$p70 = $variation_sales_price['price'];
		// *********************************** START AL 02.05.2018
		//$price = $variation_sales_price['price'];
		//$p2 = $variation_sales_price['salesPriceId'];
		//$p3 = $variation_sales_price['variationId'];

		// 'price_old' => $rrp, ERSETZT DURCH 'price_old' => $price,

		if($p70 <= 0)
		{
			$p70 = $price;
		}
		if($p70 == '')
		{
			$p70 = $price;
		}


		// *********************************** ENDE AL 02.05.2018

		return [
			'price' => $price,
			'price_old' => $rrp,
			'price_70' => $p70,
			'currency' => $currency
		];
	}
}
