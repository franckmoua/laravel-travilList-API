<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;
class LocationController extends Controller
{
  private $validation_rules = [
    'name' => 'required|max:255',
    'lat' =>'required',
    'lng' => 'required'
  ];

  private function basic_response()
  {
    return [
      'timestamp' => Carbon::now()->toDateTimeString(),
      'status' => 200,
      // 'error' => '',
      'message' => '',
      'results' => []
    ];
  }

  private $response = [];

  public function __construct()
  {
    $this->response = $this->basic_response();
  }
  public function index()
  {
    try {
      $this->response['results'] = Location::all();
    } catch (\Throwable $th) {
      $this->response['status'] = 500;
      $this->response['message'] = $th->getMessage();
    }
    return response()->json($this->response);
    // $locations = Location::all();
    // return response()->json($locations);
  }

  public function create(Request $request)
  {
    $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);
    if ($validator->fails()) {
      $this->response['status'] = 422;
      $this->response['message'] = $validator->errors();
    } else {
      try {
        $name = $request->name;
        $slug = Str::slug($name, '-');
        $location = new Location();
        $location->name = $name;
        $location->lat = $request->lat;
        $location->lng = $request->lng;
        $location->slug = $slug;
        if ($location->save()) {
          $this->response['message'] = 'location data saved successfully!';
        } else {
          $this->response['status'] = 500;
          $this->response['message'] = 'location data failed to save!';
        }
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
    }
    return response()->json($this->response);
    // $name = $request->name;
    // $slug = Str::slug($name, '-');
    // $location = new Location();
    // $location->name = $name;
    // $location->lat = $request->lat;
    // $location->lng = $request->lng;
    // $location->slug = $slug;
    // $location->save();

    // return response()->json($location);
  }

  public function show($id)
  {
    $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
    if ($validator->fails()) {
      $this->response['status'] = 422;
      $this->response['message'] = $validator->errors();
    } else {
      try {
        $this->response['results'] = Location::find($id);
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
    }
    return response()->json($this->response);
    // $location = Location::find($id);
    // return response()->json($location);
  }


  public function destroy($id)
  {
    $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
    if ($validator->fails()) {
      $this->response['status'] = 422;
      $this->response['message'] = $validator->errors();
    } else {
      try {
        $location = Location::find($id);
        if ($location->delete()) {
          $this->response['message'] = 'location data removed successfully!';
        } else {
          $this->response['status'] = 500;
          $this->response['message'] = 'location data failed to remove!';
        }
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
    }

    return response()->json($this->response);
    // $location = Location::find($id);
    // $location->delete();

    // return response()->json('location removed successfully');
  }
}