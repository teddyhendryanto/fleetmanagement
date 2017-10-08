<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Carbon\Carbon;
use App\Models\Expedition\Area;

class AreaController extends Controller
{
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
      $areas = Area::orderBy('area')->get();
      return view('main.expedition.area.index')->withAreas($areas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('main.expedition.area.create');
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
        'area' => 'required|unique:areas,area',
      ));

      $area = new Area;
      $area->area = strtoupper($request->area);
      $area->created_by = $user->username;
      $area->save();

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
      $data = Area::findOrFail($id);
      return view('main.expedition.area.edit')->withData($data);
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

      $area = Area::findOrFail($id);

      $this->validate($request, array(
        'area' => 'required|unique:areas,area,'.$area->id,
      ));

      $area->area = strtoupper($request->area);
      $area->rstatus = 'AM';
      $area->updated_by = $user->username;
      $area->save();

      return redirect()->route('areas.index')->with('status-success','Data berhasil diperbaharui.');
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

      $area = Area::findOrFail($id);
      $area->rstatus = 'DL';
      $area->deleted_by = $user->username;
      $area->deleted_at = Carbon::now();
      $area->save();

      return redirect()->route('areas.index')->with('status-success','Data berhasil dihapus.');
    }
}
