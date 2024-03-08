<div class="col-lg-4  col-md-12">
    <div class="card project-box">
        <div class="card-body project-inbox">
             <h5 class="card-title">{{ cleanLang(__('Problem Reports')) }}</h5> 
            @php $tickets = $payload['my_tickets'] ; @endphp
            <div class="dashboard-projects" id="dashboard-client-tickets">
                <table class="table table-hover">
                    <thead style="position:sticky; top:0; ">
                        <tr>
                            <th>{{ cleanLang(__('lang.ticket')) }}</th>
                            <th>{{ cleanLang(__('lang.project')) }}</th>
                            <th>{{ cleanLang(__('lang.status')) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                           
                            <td class="txt-oflo"><a
                                    href="/tickets/{{ $ticket->ticket_id }}">{{ str_limit($ticket->ticket_subject ??'---', 20) }}</a>
                            </td>
                              <td>{{ str_limit($ticket->project_title ??'---', 20) }}</td>
                            <td><span class="text-success"><span
                                        class="label {{ runtimeTaskStatusColors($ticket->ticket_status, 'label') }}">{{ runtimeLang($ticket->ticket_status) }}</span></span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>