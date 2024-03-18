<div class="row">

 
    <!--COMMENTS-->
    {{-- @include('pages.home.team.widgets.third-row.comments') --}}
    
    <!--LEADS-->
     @if(config('visibility.modules.leads'))
        @include('pages.home.team.widgets.third-row.leads')
    @endif
    <!--PROJECTS-->
     @if(config('visibility.modules.projects') && auth()->user()->role_id!=3 )
    @include('pages.home.team.widgets.third-row.projects')
    @endif
    
    <!--CAD-->
    @if(config('visibility.modules.cad'))
        @include('pages.home.team.widgets.third-row.cad')
    @endif
@if(auth()->user()->role_id==13) 
        @include('pages.home.team.widgets.second-row.events')
@endif 
 
    <!--tasks-->
    @if(config('visibility.modules.tasks'))
        @include('pages.home.team.widgets.third-row.tasks')
    @endif
     <!--Leave-->
        @include('pages.home.team.widgets.third-row.leaves')
 <!--Tickets-->
    @if(config('visibility.modules.tickets') && auth()->user()->role_id!=3)
        @include('pages.home.team.widgets.third-row.tickets')
    @endif
    
</div>