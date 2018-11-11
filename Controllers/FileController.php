<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        $upload_count = 0;

        if(count($request->file) > 0) {
            foreach($request->file as $file) {

                $path = config('jumpbutton.' . $request->path);

                // Upload the File to AWS
                $upload = Storage::disk('spaces')->putFile($path, $file, 'public');

                //If successfully uploaded to the AWS
                if($upload) {

                    //Parse the path and new random file name
                    $split = preg_split("/[\\/]+/", $upload);
                    $random_name = end($split);
                    $upload_count++;

                    //Add File to the Database
                    File::create([
                        'file_name' => $file->getClientOriginalName(),
                        'random_name' => $random_name,
                        'path' => $path,
                        'created_by' => Auth::id()
                    ]);
                }
            }
        }

        if($upload_count <> 1) {
            $multiple = 's';
        }
        else {
            $multiple = '';
        }

        // If upload has completed
        if($upload_count > 0) {
            Flash(count($upload_count) . ' File' . $multiple . ' Uploaded Successfully', 'success');
        }
        else {
            Flash('Computer says no!', 'danger');
        }

        return redirect()->route('admin.file.index');

    }

    public function delete(Request $request) {

        $ids = $request->get('ids', null);

        if (count($ids) > 0) {
            foreach($ids as $id) {
                $file = File::find($id);
                //Set AWS Path
                $aws_path = $file->path . '/' . $file->random_name;
                //Delete AWS File
                $delete_aws = Storage::disk('spaces')->delete($aws_path);
                //Delete Local File in DB
                if($delete_aws) {
                    File::where('id', $id)->delete();
                }
            }
            $request->session()->flash(count($ids) . ' files deleted.', 'success');
        } else {
            $request->session()->flash('Error deleting files', 'warning');
        }
    }
}
