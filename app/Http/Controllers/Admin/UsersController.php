<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Admin\Users;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $all_users = $this->user->withTrashed()->latest()->paginate(3);
        return view('admin.users.index')->with('all_users', $all_users);

        // withTrashed() - include the Soft Delete items ソフトデリートで消された人も含む
    }

    public function deactivate($id)
    {
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id)
    {
        $user = $this->user->onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->back();
    }


}
