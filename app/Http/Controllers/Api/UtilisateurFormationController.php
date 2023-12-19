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
