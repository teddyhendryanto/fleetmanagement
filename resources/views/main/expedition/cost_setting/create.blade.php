@extends('layouts.main')

@section('title', 'Setting Cost Baru')

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
      <li><a href="{{ route('cost_settings.index') }}">Setting Cost</a></li>
      <li><a href="{{ route('cost_settings.create') }}" class="active">Buat Baru</a></li>
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div id="panel-info" class="panel panel-default">
        <div class="panel-heading">
          <a href="{{ route('cost_settings.index') }}" class="btn btn-default">
            Back
          </a>
        </div>
        <div id="panel-body" class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <form id="form" class="form" role="form" method="POST" action="{{ route('cost_settings.store') }}">
                {{ csrf_field() }}
                @if(isset($data))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row">
                  <div class="col-md-3">
                    <label for="vehicle_class">Jenis Kendaraan <span class="text-red">*</span></label>
                    <div class="form-group">
                      <select class="form-control js-checking" name="vehicle_class" required>
                        <option value=""></option>
                        @foreach ($vehicle_classes as $vehicle_class)
                        <option value="{{ $vehicle_class->id }}">{{ $vehicle_class->description }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="area">Area <span class="text-red">*</span></label>
                    <div class="form-group">
                      <select class="form-control js-checking" name="area" required>
                        <option value=""></option>
                        @foreach ($areas as $area)
                          <option value="{{ $area->id }}">{{ $area->area }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="customer">Customer</label>
                    <div class="form-group">
                      <select class="form-control" name="customer" required>
                        <option value=""></option>
                        @foreach ($customers as $customer)
                          <option value="{{ $customer->customer_code }}">{{ $customer->customer_name }} ({{ $customer->customer_code }})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="cost1">Biaya <span class="text-red">*</span></label>
                    <div class="form-group">
                      <input type="hidden" name="cost_id" value="">
                      <div class="input-group"> <span class="input-group-addon">Tarif</span>
        								<input type="number" name="cost1" class="form-control" value="0" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost1" value="false">
                        </span>
        							</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="cost2">&nbsp;</label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. DO</span>
        								<input type="number" name="cost2" class="form-control" value="0" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost2" value="false">
                        </span>
        							</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="cost3">&nbsp;</label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Kuli</span>
        								<input type="number" name="cost3" class="form-control" value="0" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost3" value="false">
                        </span>
        							</div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Tol</span>
                        <input type="number" name="cost4" class="form-control" value="0" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost4" value="false">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Lain</span>
                        <input type="number" name="cost5" class="form-control" value="0" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost5" value="false">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Laka</span>
                        <input type="number" name="cost6" class="form-control" value="0" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost6" value="false">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="submit" name="submit" class="btn btn-default" value="Submit" disabled>
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

      $('input[type="checkbox"]').click(function(){
        if($(this).is(":checked")){
          $(this).val(true);
        }
        else if($(this).is(":not(:checked)")){
          $(this).val(false);
        }
      });

      $('.js-checking').change(function(){
				var vehicleClass = $('[name="vehicle_class"]').val();
				var area = $('[name="area"]').val();

				if(vehicleClass != '' && area != ''){
					$.ajax({
						type: "POST",
						url: "{{ route('cost_settings.getCost') }}",
						data: {_token : '{{ csrf_token() }}', vehicle_class_id : vehicleClass, area_id : area},
						datatype:"JSON",
						success: function(data){
							console.log(data);

              if (data.status == true) {
                var _costId = data.dataset.id;
                var _cost1 = data.dataset.cost1;
                var _cost2 = data.dataset.cost2;
                var _cost3 = data.dataset.cost3;
                var _cost4 = data.dataset.cost4;
                var _cost5 = data.dataset.cost5;
                var _cost6 = data.dataset.cost6 * -1;

                $('[name="cost_id"]').val(_costId);
                $('[name="cost1"').val(_cost1);
  							$('[name="cost2"').val(_cost2);
  							$('[name="cost3"').val(_cost3);
  							$('[name="cost4"').val(_cost4);
  							$('[name="cost5"').val(_cost5);
  							$('[name="cost6"').val(_cost6);

                $('[name="submit"]').removeAttr('disabled');
              }
              else {
                $('[name="cost_id"]').val('');
                $('[name="cost1"').val(0);
  							$('[name="cost2"').val(0);
  							$('[name="cost3"').val(0);
  							$('[name="cost4"').val(0);
  							$('[name="cost5"').val(0);
  							$('[name="cost6"').val(0);
                alert(data.message);
                $('[name="submit"]').attr('disabled','disabled');
              }
						},
            error: function(data){
              alert('Error');
            }
					});
				}
			});

      $('form').submit(function(){
        if($('form').find('input[type=checkbox]:checked').length == 0){
          alert('Cost harus di centang paling tidak 1.');
          return false;
        }
        else{
          return true;
        }
      });

    });
  </script>
@endsection
