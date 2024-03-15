<!--heading-->
<div class="x-heading p-t-10"><i class="mdi mdi-file-document-box"></i>{{ cleanLang(__('lang.activity_log')) }}</div>



<!--Form Data-->
<div class="card-show-form-data " id="card-lead-log">


@if(count($payload['all_events']) > 0)

<div class="col-lg-12  col-md-12">
    <div class="">
        <div class="">
            <div class="dashboard-events profiletimeline" id="dashboard-client-events">
                @php $events = $payload['all_events'] ; @endphp
                @include('pages.timeline.components.misc.ajax')
            </div>
            <!--load more-->
        </div>
    </div>
</div> 


@else

<div class="x-no-result">
    <img src="{{ url('/') }}/public/images/no-download-avialble.png" alt="404 - Not found" /> 
    <div class="p-t-20"><h4>{{ cleanLang(__('lang.you_do_not_have_logs')) }}</h4></div>
    <div class="p-t-10">
        <a href="{{ url('app/settings/customfields/leads') }}" class="btn btn-info btn-sm">@lang('lang.record_new_log')</a>
    </div>
</div>

@endif

</div>