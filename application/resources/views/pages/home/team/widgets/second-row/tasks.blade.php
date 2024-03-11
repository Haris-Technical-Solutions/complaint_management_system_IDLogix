<div class="col-lg-6  col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ cleanLang(__('lang.my_tasks')) }}</h5>
            @php $projects = $payload['my_projects'] ; @endphp
            <div class="dashboard-projects" id="dashboard-client-projects">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>{{ cleanLang(__('lang.title')) }}</th>
                            <th>{{ cleanLang(__('lang.project')) }}</th>
                            <th>{{ cleanLang(__('lang.priority')) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($payload['my_tasks']);}} --}}
                        @foreach($payload['my_tasks'] as $task)
                        <tr>
                            <td class="text-center">{{ $task->task_id }}</td>
                            <td class="txt-oflo"><a href="/tasks/v/{{ $task->task_id }}">{{ str_limit($task->task_title ??'---', 20) }}</a>
                            </td>
                            <td><a href="/projects/{{ $task->task_projectid }}/tasks">{{ $task->project->project_title }}</a></td>
                            <td><span class="text-success"><span
                                        class="label {{ runtimeTaskPriorityColors($task->task_priority, 'label') }}">{{ runtimeLang($task->task_priority) }}</span></span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>