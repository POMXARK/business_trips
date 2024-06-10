<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер авторизации.
 */
class AuthController
{
    #[OAT\Post(
        path: '/v1/tokens/create',
        description: 'Аутентификация в системе',
        summary: 'Аутентификация в системе',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(
                    properties: [
                        new OAT\Property(
                            property: 'email',
                            description: 'Email',
                            type: 'string',
                            example: 'test@example.com',
                        ),
                        new OAT\Property(
                            property: 'password',
                            description: 'Пароль',
                            type: 'string',
                            example: '123456789',
                        ),
                    ],
                    type: 'object',
                ),
            ),
        ),
        tags: ['Пользователи'],
        responses: [
            new OAT\Response(
                response: Response::HTTP_OK,
                description: 'OK',
                headers: [
                    new OAT\Header('Content-Type', 'application/json'),
                    new OAT\Header('Access-Control-Allow-Origin', '*'),
                ],
                content: new OAT\JsonContent()
            ),
        ]
    )]
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
