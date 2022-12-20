<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\CharactersResource;
use App\Http\Requests\StoreCharacterRequest;

use App\Models\Character;


class CharactersController extends Controller
{
    
    public function show(Request $request)
    {

        try {

            $page = $request->has('page') ? $request->get('page') : 5;
            $data = CharactersResource::collection(Character::paginate($page));

            return response()->json(['code' => 200, 'data' => $data], 200);

        } catch (Throwable $e) {

            return response()->json(['code' => 500, 'message' => $e->getMessage()]);

        }

    }

    public function search(Request $request)
    {
        try{

            $type = $request->get('type');

            if ( $type == 'name' ) {
                $character = Character::where('name', '=', $request->param)->get();
            } 
            else if ( $type == 'gender' ) {
                $character = Character::where('gender', '=', $request->param)->get();  
            }
            else {
                return response()->json(['code' => 400, 'message' => 'The param type is required.!'], 400);
            }

            return response()->json(['code' => 200, 'data' => $character], 200);

        } catch (Throwable $e) {

            return response()->json(['code' => 500, 'message' => $e->getMessage()]);

        }
    }

    public function create(Request $request)
    {
        try {

             $validator = Validator::make($request->all(), [
                'name' => 'required|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages());
            }

            $character = Character::create([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'gender' => $request->gender
            ]);

            return response()->json(['code' => 201, 'data' => $character], 201);

        } catch (Throwable $e) {

            return response()->json(['code' => 500, 'message' => $e->getMessage()]);

        }
    }

    public function update(Request $request, $id)
    {
        try {

            $character = Character::find($id);

            $dataUpdate = [
                'name' => $request->has('name') ? $request->name : $character->name,
                'birthday' => $request->has('birthday') ? $request->birthday : $character->birthday,
                'gender' => $request->has('gender') ? $request->gender : $character->gender
            ];

            $character->update($dataUpdate);

            return response()->json(['code' => 200, 'data' => $character], 200);

        } catch (Throwable $e) {

            return response()->json(['code' => 500, 'message' => $e->getMessage()]);

        }

    }

    public function remove($id)
    {
        try{

            $character = Character::find($id);
            $character->delete();

            return response()->json(['code' => 200, 'message' => 'Character was deleted successfully!'], 200);

        } catch (Throwable $e) {

            return response()->json(['code' => 500, 'message' => $e->getMessage()]);

        }
    }

}
