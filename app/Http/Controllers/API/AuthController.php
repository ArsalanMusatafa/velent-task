<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Library\Requests\User\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Velent\Enum\ResponseMessages;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        try {
            if (Auth::attempt($request->prepareRequest())){
                $user = Auth::user();
                return $this->successResponse([
                    'token' => $user->createToken('Velent')->plainTextToken,
                ]);
            }
            return $this->failureResponse(ResponseMessages::INVALID_CRED);
        } catch (\Throwable $exception){
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . " " . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
