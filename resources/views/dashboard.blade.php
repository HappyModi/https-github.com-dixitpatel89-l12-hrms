@extends('layouts.master')
@section('content')
  <div class="page-content">
    <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">Dashboard</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">
                <a href="javascript: void(0);">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    @if(auth()->check())
      @if(auth()->user()->hasRole('Super Admin'))
        <p>Welcome, Super Admin!</p>
      @elseif(auth()->user()->hasRole('Company Admin'))
        <p>Welcome, Company Admin!</p>
      @elseif(auth()->user()->hasRole('HR Admin'))
        <p>Welcome, HR Admin!</p>
      @else
        <p>Welcome, Guest! Please log in.</p>
      @endif
    @else
      <p>Welcome, Guest! Please log in.</p>
    @endif

    </div>
  </div>
@endsection
