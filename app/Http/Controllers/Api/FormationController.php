<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormationRequest;
use App\Http\Requests\UpdateFormationRequest;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
 * @OA\Get(
 *     path="/api/listeFormations",
 *     operationId="getFormationList",
 *     tags={"Formations"},
 *     summary="Get the list of formations",
 *     @OA\Response(response=200, description="List of formations",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Liste des formations"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/Formation")
 *             ),
 *         )
 *     ),
 * )
 */
    public function index()
    {
        $formation = Formation::all();
        return response()->json([
            'status_code'=>200,
            'status_message'=>'Liste des formations',
            'data'=>$formation
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
 *     path="/api/formation/create",
 *     operationId="createFormation",
 *     tags={"Formations"},
 *     summary="Create a new formation",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="nom_formation", type="string", example="Nom de la formation"),
 *                 @OA\Property(property="description", type="string", example="Description de la formation"),
 *                 @OA\Property(property="duree", type="integer", example=10),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=200, description="Formation created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="La formation a été ajoutée"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Formation"),
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
    public function store(StoreFormationRequest $request)
    {
        try{
            $formation = new Formation();
            $formation->nom_formation=$request->nom_formation;
            $formation->description=$request->description;
            $formation->duree=$request->duree;
            if($formation->save()){
                return response()->json([
                    'status_code'=>200,
                    'status_message'=>'La formation a ete ajouté',
                    'data'=>$formation
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
    /**
 * @OA\Post(
 *     path="/api/formation/update/{id}",
 *     operationId="updateFormation",
 *     tags={"Formations"},
 *     summary="Update an existing formation",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the formation to be updated",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="nom_formation", type="string", example="Nouveau nom de la formation"),
 *                 @OA\Property(property="description", type="string", example="Nouvelle description de la formation"),
 *                 @OA\Property(property="duree", type="integer", example=15),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=200, description="Formation updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="La formation a été modifiée"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Formation"),
 *         )
 *     ),
 *     @OA\Response(response=404, description="Formation not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Formation not found"),
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
    public function update(UpdateFormationRequest $request,$id)
    {
        try{
            $formation = Formation::FindorFail($id);
            $formation->nom_formation=$request->nom_formation;
            $formation->description=$request->description;
            $formation->duree=$request->duree;
            if($formation->update()){
                return response()->json([
                    'status_code'=>200,
                    'status_message'=>'La formation a ete modifier',
                    'data'=>$formation
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
 * @OA\Delete(
 *     path="/api/formation/{id}",
 *     operationId="deleteFormation",
 *     tags={"Formations"},
 *     summary="Delete an existing formation",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the formation to be deleted",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(response=200, description="Formation deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="La formation a été supprimée"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Formation"),
 *         )
 *     ),
 *     @OA\Response(response=404, description="Formation not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Formation not found"),
 *         )
 *     ),
 * )
 */
    public function destroy($id)
    {
        try{
            $formation = Formation::FindorFail($id);
            if($formation->delete()){
                return response()->json([
                    'status_code'=>200,
                    'status_message'=>'La formation a ete supprimer',
                    'data'=>$formation
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
