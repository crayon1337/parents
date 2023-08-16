<?php

declare(strict_types=1);

namespace Tests\Unit\User;

use PHPUnit\Framework\TestCase;

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
        $xProviderData = $xDataProvider->getUsers();
        $yProviderData = $yDataProvider->getUsers();

        // Assert
        $this->assertNotNull($xProviderData);
        $this->assertCount(5, $xProviderData);
        $this->assertTrue($xProviderData instanceof UserCollection);

        $this->assertNotNull($yProviderData);
        $this->assertCount(5, $yProviderData);
        $this->assertTrue($yProviderData instanceof UserCollection);
    }
}
