<?php

namespace Tests\Feature;

use App\Models\Estate;
use App\Repositories\EstateRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstateRepositoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected function createNewEstate(array $data = []) : array{
        return Estate::factory()->make($data)->toArray();
    }

    public function test_insert_new_estate()
    {
        $title  = $this->faker->text(60);
        $data_array = $this->createNewEstate(['title' => $title]);
        $repository =  new EstateRepository( new Estate());
        $repository->insert($data_array);
        $this->assertDatabaseHas('estates' , ['title' => $title] );
    }

    public function test_insert_few_new_estates()
    {
        $title  = $this->faker->text(60);
        $title2  = $this->faker->text(60);
        $data_array = $this->createNewEstate(['title' => $title]);
        $data_array2 = $this->createNewEstate(['title' => $title2]);
        $merge_arr_data  = [$data_array , $data_array2 ];
        $repository =  new EstateRepository( new Estate());
        $repository->insert($merge_arr_data);
        $this->assertDatabaseHas('estates' , ['title' => $title] );
        $this->assertDatabaseHas('estates' , ['title' => $title2] );
    }


}
