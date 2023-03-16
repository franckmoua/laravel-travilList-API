<?php

namespace App\Http\Controllers;


use App\Models\Place;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PlaceController extends Controller
{
    private $validation_rules = [
        'name' => 'required|max:255',
        'lat' =>'required|numeric',
        'lng' => 'required|numeric',
        'visited' => 'required|numeric'
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
  public function index($id)
  {
    $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
    
    try {
        $this->response['results'] = Place::all();
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
      return response()->json($this->response);
    // $places = Place::all($id);
    // return response()->json($places);
  }

  public function create(Request $request, $id)
  {
    $place = new Place($id);
    $place->name = $request->name;
    $place->lat = $request->lat;
    $place->lng = $request->lng;
    $place->save();

    return response()->json($place);
  }

  public function show($id)
  {
    $place = Place::find($id);
    return response()->json($place);
  }

  public function update(Request $request, $id)
  {
    $place = Place::find($id);
    $place->name = $request->name;
    $place->lat = $request->lat;
    $place->lng = $request->lng;
    $place->location_id = $request->$id;
    $place->visited = 0;
    $place->save();

    return response()->json($place);
  }

//   public function update(Request $request, $id)
//   {
//     $this->validation_rules[$id] = 'required|numeric';
//     $validator = $this->getValidationFactory()->make($request->all(), $this->validation_rules);
//     if ($validator->fails()) {
//       $this->response['status'] = 422;
//       $this->response['message'] = $validator->errors();
//     } else {
//       try {
//         $name = $request->name;
//         $slug = Str::slug($name, '-');
//         $location = Location::find($id);
//         $location->name = $name;
//         $location->lat = $request->lat;
//         $location->lng = $request->lng;
//         $location->slug = $slug;
//         if ($location->save()) {
//           $this->response['message'] = 'location data has been successfully updated!';
//         } else {
//           $this->response['status'] = 500;
//           $this->response['message'] = 'location data failed to update!';
//         }
//       } catch (\Throwable $th) {
//         $this->response['status'] = 500;
//         $this->response['message'] = $th->getMessage();
//       }
//     }

//     return response()->json($this->response);
//     // $name = $request->name;
//     // $slug = Str::slug($name, '-');
//     // $location = Location::find($id);
//     // $location->name = $name;
//     // $location->lat = $request->lat;
//     // $location->lng = $request->lng;
//     // $location->slug = $slug;
//     // $location->save();

//     // return response()->json($location);
//   }

  public function destroy($id)
  {
    $place = Place::find($id);
    $place->delete();

    return response()->json('place removed successfully');
  }
}