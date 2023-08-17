<?php

declare(strict_types=1);

namespace Tests\Feature\DataProvider;

use App\Http\Service\DataProvider\XDataProvider;
use App\Http\Service\DataProvider\YDataProvider;
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
        $xDataProvider = XDataProvider::make(filePath: 'DataProviderX.json');
        $yDataProvider = YDataProvider::make(filePath: 'DataProviderY.json');

        // Act
        $xProviderData = $xDataProvider->get();
        $yProviderData = $yDataProvider->get();

        // Assert
        $this->assertNotNull(actual: $xProviderData);
        $this->assertCount(expectedCount: 5, haystack: $xProviderData);

        $this->assertNotNull(actual: $yProviderData);
        $this->assertCount(expectedCount: 5, haystack: $yProviderData);
    }
}
