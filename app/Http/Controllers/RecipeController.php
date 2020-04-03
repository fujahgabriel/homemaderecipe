<?php

namespace App\Http\Controllers;

use Validator;

use App\Recipe;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    //
    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'name' => array('Regex:/^[A-Za-z0-9 ]+$/'),
            'description' => array('Regex:/^[A-Za-z0-9 ]+$/'),

        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->messages();
            $response['status'] = false;
        }
        else{
            //on_post, from_user, body
            $data['name'] = $request->name;
            $data['description'] = $request->description;
            $data['ingredients'] = $request->ingredients;
            $response['data'] = Recipe::create( $data );
            $response['status'] = true;
        }
		
        

        return response()->json($response, 200);
		
    }
    
    public function all()
    {

        $data['data'] = Recipe::paginate();
        if (count($data) > 0 ){
            $data['message'] = 'success';
            $data['status'] = true;
            return response()->json($data, 200);
        }
        else{
            $data['message'] = 'No data available';
            return response()->json($data, 201);
        }
        
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request, $id)
	{
        $data = Ingredient::where('id',$id)->first();
        return response()->json($data, 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}
}
