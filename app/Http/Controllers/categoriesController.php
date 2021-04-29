<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;
use Illuminate\Support\Facades\Validator;

class categoriesController extends Controller
{
    
    // Afficher les categories

    public function getCategories(){

        $categories = categories::all();

        foreach ($categories as $categorie) {

            return response([
                'code' => '200',
                'message' => 'success',
                'data' => $categories
            ], 200);

        }

        return response([
            'code' => '004',
            'message' => 'La table est vide',
            'data' => null
        ], 201);

    }
    

    // Consulter ou afficher une categorie

    public function getCategory($id){

        $categorie = categories::find($id);

        if (count($categorie) == 0) {
            
            return response([
                'code' => '500',
                'message' => 'L\'identifiant incorrect',
                'data' => null
            ], 201);
            
        }else {
        
            return response([
                'code' => '200',
                'message' => 'success',
                'data' => $categorie
            ], 200);

        }

    }


    // Creer une categorie

    public function createCategory(Request $request){

        $categorie = $request->all();

        $validator = Validator::make($categorie, [
            'name_category' => 'required|unique:categories|max:200|regex:/[^0-9.-]/'
        ]);

        if ($validator->fails()) {

            $erreur = $validator->errors();
            
            return response([
                'code' => '001',
                'message' => 'L\'un des champs est vide ou ne respecte pas le format',
                'data' => $erreur
            ], 200);

        }else {

            $cat = categories::create($categorie);

            if ($cat) {

                return response([
                    'code' => '200',
                    'message' => 'success',
                    'data' => $cat,
                ], 200);

            }else {

                return response([
                    'code' => '005',
                    'message' => 'Echec lors de l\'operation',
                    'data' => null
                ], 201);

            }

        }

    }



    // Modifier une categorie

    public function putCategory(Request $request, $id)
    {

        $categorie = $request->all();

        $identifiant = categories::findOrFail($id)->first();

            $validator = Validator::make($categorie, [
                'name_category' => 'required|uniques:categories|max:100|regex:/[^0-9.-]/'
            ]);
    
            if ($validator->fails()) {
    
                $erreur = $validator->errors();
            
                return response([
                    'code' => '001',
                    'message' => 'L\'un des champs est vide ou ne respecte pas le format',
                    'data' => $erreur
                ], 200);
    
            }else {

                $cat = $identifiant->update($categorie);

                if ($cat) {

                    return response([
                        'code' => '200',
                        'message' => 'success',
                        'data' => $identifiant,
                    ], 200);

                }else {

                    return response([
                        'code' => '005',
                        'message' => 'Erreur 005 : Echec lors de l\'operation',
                        'data' => null
                    ], 201);
                    
                }
                
            }

    }


    // Supprimer une categorie
     
    public function deleteCategory($id){

        $delete = categories::findOrFail($id)->delete();

        if ($delete) {

            return response([
                'code' => '200',
                'message' => 'Suppression effectuée avec succes',
                'data' => null
            ], 200);

        } else {

            return response([
                'code' => '004',
                'message' => 'L\'identifiant incorrect',
                'data' => null
            ], 201);

        }

    }

}
