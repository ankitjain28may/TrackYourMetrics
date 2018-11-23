<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FolderInFolder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_folder_id', 'child_folder_id',
    ];

    public static function getDirectories()
    {
      // $query = DB::table('folder_in_folder')
      //   ->join('folders', 'folders.id', '=', 'company_user.company_id')
      //   ->select('companies.*')
      //   ->where('company_user.user_id', $user_id)
      //   ->where('company_user.deleted_at', null)
      //   ->where('companies.deleted_at', null)
      //   ->where('company_user.flag', 0)
      //   ->first();
    }

}
