<?php

namespace App\Http\Controllers\Api\EventType;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\EventType\CreateEventTypeRequest;
use App\Http\Requests\Api\EventType\UpdateEventTypeRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\EventType;
use Illuminate\Http\Request;
use Response;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventType = EventType::withTrashed()->fromRequest($request);
        $paginator = $eventType->paginate(10)->appends($request->input());
        return Response::json($paginator, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\EventType\CreateEventTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventTypeRequest $request)
    {
        Log::record('EventType', 'create', json_encode(['data' => $request->all()]));
        $eventType = eventType::create($request->all());
        $eventType->save();
        return Response::json($eventType, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\EventType  $EventType
     * @return \Illuminate\Http\Response
     */
    public function show(EventType $eventType)
    {
        return Response::json($eventType, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\EventType\UpdateEventTypeRequest  $request
     * @param  \App\Model\Eloquent\EventType  $EventType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventTypeRequest $request, EventType $eventType)
    {
        Log::record('eventType', 'update', json_encode(['data' => $request->all()]));
        $eventType->fill($request->all());
        if ($eventType->isDirty()) {
            $eventType->save();
        } else {
            $eventType->touch();
        }
        return Response::json($eventType, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\EventType  $EventType
     * @return \Illuminate\Http\Response
     */
    public function delete(EventType $eventType)
    {
        Log::record('EventType', 'delete', json_encode(['data' => $eventType->toArray()]));
        $eventType->delete();
        return Response::json($eventType, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\EventType  $EventType
     * @return \Illuminate\Http\Response
     */
    public function restore(EventType $eventType)
    {
        Log::record('EventType', 'restore', json_encode(['data' => $eventType->toArray()]));
        $eventType->restore();
        return Response::json($eventType, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\EventType  $EventType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $eventType)
    {
        Log::record('EventType', 'destroy', json_encode(['data' => $eventType->toArray()]));
        $eventType->forceDelete();
        return Response::json(null, 200);
    }
}
