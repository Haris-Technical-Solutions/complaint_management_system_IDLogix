<!--folders list view-->
<div class="folders-list-view">


    <ul>
        @if(isset($folders))
        @foreach($folders as $folder)
      <li id="folder_{{ $folder->file_group_id }}" class="ajax-request file-folder-menu-item {{ runtimeFileFoldersActive($folder->file_group_id, request('filegroup_id')) }}"
            data-url="{{ url('/leads/content/'.$folder->file_group_resource_id.'/show-attachments').'?source=ext&filegroup_id='.$folder->file_group_id.'&fileresource_type='.$folder->file_group_resource_type.'&fileresource_id='.$folder->file_group_resource_id}}">
            <span>{{ $folder->file_group_name }}</span></li>
        @endforeach
        @endif

    </ul>


</div>