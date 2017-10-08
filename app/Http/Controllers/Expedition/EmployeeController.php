<?php

namespace App\Http\Controllers\Expedition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

use Auth;
use Carbon\Carbon;
use App\Models\Expedition\Employee;
use App\Models\Site;

class EmployeeController extends Controller
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
      return view('main.expedition.employee.index')->withSites($sites);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $sites = Site::all();
      return view('main.expedition.employee.create')->withSites($sites);
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
        'nik' => 'required|unique:employees,nik',
        'name' => 'required|min:3'
      ));

      $emp = new Employee;
      $emp->site_id = $request->site;
      $emp->nik = strtoupper($request->nik);
      $emp->name = strtoupper($request->name);
      $emp->created_by = $user->username;
      $emp->save();

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

      $site_id = $request->site;
      $emps = Employee::with('site')->where('site_id',$site_id)
                    ->orderBy('nik')
                    ->get();

      if(count($emps)>0){
        return view('main.expedition.employee.index')
              ->withSites($sites)
              ->withEmployees($emps);
      }
      else{
        return redirect()->route('employees.index')->with('status-danger','Data tidak ditemukan.');
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
      $emp = Employee::findOrFail($id);
      $sites = Site::all();
      return view('main.expedition.employee.edit')->withSites($sites)->withData($emp);
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

      $emp = Employee::findOrFail($id);

      $this->validate($request, array(
        'nik' => 'required|unique:employees,nik,'.$emp->id,
        'name' => 'required|min:3'
      ));

      $emp->site_id = $request->site;
      $emp->nik = strtoupper($request->nik);
      $emp->name = strtoupper($request->name);
      $emp->rstatus = 'AM';
      $emp->updated_by = $user->username;
      $emp->save();

      if($emp){
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

      $emp = Employee::findOrFail($id);
      $emp->rstatus = 'DL';
      $emp->deleted_by = $user->username;
      $emp->deleted_at = Carbon::now();
      $emp->save();

      if($emp){
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
