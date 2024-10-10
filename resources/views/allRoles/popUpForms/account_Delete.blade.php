<div class="popup modal" id="account_delete" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{ route("my.profile.delete") }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Delete Request</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <input id="user_id" name="id" value="" hidden>
                <p style="color: white">Are you sure that you want to delete your account:</p>
                <div class="pl-4" style="display: flex;">
                    <div class="avatar_div">
                        <div class="avatar_frame framePreview neon_border">
                            <img id="imagePreview" src="{{ asset(Auth::User()->profile_picture) }}" class="avatar" alt=""/>
                        </div>
                        <div class="avatar_status @if(Auth::User()->account_status==1) active_account @elseif(Auth::User()->account_status==0) unactive_account @endif"></div>
                    </div>
                    <p style="color: white" class="pl-4" id="info">{{Auth::User()->firstname}} {{Auth::User()->lastname}}<br>{{Auth::User()->email}}</p>
                </div>

            </div>
            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Delete</button>
            </div>
        </form>
    </div>

</div>

<script>
    $(document).ready(function(){
        $(".dr").click(function(){
            $("#account_delete").fadeIn();
        })
    });

    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });
</script>
