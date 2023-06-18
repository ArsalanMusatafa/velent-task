<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Velent\Enum\ResponseMessages;
use Velent\Helper\Helper;
use Velent\Repositories\User\UserInterface;
use Velent\Requests\User\UserCreateRequest;
use Velent\Requests\User\UserUpdateRequest;
use Velent\Resources\User\UserCollection;
use Velent\Resources\User\UserResource;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index']]);
        $this->user = app(UserInterface::class);
    }

    public function index(Request $request)
    {
        try {
            $params = Helper::defaultParams($request);
            $users = $this->user->getByParams($params);
            return $this->successResponse(new UserCollection($users), ResponseMessages::FOUND);
        } catch (\Throwable $exception) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . " " . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $user = $this->user->create($request->prepareRequest());
            if ($user) {
                return $this->successResponse(new UserResource($user), ResponseMessages::CREATE);
            }
            return $this->failureResponse(ResponseMessages::MESSAGE_500);
        } catch (\Throwable $exception) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . " " . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->user->getById($id);
            if ($user){
                return $this->successResponse(new UserResource($user), ResponseMessages::FOUND);
            }
            return $this->failureResponse(ResponseMessages::ERROR);
        } catch (\Throwable $exception){
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . " " . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UserUpdateRequest $request, $id){
        try {
            $user = $this->user->update($request->prepareRequest(), $id);
            if ($user){
                return $this->successResponse(new UserResource($user), ResponseMessages::UPDATED);
            }
            return $this->failureResponse(ResponseMessages::ERROR);
        } catch (\Throwable $exception){
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . " " . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id){
        try {
            $user = $this->user->getById($id);
            if ($user){
                $user->delete();
                return $this->successResponse([], ResponseMessages::DELETED);
            }
            return $this->failureResponse(ResponseMessages::ERROR);
        } catch (\Throwable $exception){
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . " " . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
