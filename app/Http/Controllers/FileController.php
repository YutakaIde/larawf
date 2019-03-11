<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Flow\Config as FlowConfig;
use Flow\Request as FlowRequest;

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

        $config = new FlowConfig();
        $config->setTempDir(storage_path() . '/tmp');
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

        $filedir = '/upload/';

        if (!file_exists(public_path() . $filedir)) {
            mkdir(public_path() . $filedir, $mode = 0777, true);
        }

        $identifier = md5($uploadFile['name']) . '-' . time();
        $p = pathinfo($uploadFile['name']);

        /* hashファイル名と拡張子を結合 */
        $identifier .= "." . $p['extension'];

        /* アップロードパス */
        $path = $filedir . $identifier;
        /* パブリックディレクトリへのパス */
        $public_path = public_path() . $path;

        if ($file->validateFile() && $file->save($public_path)) {

            $data = File::create([
                'mime' => $uploadFile['type'],
                'size' => $request->getTotalSize(),
                'storage_path' => $path,
                'filename' => $uploadFile['name'],
                'disk' => 'local'
            ]);
            $file->deleteChunks();
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
