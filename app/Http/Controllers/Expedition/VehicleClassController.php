<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

use Auth;
use Carbon\Carbon;
use App\Models\Expedition\VehicleClass;

class VehicleClassController extends Controller
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
      $vehicle_classes = VehicleClass::all();
      return view('main.expedition.vehicle_class.index')->withVehicleClasses($vehicle_classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('main.expedition.vehicle_class.create');
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
        'code' => 'required|min:2|max:2',
        'description' => 'required|min:3'
      ));

      $class = new VehicleClass;
      $class->code = strtoupper($request->code);
      $class->description = strtoupper($request->description);
      $class->created_by = $user->username;
      $class->save();

      return redirect()->back()->with('status-success','Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = VehicleClass::findOrFail($id);
      return view('main.expedition.vehicle_class.edit')->withData($data);
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

      $this->validate($request, array(
        'code' => 'required|min:2|max:2',
        'description' => 'required|min:3'
      ));

      $class = VehicleClass::findOrFail($id);
      $class->code = strtoupper($request->code);
      $class->description = strtoupper($request->description);
      $class->rstatus = 'AM';
      $class->updated_by = $user->username;
      $class->save();

      return redirect()->route('vehicle_classes.index')->with('status-success','Data berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::user();

      $class = VehicleClass::findOrFail($id);
      $class->rstatus = 'DL';
      $class->deleted_by = $user->username;
      $class->deleted_at = Carbon::now();
      $class->save();

      return redirect()->route('vehicle_classes.index')->with('status-success','Data berhasil dihapus.');
    }
}
