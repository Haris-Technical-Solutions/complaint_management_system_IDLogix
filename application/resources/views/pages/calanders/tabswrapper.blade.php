<!-- action buttons -->
@include('pages.calanders.components.misc.list-page-actions')
<!-- action buttons -->

<!--stats panel-->
@if(auth()->user()->is_team)
<div id="tasks-stats-wrapper" class="stats-wrapper card-embed-fix">
    @if($tasks)
    @if (count($tasks) > 0) @include('misc.list-pages-stats') @endif
    @endif
</div>
@endif
<!--stats panel-->

<!--tasks and kanban layouts-->
@if(auth()->user()->pref_view_tasks_layout =='list')
<div class="card-embed-fix  kanban-wrapper">
    @include('pages.calanders.components.table.wrapper')
</div>
@else
<div class="card-embed-fix  kanban-wrapper">
    @include('pages.calanders.components.kanban.wrapper')
</div>
@endif
<!--/#tasks and kanban layouts-->

<!--filter-->
@if(auth()->user()->is_team)
@include('pages.calanders.components.misc.filter-tasks')
@endif
<!--filter-->

<!--task modal-->
@include('pages.task.modal')
