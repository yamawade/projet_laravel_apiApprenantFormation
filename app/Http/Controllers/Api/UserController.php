<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="registerUser",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="prenom", type="string"),
     *                 @OA\Property(property="date_naiss", type="string", format="date"),
     *                 @OA\Property(property="email", type="string", format="email"),
     *                 @OA\Property(property="password", type="string", format="password"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="User created successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
    */
    public function register(StoreRegister $request)
    {
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naiss' => $request->date_naiss,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Utilisateur créer avec succes',
            'user' => $user
        ]);
    }

    /**
 * @OA\Post(
 *     path="/api/login",
 *     operationId="loginUser",
 *     tags={"Authentication"},
 *     summary="User login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="string", format="email"),
 *                 @OA\Property(property="password", type="string"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=200, description="Successful login",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Salut Admin"),
 *             @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *             @OA\Property(property="authorization", type="object",
 *                 @OA\Property(property="token", type="string", example="your_access_token"),
 *                 @OA\Property(property="type", type="string", example="bearer"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Failed login",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Connexion échouée"),
 *         )
 *     ),
 * )
 */
    public function login(StoreLogin $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'message' => 'Connexion echouer',
            ], 401);
        }

        $user = Auth::user();
        if($user->role ==='admin'){
            return response()->json([
                'message' => 'Salut Admin',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        }else{

            return response()->json([
                'message' => 'Salut Candidat',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        }
       
    }

    /**
 * @OA\Post(
 *     path="/api/logout",
 *     operationId="logoutUser",
 *     tags={"Authentication"},
 *     summary="User logout",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response=200, description="Successful logout",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Déconnexion réussie"),
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated"),
 *         )
 *     ),
 * )
 */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Déconnexion réussi',
        ]);
    }

}
