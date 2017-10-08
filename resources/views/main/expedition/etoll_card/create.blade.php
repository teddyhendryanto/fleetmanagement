@extends('layouts.main')

@section('title', 'Etoll Card Baru')

@section('pluginscss')
  <!-- Parsley -->
  <link rel="stylesheet" href="{{ asset('css/parsley.css')}}">
@endsection

@section('breadcrumb')
  <div id="#breadcrumb">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Beranda</a></li>
      <li><a href="#">Ekspedisi</a></li>
      <li><a href="#">Setup</a></li>
      <li><a href="{{ route('etoll_cards.index') }}">Etoll Card</a></li>
      <li><a href="{{ route('etoll_cards.create') }}" class="active">Buat Baru</a></li>
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div id="panel-info" class="panel panel-default">
        <div class="panel-heading">
          <a href="{{ route('etoll_cards.index') }}" class="btn btn-default">
            Back
          </a>
        </div>
        <div id="panel-body" class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <form id="form" class="form" role="form" method="POST" action="{{ route('etoll_cards.store') }}">
                {{ csrf_field() }}
                @if(isset($data))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row">
                  <div class="col-md-3">
                    <label for="site">Site <span class="text-red">*</span></label>
                    <div class="form-group">
                      <select class="form-control" name="site" required>
                        <option value=""></option>
                        @foreach ($sites as $site)
                          <option value="{{ $site->id }}">{{ $site->short_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="nik">NIK <span class="text-red">*</span></label>
                    <div class="form-group">
                      <select class="form-control" name="nik" required>
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="license_plate">Nomor Polisi <span class="text-red">*</span></label>
                    <div class="form-group">
                      <select class="form-control" name="license_plate" required>
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="card_num">Serial Etoll <span class="text-red">*</span></label>
                    <div class="form-group">
                      <input type="text" name="card_num" class="form-control" required
                      value="{{ old('card_num') }}" maxlength="16">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="submit">&nbsp;</label>
                    <div class="form-group">
                      <input type="submit" name="submit" class="btn btn-default" value="Submit">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('pluginsjs')
  <!-- Parsley -->
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('script')
  <script type="text/javascript">
    $('document').ready(function(){
      // initialize parsley;
      $('#form').parsley();

      $('[name="site"]').change(function(){
  			var _siteId = $(this).val();

  			$.ajax({
  				type: "POST",
  				url: "{{ route('etoll_cards.ajax.getSiteAttribute') }}",
  				data: {_token : '{{ csrf_token() }}', site_id : _siteId},
  				datatype:"JSON",
  				success: function(data){
  					console.log(data);
            var _vehicles = data.vehicles;

            if(_vehicles.length > 0){
              var _str = "<option value=''></option>";
  						$.each( _vehicles, function( key, value ) {
                var _vehicleId = _vehicles[key].id;
  	            var _vehicleNo = _vehicles[key].license_plate;
  							_str = _str + '<option value="'+_vehicleId+'">'+_vehicleNo+'</option>';
  	          });
  						$('[name="license_plate"]').html(_str);
            }
            else{
              var _str = "<option value=''>Data tidak ditemukan</option>";
              $('[name="license_plate"]').html(_str);
            }

            var _employees = data.employees;

            if(_employees.length > 0){
              var _str = "<option value=''></option>";
  						$.each( _employees, function( key, value ) {
                var _employeeId = _employees[key].id;
  	            var _employeeNo = _employees[key].nik;
                var _employeeNm = _employees[key].name;
  							_str = _str + '<option value="'+_employeeId+'">'+_employeeNm+' - '+_employeeNo+'</option>';
  	          });
  						$('[name="nik"]').html(_str);
            }
            else{
              var _str = "<option value=''>Data tidak ditemukan</option>";
              $('[name="nik"]').html(_str);
            }
  				},
  				error: function(){
  					alert('Error Get Vehicle');
  				}
  			});
	    });

      $('[name="nik"]').change(function(){
  			var _employeeId = $(this).val();

  			$.ajax({
  				type: "POST",
  				url:'{{ route('etoll_cards.ajax.checkDuplicateNik') }}',
          data: {_token : '{{ csrf_token() }}', employee_id : _employeeId},
  				datatype:"JSON",
  				success: function(data){
            console.log(data);
  					var _status = data.status;
  					if(_status == true){
  						// data duplicate
  						alert('Nik Sudah Pernah Diinput.');
  						$('[name="nik"]').focus();

  						$('[name="license_plate"]').attr('disabled','disabled');
  						$('[name="card_num"]').attr('disabled','disabled');
  					}
  					else{
  						$('[name="license_plate"]').removeAttr('disabled');
  						$('[name="card_num"]').removeAttr('disabled');
  					}
  				},
  				error: function(){
  					alert('Error check duplicate Nik');
  				}
  			});
  		});

      $('[name="license_plate"]').change(function(){
        var _vehicleId = $(this).val();

        $.ajax({
          type: "POST",
          url:'{{ route('etoll_cards.ajax.checkDuplicateVehicle') }}',
          data: {_token : '{{ csrf_token() }}', vehicle_id : _vehicleId},
          datatype:"JSON",
          success: function(data){
            console.log(data);
            var _status = data.status;
            if(_status == true){
              // data duplicate
              alert('Nomor Polisi Sudah Pernah Diinput.');
              $('[name="license_plate"]').focus();

              $('[name="card_num"]').attr('disabled','disabled');
            }
            else{
              $('[name="card_num"]').removeAttr('disabled');
            }
          },
          error: function(){
            alert('Error check duplicate License Plate');
          }
        });
      });

      $('[name="card_num"]').change(function(){
  			var _cardNum = $(this).val();
  			$.ajax({
  				type: "POST",
  				url:'{{ route('etoll_cards.ajax.checkDuplicateEtoll') }}',
  				data: {_token : '{{ csrf_token() }}', card_num : _cardNum},
  				datatype:"JSON",
  				success: function(data){
  					console.log(data);
  					var _status = data.status;

  					if(_status == true){
  						// data duplicate
  						alert('Nomor Kartu Sudah Pernah Dipakai.');
  						$('[name="card_num"]').focus();
  						$('[name="submit"]').attr('disabled','disabled');
  					}
  					else{
  						$('[name="submit"]').removeAttr('disabled');
  					}
  				},
  				error: function(){
  					alert('Error check duplicate EToll');
  				}
  			});
  		});

      $('form').submit(function(){
  			var _cardNum = $('[name="card_num"]').val();

  			if(_cardNum.length != 16){
  				alert('Nomor kartu harus 16 digit.');
  				$('[name="card_num"]').focus();
  				return false;
  			}
  			else{
  				return true;
  			}
  		});

    });
  </script>
@endsection
