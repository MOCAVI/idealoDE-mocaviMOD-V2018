<?php

namespace ElasticExportIdealoDEmmv2;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\ServiceProvider;

/**
 * Class ElasticExportIdealoDEServiceProvider
 * @package ElasticExportIdealoDE
 */
class ElasticExportIdealoDEmmv2ServiceProvider extends ServiceProvider
{
    /**
     * Function for registering the service provider.
     */
    public function register()
    {

    }

    /**
     * Adds the export format to the export preset container.
     *
     * @param ExportPresetContainer $exportPresetContainer
     */
    public function boot(ExportPresetContainer $exportPresetContainer)
    {
        $exportPresetContainer->add(
            'IdealoDE-Plugin',
            'ElasticExportIdealoDEmmv2\ResultField\IdealoDE',
            'ElasticExportIdealoDEmmv2\Generator\IdealoDE',
            '',
            true,
            true
        );
    }
}
