<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getMe(Request $request) {
        return $request->user();
    }
    public function searchUserByName(Request $request, string $query) {
        return User::whereLike('name', '%' . $query . '%')->limit(15)->get();
    }
}
