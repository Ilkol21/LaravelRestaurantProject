<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Trait\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{

    use FileUploadTrait;
    function index() : View
    {
        return view('admin.profile.index');
    }

    function updateProfile(ProfileUpdateRequest $request):RedirectResponse
    {

        $user=Auth::user();

        $imagePath = $this->uploadImage($request, 'avatar');

        $user->name = $request->name;
        $user->email=$request->email;
        $user->avatar = isset($imagePath) ? $imagePath : $user->avatar;
        $user->save();

        toastr('Updated Succesfully', 'success');

        return redirect()->back();
    }
    function updatePassword(ProfilePasswordUpdateRequest $request) : RedirectResponse {

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        toastr()->success('Password Updated Successfully');

        return redirect()->back();
    }
}
