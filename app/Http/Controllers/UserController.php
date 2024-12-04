<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 'Lista korisnika';
    }
    public function show(User $user)
    {
        return 'Lista korisnika';
    }
    public function destroy($id)
    {
        if($user->id != auth()->user()->id && auth()->user()->isAdmin()) {
            $user->delete();
            return response()->json('User is deleted successfully.');
        }
        return response()->json('You do not have the privilege to delete user if you are not admin, nor to delete your own account.');
    }

}
