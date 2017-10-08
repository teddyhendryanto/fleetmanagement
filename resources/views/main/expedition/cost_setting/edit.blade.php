@extends('layouts.main')

@section('title', 'Edit Setting Cost')

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
      <li><a href="{{ route('cost_settings.edit', Request::segment(4)) }}" class="active">Edit</a></li>
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
              <form id="form" class="form" role="form" method="POST" action="{{ route('cost_settings.update', $data->id) }}">
                {{ csrf_field() }}
                @if(isset($data))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row">
                  <div class="col-md-3">
                    <label for="vehicle_class">Jenis Kendaraan <span class="text-red">*</span></label>
                    <div class="form-group">
                      <select class="form-control js-checking" name="vehicle_class" disabled>
                        <option value=""></option>
                        @foreach ($vehicle_classes as $vehicle_class)
                          @if ($vehicle_class->id == $data->vehicle_class_id)
                            <option value="{{ $vehicle_class->id }}" selected>{{ $vehicle_class->description }}</option>
                          @else
                            <option value="{{ $vehicle_class->id }}">{{ $vehicle_class->description }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="area">Area <span class="text-red">*</span></label>
                    <div class="form-group">
                      <select class="form-control js-checking" name="area" disabled>
                        <option value=""></option>
                        @foreach ($areas as $area)
                          @if ($area->id == $data->cost->area_id)
                            <option value="{{ $area->id }}" selected>{{ $area->area }}</option>
                          @else
                            <option value="{{ $area->id }}">{{ $area->area }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="customer">Customer</label>
                    <div class="form-group">
                      <select class="form-control" name="customer" disabled>
                        <option value=""></option>
                        @foreach ($customers as $customer)
                          @if ($customer->customer_code == $data->customer_code)
                            <option value="{{ $customer->customer_code }}" selected>{{ $customer->customer_name }} ({{ $customer->customer_code }})</option>
                          @else
                            <option value="{{ $customer->customer_code }}">{{ $customer->customer_name }} ({{ $customer->customer_code }})</option>
                          @endif
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
        								<input type="number" name="cost1" class="form-control" value="{{ $data->cost->cost1 }}" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost1" value="{{ $data->cost1 }}"
                          @if ($data->cost1 == true) {{ "checked" }} @endif>
                        </span>
        							</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="cost2">&nbsp;</label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. DO</span>
        								<input type="number" name="cost2" class="form-control" value="{{ $data->cost->cost2 }}" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost2" value="{{ $data->cost2 }}"
                          @if ($data->cost2 == true) {{ "checked" }} @endif>
                        </span>
        							</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="cost3">&nbsp;</label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Kuli</span>
        								<input type="number" name="cost3" class="form-control" value="{{ $data->cost->cost3 }}" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost3" value="{{ $data->cost3 }}"
                          @if ($data->cost3 == true) {{ "checked" }} @endif>
                        </span>
        							</div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Tol</span>
                        <input type="number" name="cost4" class="form-control" value="{{ $data->cost->cost4 }}" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost4" value="{{ $data->cost4 }}"
                          @if ($data->cost4 == true) {{ "checked" }} @endif>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Lain</span>
                        <input type="number" name="cost5" class="form-control" value="{{ $data->cost->cost5 }}" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost5" value="{{ $data->cost5 }}"
                          @if ($data->cost5 == true) {{ "checked" }} @endif>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Laka</span>
                        <input type="number" name="cost6" class="form-control" value="{{ $data->cost->cost6 * -1 }}" disabled>
                        <span class="input-group-addon">
                          <input type="checkbox" name="cb_cost6" value="{{ $data->cost6 }}"
                          @if ($data->cost6 == true) {{ "checked" }} @endif>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="submit" name="submit" class="btn btn-default" value="Update">
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
