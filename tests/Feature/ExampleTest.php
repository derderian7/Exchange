<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_get_posts()
    {
        $response = $this->getJson('api/posts');

        $response->assertStatus(200);
    }
    public function test_get_GetAdmin()
    {
        $response = $this->getJson('api/GetAdmin');

        $response->assertStatus(200);
    }
    public function test_get_show_report()
    {
        $response = $this->getJson('api/show_report');

        $response->assertStatus(200);
    }
    public function test_get_report_count()
    {
        $response = $this->getJson('api/report_count');

        $response->assertStatus(200);
    }
    public function test_get_CountMsg()
    {
        $response = $this->getJson('api/CountMsg');

        $response->assertStatus(200);
    }
    
}
