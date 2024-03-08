<!-- <div class="card count-{{ @count($filegroups) }}" id="files-table-wrapper">
    <div class="card-body"> -->
        <div class="row">
            @if (@count($filegroups) > 0 )
           
                    <!--ajax content here-->
                    @include('pages.filegroups.components.table.ajax')
                    <!--ajax content here-->
             
            @endif
            @if (@count($filegroups) == 0 )
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
        
    <!-- </div>
</div> -->