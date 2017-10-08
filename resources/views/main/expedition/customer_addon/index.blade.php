@extends('layouts.main')

@section('title', 'Customer Add On')

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
      <li><a href="{{ route('customer_addons.index') }}">Customer Add On</a></li>
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div id="panel-info" class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Customer Add On</h3>
        </div>
        <div id="panel-body" class="panel-body">
          <div class="row">
    				<div class="col-md-12">
    					<div class="page-header">
    					  <h3>Daftar Customer Add On</h3>
    					</div>
    				</div>
    			</div>
          <div class="row">
            <div class="col-md-12 text-right">
              <a href="{{ route('customer_addons.create') }}" class="btn btn-success ">
                Buat Baru
              </a>
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
                      <th class="text-center w10">#</th>
                      <th class="text-center w20">Kode</th>
                      <th class="text-center w60">Nama Customer</th>
                      <th class="text-center w10"></th>
                    </tr>
                  </thead>
                  <tbody class="tbody searchable f12">
                  @if (isset($add_ons) && count($add_ons) > 0)
                    @php
                      $i = 1;
                    @endphp
                    @foreach ($add_ons as $data)
                      <tr>
                        <td class="text-center w10">{{ $i }}.</td>
                        <td class="text-center w20">{{ $data->customer_code }}</td>
                        <td class="text-center w60">{{ $data->customer_name }}</td>
                        <td class="text-center w10">
                          <form class="form" role="form" method="POST" action="{{ route('customer_addons.destroy', $data->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <a href="{{ route('customer_addons.edit', $data->id) }}" class="btn btn-default btn-xs">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <button type="submit" class="btn btn-xs btn-default" onclick="return confirm('Yakin mau hapus data ini?');">
                              <i class="fa fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @php
                        $i++;
                      @endphp
                    @endforeach
                  @else
                    <tr>
                      <td colspan="4">Data tidak ditemukan.</td>
                    </tr>
                  @endif
      	          </tbody>
                </table>
              </div>
            </div>
          </div>
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
