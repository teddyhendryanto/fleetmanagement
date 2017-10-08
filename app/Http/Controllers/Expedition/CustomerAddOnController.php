<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Expedition\CustomerAddOn;

class CustomerAddOnController extends Controller
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
      $add_ons = CustomerAddOn::all();
      return view('main.expedition.customer_addon.index')->withAddOns($add_ons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('main.expedition.customer_addon.create');
    }

    public function getLastCounter(){
      $lastcounter = CustomerAddOn::select(DB::raw('isnull(max(counter),0) as counter'))
                                ->first();

  		$newcounter = $lastcounter->counter+1;

      return $newcounter;
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
        'name' => 'required|unique:customer_add_ons,customer_name',
      ));

      $counter = $this->getLastCounter();

      $add_on = new CustomerAddOn;
      $add_on->counter = $counter;
      $add_on->customer_code = 'A'.sprintf('%05d',$counter);
      $add_on->customer_name = strtoupper($request->name);
      $add_on->created_by = $user->username;
      $add_on->save();

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
      $data = CustomerAddOn::findOrFail($id);

      return view('main.expedition.customer_addon.edit')->withData($data);
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

      $add_on = CustomerAddOn::findOrFail($id);

      $this->validate($request, array(
        'name' => 'required|unique:customer_add_ons,customer_name,'.$add_on->id,
      ));

      $add_on->customer_name = strtoupper($request->name);
      $add_on->rstatus = 'AM';
      $add_on->updated_by = $user->username;
      $add_on->save();

      return redirect()->route('customer_addons.index')->with('status-success','Data berhasil diperbaharui.');
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

      $add_on = CustomerAddOn::findOrFail($id);
      $add_on->rstatus = 'DL';
      $add_on->deleted_by = $user->username;
      $add_on->deleted_at = Carbon::now();
      $add_on->save();

      return redirect()->route('customer_addons.index')->with('status-success','Data berhasil dihapus.');
    }
}
