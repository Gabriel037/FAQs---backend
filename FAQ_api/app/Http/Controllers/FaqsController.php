<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class FaqsController extends Controller
{
    //
     // Utilizado para listar todos os recursos ex: get All
     public function index() {
        try {

            $faqs = DB::table('faqs')
            ->select('id', 'type','question', 'response')
            ->orderBy('id', 'asc')
            ->get();

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Faqs obtidas com sucesso!',
                'data' => $faqs
            ]);

        } catch(Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage()
            ], 400);
        }
    }
    // Função que mostra somente um faq
    public function show($id) {
        try {
            $faq = Faq::find($id);
            if($faq) {
                return response()->json([
                    'status' => 'Secesso',
                    'message' => 'Faq obtido com sucesso',
                    'item' => $faq
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Faq não encontrada',
            ], 404);


        } catch(Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage()
            ], 400);
        }

    }

    // Função para criar uma faq
    public function store(Request $request) {
        try {
            $faq = new Faq();
            
            $faq->type = $request->type;
            $faq->question = $request->question;
            $faq->response = $request->response;

            // validator
            $validator = Validator::make($request->all(), [
                'question' => 'required',
                'response' => 'required|string|min:6',
            ]);

            // Check if there is error in validator
            if($validator->fails()){

                // Return JSON with errors
                return response()->json([
                    'status'=> 'error', 
                    'message' => $validator->errors()
                ],400);
            }

            try {
                if($faq->save()) {
                    return response()->json([
                        'status' => 'Sucesso',
                        'message' => 'Faq cadastrado com sucesso',
                    ], 200);
                }
            } catch(Exception $error) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Não foi possível cadastrar esta faq',
                    'error' => $error->getMessage()
                ], 400);

            }

        } catch(Exception $error) {
            return response()->json([
                'status' => 'Error',
                'message' => $error->getMessage()
            ], 400);
        }

    }
    //Função para atualizar faq
    public function updated(Request $request, $id) {
        try {
            $faq = Faq::find($id);
            if($faq) {
                if($request->type) $faq->response = $request->type;
                if($request->question) $faq->question = $request->question;
                if($request->response) $faq->response = $request->response;
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Faq não localizada',
                ], 400);
            }

            if($faq->save()) {
                return response()->json([
                    'status' => 'Sucesso',
                    'message' => 'Faq atualizado com sucesso',
                ], 200);
            }

        } catch(Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage()
            ], 400);
        }
    }

    //Função para excluir Faqo
    public function destroy($id) {
        try {
            $faq = Faq::find($id);
            if(!$faq) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Faq não encontrada'
                ], 404 );
            }

            if($faq->delete()) {
                return response()->json([
                    'status' => 'Sucesso',
                    'messge' => 'Faq excluído com sucesso'
                ], 200);
            }

        } catch(Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage()
            ], 400);
        }
    }
}
