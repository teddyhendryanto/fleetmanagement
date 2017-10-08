@extends('layouts.main')

@section('title', 'Edit Cost')

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
      <li><a href="{{ route('costs.index') }}">Cost</a></li>
      <li><a href="{{ route('costs.edit', Request::segment(4)) }}" class="active">Edit</a></li>
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div id="panel-info" class="panel panel-default">
        <div class="panel-heading">
          <a href="{{ route('costs.index') }}" class="btn btn-default">
            Back
          </a>
        </div>
        <div id="panel-body" class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <form id="form" class="form" role="form" method="POST" action="{{ route('costs.update', $data->id) }}">
                {{ csrf_field() }}
                @if(isset($data))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row">
                  <div class="col-md-3">
                    <label for="vehicle_class">Jenis Kendaraan <span class="text-red">*</span></label>
                    <div class="form-group">
                      <input type="hidden" name="vehicle_class_id" value="{{ $data->vehicle_class_id }}">
                      <select class="form-control" name="vehicle_class" disabled>
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
                      <input type="hidden" name="area_id" value="{{ $data->area_id }}">
                      <select class="form-control" name="area" disabled>
                        <option value=""></option>
                        @foreach ($areas as $area)
                          @if ($area->id == $data->area_id)
                            <option value="{{ $area->id }}" selected>{{ $area->area }}</option>
                          @else
                            <option value="{{ $area->id }}">{{ $area->area }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="fuel">Konsumsi Bahan Bakar</label>
                    <div class="form-group">
                      <input type="text" id="fuel" name="fuel" class="form-control"
                      value="{{ $data->fuel }}" placeholder="Liter">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="cost1">Biaya <span class="text-red">*</span></label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">Tarif</span>
        								<input type="number" name="cost1" class="form-control" value="{{ $data->cost1 }}">
        							</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="cost2">&nbsp;</label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. DO</span>
        								<input type="number" name="cost2" class="form-control" value="{{ $data->cost2 }}">
        							</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="cost3">&nbsp;</label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Kuli</span>
        								<input type="number" name="cost3" class="form-control" value="{{ $data->cost3 }}">
        							</div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Tol</span>
                        <input type="number" name="cost4" class="form-control" value="{{ $data->cost4 }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Lain</span>
                        <input type="number" name="cost5" class="form-control" value="{{ $data->cost5 }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon">U. Laka</span>
                        <input type="number" name="cost6" class="form-control" value="{{ $data->cost6*-1 }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
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

    });
  </script>
@endsection
