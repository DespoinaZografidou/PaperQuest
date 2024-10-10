
<nav class="navbar navbar-expand-md navbar-light shadow-lg align-items-start py-2 sidebar" >
    <div class="pr-2" style="padding-top: 60px;display: flex">
            <ul class="navbar">
                @guest
                    <i class="nav-item mb-3 pb-3" style="width: 170px;color: white;display: flex;">
                        <div  class="sidebar_image_div">
                            <div class="sidebar_image_frame neon_border neon-white">
                                <img id="imagePreview" src="{{ asset('profile_pictures/avatar.jpg') }}" class="sidebar_image" alt=""/>
                            </div>
                        </div>
                        <div class="pt-3 pl-2">Guest</div>
                    </i>
                    <li class="nav-item button-57 pt-2 mt-4" style="width: 170px;">
                        <a class="nav-link pl-2" href="{{ url('/') }}"><i class="fi fi-ss-videoconference"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conferences</a>
                    </li>

                @else
                    <i class="nav-item pb-3 mb-3" style="color: white;display: flex;">
                        <div  class="sidebar_image_div">
                            <div class="sidebar_image_frame neon_border @if(Auth::User()->account_status==1) neon-green @elseif(Auth::User()->account_status==0) neon-red @endif">
                                <img src="{{ asset(Auth::User()->profile_picture) }}" class="sidebar_image" alt=""/>
                            </div>
                            <div class="sidebar_status @if(Auth::User()->account_status==1) active_account @elseif(Auth::User()->account_status==0) unactive_account @endif"></div>
                        </div>

                        <div class="pt-3 pl-2" style="width: 120px">{{Auth::User()->firstname}} {{Auth::User()->lastname}}</div>
                    </i>

                    @if(Auth::User()->system_role==="Admin")
                    <li class="nav-item button-57 pt-2" style="width: 170px;">
                        <a class="nav-link pl-2" href="{{ route("admin.home" )}}"><i class="fi fi-rs-chart-histogram"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statistics</a>
                    </li>

                    <li class="choice_drop_down_user button-57 nav-item pt-2" style="width: 170px;">
                        <a class="nav-link pl-2"><i class="fi fi-sr-users-alt"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Members</a>
                    </li>
                    <div class="drop_down_div_user bg-dark">
                        <li class="nav-item button-57 pt-2" style="width: 170px;">
                            <a class="nav-link pl-2" href="{{ route("manage.requests") }}"><i class="fi fi-sr-member-list"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Requests</a>
                        </li>
                        <li class="nav-item button-57 pt-2" style="width: 170px;">
                            <a class="nav-link pl-2" href="{{ route("manage.users") }}"><i class="fi fi-sr-users"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Users</a>
                        </li>
                        <li class="nav-item button-57 pt-2" style="width: 170px;">
                            <a class="nav-link pl-2" href="{{ route("manage.admins") }}"><i class="fi fi-sr-admin"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admins</a>
                        </li>
                    </div>
                    @endif

                    @if(Auth::User()->system_role==="User")
                    <li class="nav-item button-57 pt-2" style="width: 170px;">
                       <a class="nav-link pl-2" href="{{ route("user.home" )}}"><i class="fi fi-rs-chart-histogram"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Statistics</a>
                    </li>

                    <li class="choice_drop_down_conference button-57 nav-item pt-2" style="width: 170px;">
                        <a class="nav-link pl-2"><i class="fi fi-ss-videoconference"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Conferences</a>
                    </li>
                    <div class="drop_down_div_conference bg-dark">
                        <li class="nav-item button-57 pt-2" style="width: 170px;">
                            <a class="nav-link pl-2" href="{{ route('my.conferences',['type'=>'Author']) }}"><i class="fi fi-sr-member-list"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As Author</a>
                        </li>
                        <li class="nav-item button-57 pt-2" style="width: 170px;">
                            <a class="nav-link pl-2" href="{{ route('my.conferences',['type'=>'Pc Member']) }}"><i class="fi fi-sr-users"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As Pc Member</a>
                        </li>
                        <li class="nav-item button-57 pt-2" style="width: 170px;">
                            <a class="nav-link pl-2" href="{{ route('my.conferences',['type'=>'Pc Chair']) }}"><i class="fi fi-sr-admin"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As Pc Chair</a>
                        </li>
                    </div>

                    @endif


                    <li class="nav-item button-57 pt-2 mt-4" style="width: 170px; border-top: 2px solid white">
                        <a class="nav-link pl-2" href="{{ route("my.profile") }}"><i class="fi fi-ss-admin-alt"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Profile</a>
                    </li>

                @endguest

            </ul>

    </div>
</nav>

<script>

    $(document).ready(function (){
        // Initially hide the drop-down div
        $(".drop_down_div_user").hide();
        $(".drop_down_div_conference").hide();

        // Add click event to the drop-down trigger
        $(".choice_drop_down_user").click(function(){
            // Toggle visibility of the drop-down div
            $(".drop_down_div_user").toggle();

            // Toggle the 'active' class based on the visibility of the drop-down div
            if ($(".drop_down_div_user").is(':visible')) {
                $(".choice_drop_down_user").addClass('active');
            } else {
                $(".choice_drop_down_user").removeClass('active');
            }
        });


        // Add click event to the drop-down trigger
        $(".choice_drop_down_conference").click(function(){
            // Toggle visibility of the drop-down div
            $(".drop_down_div_conference").toggle();

            // Toggle the 'active' class based on the visibility of the drop-down div
            if ($(".drop_down_div_conference").is(':visible')) {
                $(".choice_drop_down_conference").addClass('active');
            } else {
                $(".choice_drop_down_conference").removeClass('active');
            }
        });
    });


</script>


