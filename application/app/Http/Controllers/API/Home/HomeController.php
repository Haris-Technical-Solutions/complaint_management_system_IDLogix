<?php

namespace App\Http\Controllers\API\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\EventRepository;
use App\Repositories\EventTrackingRepository;
use App\Repositories\LeadRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\StatsRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TicketRepository;
use App\Repositories\LeaveRepository;

class HomeController extends Controller
{
    //
    
    private $page = array();

    protected $statsrepo;
    protected $eventsrepo;
    protected $trackingrepo;
    protected $projectrepo;
    protected $taskrepo;
    protected $leadrepo;
    protected $ticketrepo;
    protected $leaverepo;
    public function __construct(
        StatsRepository $statsrepo,
        EventRepository $eventsrepo,
        EventTrackingRepository $trackingrepo,
        ProjectRepository $projectrepo,
        TaskRepository $taskrepo,
        LeadRepository $leadrepo,
        TicketRepository $ticketrepo,
        LeaveRepository $leaverepo
    ) {

        //parent
        parent::__construct();

        $this->statsrepo = $statsrepo;
        $this->eventsrepo = $eventsrepo;
        $this->trackingrepo = $trackingrepo;
        $this->projectrepo = $projectrepo;
        $this->taskrepo = $taskrepo;
        $this->leadrepo = $leadrepo;
        $this->ticketrepo = $ticketrepo;
        $this->leaverepo = $leaverepo;
        //authenticated
      // $this->middleware('auth:api');

        // $this->middleware('homeMiddlewareIndex')->only([
        //     'index',
        // ]);
    }

    /**
     * Display the home page
     * @return \Illuminate\Http\Response
     */
    public function index() {

       // dd(config('modules'));
    //    return 'faheem bilal';
//crumbs, page data & stats
        $page = $this->pageSettings();

        $payload = [];

        //Team Dashboards
       //
       // return auth()->user();
        if (auth()->user()->type == 'team') {
            //admin user
            if (auth()->user()->is_admin) {
                //get payload
                $payload = $this->adminDashboard();
            }
            //team uder
            if (!auth()->user()->is_admin) {
                //get payload
                
                $payload = $this->teamDashboard();
            }
        }

        //Client Dashboards
        if (auth()->user()->type == 'client') {
            //get payload
            $payload = $this->clientDashboard();

        }

        //show login page
        return $payload;
      //  return view('pages/home/home', compact('page', 'payload'));
    }

    /**
     * display team dashboard
     * @return \Illuminate\Http\Response
     */
    public function teamDashboard() {

        //payload
        $payload = [];

        //[projects][all]
        $payload['projects'] = [
            'pending' => $this->statsrepo->countProjects([
                'status' => 'pending',
                'assigned' => auth()->id(),
            ]),
        ];

        //tasks]
        $payload['tasks'] = [
            'new' => $this->statsrepo->countTasks([
                'status' => [7],
                'assigned' => auth()->id(),
            ]),
            'in_progress' => $this->statsrepo->countTasks([
                'status' => [3],
                'assigned' => auth()->id(),
            ]),
            'awaiting_feedback' => $this->statsrepo->countTasks([
                'status' => [5,6],
                'assigned' => auth()->id(),
            ]),
        ];

        //[leads] - alltime
        // $data = $this->widgetLeads('alltime');
        // $payload['leads_stats'] = json_encode($data['stats']);
        // $payload['leads_key_colors'] = json_encode($data['leads_key_colors']);
        // $payload['leads_chart_center_title'] = $data['leads_chart_center_title'];

        //filter
        request()->merge([
            'eventtracking_userid' => auth()->id(),
        ]);
        $payload['all_events'] = $this->trackingrepo->search(20);


//[projects][all]
        $payload['all_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'status' => 'not_started',
            ]),
            'sent_to_cad' => $this->statsrepo->countProjects([
                'status' =>'sent_to_cad',
            ]),
            'issue_to_client' => $this->statsrepo->countProjects([
                'status' => 'issue_to_client',
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
            ]),
             'pasca_sent' => $this->statsrepo->countProjects([
                'status' => 'pasca_sent',
            ]),
             'pasca_approved' => $this->statsrepo->countProjects([
                'status' => 'pasca_approved',
            ]),
             'survey_in_progress' => $this->statsrepo->countProjects([
                'status' => 'survey_in_progress',
            ]),
             'survey_completed' => $this->statsrepo->countProjects([
                'status' => 'survey_completed',
            ]),
             'cad_complete' => $this->statsrepo->countProjects([
                'status' => 'cad_complete',
            ]),
             'invoice_sent' => $this->statsrepo->countProjects([
                'status' => 'invoice_sent',
            ]),
              'payment_received' => $this->statsrepo->countProjects([
                'status' => 'payment_received',
            ]),
        ];

        //[projects][ny]
        $payload['my_projects_states'] = [
            'not_started' => $this->statsrepo->countProjects([
                'status' => 'not_started',
                'assigned' => auth()->id(),
            ]),
            'sent_to_cad' => $this->statsrepo->countProjects([
                'status' => 'sent_to_cad',
                'assigned' => auth()->id(),
            ]),
            'issue_to_client' => $this->statsrepo->countProjects([
                'status' => 'issue_to_client',
                'assigned' => auth()->id(),
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
                'assigned' => auth()->id(),
            ]),
             'pasca_sent' => $this->statsrepo->countProjects([
                'status' => 'pasca_sent',
                'assigned' => auth()->id(),
            ]),
             'pasca_approved' => $this->statsrepo->countProjects([
                'status' => 'pasca_approved',
                'assigned' => auth()->id(),
            ]),
             'survey_in_progress' => $this->statsrepo->countProjects([
                'status' => 'survey_in_progress',
                'assigned' => auth()->id(),
            ]),
             'survey_completed' => $this->statsrepo->countProjects([
                'status' => 'survey_completed',
                'assigned' => auth()->id(),
            ]),
             'cad_complete' => $this->statsrepo->countProjects([
                'status' => 'cad_complete',
                'assigned' => auth()->id(),
            ]),
             'invoice_sent' => $this->statsrepo->countProjects([
                'status' => 'invoice_sent',
                'assigned' => auth()->id(),
            ]),
             'payment_received' => $this->statsrepo->countProjects([
                'status' => 'payment_received',
                'assigned' => auth()->id(),
            ]),
            
        ];

        //filter
        $payload['all_events'] = $this->eventsrepo->search([
            'pagination' => 20,
            'filter' => 'timeline_visible',
        ]);

      
 //[cad][all]
        $payload['all_cad_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Not Started',
            ]),
            'in_complete' => $this->statsrepo->countProjects([
                'project_custom_field_41' =>'Incomplete or missing data',
            ]),
            'query_raised' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Query Raised',
            ]),
            'in_for_approval' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'In for Approval',
            ]),
        ];
        //[cad][my]
        $payload['my_cad_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Not Started',
                'assigned' => auth()->id(),
            ]),
            'in_complete' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Incomplete or missing data',
                'assigned' => auth()->id(),
            ]),
            'query_raised' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Query Raised',
                'assigned' => auth()->id(),
            ]),
            'in_for_approval' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'In for Approval',
                'assigned' => auth()->id(),
            ]),
        ];

        //leaves]
        $assigned = array();
        
        if(!auth()->user()->is_admin && !auth()->user()->is_management && auth()->user()->role_id!=12){
          
             $assigned['assigned'] =  auth()->id();
        }
        // $payload['leaves'] = [
        //     'new' => $this->statsrepo->countLeaves($assigned)
        //     ];
            
              //filter
        // request()->merge([
        //     'leave_status' => 'Pending',
        // ]);
        //  if(!auth()->user()->is_admin && !auth()->user()->is_management && auth()->user()->role_id!=12){
        //     request()->merge([
        //         'leaveresource_type' => 'Employee',
        //         'leaveresource_id' => auth()->id(),
        //     ]);
        // }
        // $payload['all_leaves'] = $this->leaverepo->search('', ['limit' => 10]);

        //filter
        request()->merge([
            'filter_assigned' => [auth()->id()],
        ]);

        $payload['my_projects'] = $this->projectrepo->search('', ['limit' => 10]);
        
        

       //filter
        request()->merge([
            'filter_assigned' => [auth()->id()],
        ]);
        $payload['my_tasks'] = $this->taskrepo->search('', ['limit' => 10]);

        //filter
        request()->merge([
            'filter_ticket_created_by' => [auth()->id()],
           
        ]);
        $payload['my_tickets'] = $this->ticketrepo->search('',['not_status' => 'Closed']);

        
        //return payload
        return $payload;

    }

    /**
     * display client dashboard
     * @return \Illuminate\Http\Response
     */
    public function clientDashboard() {

        //payload
        $payload = [];

        //[invoices]
        $payload['invoices'] = [
            'due' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'due',
                'client_id' => auth()->user()->clientid,
            ]),
            'overdue' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'overdue',
                'client_id' => auth()->user()->clientid,
            ]),
        ];

        //[projects][all]
        $payload['projects'] = [
            'pending' => $this->statsrepo->countProjects([
                'status' => 'pending',
                'client_id' => auth()->user()->clientid,
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
                'client_id' => auth()->user()->clientid,
            ]),
        ];

        //filter
        request()->merge([
            'eventtracking_userid' => auth()->id(),
        ]);
      return  $payload['all_events'] = $this->trackingrepo->search(20);

        //filter
        request()->merge([
            'filter_project_clientid' => auth()->user()->clientid,
            'project_client_projectmanager' => auth()->id(), 
            'project_client_sitemanager' => auth()->id(), 
            
           
        ]);
        $payload['my_projects'] = $this->projectrepo->search('', ['limit' => 30]);
        // dd($payload['my_projects']);
        //filter
        request()->merge([
            // 'filter_assigned' => [auth()->id()],
            'filter_task_clientid' =>  auth()->user()->clientid,
            'filter_task_projectid' => $payload['my_projects']->pluck('project_id'),
            
            
        ]);
        // dd($payload['my_projects']->pluck('project_id'));
        $payload['my_tasks'] = $this->taskrepo->search('', ['limit' => 10]);

       
        //return payload
        return $payload;

    }

    /**
     * display admin User
     * @return \Illuminate\Http\Response
     */
    public function adminDashboard() {

        //payload
        $payload = [];
        
       
        //[payments]
        $payload['payments'] = [
            'today' => $this->statsrepo->sumCountPayments([
                'type' => 'sum',
                'date' => \Carbon\Carbon::now()->format('Y-m-d'),
            ]),
            'this_month' => $this->statsrepo->sumCountPayments([
                'type' => 'sum',
                'start_date' => \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => \Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d'),
            ]),
        ];

        //[invoices]
        $payload['invoices'] = [
            'due' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'due',
            ]),
            'overdue' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'overdue',
            ]),
        ];

        //[income][yearly]
        $payload['income'] = $this->statsrepo->sumYearlyIncome([
            'period' => 'this_year',
        ]);

        //[expense][yearly]
        $payload['expenses'] = $this->statsrepo->sumYearlyExpenses([
            'period' => 'this_year',
        ]);

        //[projects][all]
        $payload['all_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'status' => 'not_started',
            ]),
            'in_progress' => $this->statsrepo->countProjects([
                'status' =>
                'in_progress',
            ]),
            'on_hold' => $this->statsrepo->countProjects([
                'status' => 'on_hold',
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
            ]),
        ];

        //[projects][my]
        $payload['my_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'status' => 'not_started',
                'assigned' => auth()->id(),
            ]),
            'in_progress' => $this->statsrepo->countProjects([
                'status' => 'in_progress',
                'assigned' => auth()->id(),
            ]),
            'on_hold' => $this->statsrepo->countProjects([
                'status' => 'on_hold',
                'assigned' => auth()->id(),
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
                'assigned' => auth()->id(),
            ]),
        ];



    //[cad][all]
        $payload['all_cad_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Not Started',
            ]),
            'in_complete' => $this->statsrepo->countProjects([
                'project_custom_field_41' =>'Incomplete or missing data',
            ]),
            'query_raised' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Query Raised',
            ]),
            'in_for_approval' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'In for Approval',
            ]),
        ];
        //[cad][my]
        $payload['my_cad_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Not Started',
                'assigned' => auth()->id(),
            ]),
            'in_complete' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Incomplete or missing data',
                'assigned' => auth()->id(),
            ]),
            'query_raised' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'Query Raised',
                'assigned' => auth()->id(),
            ]),
            'in_for_approval' => $this->statsrepo->countProjects([
                'project_custom_field_41' => 'In for Approval',
                'assigned' => auth()->id(),
            ]),
        ];

        //filter
        $payload['all_events'] = $this->eventsrepo->search([
            'pagination' => 20,
            'filter' => 'timeline_visible',
        ]);
        
        //[leads] - alltime
        // $data = $this->widgetLeads('alltime');
        // $payload['leads_stats'] = json_encode($data['stats']);
        // $payload['leads_key_colors'] = json_encode($data['leads_key_colors']);
        // $payload['leads_chart_center_title'] = $data['leads_chart_center_title'];

       
        //filter payments-today
        $payload['filter_payment_today'] = \Carbon\Carbon::now()->format('Y-m-d');

        //filter payments - this month
        $payload['filter_payment_month_start'] = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $payload['filter_payment_month_end'] = \Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d');

        //return payload
        return $payload;

    }

    /**
     * create a leads widget
     * [UPCOMING] call this via ajax for dynamically changing dashboad filters
     * @param string $filter [alltime|...]  //add as we go
     * @return \Illuminate\Http\Response
     */
    public function widgetLeads($filter) {

        $payload['stats'] = [];
        $payload['leads_key_colors'] = [];
        $payload['leads_chart_center_title'] = __('lang.leads');

        $counter = 0;

        //do this for each lead category
        foreach (config('home.lead_statuses') as $status) {

            //count all leads
            if ($filter = 'alltime') {
                $count = $this->statsrepo->countLeads(
                    [
                        'status' => $status['id'],
                    ]);
            }

            //add to array
            $payload['stats'][] = [
                $status['title'], $count,
            ];

            //add to counter
            $counter += $count;

            $payload['leads_key_colors'][] = $status['colorcode'];

        }

        // no lead in system - display something (No Leads - 100%) in chart
        if ($counter == 0) {
            $payload['stats'][] = [
                'No Leads', 1,
            ];
            $payload['leads_key_colors'][] = "#eff4f5";
            $payload['leads_chart_center_title'] = __('lang.no_leads');
        }

        return $payload;
    }
    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        $page = [
            'crumbs' => [
                __('lang.home'),
            ],
            'crumbs_special_class' => 'main-pages-crumbs',
            'page' => 'home',
            'meta_title' => __('lang.home'),
            'heading' => __('lang.home'),
            'mainmenu_home' => 'active',
            'add_button_classes' => '',
        ];

        return $page;
    }
}
