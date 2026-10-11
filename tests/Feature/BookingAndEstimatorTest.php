<?php

namespace Tests\Feature;

use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingAndEstimatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_estimator_page_renders_and_calculates(): void
    {
        $response = $this->get('/fa/estimator');
        $response->assertStatus(200);
        $response->assertSee('برآورد هوشمند');

        $calcResponse = $this->postJson('/fa/estimator/calculate', [
            'project_type' => 'mvp',
            'scale' => 'small',
            'timeline' => 'standard',
        ]);

        $calcResponse->assertStatus(200);
        $calcResponse->assertJsonStructure(['status', 'public_id', 'min_estimate', 'max_estimate']);
    }

    public function test_booking_page_renders_and_creates_appointment(): void
    {
        $response = $this->get('/fa/booking');
        $response->assertStatus(200);
        $response->assertSee('رزرو جلسه');

        $bookResponse = $this->post('/fa/booking', [
            'client_name' => 'مهندس کاظمی',
            'client_email' => 'kazemi@company.ir',
            'client_phone' => '09129998877',
            'slot_date' => date('Y-m-d', strtotime('+3 days')),
            'slot_time' => '14:00',
            'notes' => 'بررسی معماری سیستم و مشاوره فنی',
        ]);

        $bookResponse->assertRedirect();
        $this->assertDatabaseHas('appointments', [
            'client_email' => 'kazemi@company.ir',
            'status' => 'confirmed',
        ]);
    }
}
