@extends('layouts.main')

@section('title', 'Edit Employee')

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
      <li><a href="{{ route('employees.edit', Request::segment(4)) }}" class="active">Edit</a></li>
    </ol>
  </div>
@endsection

@section('content')
  @include('partials.flash')
  <div class="row">
    <div class="col-md-12">
      <div id="panel-info" class="panel panel-default">
        <div class="panel-heading">
          <a href="{{ route('employees.index') }}" class="btn btn-default">
            Back
          </a>
        </div>
        <div id="panel-body" class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <form id="form" class="form" role="form" method="POST" action="{{ route('employees.update', $data->id) }}">
                {{ csrf_field() }}
                @if(isset($data))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row">
                  <div class="col-md-3">
                    <label for="site">Site</label>
                    <div class="form-group">
                      <select class="form-control" name="site" required>
                        @foreach ($sites as $site)
                          @if ($site->id == $data->site_id)
                            <option value="{{ $site->id }}" selected>{{ $site->short_name }}</option>
                          @else
                            <option value="{{ $site->id }}">{{ $site->short_name }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="nik">NIK</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="nik" value="{{ $data->nik }}" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="name">Nama</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
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

    });
  </script>
@endsection
