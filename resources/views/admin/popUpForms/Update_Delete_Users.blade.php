<div class="popup modal" id="user_update" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" action="{{ route('manage.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Update User </h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <div class="row justify-content-between pb-3">
                    <div class="col-md-5 row justify-content-center pt-5 mt-4 pb-5">
                        <div class="profile_div">
                            <div class="profile_frame neon_border">
                                <img class="profile" src="" alt=""/>
                            </div>
                            <div class="profile_status"></div>
                            <label for="imageInput"><i class="fi fi-sr-cloud-upload-alt upload"></i></label>
                            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row justify-content-between">
                            <input id="id" name="id" value="" hidden>

                            <div class="col-md-6">
                                <label class="col-form-label pt-4" style="color: white">Firstname</label>
                                <input class="form-control" id="firstname" name="firstname" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label pt-4" style="color: white">Lastname</label>
                                <input class="form-control" id="lastname" name="lastname" readonly>
                            </div>
                        </div>

                        <label class="col-form-label pt-4" style="color: white">Email Address</label>
                        <input class="form-control" id="email" name="email" readonly>

                        <label class="col-form-label pt-4 " style="color: white">Role</label>
                        <select class="form-select" onfocus=""  name="role" id="role" required>
                            <option value="" id="selectedrole" selected hidden></option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>

                        <label class="col-form-label pt-4" style="color: white">Account Status</label>
                        <select class="form-select" name="status"  id="status" required>
                            <option value="" id="selectedstatus" selected hidden></option>
                            <option value="0">Locked</option>
                            <option value="1">Unlocked</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>
    </div>

</div>


<div class="popup modal" id="user_delete" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{ route('manage.delete') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Delete User</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <input id="user_id" name="id" value="" hidden>
                <p style="color: white">Are you sure that you want to delete the user:</p>
                <div class="pl-4" style="display: flex;">
                    <div class="avatar_div">
                        <div class="avatar_frame framePreview neon_border">
                            <img id="imagePreview" src="" class="avatar" alt=""/>
                        </div>
                        <div class="avatar_status statusPreview"></div>
                    </div>
                    <p style="color: white" class="pl-4" id="info"></p>
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
        $(".user_tr").click(function(event){
            const { id, firstname, lastname, email, status, role, image} = $(this).data();

            const $button = $(event.target).closest('.delete').find('button');
            if ($button.length) {
                $("#user_id").val(id);
                $('#imagePreview').attr('src', "{{asset('')}}"+image);
                if (status === 0) {
                    $(".framePreview").removeClass('neon-green');
                    $(".framePreview").addClass('neon-red');
                    $(".statusPreview").removeClass('active_account');
                    $(".statusPreview").addClass('unactive_account');
                } else {
                    $(".framePreview").removeClass('neon-red');
                    $(".framePreview").addClass('neon-green');
                    $(".statusPreview").removeClass('unactive_account');
                    $(".statusPreview").addClass('active_account');
                }
                $("#info").html("<b>"+firstname+" "+lastname+"</b><br>"+email)
                return $("#user_delete").fadeIn();
            }

            $("#id").val(id);

            $('.profile').attr('src', "{{asset('')}}"+image);

            $("#firstname").val(firstname);
            $("#lastname").val(lastname);
            $("#email").val(email);

            $("#selectedrole").val(role);
            $("#selectedrole").text(role);

            $("#selectedstatus").val(status);
            $("#selectedstatus").text(status === 1 ? 'Unlocked' : 'Locked');

            if (status === 0) {
                $(".profile_frame").removeClass('neon-green');
                $(".profile_frame").addClass('neon-red');
                $(".profile_status").removeClass('active_account');
                $(".profile_status").addClass('unactive_account');
            } else {
                $(".profile_frame").removeClass('neon-red');
                $(".profile_frame").addClass('neon-green');
                $(".profile_status").removeClass('unactive_account');
                $(".profile_status").addClass('active_account');
            }

            $("#user_update").fadeIn();
        });

        //function that close the popups forms
        $(".popup-close").click(function () {
            $(".popup").fadeOut();
        });

        $('#status').change(function() {
            if ($(this).val() === '0') {
                $(".profile_frame").removeClass('neon-green');
                $(".profile_frame").addClass('neon-red');
                $(".profile_status").removeClass('active_account');
                $(".profile_status").addClass('unactive_account');
            } else {
                $(".profile_frame").removeClass('neon-red');
                $(".profile_frame").addClass('neon-green');
                $(".profile_status").removeClass('unactive_account');
                $(".profile_status").addClass('active_account');
            }
        });

        $('#imageInput').on('change', function(e) {

            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.profile').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        });




    });
</script>
