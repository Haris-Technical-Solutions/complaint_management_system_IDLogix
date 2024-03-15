@if(isset($folders))
    @foreach($folders as $folder)
      <option value="{{ $folder->file_group_id }}" {{ runtimePreselected($file->file_folder_id ?? '', $folder->file_group_id) }} >
            <span>{{ $folder->file_group_name }}</span></option>
    @endforeach
@endif