<!--main table view-->
<form action="{{ urlResource('/tasks/calander/show-calander') }}" method="post" id="calanderFilter">
    @csrf
<div class="hidden" id="caltaskfilterBody">
    <!--city-->
    <div class="form-data-row">
        <div class="col-md-3">
            <div class="title">
                {{ cleanLang(__('Start Date')) }}
            </div>
            <div class="fields">
                <input type="text" name="filter_task_date_start_start" autocomplete="off"
                                    class="form-control form-control-sm pickadate" placeholder="Start">
                <input class="mysql-date" type="hidden" name="filter_task_date_start_start"
                                    id="filter_task_date_start_start" value="">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="title">
                {{ cleanLang(__('lang.team')) }}
            </div>
            <div class="fields">
                <select name="filter_assigned[]" id="filter_assigned"
                    class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                    multiple="multiple" tabindex="-1" aria-hidden="true">
                    @foreach(config('system.team_members') as $user)
                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="title">
            {{ cleanLang(__('lang.project')) }}
            </div>
            <div class="fields">
                <div class="row">
                    <div class="col-md-12">
                        <select name="filter_task_projectid" id="filter_task_projectid"
                            class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                            data-ajax--url="{{ url('/') }}/feed/projects?ref=general"></select>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-3">
            
            <div class="title " style="visibility:hidden;"> asd
             <input type="hidden" name="action" value="">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                   
            </div>
            <div class="fields">
                <button type="button" name="foo1" class="btn btn-rounded-x btn-secondary js-reset-filter-section">Reset</button>
                {{-- class="btn btn-danger ajax-request"
                data-loading-target="card-leads-left-panel"
                data-loading-class="loading-before-centre"
                data-url="{{ urlResource('/tasks/calander/show-calander') }}" data-type="form" data-ajax-type="post" data-form-id="caltaskfilterBody" --}}
                <Button class="btn btn-danger " type="submit"
                >{{'Filter'}}</Button>
            </div>
        </div>
    </div>
</div>
</form>
<div id="tasks-componente-view-wrapper" class="floating-scroller" style="height:800px;overflow-x:auto;">
    @include('pages.calanders.components.table.table')
</div>