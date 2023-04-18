<?php

namespace Tests\Feature;

use Tests\TestCase;

class DivergeValidatorTest extends TestCase
{
    public function testValidationPasses(): void
    {
        $response = $this->post('/testValidation', ['newPrice' => 105, 'currentPrice' => 100]);
        $response->assertStatus(200);
    }

    public function testValidationFailedMessage(): void
    {
        $response = $this->post('/testValidation', ['newPrice' => 106, 'currentPrice' => 100]);
        $test = $response->exception->getMessage();

        $this->assertStringContainsString('отклонения', $response->exception->getMessage());
    }
}