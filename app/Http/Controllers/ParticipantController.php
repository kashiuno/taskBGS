<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\ParticipantRequest;
use App\Jobs\EmailNotification;
use App\Participant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse {
        $event = $request->get('event');
        $amount = $request->get('amount') ?? 20;

        $participants = ($event) ? Participant::where('event_id', $event)->take($amount)->get() : Participant::all()->take($amount);
        return response()->json($participants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ParticipantRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ParticipantRequest $request): JsonResponse {
        $event_id = $request->get('event_id');

        if (!$this->isEventExist($event_id)) {
            return response()->json([
                'success' => false,
                'error' => 'This event is not exist.',
            ]);
        }

        $data = $request->only(['name', 'surname', 'email', 'event_id']);
        Participant::create($data);

        EmailNotification::dispatch();

        return $this->getSuccessJsonResponse(JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Participant $participant) {
        return response()->json($participant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ParticipantRequest  $request
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ParticipantRequest $request, Participant $participant) {
        $data = $request->only(['name', 'surname', 'email', 'event_id']);
        $participant->fill($data)->save();
        return $this->getSuccessJsonResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Participant $participant) {
        try {
            $participant->delete();
            return $this->getSuccessJsonResponse();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param int
     * @return \Illuminate\Http\JsonResponse
     */
    private function getSuccessJsonResponse(int $code = JsonResponse::HTTP_OK) {
        return response()->json([
            'success' => true,
        ], $code);
    }

    /**
     *
     * @param int
     * @return bool
     */
    private function isEventExist(int $event_id): bool {
        try {
            Event::findOrFail($event_id);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
