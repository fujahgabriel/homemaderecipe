<?php

namespace App\Http\Controllers;

use Validator;

use App\CustomerBox;
use App\Recipe;
use App\Ingredient;

use Illuminate\Http\Request;

class CustomerBoxController extends Controller
{
    //
    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function verify_recipe($data)
    
	{
        $errors = array();
		foreach($data as $key => $value){
            $response = Recipe::find($value['id']);
            if (count($response) == 0){
                array_push($errors, $value['id']);
            }
        }
        return $errors;
    }
    
    public function check_date($date)
    {
        $error['message'] = '';
        $current_date = date('Y-m-d');
        if($current_date > $date && date_diff(date_create($date),date_create($current_date))){
            $error['message'] = 'Error: Orders can only be delivered after 48hrs';
        }
        elseif($date < $current_date ){
            $error['message'] = 'Error: Please input an appropriate delivery date';
        }
        return $error['message'];
    }

    public function find_recipe($recipe){
        $all_recipes = array();
        $all_ingredients = array();
        $recipes= array();
        $result_length = count($recipe);
       
        foreach ($recipe as $key => $value) {
            $result = Recipe::find($recipe[$key], ['id', 'name', 'ingredients', 'description']);
            $result_length = count($result);
           //loop through recipes
       
            for ($i=0; $i<count($result); $i++){
                
                $new_result = array(
                    "id" => $result[$i]['id'],
                    "name" => $result[$i]['name'],
                    "description" => $result[$i]['description']
                );
                $recipes[$i]=array();
                array_push($recipes[$i],(object) $result[$i]);
                $recipes[$i]['ingredients']=array();
                foreach($result[$i]['ingredients'] as $k=>$ing ){
                    $_ingredients = $this->find_ingredients($ing['id']);
                    
                    $new_result['ingredients'][$k] = $_recipe=(object) array_merge($ing,$_ingredients);
                   
                }
               
            }
            
          
        }
        
        return $new_result;
    }

    public function find_ingredients($ingId){
     
        return $result = Ingredient::find($ingId, ['name', 'measure', 'supplier'])->toArray();
           
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'customer_name' => array('Regex:/^[A-Za-z0-9 ]+$/'),

        ]);
        $data['customer_name'] = $request->customer_name;
        $current_date = date('Y-m-d');
        $data['delivery_date'] = $request->delivery_date;
        $data['recipe'] = $request->recipe;

        if ($validator->fails()) {
            $response['message'] = $validator->messages();
            $response['status'] = false;
        }
        elseif ($this->check_date($data['delivery_date'])){
            $response['message'] = json_encode($this->check_date($data['delivery_date']));
            $response['status'] = false;
        }
        elseif(count($this->verify_recipe($data['recipe'])) > 0){
            $response['message'] = "Invalid recipe id" . json_encode($this->verify_recipe($data['recipe']));
            $response['status'] = false;
        }
        else{
            
            $response['data'] = CustomerBox::create( $data );
            $response['status'] = true;
        }
		
        

        return response()->json($response, 200);
		
    }
    
    public function all()
    {
        $final = array();
        $data['data'] = CustomerBox::paginate();
        if (count($data['data']) > 0 ){
            
            $response = $data['data'];
            foreach ($response as $key => $val) {
                $recipe = $response[$key]['recipe'];
                $recipe_result = $this->find_recipe($recipe);
                $response[$key]['recipe'] = $recipe_result;
                
                array_push($final, $response[$key]);
                
            }
            $data['data'] = $final;
            
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
	public function showByDate(Request $request, $date)
	{   

        $final = array();
        $data['data'] = CustomerBox::whereDate('created_at', $date)->get();
        //print_r($data['data']);
        if (count($data['data']) > 0 ){
           
            $response = $data['data'];
            foreach ($response as $key => $val) {
                $recipe = $response[$key]['recipe'];
                $recipe_result = $this->find_recipe($recipe);
                $response[$key]['recipe'] = $recipe_result;
                
                array_push($final, $response[$key]);
                
            }
            $data['data'] = $final;
    
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
