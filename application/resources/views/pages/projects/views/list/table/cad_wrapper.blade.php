<!--checkbox actions-->
@include('pages.projects.components.actions.checkbox-actions')

<!--main table view-->
@if(@$show_history=='')
@include('pages.projects.views.list.table.cad_table')
@else
@include('pages.projects.views.list.table.cad_states_table')
@endif
<!--filter-->
@if(auth()->user()->is_team)
@include('pages.projects.components.misc.filter-projects')
@endif
<!--filter-->