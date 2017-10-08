<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Expedition\Area;
use App\Models\Expedition\Cost;
use App\Models\Expedition\CostSetting;
use App\Models\Expedition\VehicleClass;

class CostSettingController extends Controller
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
      $vehicle_classes = VehicleClass::orderBy('description')->get();
      return view('main.expedition.cost_setting.index')->withVehicleClasses($vehicle_classes);
    }

    public function getCost(Request $request){
      $vehicle_class_id = $request->vehicle_class_id;
      $area_id = $request->area_id;

      $cost = Cost::where('vehicle_class_id', $vehicle_class_id)
                  ->where('area_id', $area_id)
                  ->first();

      if(!is_null($cost)){
        $output = array(
          'status' => true,
          'dataset' => $cost,
          'message' => 'Data Found'
        );
      }
      else{
        $output = array(
          'status' => false,
          'dataset' => null,
          'message' => 'Data Not Found'
        );
      }

      return response()->json($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $areas = Area::orderBy('area')->get();
      $customers = Customer::customer_union_addon();

      $vehicle_classes = VehicleClass::orderBy('description')->get();
      return view('main.expedition.cost_setting.create')
            ->withAreas($areas)
            ->withCustomers($customers)
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
        'customer' => 'required',
      ));

      $cost_setting = CostSetting::where('cost_id',$request->cost_id)
                          ->where('customer_code',$request->customer)
                          ->first();
      if(!is_null($cost_setting)){
        return redirect()->back()->with('status-danger','Data sudah pernah diinput.');
      }

      $cost_setting = new CostSetting;
      $cost_setting->vehicle_class_id = $request->vehicle_class;
      $cost_setting->cost_id = $request->cost_id;
      $cost_setting->customer_code = $request->customer;
      $cost_setting->cost1 = $this->nullRequestToFalse($request->cb_cost1);
      $cost_setting->cost2 = $this->nullRequestToFalse($request->cb_cost2);
      $cost_setting->cost3 = $this->nullRequestToFalse($request->cb_cost3);
      $cost_setting->cost4 = $this->nullRequestToFalse($request->cb_cost4);
      $cost_setting->cost5 = $this->nullRequestToFalse($request->cb_cost5);
      $cost_setting->cost6 = $this->nullRequestToFalse($request->cb_cost6);
      $cost_setting->created_by = $user->username;
      $cost_setting->save();

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
      $vehicle_classes = VehicleClass::all();

      $vehicle_class_id = $request->vehicle_class;
      $cost_settings = CostSetting::with(['cost','cost.vehicle_class'])
                        ->select([
                          'cost_settings.*',
                          'customers.customer_name',
                          'areas.area'
                        ])
                        ->leftJoin('costs','costs.id','cost_settings.cost_id')
                        ->leftJoin('areas','areas.id','costs.area_id')
                        ->leftJoin(DB::raw("(
                          select customer_code, customer_name
                          from customer_add_ons
                          where rstatus <> 'DL'
                          union all
                          select CODE as customer_code, NAME as customer_name
                          from STAGINGCPS.dbo.CUSTOMER
                          ) as customers"),'customers.customer_code','cost_settings.customer_code')
                        ->where('cost_settings.vehicle_class_id',$vehicle_class_id)
                        ->orderBy('areas.area')
                        ->get();

      if(count($cost_settings)>0){
        return view('main.expedition.cost_setting.index')
              ->withVehicleClasses($vehicle_classes)
              ->withCostSettings($cost_settings);
      }
      else{
        return redirect()->route('cost_setting.index')->with('status-danger','Data tidak ditemukan.');
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
      $areas = Area::orderBy('area')->get();
      $customers = Customer::customer_union_addon();
      $vehicle_classes = VehicleClass::orderBy('description')->get();

      $data = CostSetting::with('cost')->findOrFail($id);
      return view('main.expedition.cost_setting.edit')
            ->withAreas($areas)
            ->withCustomers($customers)
            ->withData($data)
            ->withVehicleClasses($vehicle_classes);
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

      $cost_setting = CostSetting::findOrFail($id);
      $cost_setting->cost1 = $this->nullRequestToFalse($request->cb_cost1);
      $cost_setting->cost2 = $this->nullRequestToFalse($request->cb_cost2);
      $cost_setting->cost3 = $this->nullRequestToFalse($request->cb_cost3);
      $cost_setting->cost4 = $this->nullRequestToFalse($request->cb_cost4);
      $cost_setting->cost5 = $this->nullRequestToFalse($request->cb_cost5);
      $cost_setting->cost6 = $this->nullRequestToFalse($request->cb_cost6);
      $cost_setting->rstatus = 'AM';
      $cost_setting->updated_by = $user->username;
      $cost_setting->save();

      if($cost_setting){
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

      $cost_setting = CostSetting::findOrFail($id);
      $cost_setting->rstatus = 'DL';
      $cost_setting->deleted_by = $user->username;
      $cost_setting->deleted_at = Carbon::now();
      $cost_setting->save();

      if($cost_setting){
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
