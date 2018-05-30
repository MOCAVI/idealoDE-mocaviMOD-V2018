<?php

namespace ElasticExportIdealoDEv2;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\ServiceProvider;

/**
 * Class ElasticExportIdealoDEServiceProvider
 * @package ElasticExportIdealoDE
 */
class ElasticExportIdealoDEv2ServiceProvider extends ServiceProvider
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
            'IdealoDE-Plugin-MOCAVI-MODv2018',
            'ElasticExportIdealoDEv2\ResultField\IdealoDE',
            'ElasticExportIdealoDEv2\Generator\IdealoDE',
            '',
            true,
            true
        );
    }
}
