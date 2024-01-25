<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Exceptions\GlobalException;
use App\Exceptions\PDPException;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

class AddressController extends Controller
{    
    /**
     *  @ all country list
     *
     * @return void
     */
    public function country()
    {
        try {
            DB::beginTransaction();
            $country = Country::get();
            return response()->json([
                'results' => $country
           ],200);
            // return view('master.city.index', compact('country'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new PDPException($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            throw new GlobalException($e->getMessage());
        }
    }
    
    /**
     *  @ add new company addCountry
     *
     * @param  mixed $request
     * @return void
     */
    public function addCountry(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:countries,name',
                'abbreviation' => 'required',
                'dial_code' => 'required',
                'flag' => 'required',
            ]);

            DB::beginTransaction();

            Country::create([
                'name' => $request->name,
                'abbreviation' => $request->abbreviation,
                'dial_code' => $request->dial_code,
                'flag' => $request->flag,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => "Country added successfully!"
            ], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 422,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GlobalException($e->getMessage());
        }
    }
    
    /**
     * editCountry
     *
     * @param  mixed $id
     * @return void
     */
    public function editCountry(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $country = Country::where('id',$id)->first();
            DB::commit();
            $apiMethod = in_array(config('constants.get_action.api'),$request->route()->getAction('middleware'));
            if($apiMethod){
                return response()->json([
                    'status' => 200,
                    'result' => $country
                ],200);
            }else{
                return view('dashboard',compact('country'));
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new PDPException($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            throw new GlobalException($e->getMessage());
        }
    }
    
    /**
     * updateCountry
     *
     * @param  mixed $id
     * @return void
     */
    public function updateCountry(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'abbreviation' => 'required',
                'dial_code' => 'required',
                'flag' => 'required',
            ]);
            DB::beginTransaction();
            Country::find($id)->update([
                'name' => $request->name,
                'abbreviation' => $request->abbreviation,
                'dial_code' => $request->dial_code,
                'flag' => $request->flag,
            ]);            
            DB::commit();
            return response()->json([
                'status' => 200,
                'results' => "Country update successfull!"
           ],200);
        }catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 422,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            throw new PDPException($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            throw new GlobalException($e->getMessage());
        }
    }
    
    /**
     * deleteCountry
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteCountry($id)
    {
        try {
            DB::beginTransaction();
            Country::Where('id',$id)->Delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'results' => "Country Delete successfull!"
           ],200);            
        } catch (Exception $e) {
            DB::rollBack();
            throw new PDPException($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            throw new GlobalException($e->getMessage());
        }
    }
}
