<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Loan;
use App\Models\Euribor;

class AddEuriborToLoanTest extends TestCase
{
    public const URI = '/api/loans/';

    public function test_euribor_can_be_created(): void
    {
        $loan = Loan::factory()->create();
        Euribor::factory()->for($loan)->create(['term' => 1]);
        $instance = Euribor::factory()->make();
        $response = $this->POST(self::URI . (string) $loan->id, [
            'segment_nr' => $instance->term,
            'euribor_in_basis_point' => $instance->euribor_rate_in_basis_points,
        ]);
        $response->assertStatus(200);
    }

    public function test_euribor_can_not_be_created_without_data(): void
    {
        $loan = Loan::factory()->create();
        Euribor::factory()->for($loan)->create(['term' => 1]);
        $instance = Euribor::factory()->make();
        $response = $this->POST(self::URI . (string) $loan->id);
        $response->assertStatus(422);
    }

    public function test_euribor_can_not_be_created_without_segment_nr(): void
    {
        $loan = Loan::factory()->create();
        Euribor::factory()->for($loan)->create(['term' => 1]);
        $instance = Euribor::factory()->make();
        $response = $this->POST(self::URI . (string) $loan->id, [
            'segment_nr' => 0,
            'euribor_in_basis_point' => $instance->euribor_rate_in_basis_points,
        ]);
        $response = $this->POST(self::URI . (string) $loan->id, [
            'segment_nr' => -10,
            'euribor_in_basis_point' => $instance->euribor_rate_in_basis_points,
        ]);
        $response->assertStatus(422);
        $response = $this->POST(self::URI . (string) $loan->id, [
            'segment_nr' => "segment_nr",
            'euribor_in_basis_point' => $instance->euribor_rate_in_basis_points,
        ]);
        $response->assertStatus(422);
        $response = $this->POST(self::URI . (string) $loan->id, [
            'euribor_in_basis_point' => $instance->euribor_rate_in_basis_points,
        ]);
        $response->assertStatus(422);
    }

    public function test_euribor_can_not_be_created_without_rate(): void
    {
        $loan = Loan::factory()->create();
        Euribor::factory()->for($loan)->create(['term' => 1]);
        $instance = Euribor::factory()->make();
        $response = $this->POST(self::URI . (string) $loan->id, [
            'segment_nr' => $instance->term,
            'euribor_in_basis_point' => -10
        ]);
        $response->assertStatus(422);
        $response = $this->POST(self::URI . (string) $loan->id, [
            'segment_nr' => $instance->term,
            'euribor_in_basis_point' => 'euribor_in_basis_point',
        ]);
        $response->assertStatus(422);
        $response = $this->POST(self::URI . (string) $loan->id, [
            'segment_nr' => $instance->term,
        ]);
        $response->assertStatus(422);
    }
}
