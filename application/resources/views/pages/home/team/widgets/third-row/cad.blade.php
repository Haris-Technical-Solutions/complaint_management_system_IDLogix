<div class="col-lg-4  col-md-12">
    <div class="card">
        <div class="card card-body mailbox m-b-0">
            <h5 class="card-title">{{ cleanLang(__('CAD Jobs')) }}</h5>
            <div class="message-center dashboard-projects-admin">
                <!-- not started -->
                <a href="javascript:void(0)">
                    <div class="btn btn-danger label-default btn-circle">{{ $payload['all_cad_projects']['not_started']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.not_started')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_cad_projects']['not_started']??'0' }}</strong></span>
                    </div>
                </a>

                <!-- in progress -->
                <a href="javascript:void(0)">
                    <div class="btn btn-info btn-circle">{{ $payload['all_cad_projects']['in_complete'] ??'0'}}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('Incomplete or Missing Data')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_cad_projects']['in_complete']??'0' }}</strong></span>
                    </div>
                </a>

                <!-- on hold -->
                <a href="javascript:void(0)">
                    <div class="btn btn-danger btn-circle">{{ $payload['all_cad_projects']['query_raised'] ??'0'}}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('Query Raised')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_cad_projects']['query_raised']??'0' }}</strong></span>
                    </div>
                </a>


                <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn btn-danger btn-circle">{{ $payload['all_cad_projects']['in_for_approval']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('In For Approval')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_cad_projects']['in_for_approval']??'0' }}</strong></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>