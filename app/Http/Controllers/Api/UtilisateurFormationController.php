<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UtilisateurFormation;
use Illuminate\Support\Facades\Auth;

class UtilisateurFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
 * @OA\Get(
 *     path="/api/listeCandidatures",
 *     operationId="getCandidatureList",
 *     tags={"Candidatures"},
 *     summary="Get the list of candidatures",
 *     @OA\Response(response=200, description="List of candidatures",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Liste des candidatures"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/UtilisateurFormation")
 *             ),
 *         )
 *     ),
 * )
 */
    public function index()
    {
        $listeCandidatures = UtilisateurFormation::all();
        return response()->json([
            'status_code'=>200,
            'status_message'=>'Liste des candidatures',
            'data'=>$listeCandidatures
        ]);
    }

    /**
 * @OA\Get(
 *     path="/api/listeCandidaturesAccepter",
 *     operationId="getCandidaturesAcceptees",
 *     tags={"Candidatures"},
 *     summary="Get the list of accepted candidatures",
 *     @OA\Response(response=200, description="List of accepted candidatures",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Liste des candidatures acceptées"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/UtilisateurFormation")
 *             ),
 *         )
 *     ),
 * )
 */
    public function listeCandidaturesAccepter(){
        $listeCandidatureAccepter = UtilisateurFormation::where('statut','accepter')->get();
        return response()->json([
            'status_code'=>200,
            'status_message'=>'Liste des candidatures acceptés',
            'data'=>$listeCandidatureAccepter
        ]);
    }

    /**
 * @OA\Get(
 *     path="/api/listeCandidaturesRefuser",
 *     operationId="getCandidaturesRefusees",
 *     tags={"Candidatures"},
 *     summary="Get the list of refused candidatures",
 *     @OA\Response(response=200, description="List of refused candidatures",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Liste des candidatures refusées"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/UtilisateurFormation")
 *             ),
 *         )
 *     ),
 * )
 */
    public function listeCandidaturesRefuser(){
        $listeCandidatureRefuser = UtilisateurFormation::where('statut','refuser')->get();
        return response()->json([
            'status_code'=>200,
            'status_message'=>'Liste des candidatures acceptés',
            'data'=>$listeCandidatureRefuser
        ]);
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
    /**
 * @OA\Post(
 *     path="/api/candidater/create",
 *     operationId="createCandidature",
 *     tags={"Candidatures"},
 *     summary="Create a new candidature",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="formation_id", type="integer", example=1),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=200, description="Candidature created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="La candidature a été effectuée"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/UtilisateurFormation"),
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthenticated",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated"),
 *         )
 *     ),
 *     @OA\Response(response=422, description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object", ref="#/components/schemas/ValidationError"),
 *         )
 *     ),
 * )
 */
    public function store(Request $request)
    {
        try{
            $user = Auth::user();
            //dd($user->id);
            $candidat = new UtilisateurFormation();
            $candidat->user_id=$user->id;
            $candidat->formation_id=$request->formation_id;
            if($candidat->save()){
                return response()->json([
                    'status_code'=>200,
                    'status_message'=>'La candidature a ete effectué',
                    'data'=>$candidat
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
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

    /**
 * @OA\Post(
 *     path="/api/accepterCandidature/{candidature}",
 *     operationId="acceptOrRejectCandidature",
 *     tags={"Candidatures"},
 *     summary="Accept or reject a candidature",
 *     @OA\Parameter(
 *         name="candidature",
 *         in="path",
 *         required=true,
 *         description="Candidature instance",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(response=200, description="Candidature status updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="La candidature a été acceptée/refusée"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/UtilisateurFormation"),
 *         )
 *     ),
 *     @OA\Response(response=404, description="Candidature not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Candidature not found"),
 *         )
 *     ),
 * )
 */
    public function accepter_refuser_candidature(UtilisateurFormation $candidature){
       // dd($candidature);
        if($candidature->statut ==='accepter'){
            $candidature->statut ='refuser';
            if($candidature->save()){
                return response()->json([
                    'status_code'=>200,
                    'status_message'=>'La candidature a ete refuser',
                    'data'=>$candidature
                ]);
            }
        }else{
            $candidature->statut ='accepter';
            if($candidature->save()){
                return response()->json([
                    'status_code'=>200,
                    'status_message'=>'La candidature a ete accepter',
                    'data'=>$candidature
                ]);
            }
        }
    }
}
