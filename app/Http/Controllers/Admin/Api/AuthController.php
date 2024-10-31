<?php
/**
 * File AuthController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App\Http\Controllers\Admin\Api;

use App\Http\Resources\UserResource;
use App\Laravue\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Laravue\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 */
class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ],
        [
            'token.required' => 'Введите токен',
        ]
        );
        return true;
    }


    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()
                ->json(new JsonResponse([], 'login_error'), Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();

        return response()->json(new JsonResponse(new UserResource($user)), Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user -> active = true;
        $user->save();
        $role = Role::firstOrCreate(['name' => 'manager']);
        $user->assignRole($role);
        return response()->json(new JsonResponse(new UserResource($user)), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return response()->json((new JsonResponse())->success([]), Response::HTTP_OK);
    }

}
