<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/fa');
        $response->assertStatus(200);
        $response->assertSee('امیرمحمد بحرلو');
        $response->assertSee('Hybrid Core');
    }

    public function test_english_home_page_renders_successfully(): void
    {
        $response = $this->get('/en');
        $response->assertStatus(200);
        $response->assertSee('AmirMohammad Baharlou');
    }

    public function test_portfolio_page_and_case_study_render(): void
    {
        $response = $this->get('/fa/portfolio');
        $response->assertStatus(200);

        $project = Project::first();
        if ($project) {
            $showResponse = $this->get("/fa/portfolio/{$project->slug}");
            $showResponse->assertStatus(200);
        }
    }

    public function test_contact_form_submission_creates_inquiry(): void
    {
        $response = $this->post('/fa/contact', [
            'name' => 'کاربر تستی',
            'email' => 'client@test.com',
            'phone' => '09121112233',
            'service_type' => 'custom_development',
            'subject' => 'درخواست مشاوره پروژه',
            'message' => 'این یک متن تستی برای بررسی فرم تماس است.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiries', [
            'email' => 'client@test.com',
            'subject' => 'درخواست مشاوره پروژه',
        ]);
    }
}
