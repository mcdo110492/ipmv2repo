<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\User;

class AuthenticateController extends Controller
{


    public function authenticate(Request $request)
    {
    	
        $credentials = $request->only('username', 'password');

        try {
            $where          = [ 'username' => $credentials['username'], 'password' => $credentials['password'], 'status' => 1 ];

            $user           = User::where('username',$where['username'])->get()->first();

            $role           = $user['role'];

            $project_id     = $user['project_id'];

            $customClaim    = compact('role','project_id');

            $profileName    = $user['profile_name'];

            $profilePic     = $user['profile_pic'];

            $status         = 200;

            


            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($where,$customClaim) )

            {

                return response()->json([ 'status' => 401,'error' => 'Invalid Credentials'], 200);

            }

        } catch (JWTException $e) {


            // If the token creation has an error.
            return response()->json([ 'status' => 500, 'error' => 'Token Creation Error'], 500);


        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token','profileName','profilePic','role','status','user_id'));
      

        
    }


    public function checkValidity ()

    {

        $status    = 200;
        return response()->json(compact('status'),200);

    }
}
