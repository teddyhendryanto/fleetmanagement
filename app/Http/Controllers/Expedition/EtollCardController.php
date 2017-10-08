<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

use Auth;
use Carbon\Carbon;
use App\Models\Expedition\EtollCard;
use App\Models\Expedition\Employee;
use App\Models\Expedition\Vehicle;
use App\Models\Site;

class EtollCardController extends Controller
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
      $cards = EtollCard::with('employee','vehicle')->get();
      return view('main.expedition.etoll_card.index')->withCards($cards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $sites = Site::all();

      return view('main.expedition.etoll_card.create')
              ->withSites($sites);
    }

    public function getSiteAttribute(Request $request){
      $site_id = $request->site_id;

      $vehicles = Vehicle::where('site_id',$site_id)->get();
      $employees = Employee::where('site_id',$site_id)->get();

      $output = array(
        'vehicles' => $vehicles,
        'employees' => $employees
      );

      return response()->json($output);
    }

    public function checkDuplicateNik(Request $request){
      $employee_id = $request->employee_id;

      $etoll = EtollCard::where('employee_id',$employee_id)->first();

      if(!is_null($etoll)){
  			// duplicate found
  			$output = array(
  				'status' => true
  			);
  		}
  		else{
  			$output = array(
  				'status' => false
  			);
  		}

      return response()->json($output);
    }

    public function checkDuplicateVehicle(Request $request){
      $vehicle_id = $request->vehicle_id;

      $etoll = EtollCard::where('vehicle_id',$vehicle_id)->first();

      if(!is_null($etoll)){
  			// duplicate found
  			$output = array(
  				'status' => true
  			);
  		}
  		else{
  			$output = array(
  				'status' => false
  			);
  		}

      return response()->json($output);
    }

    public function checkDuplicateEtoll(Request $request){
      $card_num = $request->card_num;

      $etoll = EtollCard::where('card_num',$card_num)->first();

      if(!is_null($etoll)){
  			// duplicate found
  			$output = array(
  				'status' => true
  			);
  		}
  		else{
  			$output = array(
  				'status' => false
  			);
  		}

      return response()->json($output);
    }

    public function checkDuplicateEtollUpdate(Request $request){
      $card_num = $request->card_num;
      $id = $request->id;

      $etoll = EtollCard::where('id','<>',$id)->where('card_num',$card_num)->first();

      if(!is_null($etoll)){
  			// duplicate found
  			$output = array(
  				'status' => true
  			);
  		}
  		else{
  			$output = array(
  				'status' => false
  			);
  		}

      return response()->json($output);
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
        'card_num' => 'required|min:16|max:16|unique:etoll_cards,card_num',
        'nik' => 'required',
        'license_plate' => 'required'
      ));

      $etoll = new EtollCard;
      $etoll->card_num = $request->card_num;
      $etoll->employee_id = $request->nik;
      $etoll->vehicle_id = $request->license_plate;
      $etoll->created_by = $user->username;
      $etoll->save();

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
      $data = EtollCard::with('employee','employee.site','vehicle')->findOrFail($id);

      $sites = Site::all();

      return view('main.expedition.etoll_card.edit')
              ->withSites($sites)
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

      $etoll = EtollCard::findOrFail($id);

      $this->validate($request, array(
        'card_num' => 'required|min:16|max:16|unique:etoll_cards,card_num,'.$etoll->id,
        'nik' => 'required',
        'license_plate' => 'required'
      ));

      $etoll->card_num = $request->card_num;
      $etoll->employee_id = $request->nik;
      $etoll->vehicle_id = $request->license_plate;
      $etoll->rstatus = 'AM';
      $etoll->updated_by = $user->username;
      $etoll->save();

      return redirect()->route('etoll_cards.index')->with('status-success','Data berhasil diperbaharui.');
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

      $etoll = EtollCard::findOrFail($id);
      $etoll->rstatus = 'DL';
      $etoll->deleted_by = $user->username;
      $etoll->deleted_at = Carbon::now();
      $etoll->save();

      return redirect()->route('etoll_cards.index')->with('status-success','Data berhasil dihapus.');
    }
}
