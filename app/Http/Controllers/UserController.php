<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $atributes = request()->validate([
            'name' => 'required|min:3',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'required|email'
        ]);

        if(request('image') != NULL){
            if($user->image != NULL){
                $usertImage = public_path("images/users/{$user->image}"); // get previous image from folder
                unlink($usertImage); // unlink or remove previous image from folder
            }
            $imageName = time().'_'.request()->image->getClientOriginalName();
            request()->image->move(public_path('images/users'), $imageName);
        }else{
            $imageName = $user->image;
        }
        $user->update([
            'name'=> request('name'),
            'image'=> $imageName,
            'email'=> request('email'),
            'date_of_birth'=> request('date_of_birth')
        ]);
        

        //creating log of update user
        DB::table('log')->insert ([
            ['description' => 'Updated user '. request('name')  .' ' , 'updated_at' => date('Y-m-d H:i:s')]
        ]);

        $request->session()->flash('status', 'User edit was successful!');
        return redirect('/user/'.$user->id.'');
    }

}
