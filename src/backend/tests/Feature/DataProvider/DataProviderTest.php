<?php

declare(strict_types=1);

namespace Tests\Feature\DataProvider;

use App\Http\Service\DataProvider\XDataProvider\XDataDataProvider;
use App\Http\Service\DataProvider\YDataProvider\YDataDataProvider;
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
        $xDataProvider = new XDataDataProvider();
        $yDataProvider = new YDataDataProvider();

        // Act
        $xProviderData = $xDataProvider->getData();
        $yProviderData = $yDataProvider->getData();

        // Assert
        $this->assertNotNull($xProviderData);
        $this->assertCount(5, $xProviderData);

        $this->assertNotNull($yProviderData);
        $this->assertCount(5, $yProviderData);
    }
}
