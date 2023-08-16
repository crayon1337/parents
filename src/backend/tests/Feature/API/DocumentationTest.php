<?php

namespace tests\Feature\API;

use Tests\TestCase;

class DocumentationTest extends TestCase
{
    public function testApiDocumentationLinkIsAvailable()
    {
        // Act
        $apiDocumentation = $this->get(uri: '/api/docs');

        // Assert
        $apiDocumentation->assertOk();
    }
}
