<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Enum\TransactionStatus;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * This test case will assert that the users API will return all users by default.
     *
     * @return void
     */
    public function testUsersApiWouldReturnAllUsersIfNoFiltersSpecified(): void
    {
        // Act
        $usersApiResponse = $this->callUsersApi();

        // Assert
        $this->assertCount(10, $usersApiResponse->json(key: 'data'));
        // Assert User 1 data is correct
        $this->assertEquals(expected: 'd3d29d70-1d25-11e3-8591-034165a3a613', actual: $usersApiResponse->json(key: 'data.0.id'));
        $this->assertEquals(expected: 'parent1@parent.eu', actual: $usersApiResponse->json(key: 'data.0.email'));
        $this->assertEquals(expected: TransactionStatus::Authorized->value, actual: $usersApiResponse->json(key: 'data.0.status'));
        $this->assertEquals(expected: 10, actual: $usersApiResponse->json(key: 'data.0.amount'));
        $this->assertEquals(expected: 'USD', actual: $usersApiResponse->json(key: 'data.0.currency'));
        $this->assertEquals(expected: 'DataProviderX', actual: $usersApiResponse->json(key: 'data.0.provider'));
        $this->assertEquals(expected: '2018-11-30', actual: $usersApiResponse->json(key: 'data.0.date'));
        // Assert User 2 data is correct
        $this->assertEquals(expected: 'd3d29d70-1d25-11e3-1337-034165a3a656', actual: $usersApiResponse->json(key: 'data.1.id'));
        $this->assertEquals(expected: 'parent2@parent.eu', actual: $usersApiResponse->json(key: 'data.1.email'));
        $this->assertEquals(expected: TransactionStatus::Decline->value, actual: $usersApiResponse->json(key: 'data.1.status'));
        $this->assertEquals(expected: 150, actual: $usersApiResponse->json(key: 'data.1.amount'));
        $this->assertEquals(expected: 'EGP', actual: $usersApiResponse->json(key: 'data.1.currency'));
        $this->assertEquals(expected: 'DataProviderX', actual: $usersApiResponse->json(key: 'data.1.provider'));
        $this->assertEquals(expected: '2019-10-22', actual: $usersApiResponse->json(key: 'data.1.date'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using provider.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersFilteredByProvider(): void
    {
        // Setup
        $provider = 'DataProviderX';

        $queryParameters = $this->getQueryParameters(
            parameters: [
                'provider' => $provider
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 5, haystack: $usersApiResponse->json(key: 'data'));
        $this->assertEquals(expected: $provider, actual: $usersApiResponse->json(key: 'data.0.provider'));
        $this->assertEquals(expected: $provider, actual: $usersApiResponse->json(key: 'data.1.provider'));
        $this->assertEquals(expected: $provider, actual: $usersApiResponse->json(key: 'data.2.provider'));
        $this->assertEquals(expected: $provider, actual: $usersApiResponse->json(key: 'data.3.provider'));
        $this->assertEquals(expected: $provider, actual: $usersApiResponse->json(key: 'data.4.provider'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using status.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersFilteredByStatus(): void
    {
        // Setup
        $status = TransactionStatus::Authorized->value;

        $queryParameters = $this->getQueryParameters(
            parameters: [
                'status' => $status
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 4, haystack: $usersApiResponse->json(key: 'data'));
        $this->assertEquals(expected: $status, actual: $usersApiResponse->json(key: 'data.0.status'));
        $this->assertEquals(expected: $status, actual: $usersApiResponse->json(key: 'data.1.status'));
        $this->assertEquals(expected: $status, actual: $usersApiResponse->json(key: 'data.2.status'));
        $this->assertEquals(expected: $status, actual: $usersApiResponse->json(key: 'data.3.status'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using balance min and balance max.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersFilteredByBalanceMinAndBalanceMax(): void
    {
        // Setup
        $balanceMin = 10;
        $balanceMax = 300;
        $balanceAvg = 150;

        $queryParameters = $this->getQueryParameters(
            parameters: [
                'balanceMin' => $balanceMin,
                'balanceMax' => $balanceMax
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 5, haystack: $usersApiResponse->json(key: 'data'));
        $this->assertEquals(expected: $balanceMin, actual: $usersApiResponse->json(key: 'data.0.amount'));
        $this->assertEquals(expected: $balanceAvg, actual: $usersApiResponse->json(key: 'data.1.amount'));
        $this->assertEquals(expected: $balanceMax, actual: $usersApiResponse->json(key: 'data.4.amount'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using balance min.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersFilteredByBalanceMin(): void
    {
        // Setup
        $balanceMin = 155;

        $queryParameters = $this->getQueryParameters(
            parameters: [
                'balanceMin' => $balanceMin
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 3, haystack: $usersApiResponse->json(key: 'data'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using balance max.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersFilteredByBalanceMax(): void
    {
        // Setup
        $balanceMax = 600;

        $queryParameters = $this->getQueryParameters(
            parameters: [
                'balanceMax' => $balanceMax
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 9, haystack: $usersApiResponse->json(key: 'data'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using currency.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersFilteredByCurrency(): void
    {
        // Setup
        $currency = 'USD';

        $queryParameters = $this->getQueryParameters(
            parameters: [
                'currency' => $currency
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 3, haystack: $usersApiResponse->json(key: 'data'));
        $this->assertEquals(expected: $currency, actual: $usersApiResponse->json(key: 'data.0.currency'));
        $this->assertEquals(expected: $currency, actual: $usersApiResponse->json(key: 'data.1.currency'));
        $this->assertEquals(expected: $currency, actual: $usersApiResponse->json(key: 'data.2.currency'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using all filters combined.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersWhenAllFiltersCombined(): void
    {
        // Setup
        $queryParameters = $this->getQueryParameters(
            parameters: [
                'provider' => 'DataProviderX',
                'status' => TransactionStatus::Authorized->value,
                'balanceMin' => 10,
                'balanceMax' => 100,
                'currency' => 'USD'
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 1, haystack: $usersApiResponse->json(key: 'data'));
        $this->assertEquals(expected: TransactionStatus::Authorized->value, actual: $usersApiResponse->json(key: 'data.0.status'));
        $this->assertEquals(expected: 10, actual: $usersApiResponse->json(key: 'data.0.amount'));
        $this->assertEquals(expected: 'USD', actual: $usersApiResponse->json(key: 'data.0.currency'));
        $this->assertEquals(expected: 'DataProviderX', actual: $usersApiResponse->json(key: 'data.0.provider'));
    }

    /**
     * This test case will validate that it is possible to filter the users returned by the API.
     * Using all filters combined.
     *
     * @return void
     */
    public function testUsersApiWouldReturnUsersWhenAllFiltersCombinedWithoutProviders(): void
    {
        // Setup
        $queryParameters = $this->getQueryParameters(
            parameters: [
                'status' => TransactionStatus::Refunded->value,
                'balanceMin' => 100,
                'balanceMax' => 500,
                'currency' => 'USD'
            ]
        );

        // Act
        $usersApiResponse = $this->callUsersApi(queryParameters: $queryParameters);

        // Assert
        $this->assertCount(expectedCount: 2, haystack: $usersApiResponse->json(key: 'data'));
        $this->assertEquals(expected: TransactionStatus::Refunded->value, actual: $usersApiResponse->json(key: 'data.0.status'));
        $this->assertEquals(expected: 200, actual: $usersApiResponse->json(key: 'data.0.amount'));
        $this->assertEquals(expected: 'USD', actual: $usersApiResponse->json(key: 'data.0.currency'));
        $this->assertEquals(expected: 'DataProviderX', actual: $usersApiResponse->json(key: 'data.0.provider'));
        $this->assertEquals(expected: TransactionStatus::Refunded->value, actual: $usersApiResponse->json(key: 'data.1.status'));
        $this->assertEquals(expected: 500, actual: $usersApiResponse->json(key: 'data.1.amount'));
        $this->assertEquals(expected: 'USD', actual: $usersApiResponse->json(key: 'data.1.currency'));
        $this->assertEquals(expected: 'DataProviderX', actual: $usersApiResponse->json(key: 'data.1.provider'));
    }

    /**
     * This function will call the users API with query parameters if specified.
     * The idea behind this function is to make the API call sit in one place. In case of change,
     * We would have to alter only one place.
     *
     * @param string|null $queryParameters
     * @return TestResponse
     */
    private function callUsersApi(?string $queryParameters = null): TestResponse
    {
        $uri = route(name: 'users.index');

        if (!is_null($queryParameters)) {
            $uri .= $queryParameters;
        }

        return $this->get($uri);
    }

    /**
     * This function will convert a given array to string of query parameters.
     *
     * @param array $parameters
     * @return string
     */
    private function getQueryParameters(array $parameters): string
    {
        return '?' . http_build_query(data: $parameters);
    }
}
