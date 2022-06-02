<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EditProfileController extends Controller
{
    public function index()
    {
        return view('editProfile.index', [
            'title' => "Edit Profile",
            'active' => "edit"
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name' => 'required|max:255'
        ];

        if($request->username != auth()->user()->username) {
            $rules['username'] = ['required', 'min:3', 'max:255', 'unique:users'];
        }

        if($request->email != auth()->user()->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if(!(Hash::check($request->password, auth()->user()->password))) {
            $rules['password'] = 'required|min:5|max:255';
        }

        $validatedData = $request->validate($rules);

        if(!(Hash::check($request->password, auth()->user()->password))) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        User::where('id', $request->id)
            ->update($validatedData);

        return redirect('/editProfile')->with('success', 'Profile has been updated!');
    }
}
