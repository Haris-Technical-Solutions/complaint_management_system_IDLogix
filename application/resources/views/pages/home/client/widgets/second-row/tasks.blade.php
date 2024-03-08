<div class="col-lg-6  col-md-12">
    <div class="card project-box">
        <div class="card-body project-inbox">
             <h5 class="card-title">{{ cleanLang(__('lang.tasks')) }}</h5> 
            @php $tasks = $payload['my_tasks'] ; @endphp
            <div class="table-responsive  list-table-wrapper  floating-scroller dashboard-projects" id="dashboard-client-projects">
                <table class="table table-hover">
                    <thead style="position:sticky; top:0; ">
                        <tr >
                            <th>{{ cleanLang(__('lang.task')) }}</th>
                            <th>{{ cleanLang(__('lang.project')) }}</th>
                            <th>{{ cleanLang(__('lang.due_date')) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                           
                            <td class="txt-oflo"><a  href="{{ urlResource('/tasks/v/'.$task->task_id).'/'.$task->task_title }}"><span class="x-strike-through"
                id="table_task_title_{{ $task->task_id }}">
                {{ str_limit($task->task_title ?? '---', 45) }}</span></a>
                
                            </td>
                            <td>{{ str_limit($task->project_title ??'---', 20) }}</td>
                            <td>{{ runtimeDate($task->task_date_due) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>