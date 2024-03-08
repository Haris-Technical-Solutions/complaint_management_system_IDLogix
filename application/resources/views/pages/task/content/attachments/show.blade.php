<!--heading-->
{{-- 
<div class="x-heading p-t-10"><i class="mdi mdi-file-document-box"></i>{{ cleanLang(__('lang.custom_fields')) }}</div>
--}}

<div class="card-attachments" id="card-attachments" data-upload-url="{{ url('/tasks/'.$task->task_id.'/attach-files')}}" >
    <div class="x-heading"><i class="mdi mdi-cloud-download"></i>{{ cleanLang(__('lang.attachments')) }}</div>
    <div class="x-content row" id="card-attachments-container"> 
        <!--Form Data-->
        @foreach($attachments as $attachment)
        <div class="col-sm-12" id="card_attachment_{{ $attachment->attachment_uniqiueid }}">
            <div class="file-attachment">
                @if($attachment->attachment_type == 'image')
                <!--dynamic inline style-->
                <div class="">
                    <a class="fancybox-rrrr preview-image-thumb"
                        href="storage/files/{{ $attachment->attachment_directory }}/{{ $attachment->attachment_filename  }}"
                        title="{{ str_limit($attachment->attachment_filename, 60) }}"
                        alt="{{ str_limit($attachment->attachment_filename, 60) }}"
                        target="_blank">
                        <img class="x-image" src="{{ url('storage/files/' . $attachment->attachment_directory .'/'. $attachment->attachment_thumbname) }}">
                    </a>
                </div>
                @else
                <div class="x-image">
                    <a class="preview-image-thumb" href="tasks/download-attachment/{{ $attachment->attachment_uniqiueid }}" download>
                        {{ $attachment->attachment_extension }}
                    </a>
                </div>
                @endif
                <div class="x-details">
                    <div><span class="x-meta">{{ $attachment->first_name ?? runtimeUnkownUser() }}</span>
                        [{{ runtimeDateAgo($attachment->attachment_created) }}]</div>
                    <div class="x-name"><span
                            title="{{ $attachment->attachment_filename }}">{{ str_limit($attachment->attachment_filename, 60) }}</span>
                    </div>
                    <div class="x-actions"><strong>
                            <!--action: download-->
                            <a href="tasks/download-attachment/{{ $attachment->attachment_uniqiueid }}" download>{{ cleanLang(__('lang.download')) }}
                                <span class="x-icons"><i class="ti-download"></i></span></strong></a>
                        <!--action: delete-->
                        @if($attachment->permission_delete_attachment)
                        <span> |
                            <a href="javascript:void(0)" class="text-danger js-delete-ux-confirm confirm-action-danger"
                                data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                                data-ajax-type="DELETE"
                                data-parent-container="card_attachment_{{ $attachment->attachment_uniqiueid }}"
                                data-progress-bar="hidden"
                                data-url="{{ url('/tasks/delete-attachment/'.$attachment->attachment_uniqiueid) }}">{{ cleanLang(__('lang.delete')) }}</a></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($task->permission_participate)
    <div class="x-action"><a class="card_fileupload" id="js-card-toggle-fileupload" href="javascript:void(0)">{{ cleanLang(__('lang.add_attachment')) }}</a></div>

    <div class="hidden" id="card-fileupload-container">
        <div class="dropzone dz-clickable" id="card_fileupload">
            <div class="dz-default dz-message">
                <i class="icon-Upload-toCloud"></i>
                <span>{{ cleanLang(__('lang.drag_drop_file')) }}</span>
            </div>
        </div>
    </div>
     @endif
</div>
<!--attachemnts js--> 