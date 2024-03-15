@foreach($projects as $project)

<tr id="" class="tr">
    <td class="projects_col_id ">
         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ $project->category_name }}</label>
    </td>
    <td class="">
         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ $project->total_projects }}</label>
    </td>
    <td class="">
         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ $project->cad_total_days }}</label>
    </td>
   
    
</tr>
@endforeach
<!--each row-->