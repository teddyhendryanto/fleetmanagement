@extends('layouts.main')

@section('title', 'Roles')

@section('pluginscss')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('vendor/datatables/media/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('breadcrumb')
  <div id="#breadcrumb">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Beranda</a></li>
      <li><a href="#">Setup</a></li>
      <li><a href="{{ route('roles.index') }}" class="active">Role</a></li>
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">List Role</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <a href="{{ route('roles.create') }}" class="btn btn-success">
                Buat Baru
              </a>
            </div>
          </div>
  				<div class="table-responsive mt10">
  	        <table id="table" class="table table-hover" width="100%">
  	          <thead>
  	            <tr>
                  <th>#</th>
    							<th>Nama Role</th>
                  <th>Display</th>
                  <th>Deskripsi</th>
    							<th>Aksi</th>
  	            </tr>
  	          </thead>
  	          <tbody class="tbody searchable">
  	          </tbody>
  	        </table>
  		    </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('pluginsjs')
  <!-- DataTables -->
  <script src="{{ asset('vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section('script')
<script>

  var _reload = (function reload_datatable(){

    $.ajax({
      type: "POST",
      url : '{{ route('roles.ajax.datatable') }}',
      dataType: "JSON",
      data : {"_token": "{{ csrf_token() }}"},
      success: function(data)
      {
        var _dataset = [];
        var _data = data.dataset;
        var _i = 1;
        $(_data).each(function(idx,dataset){
          var _j 				= _i+'.';
          var _id    		= _data[idx].id;
          var _name     = _data[idx].name;
          var _display  = _data[idx].display_name;
          var _desc     = _data[idx].description;
          var _action 	= ""
          + "<a href='roles/"+_id+"/edit' title='Edit'>"
          + "<button type='button' name='btn-edit' class='btn btn-default btn-xs' value='"+_id+"'>"
          + "<i class='fa fa-pencil'></i>"
          + "</button>"
          + "</a>"
          + "<a href='javascript:void(0)' onClick='ajax_roles_delete("+_id+"); return false;' title='Delete'>"
          + "<button type='button' name='btn-delete' class='btn btn-default btn-xs' value='"+_id+"'>"
          + "<i class='fa fa-trash'></i>"
          + "</button>"
          + "</a>";
          _dataset.push([_j,_name,_display,_desc,_action]);
          _i = _i+1;
        });
        // console.log(_dataset);
        $("#table").DataTable({
          destroy: true,
          paging: true,
          searching: true,
          pageLength: 50,
          data : _dataset,
          columnDefs: [
            { className: "text-center w10", "targets": [ 0 ] },
            { className: "text-center w25", "targets": [ 1 ] },
            { className: "text-center w25", "targets": [ 2 ] },
            { className: "text-center w25", "targets": [ 3 ] },
            { className: "text-center w15", "targets": [ 4 ] },
          ]
        });
      }
    });

    return reload_datatable; //return the function itself to reference

  }());

  function ajax_roles_delete(_id){
    if (confirm('Yakin data ingin di hapus?')) {
      $.ajax({
        type: "DELETE",
        url : 'roles/'+_id+'',
        dataType: "JSON",
        data : {"_token": "{{ csrf_token() }}"},
        success: function(data)
        {
          alert('Hapus role berhasil.');
          _reload();
        }
      });
    }
	}

  $(document).ready(function(){

  });
</script>
@endsection
