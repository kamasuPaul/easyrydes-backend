<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Facades\MediaUploader;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 100);
        $data = Media::paginate($per_page);
        return response()->json($data);
    }

    /**
     * Store a newly created media file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $visibility = $request->input('visibility', 'public');
        $this->validate($request, ['file' => 'required|file|mimes:jpeg,png,jpg|max:2048']);
        $media = MediaUploader::fromSource($request->file('file'));
        //if APP_ENV is local , upload to local disk, else upload gcs
        if (env('APP_ENV') == 'local') {
            $media->toDisk('public');
        } else {
            $media->toDisk('gcs');
        }
        $media = $media->upload();
        $media->url = $media->getUrl();
        return jsend_success([
            'message' => 'Uploaded successfully',
            'media' => $media
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        $name = $media->basename;
        $headers =
            [
                'Content-Size' => $media->size,
                'Content-Type' => $media->mime_type,
            ];
        return response()->streamDownload(
            function () use ($media) {
                echo  Storage::disk($media->disk)->get($media->basename);
            },
            $name,
            $headers
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json("Successfully deleted", 200);
    }
}
