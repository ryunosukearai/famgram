<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private $user;
    const LOCAL_STORAGE_FOLDER = 'public/avatars';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return view('users.profile.show')->with('user', $user);
    }

    public function edit($id)
    {
        $user = $this->user->findOrFail($id);

        return view('users.profile.edit')
                ->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png,gif|max:1048',
            'name' => 'required|min:1|max:50',
            'eamil' => 'required|max:255',
            'introduction' => 'required|min:1|max:500'
        ]);

        #Save in the user table
        $user = $this->user->findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        #if the user update an avatar
        if($request->avatar): //if the user uploads an image/avatar
            if($user->avatar): //if there is  an existing avatar
                $this->deleteImage($user->avatar);
            endif;

            $user->avatar = $this->saveImage($request);
        endif;

        $user->save();


        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function saveImage($request)
    {
        #save image later
        #rename the file.
        $image_name = time() . "." . $request->avatar->extension();
        #example = 1234567890.png
        #upload
        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);
        #public/images/1234567890.png

        return $image_name;
    }

    public function deleteImage($image_name)
    {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;

        if(Storage::disk('local')->exists($image_path)){
            Storage::disk('local')->delete($image_path);
        }
    }


}
