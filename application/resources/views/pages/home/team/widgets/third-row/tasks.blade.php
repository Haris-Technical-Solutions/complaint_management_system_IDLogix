<div class="col-lg-4  col-md-12">
    <div class="card project-box">
        <div class="card-body project-inbox">
             <h5 class="card-title">{{ cleanLang(__('lang.tasks')) }}</h5> 
            @php $tasks = $payload['my_tasks'] ; @endphp
            <div class="table-responsive  list-table-wrapper dashboard-projects" id="dashboard-client-tasks">
                <table class="table table-hover">
                    <thead style="position:sticky; top:0; ">
                        <tr >
                            <th>{{ cleanLang(__('lang.task')) }}</th>
                            <th>{{ cleanLang(__('lang.project')) }}</th>
                            <th>{{ cleanLang(__('lang.start_date')) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                           
                            <td class="txt-oflo"><a
                                    href="/tasks/{{ $task->task_id }}">{{ str_limit($task->task_title ??'---', 20) }}</a>
                            </td>
                            <td>{{ str_limit($task->project_title ??'---', 20) }}</td>
                            <td>{{ runtimeDate($task->task_date_start) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>