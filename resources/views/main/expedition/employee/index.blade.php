@extends('layouts.main')

@section('title', 'Employee')

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
      <li><a href="{{ route('employees.index') }}">Employee</a></li>
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div id="panel-info" class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Employee</h3>
        </div>
        <div id="panel-body" class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <form id="form-filter" class="form" role="form" method="POST" action="{{ route('employees.show') }}">
                {{ csrf_field() }}
                @if(isset($data))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row">
                  <div class="col-md-12">
                    <!-- Left side -->
                    <div class="row">
                      <div class="col-md-3">
                        <label for="site">Site</label>
                        <div class="form-group">
                          <select class="form-control" name="site">
                            @foreach ($sites as $site)
                              @if ($site->id == env('SITE_ID'))
                                <option value="{{ $site->id }}" selected>{{ $site->short_name }}</option>
                              @else
                                <option value="{{ $site->id }}">{{ $site->short_name }}</option>
                              @endif
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
                          <a href="{{ route('employees.create') }}" class="btn btn-success ">
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

          @if(isset($employees) && count($employees) > 0)
            <div class="row">
      				<div class="col-md-12">
      					<div class="page-header">
      					  <h3>Daftar Kendaraan</h3>
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
                        <th class="text-center w10">#</th>
                        <th class="text-center w20">Site</th>
                        <th class="text-center w20">NIK</th>
                        <th class="text-center w40">Nama</th>
                        <th class="text-center w10"></th>
                      </tr>
                    </thead>
                    <tbody class="tbody searchable f12">
                    @php
                      $i = 1;
                    @endphp
                    @foreach ($employees as $emp)
                      <tr>
                        <td class="text-center w10">{{ $i }}.</td>
                        <td class="text-center w20">{{ $emp->site->short_name }}</td>
                        <td class="text-center w20">{{ $emp->nik }}</td>
                        <td class="text-center w40">{{ $emp->name }}</td>
                        <td class="text-center w10">
                          <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-default btn-xs" target="_blank">
                            <i class="fa fa-pencil"></i>
                          </a>
                          <a href="{{ route('employees.delete', $emp->id) }}" class="btn btn-default btn-xs" target="_blank" onclick="return confirm('Yakin mau hapus data ini?');">
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
