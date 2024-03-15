@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid emp_calander">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        @include('misc.heading-crumbs')
        <!--Page Title & Bread Crumbs -->


        <!-- action buttons -->
        @include('pages.calanders.components.misc.list-page-actions') 
        <!-- action buttons -->

    </div>
    <!--page heading-->

    <!-- page content -->
    <div class="row kanban-wrapper">
        <div class="col-12" id="tasks-layout-wrapper">
            @include('pages.calanders.components.table.wrapper')
            <!--tasks table-->
            <!--filter-->
            @if(auth()->user()->is_team)
            @include('pages.calanders.components.misc.filter-tasks') 
            @endif
            <!--filter-->
        </div>
    </div>
    <!--page content -->

</div>
<!--main content -->

<!--task modal-->
@include('pages.task.modal')

<!--dynamic load task task (dynamic_trigger_dom)-->
@if(config('visibility.dynamic_load_modal'))
<a href="javascript:void(0)" id="dynamic-task-content"
    class="show-modal-button reset-card-modal-form js-ajax-ux-request js-ajax-ux-request" data-toggle="modal"
    data-target="#cardModal" data-url="{{ url('/tasks/'.request()->route('task').'?ref=list') }}"
    data-loading-target="main-top-nav-bar"></a>
@endif

<!--js dom elements-->
@endsection