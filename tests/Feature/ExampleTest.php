<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_get_posts()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/posts');

        $response->assertStatus(200);
    }
    public function test_get_GetAdmin()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/GetAdmin');

        $response->assertStatus(200);
    }
    public function test_get_show_report()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/show_report');

        $response->assertStatus(200);
    }
    public function test_get_report_count()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/report_count');

        $response->assertStatus(200);
    }
    public function test_get_CountMsg()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/CountMsg');

        $response->assertStatus(200);
    }
    
}