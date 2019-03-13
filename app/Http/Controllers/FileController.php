<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Flow\Config as FlowConfig;
use Flow\Request as FlowRequest;
use Uuid;

use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('FileController::store start');

        $config = new FlowConfig();
        $flow_chunk_path = env('FLOW_CHUNK_PATH');
        $config->setTempDir(storage_path() . "/${flow_chunk_path}");
        $config->setDeleteChunksOnSave(false);

        $file = new \Flow\File($config);

        $request = new FlowRequest();

        $totalSize = $request->getTotalSize();

        if ($totalSize && $totalSize > (1024 * 1024 * 10)) {
            return \Response::json(['error' => 'ファイルサイズが大きすぎます。アップロード可能なサイズは10MBまでです。'], 400);
        }

        $uploadFile = $request->getFile();

        if ($file->validateChunk()) {
            $file->saveChunk();
        } else {
            // Indicate that we are not done with all the chunks.
            return \Response::json(['error' => 'アップロードに失敗しました。'], 204);
        }

        $project_file_path = env('PROJECT_FILE_PATH');
        $filedir = "/${project_file_path}/";

        /* このコードは削除した方が良い */
        if (!file_exists(public_path() . $filedir)) {
            mkdir(public_path() . $filedir, $mode = 0777, true);
        }

//        $identifier = md5($uploadFile['name']) . '-' . time();
        $identifier = Uuid::generate(4);
        $p = pathinfo($uploadFile['name']);

        $identifier .= "." . $p['extension'];

        /* アップロードパス */
        $path = $filedir . $identifier;
        /* パブリックディレクトリへのパス */
        $public_path = public_path() . $path;

        if ($file->validateFile() && $file->save($public_path)) {

            $data = File::create([
                'mime' => $uploadFile['type'],
                'original_filename' => $uploadFile['name'],
                'size' => $request->getTotalSize(),
                'filename' => $identifier,
                'disk' => 'local'
            ]);
            $file->deleteChunks();

            Log::info($data);

            Log::info('FileController::store end');

            return \Response::json($data, 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
