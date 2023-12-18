<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
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
    public function store(Request $request)
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
    public function update(Request $request,$id)
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
