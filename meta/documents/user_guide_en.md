
# idealo.de plugin user guide

<div class="container-toc"></div>

## 1 Registering with idealo.de

idealo.de is a German price comparison portal and provides comparisons for offers and prices, test reports, product comparisons and also price notifications.

## 2 Setting up the data format IdealoDE-Plugin in plentymarkets

By installing this plugin you will receive the export format **IdealoDE-Plugin**. Use this format to exchange data between plentymarkets and idealo.de. It is required to install the Plugin **Elastic export** from the plentyMarketplace first before you can use the format **IdealoDE-Plugin** in plentymarkets.

Once both plugins are installed, you can create the export format **IdealoDE-Plugin**. Refer to the [Exporting data formats for price search engines](https://knowledge.plentymarkets.com/en/basics/data-exchange/exporting-data#30) page of the manual for further details about the individual format settings.

Creating a new export format:

1. Go to **Data » Elastic export**.
2. Click on **New export**.
3. Carry out the settings as desired. Pay attention to the information given in table 1.
4. **Save** the settings.
→ The export format will be given an ID and it will appear in the overview within the **Exports** tab.

The following table lists details for settings, format settings and recommended item filters for the format **IdealoDE-Plugin**.

| **Setting**                                           | **Explanation** |
| :---                                                  | :--- |
| **Settings**                                          |
| **Name**                                              | Enter a name. The export format will be listed under this name in the overview within the **Exports** tab. |
| **Type**                                              | Select the type **Item** from the drop-down list. |
| **Format**                                            | Select **IdealoDE-Plugin**. |
| **Limit**                                             | Enter a number. If you want to transfer more than 9,999 data records to the price search engine, then the output file will not be generated again for another 24 hours. This is to save resources. If more than 9,999 data records are necessary, the setting **Generate cache file** has to be active. |
| **Generate cache file**                               | Place a check mark if you want to transfer more than 9,999 data records to the price search engine. The output file will not be generated again for another 24 hours. We recommend not to activate this setting for more than 20 export formats. This is to save resources. |
| **Provisioning**                                      | Select **URL**. |
| **File name**                                         | The file name must have the ending **.csv** or **.txt** for idealo.de to be able to import the file successfully. |
| **Token, URL**                                        | If you have selected the option **URL** under **Provisioning**, then click on **Generate token**. The token will be entered automatically. When the token is generated under **Token**, the URL is entered automatically. |
| **Item filters**                                      |
| **Add item filters**                                  | Select an item filter from the drop-down list and click on **Add**. There are no filters set in default. It is possible to add multiple item filters from the drop-down list one after the other.<br/> **Variations** = Select **Transfer all** or **Only transfer main variations**.<br/> **Markets** = Select **idealo**.<br/> The availability for all markets selected here has to be saved for the item. Otherwise, the export will not take place.<br/> **Currency** = Select a currency.<br/> **Category** = Activate to transfer the item with its category link. Only items belonging to this category will be exported.<br/> **Image** = Activate to transfer the item with its image. Only items with images will be transferred.<br/> **Client** = Select client.<br/> **Stock** = Select which stocks you want to export.<br/> **Flag 1 - 2** = Select the flag.<br/> **Manufacturer** = Select one, several or **ALL** manufacturers.<br/> **Active** = Only active variations will be exported. |
| **Format settings**                                   |
| **Product URL**                                       | Choose wich URL should be transferred to the price comparison portal, the item’s URL or the variation’s URL. Variation SKUs can only be transferred in combination with the Ceres store. |
| **Client**                                            | Select a client. This setting is used for the URL structure. |
| **URL parameter**                                     | Enter a suffix for the product URL if this is required for the export. If you have activated the transfer option for the product URL further up, then this character string will be added to the product URL. |
| **Order referrer**                                    | Choose the order referrer **idealo**. |
| **Marketplace account**                               | Select the marketplace account from the drop-down list. The selected referrer is added to the product URL so that sales can be analysed later. |
| **Language**                                          | Select the language from the drop-down list. |
| **Item name**                                         | Select **Name 1**, **Name 2** or **Name 3**. These names are saved in the **Texts** tab of the item. Enter a number into the **Maximum number of characters (def. Text)** field if desired. This specifies how many characters should be exported for the item name. |
| **Preview text**                                      | Select the text that you want to transfer as preview text.<br/> Enter a number into the **Maximum number of characters (def. text)** field if desired. This will specify how many characters should be exported for the item name.<br/> Activate the option **Remove HTML tags** if you want HTML tags to be removed during the export.<br/> If you only want to allow specific HTML tags to be exported, then enter these tags into the field **Permitted HTML tags, separated by comma (def. Text)**. Use commas to separate multiple tags. |
| **Description**                                       | Select the text that you want to transfer as description.<br/> Enter a number into the **Maximum number of characters (def. text)** field if desired. This specifies how many characters should be exported for the description.<br/> Activate the option **Remove HTML tags** if you want HTML tags to be removed during the export. If you only want to allow specific HTML tags to be exported, then enter these tags into the field **Permitted HTML tags, separated by comma (def. Text)**. Use commas to separate multiple tags. |
| **Target country**                                    | Select the target country from the drop-down list. |
| **Barcode**                                           | Select the ASIN, ISBN or an EAN from the drop-down list. The barcode has to be linked to the order referrer selected above. If the barcode is not linked to the order referrer it will not be exported. |
| **Image**                                             | Select **Position 0** or **First image** to export this image.<br/> **Position 0** = An image with position 0 will be transferred.<br/> **First image** = The first image will be transferred. |
| **Image position of the energy efficiency label**     | Enter the position. Every image that should be transferred as an energy efficiency label must have this position. |
| **Stockbuffer**                                       | The stock buffer for variations with the limitation to the net stock. |
| **Stock for variations without stock limitation**     | The stock for variations without stock limitation. |
| **Stock for variations with no stock administration** | The stock for variations without stock administration. |
| **Retail price**                                      | Select gross price or net price from the drop-down list. |
| **Offer price**                                       | This option does not affect this format. |
| **RRP**                                               | Activate to transfer the RRP. |
| **Shipping costs**                                    | The chosen payment method does not affect this format. All payment methods of the selected configuration will be exported.<br/> If no configuration has been selected, all configurations and payment methods will be exported.<br/> If **Transfer flat rate shipping charge** has been selected, only prepayment will be exported as the payment method. |
| **VAT note**                                          | This option does not affect this format. |
| **Item availability**                                 | Activate the **overwrite** option and enter item availabilities into the fields **1** to **10**. The fields represent the IDs of the availabilities. This will overwrite the item availabilities that are saved in the menu **System » Item » Availability**. |

## 3 Available columns for the export file

| **Column description**  | **Explanation** |
| :---                    | :--- |
| **article_id**          | **Required**<br/> The **SKU** of the item. For all items which are configured for **idealo Checkout** a SKU will be generated for **idealo Checkout**. |
| **deeplink**            | **Required**<br/> The **URL** of the item depending on the selected **Client** in the format settings. |
| **name**                | **Required**<br/> According to the format setting **Item name**.|
| **short_description**   | According to the format setting **Preview text**. |
| **description**         | **Limitation**: max. 1000 characters<br/> According to the format setting **Description**. |
| **article_no**          | The **Variation number** within **Item » Edit item » Open item » Open variation » Settings » Basic settings**. |
| **producer**            | The **Name of the manufacturer** of the item. The **external name** within **Settings » Item » Manufacturer** will be preferred, if existing. |
| **model**               | The **Model** within **Items » Edit items » Open item » Open variation » Settings » Basic settings**. |
| **availability**        | **Required**<br/> The **Name of the item availability** within **Settings » Item » Item availability** or the translation according to the format setting **Overwrite item availability**. |
| **ean**                 | According to the format setting **Barcode**. |
| **isbn**                | According to the format setting **Barcode**. |
| **fedas**               | The **Amazon product type** within **Items » Edit item » Open item » Multi-Channel » Amazon**. |
| **warranty**            | Currently not configured. |
| **price**               | **Required**<br/> The **retail price** of the variation. |
| **price_old**           | The **retail price** of type **RRP** of the variation, if activated in the format settings. |
| **weight**              | The **gross weight** in gram within **Items » Edit item » Open item » Open variation » Settings » Measurements**. |
| **category1-6**         | The **name of the category level** of the **category path of the default category** for the client which is configured in the format settings. |
| **category_concat**     | The **category path of the default category** for the **client** which is configured in the format settings. |
| **image_url_preview**   | The **URL for the image** which is scaled for preview according to the format setting **Image**. |
| **image_url**           | **Required**<br/> The **URL of the image** according to the format setting **Image**. |
| **base_price**          | The **base price information** in the format "price / unit". (e.g.: 10,00 EUR / kilogram) |
| **free_text_field**     | The value of a **property** of type **Text** or **Selection** with a link to **idealo**. |
| **checkoutApproved**    | Is **true** if the order referrer **idealo Direktkauf** within **Items » Edit item » Open item » Open variation » Availability » Markets** is set or a property of type **No** and the link to the idealo Checkout property **CheckoutApproved** is configured. |
| **itemsInStock**        | **Requirement**: checkoutApproved is true.<br/> The **net stock of the variation**. For items which are not limited to the net stock **999** will be exported. |
| **fulfillmentType**     | **Requirement**: checkoutApproved is true.<br/> Property of type **No** and the link to the idealo Checkout property **FulfillmentType » Spedition or FulfillmentType » Paketdienst**. |
| **twoManHandlingPrice** | **Requirement**: checkoutApproved is true and fulfillmentType is "Spedition".<br/> Property of type **Text**, **Selection** or **float** and the link to the idealo Checkout property **twoManHandlingPrice**. |
| **disposalPrice**       | **Requirement**: checkoutApproved is true and fulfillmentType is "Spedition".<br/> Property of type **Text**, **Selection** or **float** and the link to the idealo Checkout property **disposalPrice**. |
| **Zahlungsarten**       | **Required**: (min. one payment method)<br/> All payment methods will be exported, according to the format setting **Shipping costs** in its own column. |

## 4 License

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-idealo-de/blob/master/LICENSE.md).
