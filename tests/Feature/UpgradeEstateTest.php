<?php

namespace Tests\Feature;

use App\Enums\DealTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpgradeEstateTest extends TestCase
{

   // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_upgrade_estate_rent()
    {
        $response = $this->get('/api/upgrade/' . DealTypeEnum::RENT->name);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

/*    public function test_upgrade_estate_sale()
    {
        $response = $this->get('/api/upgrade/' . DealTypeEnum::SALE->name);
        $response->assertStatus(200);
    }

    public function test_upgrade_estate_short_rent()
    {
        $response = $this->get('/api/upgrade/' . DealTypeEnum::SHORT_RENT->name);
        $response->assertStatus(200);
    }

    public function test_fail_update_estate()
    {
        $response = $this->get('/api/upgrade/'.'xs');
        $response->assertStatus(404);
    }
*/


}
