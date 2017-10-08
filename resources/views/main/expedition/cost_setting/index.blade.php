@extends('layouts.main')

@section('title', 'Setting Cost')

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
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div id="panel-info" class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Setting Cost</h3>
        </div>
        <div id="panel-body" class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <form id="form-filter" class="form" role="form" method="POST" action="{{ route('cost_settings.show') }}">
                {{ csrf_field() }}
                @if(isset($data))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row">
                  <div class="col-md-12">
                    <!-- Left side -->
                    <div class="row">
                      <div class="col-md-3">
                        <label for="vehicle_class">Jenis Kendaraan</label>
                        <div class="form-group">
                          <select class="form-control" name="vehicle_class" required>
                            <option value="" selected></option>
                            @foreach ($vehicle_classes as $vehicle_class)
                            <option value="{{ $vehicle_class->id }}">{{ $vehicle_class->description }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="submit">&nbsp;</label>
                        <div class="form-group">
                          <input type="submit" class="btn btn-default" name="submit" value="Submit">
                        </div>
                      </div>
                      <div class="col-md-3 col-md-offset-3 text-right">
                        <label for="new">&nbsp;</label>
                        <div class="form-group">
                          <a href="{{ route('cost_settings.create') }}" class="btn btn-success ">
                            Buat Baru
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          @if (isset($cost_settings) && count($cost_settings) > 0)
          <div class="row">
    				<div class="col-md-12">
    					<div class="page-header">
    					  <h3>Daftar Setting Cost</h3>
    					</div>
    				</div>
    			</div>
          <div class="row mt10 mb5">
            <div class="col-md-3 col-md-offset-9">
              <div class="input-group"> <span class="input-group-addon">Filter</span>
                <label class="sr-only" for="search-history">Search</label>
                <input class="form-control" id="filter" name="search-history" placeholder="Type Here" type="text">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="table-history" class="table table-hover table-striped" width="100%">
                  <thead class="f14">
                    <tr>
                      <th class="text-center w5">#</th>
                      <th class="text-center w10">Jenis Kendaraan</th>
                      <th class="text-center w10">Area</th>
                      <th class="text-center w15">Customer</th>
                      <th class="text-center w7-5">Tarif</th>
                      <th class="text-center w7-5">Uang DO</th>
                      <th class="text-center w7-5">Uang Kuli</th>
                      <th class="text-center w7-5">Uang Tol</th>
                      <th class="text-center w7-5">Uang Lain</th>
                      <th class="text-center w7-5">Uang Laka</th>
                      <th class="text-center w7-5">Total</th>
                      <th class="text-center w7-5"></th>
                    </tr>
                  </thead>
                  <tbody class="tbody searchable f12">
                  @php
                    $i = 1;
                  @endphp
                  @foreach ($cost_settings as $cost_setting)
                    @if ($cost_setting->cost1 == true)
                      @php
                        $cost1 = $cost_setting->cost->cost1;
                      @endphp
                    @else
                      @php
                        $cost1 = 0;
                      @endphp
                    @endif
                    @if ($cost_setting->cost2 == true)
                      @php
                        $cost2 = $cost_setting->cost->cost2;
                      @endphp
                    @else
                      @php
                        $cost2 = 0;
                      @endphp
                    @endif
                    @if ($cost_setting->cost3 == true)
                      @php
                        $cost3 = $cost_setting->cost->cost3;
                      @endphp
                    @else
                      @php
                        $cost3 = 0;
                      @endphp
                    @endif
                    @if ($cost_setting->cost4 == true)
                      @php
                        $cost4 = $cost_setting->cost->cost4;
                      @endphp
                    @else
                      @php
                        $cost4 = 0;
                      @endphp
                    @endif
                    @if ($cost_setting->cost5 == true)
                      @php
                        $cost5 = $cost_setting->cost->cost5;
                      @endphp
                    @else
                      @php
                        $cost5 = 0;
                      @endphp
                    @endif
                    @if ($cost_setting->cost6 == true)
                      @php
                        $cost6 = $cost_setting->cost->cost6;
                      @endphp
                    @else
                      @php
                        $cost6 = 0;
                      @endphp
                    @endif
                    @php
                      $cost_total = $cost1+$cost2+$cost3+$cost4+$cost5+$cost6;
                    @endphp
                    <tr>
                      <td class="text-center w5">{{ $i }}.</td>
                      <td class="text-center w10">{{ $cost_setting->cost->vehicle_class->description }}</td>
                      <td class="text-center w10">{{ $cost_setting->area }}</td>
                      <td class="text-center w15">{{ $cost_setting->customer_name }} <br/>{{ $cost_setting->customer_code }}</td>
                      <td class="text-right w7-5">{{ number_format($cost1,0,',','.') }}</td>
                      <td class="text-right w7-5">{{ number_format($cost2,0,',','.') }}</td>
                      <td class="text-right w7-5">{{ number_format($cost3,0,',','.') }}</td>
                      <td class="text-right w7-5">{{ number_format($cost4,0,',','.') }}</td>
                      <td class="text-right w7-5">{{ number_format($cost5,0,',','.') }}</td>
                      <td class="text-right w7-5">{{ number_format($cost6,0,',','.') }}</td>
                      <td class="text-right w7-5">{{ number_format($cost_total,0,',','.') }}</td>
                      <td class="text-center w7-5">
                        <a href="{{ route('cost_settings.edit', $cost_setting->id) }}" class="btn btn-default btn-xs" target="_blank">
                          <i class="fa fa-pencil"></i>
                        </a>
                        <a href="{{ route('cost_settings.delete', $cost_setting->id) }}" class="btn btn-default btn-xs" target="_blank" onclick="return confirm('Yakin mau hapus data ini?');">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                    @php
                      $i++;
                    @endphp
                  @endforeach
      	          </tbody>
                </table>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

@endsection

@section('pluginsjs')
  <!-- Parsley JS -->
  <script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('script')
  <script>
    $(document).ready(function(){

    });
  </script>
@endsection
