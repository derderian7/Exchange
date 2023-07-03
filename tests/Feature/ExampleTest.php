<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_get_GetAdmin()
    {
        $user=User::factory()->create();
        $response = $this->getJson('/api/GetAdmin');

        $response->assertStatus(200);
    }
    public function test_get_show_report()
    {

        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/show_report');
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }
    public function test_get_report_count()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/report_count');

        $response->assertStatus(200);
    }
    public function test_get_CountMsg()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/CountMsg');

        $response->assertStatus(200);
    }
    public function test_get_new_users()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/NewUsers');

        $response->assertStatus(200);
    }
    public function test_get_count_all_users()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/CountAllUsers');

        $response->assertStatus(200);
    } 
    public function test_get_my_profile()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/getmyprofile');

        $response->assertStatus(200);
    }
    public function test_get_My_Rating()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/getMyRating');

        $response->assertStatus(200);
    }
    public function test_get_Wishlist()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/getWishlist');

        $response->assertStatus(200);
    }
    public function test_get_percentage_of_locations()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/percentage_of_locations');

        $response->assertStatus(200);
    }
    public function test_get_CountAllCategories()
    {
        $user=User::factory()->create();
        $response = $this->actingAs($user)->getJson('api/CountAllCategories');
        $response->assertStatus(200);
    }
    
}