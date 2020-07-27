<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        return view('profiles/index', ['user' => $user]);
    }

    public function edit(User $user)
    {
        //$this->authorize('update', $user->profile);

        return view('profiles/edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        //$this->authorize('update', $user->profile);

        $data = request()->validate([
            'name' => 'required',
            'image' => ''
        ]);

        if(request('image'))
        {
            $imagePath = request('image')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
        }

        auth()->user()->profile->update(array_merge([
            $data,
            ['image' => $image]
        ]));

        return redirect("/profile/{$user->id}");
    }
}