
{{--CREATE A NEW CONFERENCE--}}
<div class="popup modal" id="conference_create" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{ route('my.conferences.create',['type'=>$type])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Create New Conference </h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <label class="col-form-label" style="color: white">Conference's Title </label>
                <input class="form-control mb-4" id="title" name="title" placeholder="Conference's Title" required>
                <label class="col-form-label" style="color: white">Conference's Description</label>
                <textarea class="form-control" id="create_description" name="description" placeholder="Conference's Description"></textarea>

            </div>

            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>
    </div>
</div>

{{--UPDATE A CONFERENCE--}}
<div class="popup modal" id="conference_update" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{ route('my.conferences.update',['type'=>$type]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Update Conference </h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <input name="conference_id" id="conf_id" value="" hidden>
                <label class="col-form-label" style="color: white">Conference's Title </label>
                <input class="form-control mb-4" id="conf_title" name="title" placeholder="Conference's Title" required>
                <label class="col-form-label" style="color: white">Conference's Description</label>
                <textarea class="form-control" id="update_description" name="description" placeholder="Conference's Description"></textarea>
            </div>

            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>
    </div>
</div>

{{--DELETE A CONFERENCE--}}
<div class="popup modal" id="conference_delete" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{ route('my.conferences.delete',['type'=>$type]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Delete Conference</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <input id="conference_id" name="conference_id" value="" hidden>
                <p style="color: white">Are you sure that you want to delete the conference with the title below.</p>
                <div class="pl-4">
                    <p class="info" style="color: white;"></p>
                </div>
            </div>
            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Delete</button>
            </div>
        </form>
    </div>

</div>


{{--DEFINE DATES A CONFERENCE--}}
<div class="popup modal" id="define_dates" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{ route('my.conferences.dates',['type'=>$type]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Define Dates for "<i id="con_title"></i>"</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <input id="con_id" name="conference_id" value="" hidden required>
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label pt-4" style="color: white">Submission Date</label>
                        <input class="form-control" type="date" name="submission" id="submission" value=""/>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label pt-4" style="color: white">Assigment Date</label>
                        <input class="form-control" type="date" name="assigment" id="assigment" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label pt-4" style="color: white">Review Date</label>
                        <input class="form-control" type="date" name="review" id="review" value="" />
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label pt-4" style="color: white">Decision Date</label>
                        <input class="form-control" type="date" name="decision" id="decision" value="" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label pt-4" style="color: white">Final Submission Date</label>
                        <input class="form-control" type="date"  name="finalSubmission" id="finalSubmission" value="" />
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label pt-4" style="color: white">Final Date</label>
                        <input class="form-control" type="date"  name="final" id="final" value="" />
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>
    </div>

</div>

{{--ADD MEMBERS TO A CONFERENCE--}}
<div class="popup modal" id="add_members" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" action="{{ route('my.conference.members',['type'=>$type]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Select Members for "<i id="c_title"></i>"</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">

                <input id="c_id" name="conference_id" value="" hidden required>
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h4 style="color: white;">Add Members</h4>
                        <label class="col-form-label pt-4" style="color: white"><i class="fi fi-sr-admin"></i> Choose Pc Chairs</label>
                        <select id="pcChairSelect" name="user" class="form-select">
                            <option value="" disabled hidden selected>Select a user</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{$u->firstname}} {{$u->lastname}}</option>
                            @endforeach
                        </select>
                        <div class="check-area" id="selectedPcChairs">
                        <!-- Checkboxes for PC Chairs will appear here -->
                        </div>

                        <label class="col-form-label pt-4" style="color: white" data-dynamic-select><i class="fi fi-sr-users"></i> Choose Pc Members</label>
                        <select id="pcMemberSelect" name="user" class="form-control" >
                            <option value="" disabled hidden selected>Select a user</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" style="background-image: url('{{ $u->profile_picture }}')">
                                    {{$u->firstname}} {{$u->lastname}}
                                </option>
                            @endforeach
                        </select>

                        <div class="check-area" id="selectedPcMembers">
                            <!-- Checkboxes for PC Chairs will appear here -->
                        </div>
                    </div>
                    <div class="col-md-6" style="border-left: 1px solid white">
                        <h4 style="color: white;">Remove Members</h4>
                        <label class="col-form-label pt-4" style="color: white"><i class="fi fi-sr-admin"></i> Choose Pc Chairs</label>
                        <div class="check-area delete-area" id="deletePcChairs"></div>
                        <label class="col-form-label pt-4" style="color: white" data-dynamic-select><i class="fi fi-sr-users"></i> Choose Pc Members</label>
                        <div class="check-area delete-area" id="deletePcMembers" ></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>

    </div>

</div>




<script>
    $(document).ready(function() {
        // On click show the create form for a new conference
        $(".create").click(function() {
            $("#conference_create").fadeIn();

            if (!tinymce.get('create_description')) {
                tinymce.init({
                    selector: 'textarea#create_description',
                    plugins: 'autolink lists link charmap preview wordcount',
                    toolbar: 'undo redo | bold italic underline | bullist | wordcount',
                    menubar: false,
                    force_br_newlines: true,
                    height: 350,
                    elementpath: false,
                    branding: false,
                    entity_encoding: "raw",
                });
            }
            tinymce.get('create_description').setContent('');
        });

        // On click of the conference options
        $(".conference_tr").click(function(event) {
            const { id, title, description } = $(this).data();
            // if you choose the delete option then it shows the form that deletes the conference
            const $button = $(event.target).closest('.delete').find('button');
            if ($button.length) {
                $(".info").html('<b>"' + title + '"</b><br>');
                $('#conference_id').val(id);

                return $("#conference_delete").fadeIn();
            }
            // If you choose the option edit then it shows the form that allow you to edit the conference
            const $button1 = $(event.target).closest('.edit').find('button');
            if ($button1.length) {
                $('#conf_id').val(id);
                $('#conf_title').val(title);

                if (!tinymce.get('update_description')) {
                    tinymce.init({
                        selector: 'textarea#update_description',
                        plugins: 'autolink lists link charmap preview wordcount',
                        toolbar: 'undo redo | bold italic underline | bullist | wordcount',
                        menubar: false,
                        force_br_newlines: true,
                        height: 350,
                        elementpath: false,
                        branding: false,
                        entity_encoding: "raw",
                    });
                }
                tinymce.get('update_description').setContent(description);

                return $("#conference_update").fadeIn();
            }
            // If you choose the option dates then it shows the form that allow you to define the dates
            const $button2 = $(event.target).closest('.dates').find('button');
            if ($button2.length) {
                const {submission, assigment, review, decision, finalsubmition, final } = $(this).data();
                $('#con_id').val(id);
                $('#con_title').html(title);
                const formatDate = date => date ? new Date(date).toLocaleDateString('en-CA') : null;

                $('#submission').val(formatDate(submission));
                $('#assigment').val(formatDate(assigment));
                $('#review').val(formatDate(review));
                $('#decision').val(formatDate(decision));
                $('#finalSubmission').val(formatDate(finalsubmition));
                $('#final').val(formatDate(final));
                return $("#define_dates").fadeIn();
            }

            // If you choose the option member then it shows the form that allow you to choose the Pc member and Pc chairs
            const $button3 = $(event.target).closest('.members').find('button');
            if ($button3.length) {
                const{ pcchair, pcmember,creator } = $(this).data();
                $('#c_id').val(id);
                $('#c_title').html(title);
                $('#selectedPcChairs, #selectedPcMembers, #deletePcChairs, #deletePcMembers').empty();
                $('#pcChairSelect, #pcMemberSelect').find("option").show();

                var creatorHtml = '<div class="user-checkbox">' +
                    '<input  type="checkbox" id="creator" disabled>' +
                    '<label style="color: white" for="creator"><span style="background-color: lightyellow"></span>' + creator.firstname +' '+creator.lastname+ '<br><i class="small pl-4">This user is the creator.</i></label>' +
                    '</div>'
                $('#deletePcChairs').append(creatorHtml);

                pcchair.forEach(function(user) {
                    var checkboxHtml = '<div class="user-checkbox" id="'+user.user.id+'">' +
                        '<input type="checkbox" data-user_id="'+user.user.id+'" id="pcChair' +user.user.id + '" name="removePcChairs[]" value="' + user.id + '" >' +
                        '<label style="color: white" for="pcChair' + user.user.id + '"><span></span>' + user.user.firstname +' '+user.user.lastname+ '</label>' +
                        '</div>'
                    $('#pcChairSelect, #pcMemberSelect').find("option[value='" + +user.user.id + "']").hide();
                    $('#deletePcChairs').append(checkboxHtml);
                });
                pcmember.forEach(function(user) {
                    var checkboxHtml = '<div class="user-checkbox" id="'+user.user.id+'">' +
                        '<input type="checkbox" data-user_id="'+user.user.id+'" id="pcMember' +user.user.id + '" name="removePcMembers[]" value="' + user.id + '">' +
                        '<label style="color: white" for="pcMember' + user.user.id + '"><span></span>' + user.user.firstname +' '+user.user.lastname+ '</label>' +
                        '</div>'
                    $('#pcChairSelect, #pcMemberSelect').find("option[value='" + +user.user.id + "']").hide();
                    $('#deletePcMembers').append(checkboxHtml);
                });


                return $("#add_members").fadeIn();
            }

            return null;
        });

        // Function to close the popups
        $(".popup-close").click(function() {
            $(".popup").fadeOut();
        });

        $('#pcChairSelect').change(function (){
            var selectedUserId= $(this).val();
            var selectedUserName=$(this).find("option:selected").text();

            var checkboxHtml = '<div class="user-checkbox">' +
                '<input type="checkbox" id="userCheckbox' + selectedUserId + '" name="addPcChairs[]" value="' + selectedUserId + '" checked>' +
                '<label style="color: white" for="userCheckbox' + selectedUserId + '"><span></span>' + selectedUserName + '</label>' +
                '</div>';

            // Hide the selected option in both dropdowns
            $('#pcChairSelect, #pcMemberSelect').find("option[value='" + selectedUserId + "']").hide();

            $('#selectedPcChairs').append(checkboxHtml);
        });


        $('#pcMemberSelect').change(function (){
            var selectedUserId= $(this).val();
            var selectedUserName=$(this).find("option:selected").text();

            var checkboxHtml = '<div class="user-checkbox">' +
                '<input type="checkbox" id="userCheckbox' + selectedUserId + '" name="addPcMembers[]" value="' + selectedUserId + '" checked>' +
                '<label style="color: white" for="userCheckbox' + selectedUserId + '"><span></span>' + selectedUserName + '</label>' +
                '</div>';

            // Hide the selected option in both dropdowns
            $('#pcChairSelect, #pcMemberSelect').find("option[value='" + selectedUserId + "']").hide();

            $('#selectedPcMembers').append(checkboxHtml);
        });


        // Handle unchecking of checkboxes to show options back in the dropdowns
        $('#selectedPcChairs, #selectedPcMembers').on('change', 'input[type="checkbox"]', function() {
            if (!this.checked) {
                var userId = $(this).val();

                // Remove the checkbox container
                $(this).closest('.user-checkbox').remove();

                // Show the option in both dropdowns again
                $('#pcChairSelect, #pcMemberSelect').find("option[value='" + userId + "']").show();
            }
        });

        // Handle unchecking of checkboxes to show options back in the dropdowns
        $('#deletePcChairs, #deletePcMembers').on('change', 'input[type="checkbox"]', function() {
            var {user_id} = $(this).data();
            if (this.checked) {
                $('#deletePcChairs, #deletePcMembers').find("div[id='" + user_id + "']").hide();


                // Show the option in both dropdowns again
                $('#pcChairSelect, #pcMemberSelect').find("option[value='" + user_id + "']").show();
            }

        });

    });

</script>
