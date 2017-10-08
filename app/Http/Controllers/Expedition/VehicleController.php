<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

use Auth;
use Carbon\Carbon;
use App\Models\Expedition\VehicleClass;
use App\Models\Expedition\Vehicle;
use App\Models\Site;

class VehicleController extends Controller
{
    use GeneralTrait;
    
    public function __construct(){
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $sites = Site::all();
      $vehicle_classes = VehicleClass::all();
      return view('main.expedition.vehicle.index')
            ->withSites($sites)
            ->withVehicleClasses($vehicle_classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $sites = Site::all();
      $vehicle_classes = VehicleClass::all();
      return view('main.expedition.vehicle.create')
            ->withSites($sites)
            ->withVehicleClasses($vehicle_classes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = Auth::user();

      $this->validate($request, array(
        'site' => 'required',
        'vehicle_class' => 'required',
        'license_plate' => 'required|min:6|unique:vehicles'
      ));

      $vehicle = new Vehicle;
      $vehicle->site_id = $request->site;
      $vehicle->vehicle_class_id = $request->vehicle_class;
      $vehicle->license_plate = strtoupper($request->license_plate);
      $vehicle->created_by = $user->username;
      $vehicle->save();

      return redirect()->back()->with('status-success','Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $sites = Site::all();
      $vehicle_classes = VehicleClass::all();

      $site_id = $request->site;
      $vehicle_class_id = $request->vehicle_class;

      if($vehicle_class_id == 0){
        $vehicles = Vehicle::with('site','vehicle_class')->where('site_id',$site_id)->get();
      }
      else{
        $vehicles = Vehicle::with('site','vehicle_class')->where('site_id',$site_id)
                          ->where('vehicle_class_id',$vehicle_class_id)
                          ->get();
      }

      if(count($vehicles)>0){
        return view('main.expedition.vehicle.index')
              ->withSites($sites)
              ->withVehicleClasses($vehicle_classes)
              ->withVehicles($vehicles);
      }
      else{
        return redirect()->route('vehicles.index')->with('status-danger','Data tidak ditemukan.');
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $sites = Site::all();
      $vehicle_classes = VehicleClass::all();
      $vehicle = Vehicle::findOrFail($id);
      return view('main.expedition.vehicle.edit')
            ->withSites($sites)
            ->withVehicleClasses($vehicle_classes)
            ->withData($vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = Auth::user();

      $vehicle = Vehicle::findOrFail($id);

      $this->validate($request, array(
        'site' => 'required',
        'vehicle_class' => 'required',
        'license_plate' => 'required|min:6|unique:vehicles,license_plate,'.$vehicle->id
      ));

      $vehicle->site_id = $request->site;
      $vehicle->vehicle_class_id = $request->vehicle_class;
      $vehicle->license_plate = strtoupper($request->license_plate);
      $vehicle->rstatus = 'AM';
      $vehicle->updated_by = $user->username;
      $vehicle->save();

      if($vehicle){
        echo "
          <script>
            alert('Data berhasil diperbaharui.');
            window.close();
          </script>
        ";
      }
      else{
        echo "
          <script>
            alert('Data gagal diperbaharui.');
            window.close();
          </script>
        ";
      }
    }

    public function delete($id)
    {
      $user = Auth::user();

      $vehicle = Vehicle::findOrFail($id);
      $vehicle->rstatus = 'DL';
      $vehicle->deleted_by = $user->username;
      $vehicle->deleted_at = Carbon::now();
      $vehicle->save();

      if($vehicle){
        echo "
          <script>
            alert('Data berhasil dihapus.');
            window.close();
          </script>
        ";
      }
      else{
        echo "
          <script>
            alert('Data gagal dihapus.');
            window.close();
          </script>
        ";
      }
    }
}
