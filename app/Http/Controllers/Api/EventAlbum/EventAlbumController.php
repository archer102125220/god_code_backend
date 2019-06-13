<?php

namespace App\Http\Controllers\Api\EventAlbum;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\EventAlbum\CreateEventAlbumRequest;
use App\Http\Requests\Api\EventAlbum\UpdateEventAlbumRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\EventAlbum;
use Illuminate\Http\Request;
use Response;

class EventAlbumController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventAlbum = EventAlbum::with(['eventType', 'files'])->withTrashed()->fromRequest($request);
        $paginator = $eventAlbum->paginate(10)->appends($request->input());
        return Response::json($paginator, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\EventAlbum\CreateEventAlbumRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventAlbumRequest $request)
    {
        Log::record('EventAlbum', 'create', json_encode(['data' => $request->all()]));
        $eventAlbum = EventAlbum::create($request->only(['event_albums', 'event_type_id']));
        $eventAlbum->save();
        $this->updateFileRefer($eventAlbum, $request->input('files', []), 'eventAlbum');
        return Response::json($eventAlbum->fresh(['eventType', 'files']), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\EventAlbum  $EventAlbum
     * @return \Illuminate\Http\Response
     */
    public function show(EventAlbum $eventAlbum)
    {
        return Response::json($eventAlbum->fresh(['eventType', 'files']), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\EventAlbum\UpdateEventAlbumRequest  $request
     * @param  \App\Model\Eloquent\EventAlbum  $EventAlbum
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventAlbumRequest $request, EventAlbum $eventAlbum)
    {
        Log::record('EventAlbum', 'update', json_encode(['data' => $request->all()]));
        $eventAlbum->fill($request->only(['event_albums', 'event_type_id']));
        if ($eventAlbum->isDirty()) {
            $eventAlbum->save();
        } else {
            $eventAlbum->touch();
        }
        $this->updateFileRefer($eventAlbum, $request->input('files', []), 'eventAlbum');
        return Response::json($eventAlbum->fresh(['eventType', 'files']), 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\EventAlbum  $EventAlbum
     * @return \Illuminate\Http\Response
     */
    public function delete(EventAlbum $eventAlbum)
    {
        Log::record('EventAlbum', 'delete', json_encode(['data' => $eventAlbum->toArray()]));
        $eventAlbum->delete();
        return Response::json($eventAlbum->fresh(['eventType', 'files']), 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\EventAlbum  $EventAlbum
     * @return \Illuminate\Http\Response
     */
    public function restore(EventAlbum $eventAlbum)
    {
        Log::record('EventAlbum', 'restore', json_encode(['data' => $eventAlbum->toArray()]));
        $eventAlbum->restore();
        return Response::json($eventAlbum->fresh(['eventType', 'files']), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\EventAlbum  $EventAlbum
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventAlbum $eventAlbum)
    {
        Log::record('EventAlbum', 'destroy', json_encode(['data' => $eventAlbum->toArray()]));
        $eventAlbum->forceDelete();
        return Response::json(null, 200);
    }

    public function upload(Request $request)
    {
        return $this->putFileFromRequest($request, 'file', 'event_album');
    }
}
