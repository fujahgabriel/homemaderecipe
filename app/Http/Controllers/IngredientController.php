<?php 

namespace App\Http\Controllers;

use Validator;

use App\Ingredient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class IngredientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

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
            'measure' => array('Regex:/^[A-Za-z0-9 ]+$/'),
            'supplier' => array('Regex:/^[A-Za-z0-9 ]+$/'),

        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->messages();
            $response['status'] = false;
        }
        else{
            //on_post, from_user, body
            $data['name'] = $request->name;
            $data['measure'] = $request->measure;
            $data['supplier'] = $request->supplier;
            $response['data'] = Ingredient::create( $data );
            $response['status'] = true;
        }
		
        

        return response()->json($response, 200);
		
    }
    
    public function all()
    {

        $data['data'] = Ingredient::paginate();
        if (count($data['data'])){
            $data['message'] = 'success';
            $data['status'] = true;
            return response()->json($data, 200);
        }
        else{
            $data['message'] = 'No data available';
            $data['status'] = false;
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
