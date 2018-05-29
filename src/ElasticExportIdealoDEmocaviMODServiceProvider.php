<?php

namespace ElasticExportIdealoDE;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\ServiceProvider;

/**
 * Class ElasticExportIdealoDEServiceProvider
 * @package ElasticExportIdealoDE
 */
class ElasticExportIdealoDEServiceProvider extends ServiceProvider
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
            'ElasticExportIdealoDE\ResultField\IdealoDE',
            'ElasticExportIdealoDE\Generator\IdealoDE',
            '',
            true,
            true
        );
    }
}
