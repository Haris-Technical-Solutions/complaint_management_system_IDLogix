@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        @include('misc.heading-crumbs')
        <!--Page Title & Bread Crumbs -->


        <!-- action buttons -->
        <!-- action buttons -->

    </div>
    <!--page heading-->

    <!--stats panel-->
    @if(auth()->user()->is_team)
{{--    <div class="stats-wrapper" id="projects-stats-wrapper"> 
    @include('misc.list-pages-stats')
    </div>
    --}}
    @endif
    <!--stats panel-->


    <!-- page content -->
    <div class="row">
        <div class="col-12">
            <!--projects table-->
            @include('pages.projects.views.list.table.cad_wrapper')
            <!--projects table-->
        </div>
    </div>
    <!--page content -->

</div>
<!--main content -->
@endsection