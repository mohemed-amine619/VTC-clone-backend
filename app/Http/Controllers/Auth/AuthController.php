<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendEmailEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }
        $field = $request->all();
        $user = User::where('email', $field['email'])->first();
        if (!$user || !Hash::check($field['password'], $user->password)) {
            return response([
                'errors' => [
                    'email or password Not Correct',
                ],
            ], 401);
        }

        $token = $user->createToken(env('SECRET_TOKEN_KEY'));
        $accessToken = $token->plainTextToken;

        return response([
            'user' => $user,
            'token' => $accessToken,
            'message' => 'You are Logged in'
        ]);
    }

    public function register(Request $request)
    {
        $field = $request->all();

        $error = Validator::make($field, [
            'name' => 'required',
            'password' => 'required|min:6|max:255',
            'email' => 'required|email|unique:users,email'
        ]);

        if ($error->fails()) {
            return response([
                'errors' => $error->errors()->all(),
            ], 422);
        }
        $user = User::create([
            'name' => $field['name'],
            'email' => $field['email'],
            'is_valid_email' => User::Is_Invalid_email,
            'otp_code' => User::generateOTP(8),
            'password' => Hash::make($field['password']),
            'role' => User::Customer_Role 
        ]);
        /*  Event Sending the Email */
        SendEmailEvent::dispatch($user);
        return response(['message' => 'Your account Has Been created with success'], 200);
    }
    public function updateRole(Request $request)
    {
        DB::table('users')->where('id' , $request->userId)->update(['role' => $request->role]);
        return response(['message' => 'role updated Successfuly'] , 200);
    }
    public function ValidateUserEmail(Request $request)
    {
        $error = Validator::make($request->all(), [
            'email' => 'required',
            'otp_code' => 'required'
        ]);
        if ($error) {
            if ($error->fails()) {
                return response([
                    'errors' => $error->errors()->all(),
                ], 422);
            }
        }
        $email = $request->email ?? null;
        $otp_code = $request->otp_code ?? null;
        $user = User::where('email', $email)->first();
        if ($request->all()) {
            if ($user->otp_code != null) {
                if ($user->otp_code == $otp_code) {
                    $user->where('email', $email)->update([
                        'is_valid_email' => User::Is_Valid_email
                    ]);
                    $token = $user->createToken(env('SECRET_TOKEN_KEY'));
                    $accessToken = $token->plainTextToken;
                    return response([
                        'message' => 'you are email Has Been Validated',
                        'user' => $user
                    ], 200);
                } else {
                    return response([
                        'message' => 'invalid code',
                        'user' => $user
                    ], 200);
                }
            } else {
                return response([
                    'message' => 'user not found',
                    'user' => $user
                ], 200);
            }
        }
    }
    public function getUsers(Request $request)
    {
        $data = DB::table('users')->select('id', 'name', 'email', 'role')->where('name', 'Like', '%'.$request->params.'%')
            ->orWhere('email', 'Like', '%' . $request->params . '%')->orderBy('created_at','DESC')
            ->paginate(10);
        return response($data, 200);
    }
    public function logout(Request $request)
    {
        DB::table('personal_access_tokens')
            ->where('tokenable_id', $request->userId)
            ->delete();
        return response([
            'message' => 'User Logged Out'
        ]);
    }
}
