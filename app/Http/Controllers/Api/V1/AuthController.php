<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController
{
    /**
     * @OA\Post(
     *     path="/v1/tokens/create",
     *     summary="Аутентификация в системе",
     *     tags={"Пользователи"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                  property="email",
     *                  description="Email",
     *                  type="string",
     *                  example="test@example.com",
     *               ),
     *               @OA\Property(
     *                  property="password",
     *                  description="Пароль",
     *                  type="string",
     *                  example="123456789",
     *               )
     *           )
     *       )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Успешная операция",
     *          @OA\JsonContent()
     *     )
     * )
     */
    public function token(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        /* @var User $user */
        $user = User::query()->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        return response()->json(['data' => ['token' => $user->createToken($user->email)->plainTextToken]]);
    }
}
