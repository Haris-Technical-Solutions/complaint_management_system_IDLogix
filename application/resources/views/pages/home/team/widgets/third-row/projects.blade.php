<div class="col-lg-4  col-md-12">
    <div class="card">
        <div class="card card-body mailbox m-b-0">
            <h5 class="card-title">{{ cleanLang(__('lang.projects')) }} Status</h5>
            
            <div class="message-center dashboard-projects-admin">
                <!-- not started -->
                <a href="javascript:void(0)">
                    <div class="btn btn-danger label-default btn-circle">{{ $payload['all_projects']['not_started']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.not_started')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects_states']['not_started']??'0' }}</strong></span>
                    </div>
                </a>

                <!-- in progress -->
                <a href="javascript:void(0)">
                    <div class="btn btn-info btn-circle">{{ $payload['all_projects']['sent_to_cad']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.sent_to_cad')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects_states']['sent_to_cad']??'0' }}</strong></span>
                    </div>
                </a>

                <!-- on hold -->
                <a href="javascript:void(0)">
                    <div class="btn btn-info btn-circle">{{ $payload['all_projects']['issue_to_client']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.issue_to_client')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects_states']['issue_to_client']??'0' }}</strong></span>
                    </div>
                </a>


                <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn btn-success btn-circle">{{ $payload['all_projects']['completed']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.completed')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects_states']['completed']??'0' }}</strong></span>
                    </div>
                </a>
                 <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn btn-warning btn-circle">{{ $payload['all_projects']['pasca_sent']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.pasca_sent')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.pasca_sent')) }}:
                            <strong>{{ $payload['my_projects_states']['pasca_sent']??'0' }}</strong></span>
                    </div>
                </a>
                 <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn btn-success btn-circle">{{ $payload['all_projects']['pasca_approved']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.pasca_approved')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.pasca_approved')) }}:
                            <strong>{{ $payload['my_projects_states']['pasca_approved']??'0' }}</strong></span>
                    </div>
                </a>
                  <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn btn-warning btn-circle">{{ $payload['all_projects']['survey_in_progress']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.survey_in_progress')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.survey_in_progress')) }}:
                            <strong>{{ $payload['my_projects_states']['survey_in_progress']??'0' }}</strong></span>
                    </div>
                </a>
                 <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn btn-success btn-circle">{{ $payload['all_projects']['survey_completed']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.survey_completed')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.survey_completed')) }}:
                            <strong>{{ $payload['my_projects_states']['survey_completed']??'0' }}</strong></span>
                    </div>
                </a>
                  <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn btn-success btn-circle">{{ $payload['all_projects']['cad_complete']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.cad_complete')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.cad_complete')) }}:
                            <strong>{{ $payload['my_projects_states']['cad_complete']??'0' }}</strong></span>
                    </div>
                </a>
                 <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn purple-theme btn-circle">{{ $payload['all_projects']['invoice_sent']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.invoice_sent')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.invoice_sent')) }}:
                            <strong>{{ $payload['my_projects_states']['invoice_sent']??'0' }}</strong></span>
                    </div>
                </a>
                  <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="btn purple-theme btn-circle">{{ $payload['all_projects']['payment_received']??'0' }}</div>
                    <div class="mail-contnet">
                        <h5>{{ cleanLang(__('lang.payment_received')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.payment_received')) }}:
                            <strong>{{ $payload['my_projects_states']['payment_received']??'0' }}</strong></span>
                    </div>
                </a>
               
            </div>
          
        </div>
    </div>
</div>