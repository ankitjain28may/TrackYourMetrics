<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Models\Files;
use App\Models\Folders;
use finfo;
use Zipper;

class FolderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentDirectoryFolders = Storage::directories('/');
        $directories = [];
        foreach ($currentDirectoryFolders as $folder) {
            $directories[] = $this->folderInfo($folder);
        }
        $data['directories'] = $directories;

        $allFiles = Storage::files('/public');
        $files = array();

        foreach ($allFiles as $file) {
            $files[] = $this->fileInfo($file);
        }

        $dirs = Storage::directories('/public');
        $folders = array();
        foreach ($dirs as $folder) {
            $folders[] = $this->folderInfo($folder);
        }
        // dd($folders);

        // File::makeDirectory(storage_path().'/app/public/images');
        $data['folders'] = $folders;
        $data['files'] = $files;
        $data['current'] = [];
        $data['path'] = 'public';
        return view('dashboard', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $path)
    {
        $folder = $request->get('name');
        $path = implode('/', explode('--', $path));
        // save to storage/app/photos as the new $filename
        if (Storage::exists($path . '/' . $folder)) {
            return redirect()->back()->with([
                'message' => [
                    'class' => 'Danger',
                    'value' => 'Folder with this name already exists',
                ],
            ]);
        }
        Storage::makeDirectory($path . '/' . $folder);

        return redirect()->back()->with([
            'message' => [
                'class' => 'Success',
                'value' => 'Folder is created successfully',
            ],
        ]);;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $path = implode('/', explode('--', $id));
        $currentDirectoryPath = pathinfo($path)['dirname'];

        $currentDirectoryFolders = Storage::directories($currentDirectoryPath);
        $directories = [];
        foreach ($currentDirectoryFolders as $folder) {
            $directories[] = $this->folderInfo($folder);
        }
        $data['directories'] = $directories;

        $dirs = Storage::directories($path);
        $folders = array();
        foreach ($dirs as $folder) {
            $folders[] = $this->folderInfo($folder);
        }
        $data['folders'] = $folders;

        $files = array();
        foreach( Storage::files($path) as $file)
        {
            $files[] = $this->fileInfo($file);
        }
        $data['files'] = $files;
        $tags = explode('--', $id);
        // $prev = 'public';
        foreach ($tags as $value) {
            if (!isset($prev)) {
                $prev = 'public';
            } else {
                $prev = $prev . '--' . $value;
            }
            $data['current'][$prev] = $value;
        }
        $data['path'] = $id;
        return view('dashboard', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $path = implode('/', explode('--', $id));
        Storage::deleteDirectory($path);

        return redirect()->back()->with([
            'message' => [
                'class' => 'Success',
                'value' => 'Folder is deleted successfully',
            ],
        ]);
    }

    public function destroyfiles($id)
    {
        $path = implode('/', explode('--', $id));
        Storage::delete($path);

        return redirect()->back()->with([
            'message' => [
                'class' => 'Success',
                'value' => 'File is deleted successfully',
            ],
        ]);
    }

    public function fileInfo($filedata)
    {
        $filePath = pathinfo($filedata);
        $file = array();
        $file['path'] = implode('--', explode('/', $filedata));
        $file['name'] = $filePath['basename'];
        $file['type'] = $filePath['extension'];
        $file['size'] = filesize(storage_path() . '/app/' . $filePath['dirname'] . '/' . $filePath['basename']);

        return $file;
    }

    public function folderInfo($filedata)
    {
        $filePath = pathinfo($filedata);
        $file = array();
        $file['path'] = implode('--', explode('/', $filedata));
        $file['name'] = $filePath['basename'];
        $file['type'] = 'dir';
        $file['size'] = filesize(storage_path() . '/app/' . $filePath['dirname'] . '/' . $filePath['basename']);

        return $file;
    }

    public function fileupload(Request $request, $path)
    {
        $file = $request->file('file');
        $path = implode('/', explode('--', $path));
        // save to storage/app/photos as the new $filename
        if (Storage::exists($path . '/' . $file->getClientOriginalName())) {
            return redirect()->back()->with([
                'message' => [
                    'class' => 'Danger',
                    'value' => 'File with this name already exists',
                ],
            ]);
        }
        $fileContent = File::get($file);
        Storage::put($path . '/' . $file->getClientOriginalName(), Crypt::encrypt($fileContent));
        // $path = $file->storeAs($path, $file->getClientOriginalName());

        return redirect()->back()->with([
            'message' => [
                'class' => 'Success',
                'value' => 'File is uploaded successfully',
            ],
        ]);;
    }

    public function download($path)
    {
        $path = implode('/', explode('--', $path));
        $encryptedContents = Storage::get($path);

        $decryptedContents = Crypt::decrypt($encryptedContents);

        return response()->make($decryptedContents, 200, array(
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($decryptedContents),
            'Content-Disposition' => 'attachment; filename="' . pathinfo($path, PATHINFO_BASENAME) . '"'
        ));
    }

    public function downloadfolders($path)
    {
        $path = storage_path() . '/app/' . implode('/', explode('--', $path));
        if (Storage::exists($path . '.zip')) {
            return dd('Hello');
            Storage::delete($path . '.zip');
        }
        Zipper::make($path . '.zip')->add($path)->close();
        return response()->download($path . '.zip');
    }
}
