<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use Illuminate\Support\Facades\Validator;

class productsController extends Controller
{

    // Afficher les produits

    public function getProducts(){

        $products = products::all();

        foreach ($products as $product) {

            return response([
                'code' => '200',
                'message' => 'success',
                'data' => $products
            ], 200);

        }

        return response([
            'code' => '004',
            'message' => 'La table est vide',
            'data' => null
        ], 201);

    }

    // Afficher l'image du produits
    
    public function image($fileName){
        
        return response()->download(public_path('/products/images/' . $fileName));

    }


    // Consulter ou afficher un produit 

    public function getProduit($id){

        $product = products::find($id);

        if (!$product) {
            
            return response([
                'code' => '004',
                'message' => 'L\'identifiant incorrect',
                'data' => null
            ], 201);
            
        }else {
        
            return response([
                'code' => '200',
                'message' => 'success',
                'data' => $product
            ], 200);

        }

    }


    // Creer un produit

    public function createProduct(Request $request){


        $product = $request->all();

        $validator = Validator::make($product, [
            
            'name_product' => 'required|unique:products|max:100|regex:/[^0-9.-]/',
            'description' => 'required|unique:product|regex:/[^0-9.-]/',
            'price' => 'required|int',
            'categories_id' => 'required|int',
        ]);

        if ($validator->fails()) {

            $erreur = $validator->errors();
            
            return response([
                'code' => '001',
                'message' => 'L\'un des champs est vide ou ne respecte pas le format',
                'data' => $erreur
            ], 200);

        }else {

            $product = products::create($product);

            if ($product) {

                return response([
                    'code' => '200',
                    'message' => 'success',
                    'data' => $product,
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

    public function putProduct(Request $request, $id)
    {

        $identifiant = products::findOrFail($id);

        $product = $request->all();

        if ($identifiant == null) {

            return response([
                'code' => '004',
                'message' => 'Identifiant incorrect',
                'data' => $erreur
            ], 201);

        } else {

            $validator = Validator::make($product, [
                'name_product' => 'required|unique:products|max:100|regex:/[^0-9.-]/',
                'description' => 'required|unique:product|regex:/[^0-9.-]/',
                'price' => 'required|int',
                'categories_id' => 'required|int',
            ]);
    
            if ($validator->fails()) {
    
                $erreur = $validator->errors();
            
                return response([
                    'code' => '001',
                    'message' => 'L\'un des champs est vide ou ne respecte pas le format',
                    'data' => $erreur
                ], 200);
    
            }else {

                $product = $identifiant->update($product);

                if ($product) {

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
    }

    
    // Creer ou modifier l'image du produit

    public function createImage(Request $request){

        $image = $request->all();

        $validator = Validator::make($request->all(), [
            
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'annonces_id' => 'required'
        ]);

        if ($validator->fails()) {

            $erreur = $validator->errors();
            
            return response([
                'code' => '001',
                'message' => 'L\'un des champs est vide ou ne respecte pas le format',
                'data' => $erreur
            ], 200);

        }else {

            if ($file = $request->file('image')) {

                $fileName = $file->getClientOriginalName();

                $path = $file->move(public_path("/annonceImages/images/"), $fileName);

                $photoURL = url('/products/images/'.$fileName);

                $image['image'] = $fileName;

                $productsI = products::create($image);

                if ($productsI) {

                    return response([
                        'code' => '200',
                        'message' => 'success',
                        'data' => $productsI,
                        'url' => $photoURL
                    ], 200);

                }else {

                    return response([
                        'code' => '005',
                        'message' => 'Echec lors de l\'operation',
                        'data' => null
                    ], 201);

                }

            }else {

                return response([
                    'code' => '001',
                    'message' => 'image nulle',
                    'data' => null
                ], 201);
                
            }
        }

    }



    // Supprimer un produit
    
    public function deleteProduct($id){

        $delete = products::findOrFail($id)->delete();

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


