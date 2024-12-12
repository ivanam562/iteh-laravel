<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductRating;
use App\Models\Provider;
use App\Models\Product;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if(auth()->user()->isAdmin())
        return new UserCollection(User::all());
    }
    public function show(User $user)
    {
        if(auth()->user()->isAdmin())
            return new UserResource($user);
    }
    public function update(Request $request, $id)
    {
        if(auth()->user()->id == $user->id || auth()->user()->isAdmin()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|max:50|email|unique:users,email,'.$user->id,
                'password' => 'required|string|regex:"^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $user->email_verified_at = now();
            $user->name =  $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return response()->json(['user' => $user, 'access_token' => $user->remember_token, 'token_type' => 'Bearer']);
        }

        return response()->json('You are not authorized to update someone');     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($user->id != auth()->user()->id && auth()->user()->isAdmin()) {
            $user->delete();
            return response()->json('User is deleted successfully.');
        }

        return response()->json('You do not have the privilege to delete user if you are not admin, nor to delete your own account.');
    }
}
