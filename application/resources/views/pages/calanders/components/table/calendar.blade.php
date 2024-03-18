<div id="tasks-view-wrapper"class="scheduler_view" style="height:800px;overflow:auto;">
 <article class="content">
        <aside class="sidebar calendar-sidebar">
          <div class="sidebar-item label label-rounded check-all-box">
            <input class="checkbox-all" type="checkbox" id="all" value="all" checked />
            <label class="checkbox checkbox-all" for="all">View all</label>
          </div>
          <hr />
          @foreach($parent_tasks as $mCal)
          <div class="sidebar-item label label-rounded" style="background-color:{{$mCal->backgroundColor}};">
            <input type="checkbox" id="{{$mCal->id}}" value="{{$mCal->id}}" checked />
            <label class="label label-rounded checkbox checkbox-calendar checkbox-{{$mCal->id}}"  for="{{$mCal->id}}">{{$mCal->name}}</label>
          </div>
          @endforeach
          <hr />
          
        </aside>
        <section class="app-column calendar-app-column">

          <main id="app"></main>
        </section>
      </article>
    </div>

</div>