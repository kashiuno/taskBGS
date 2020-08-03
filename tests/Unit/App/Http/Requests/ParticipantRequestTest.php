<?php

namespace Tests\Feature\App\Http\Requests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tests\TestCase;

class ParticipantRequestTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    /** @test */
    public function request_should_fail_when_no_name_is_provided() {
        $response =
            $this
            ->actingAs($this->user, 'api')
            ->postJson(route('participants.store'),[
                'surname' => $this->faker->name,
                'email' => $this->faker->email,
                'event_id' => $this->faker->numberBetween(1, 50),
            ]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function request_should_fail_when_name_length_better_then_255() {
        $response =
            $this
                ->actingAs($this->user, 'api')
                ->postJson(route('participants.store'),[
                    'name' => Str::random(256),
                    'surname' => $this->faker->name,
                    'email' => $this->faker->email,
                    'event_id' => $this->faker->numberBetween(1, 50),
                ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }
}
