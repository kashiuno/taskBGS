<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Event;
use App\Participant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ParticipantsControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->participants = factory(Participant::class, 100)->create();
    }
    /** @test */
    public function participant_should_be_created_when_request_sent() {
        $response =
            $this
                ->actingAs($this->user, 'api')
                ->postJson(route('participants.store'),[
                    'name' => $this->faker->name,
                    'surname' => $this->faker->name,
                    'email' => $this->faker->unique()->safeEmail,
                    'event_id' => $this->faker->randomElement($this->participants)['event_id'],
                ]);
        $response->assertCreated();
    }

    /** @test */
    public function participants_should_be_returned_when_request_sent_default_count() {
        $response =
            $this
            ->actingAs($this->user, 'api')
            ->get(route('participants.index'));

        $response->assertJsonCount(20);


    }
    /** @test */
    public function participants_should_be_returned_when_request_sent_with_set_amount() {
        $response =
            $this
                ->actingAs($this->user, 'api')
                ->get(route('participants.index') . '?amount=12');

        $response->assertJsonCount(12);
    }
    /** @test */
    public function participants_should_be_returned_when_request_sent_with_certain_structure() {
        $response =
            $this
                ->actingAs($this->user, 'api')
                ->get(route('participants.index'));

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'surname',
                'email',
                'event_id',
                'created_at',
                'updated_at',
            ]
        ]);
    }
    /** @test */
    public function participants_should_be_returned_when_request_sent_with_filter() {

        $event_ids = [];
        for ($i = 0; $i < 10; $i++) {
            $event_ids[$i] = $this->participants->random()->toArray()['event_id'];
        }

        foreach ($event_ids as $event_id) {
            $response =
                $this
                ->actingAs($this->user, 'api')
                ->get(route('participants.index') . '?event=' . $event_id);

            $response->assertStatus(JsonResponse::HTTP_OK);
            $response->assertJsonCount(1);
        }
    }


}
