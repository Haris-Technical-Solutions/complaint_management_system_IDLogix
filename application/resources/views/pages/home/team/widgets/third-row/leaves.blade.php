<div class="col-lg-4  col-md-12">
    <div class="card project-box">
        <div class="card-body project-inbox">
             <h5 class="card-title">{{ cleanLang(__('lang.leaves')) }}</h5> 
            @php $leaves = $payload['all_leaves'] ; @endphp
            <div class="table-responsive  list-table-wrapper   dashboard-projects" id="dashboard-client-leaves">
                <table class="table table-hover">
                    <thead style="position:sticky; top:0; ">
                        <tr >
                            <th>{{ cleanLang(__('lang.leave')) }}</th>
                            @if(auth()->user()->role_id!=3 && auth()->user()->role_id!=13)
                            <th>{{ cleanLang(__('Person')) }}</th>
                            @endif
                            <th>{{ cleanLang(__('lang.start_date')) }}</th>
                            <th>{{ cleanLang(__('lang.status')) }}</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr>
                           
                            <td class="txt-oflo">
                                {{ str_limit($leave->leave_title ??'---', 20) }}
                                {{-- <a href="/leaves">{{ str_limit($leave->leave_title ??'---', 20) }}</a> --}}
                            </td>
                            @if(auth()->user()->role_id!=3 && auth()->user()->role_id!=13 )
                            <td>{{ $leave->requester->first_name.' '.$leave->requester->last_name }}</td>
                            @endif
                            <td>{{ runtimeDate($leave->leave_start_date ) }}</td>
                            <td>{{ $leave->leave_status  }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>