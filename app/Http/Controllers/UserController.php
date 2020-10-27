<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO paginate user list
        //TODO add search,sort and filter to user list
        $users = User::all();
        return jsend_success($users);
    }

    /**
     * Get details of a single user
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        //return 404 if the user is not found
        if(!$user){
            return jsend_fail(['message' => 'User  not found'],404);
        }
        return jsend_success($user);
    }

    /**
     * Update a users details
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        //return 404 if the user is not found
        if(!$user){
            return jsend_fail(['message' => 'User  not found'],404);
        }
        //update the user
        $data = $request->only('name'); // Limit  updates to only the name for now
        $user->update($data);
        $user = User::find($user_id); //retrieve an updated user
        return jsend_success($user);
    }

    /**
     * Delete a user
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $user = User::find($user_id);
        if(!$user){
            return jsend_fail(['message' => 'User  not found'],404);
        }
        $deleted = $user->delete();
        if($deleted){
            return jsend_success([
                'message' => 'User successfully deleted',
            ], 201);
        }else{
            return jsend_error("User not found",404);
        }
    }
}
