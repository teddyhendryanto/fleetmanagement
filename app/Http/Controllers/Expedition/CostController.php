<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

use Auth;
use Carbon\Carbon;
use App\Models\Expedition\Area;
use App\Models\Expedition\Cost;
use App\Models\Expedition\VehicleClass;

class CostController extends Controller
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
      $costs = Cost::with('area','vehicle_class')
                    ->orderBy('area_id')
                    ->orderBy('vehicle_class_id')
                    ->get();
      return view('main.expedition.cost.index')->withCosts($costs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $areas = Area::orderBy('area')->get();
      $vehicle_classes = VehicleClass::orderBy('description')->get();
      return view('main.expedition.cost.create')
            ->withAreas($areas)
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
        'vehicle_class' => 'required',
        'area' => 'required',
      ));

      $cost = Cost::where('area_id',$request->area)
                  ->where('vehicle_class_id',$request->vehicle_class)
                  ->first();
      if(!is_null($cost)){
        return redirect()->back()->with('status-danger','Data sudah pernah diinput.');
      }

      $cost = new Cost;
      $cost->area_id = $request->area;
      $cost->vehicle_class_id = $request->vehicle_class;
      $cost->cost1 = $request->cost1;
      $cost->cost2 = $request->cost2;
      $cost->cost3 = $request->cost3;
      $cost->cost4 = $request->cost4;
      $cost->cost5 = $request->cost5;
      $cost->cost6 = $request->cost6*-1;
      $cost->total_cost = round(($request->cost1+$request->cost2+$request->cost3+$request->cost4+$request->cost5-$request->cost6)/1000)*1000;
      $cost->created_by = $user->username;
      $cost->save();

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
      $areas = Area::orderBy('area')->get();
      $vehicle_classes = VehicleClass::orderBy('description')->get();

      $data = Cost::findOrFail($id);
      return view('main.expedition.cost.edit')
            ->withAreas($areas)
            ->withVehicleClasses($vehicle_classes)
            ->withData($data);
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

      $cost = Cost::findOrFail($id);
      $cost->cost1 = $request->cost1;
      $cost->cost2 = $request->cost2;
      $cost->cost3 = $request->cost3;
      $cost->cost4 = $request->cost4;
      $cost->cost5 = $request->cost5;
      $cost->cost6 = $request->cost6*-1;
      $cost->total_cost = round(($request->cost1+$request->cost2+$request->cost3+$request->cost4+$request->cost5-$request->cost6)/1000)*1000;
      $cost->rstatus = 'AM';
      $cost->updated_by = $user->username;
      $cost->save();

      return redirect()->route('costs.index')->with('status-success','Data berhasil diperbaharui.');
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

      $cost = Cost::findOrFail($id);
      $cost->rstatus = 'DL';
      $cost->deleted_by = $user->username;
      $cost->deleted_at = Carbon::now();
      $cost->save();

      return redirect()->route('vehicle_classes.index')->with('status-success','Data berhasil dihapus.');
    }
}
