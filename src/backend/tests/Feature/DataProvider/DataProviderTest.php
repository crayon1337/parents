<?php

declare(strict_types=1);

namespace Tests\Feature\DataProvider;

use App\Http\Service\DataProvider\XDataProvider\XDataProvider;
use App\Http\Service\DataProvider\YDataProvider\YDataProvider;
use Tests\TestCase;

class DataProviderTest extends TestCase
{
    /**
     * This test case will validate that the data is collected from the corresponding json files
     * And the data is also mapped into a Laravel collection
     *
     * @return void
     */
    public function testProvidersDataAreBeingCollectedAndStoredIntoCollection(): void
    {
        // Setup
        $xDataProvider = new XDataProvider();
        $yDataProvider = new YDataProvider();

        // Act
        $xProviderData = $xDataProvider->getData(filePath: 'DataProviderX.json');
        $yProviderData = $yDataProvider->getData(filePath: 'DataProviderY.json');

        // Assert
        $this->assertNotNull($xProviderData);
        $this->assertCount(5, $xProviderData);

        $this->assertNotNull($yProviderData);
        $this->assertCount(5, $yProviderData);
    }
}
