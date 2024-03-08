    <!--street-->
    <div class="form-data-row">
        <span class="x-data-title">{{ cleanLang(__('lang.street')) }}:</span>
        <span class="x-data-content">{{ $lead->lead_street ?? '' }}</span>
    </div>


    <!--city-->
    <div class="form-data-row">
        <span class="x-data-title">{{ cleanLang(__('lang.city')) }}:</span>
        <span class="x-data-content">{{ $lead->lead_city ?? '' }}</span>
    </div>


    <!--state-->
    <div class="form-data-row">
        <span class="x-data-title">{{ cleanLang(__('lang.state')) }}:</span>
        <span class="x-data-content">{{ $lead->lead_state ?? '' }}</span>
    </div>


    <!--zip-->
    <div class="form-data-row">
        <span class="x-data-title">{{ cleanLang(__('lang.zipcode')) }}:</span>
        <span class="x-data-content">{{ $lead->lead_zip ?? '' }}</span>
    </div>
    <!--lead details - toggle-->
    <div class="spacer row">
        <div class="col-sm-12 col-lg-8">
            <span class="title">Show Map</span>
        </div>
        <div class="col-sm-12 col-lg-4">
            <div class="switch  text-right">
                <label>
                    <input type="checkbox" name="show_map" id="show_mao"
                        class="js-switch-toggle-hidden-content" data-target="add_map">
                    <span class="lever switch-col-light-blue"></span>
                </label>
            </div>
        </div>
    </div>
    <!--lead details - toggle-->
    <!--lead details-->
    <div class="hidden" id="add_map">
        <div class="mapouter row">
            <div class="gmap_canvas">
                <iframe src="https://maps.google.com/maps?q={{ $lead->lead_street ?? '' }}%20{{ $lead->lead_city ?? '' }}%20{{ $lead->lead_zip ?? '' }}%20&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed" id="gmap_canvas" frameborder="0" scrolling="no" style="width: 450px; height: 400px;">
                </iframe><a href="https://fnfmod.org" style="display:none">fnf mod</a>
                    <style>.mapouter{position:relative;text-align:right;height:400px;width:450px;}
                    </style>
                    <a href="https://googlemapsiframegenerator.com" style="display:none">Google Maps Iframe Generator - Free Html Embed Code</a>
                <style>.gmap_canvas{overflow:hidden;background:none!important;height:400px;width:450px;}
                </style>
            </div>
        </div>
    </div>    