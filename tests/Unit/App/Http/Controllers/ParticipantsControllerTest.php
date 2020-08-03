<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Event;
use App\Jobs\EmailNotification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ParticipantsControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->events = factory(Event::class, 50)->create();
    }
    /** @test */
    public function participant_should_be_created_when_request_sent() {
        $arrayEventIds = $this->events->random()->get('id')->toArray();
        $response =
            $this
                ->actingAs($this->user, 'api')
                ->postJson(route('participants.store'),[
                    'name' => $this->faker->name,
                    'surname' => $this->faker->name,
                    'email' => $this->faker->unique()->safeEmail,
                    'event_id' => $arrayEventIds[array_rand($arrayEventIds, 1)]['id'],
                ]);
        $response->assertCreated();
    }
}
