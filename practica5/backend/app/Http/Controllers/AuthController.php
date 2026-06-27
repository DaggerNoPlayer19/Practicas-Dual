<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    private const TOKEN_ABILITY_SETS = [
        'read' => ['ver'],
        'write' => ['ver', 'crear', 'editar', 'eliminar'],
    ];

    private function resolveAbilities(?string $tokenType, ?array $abilities = null): array
    {
        if (is_array($abilities) && $abilities !== []) {
            $normalized = collect($abilities)
                ->map(fn ($ability) => trim((string) $ability))
                ->filter()
                ->unique()
                ->values()
                ->all();

            $invalid = array_diff($normalized, self::TOKEN_ABILITY_SETS['write']);

            if ($invalid !== []) {
                abort(422, 'Abilities invalidas: '.implode(', ', $invalid));
            }

            return $normalized;
        }

        return self::TOKEN_ABILITY_SETS[$tokenType ?? 'write'] ?? self::TOKEN_ABILITY_SETS['write'];
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'token_type' => ['nullable', Rule::in(array_keys(self::TOKEN_ABILITY_SETS))],
            'abilities' => ['nullable', 'array'],
            'abilities.*' => ['string'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);

        $abilities = $this->resolveAbilities($data['token_type'] ?? null, $data['abilities'] ?? null);
        $token = $user->createToken('auth-token', $abilities)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'abilities' => $abilities,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'token_type' => ['nullable', Rule::in(array_keys(self::TOKEN_ABILITY_SETS))],
            'abilities' => ['nullable', 'array'],
            'abilities.*' => ['string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $abilities = $this->resolveAbilities($credentials['token_type'] ?? null, $credentials['abilities'] ?? null);
        $token = $user->createToken('auth-token', $abilities)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'abilities' => $abilities,
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesion cerrada correctamente',
        ], 200);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
            'abilities' => $request->user()?->currentAccessToken()?->abilities ?? [],
        ], 200);
    }
}
