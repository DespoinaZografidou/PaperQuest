
{{--CREATE A NEW PAPER--}}
<div class="popup modal" id="Paper_create" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{route('paper.submit',['type'=>$type,'id'=>$conference->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Create New Conference </h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">

                <label class="col-form-label" style="color: white">Paper's Title </label>
                <input class="form-control mb-4" id="title" name="title" placeholder="Paper's Title" required>
                <label class="col-form-label" style="color: white">Paper's Description </label>
                <textarea class="form-control" id="description" name="description" placeholder="Paper's Description"></textarea>

                <label class="col-form-label mt-4" style="color: white">Paper's Keywords</label>
                <input class="form-control mb-4" id="keywords" name="keywords" placeholder="Paper's keyword 1, Paper's keyword 2...." value="" required>
                <label class="col-form-label" style="color: white">Upload the Paper </label>
                <input type="file" class="form-control mb-4" id="file" name="file" required>

            </div>

            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>
    </div>
</div>

{{--UPDATE A PAPER--}}
<div class="popup modal" id="Paper_update" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{ route('paper.update',['type'=>$type,'id'=>$conference->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">

                <h5 class="modal-title" style="color: white">Update Conference </h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>

            </div>
            <div class="modal-body bg-dark container">

                <input name="paper_id" id="p_id" value="" hidden required>

                <label class="col-form-label" style="color: white">Paper's Title </label>
                <input class="form-control mb-4" id="paper_title" name="title" placeholder="Paper's Title" required>
                <label class="col-form-label" style="color: white">Paper's Description </label>
                <textarea class="form-control" id="update_description" name="description" placeholder="Paper's Description" contenteditable="true" required></textarea>
                <label class="col-form-label mt-4" style="color: white">Paper's Keywords</label>
                <input class="form-control mb-4" id="paper_keywords" name="keywords" placeholder="Paper's keyword 1, Paper's keyword 2...." value="" required>
                <label class="col-form-label" style="color: white">Upload the Paper </label>
                <input type="file" class="form-control mb-4" id="file" name="file">

            </div>

            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>
    </div>
</div>

{{--ADD AUTHORS--}}
<div class="popup modal" id="Paper_addAuthors" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" action="{{route('paper.authors',['type'=>$type,'id'=>$conference->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Select authors</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <div class="row justify-content-between">
                    <div class="col-md-6" style="border-right: 1px solid white">
                        <input name="paper_id" id="paper_id" value="" hidden>

                        <h4 style="color: white;">Add Authors</h4>
                        <label class="col-form-label" style="color: white" data-dynamic-select><i class="fi fi-sr-member-list"></i> Choose Authors</label>
                        <select id="AuthorSelect" name="user" class="form-control" >
                            <option value="" disabled hidden selected>Select a user</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">
                                    {{$u->firstname}} {{$u->lastname}}
                                </option>
                            @endforeach
                        </select>
                        <div class="check-area" id="selectedAuthor"></div>
                    </div>
                    <div class="col-md-6" style="border-right: 1px solid white">
                        <h4 style="color: white;">Remove Authors</h4>
                        <label class="col-form-label" style="color: white" data-dynamic-select><i class="fi fi-sr-users"></i> Choose Author</label>
                        <div class="check-area" id="deleteAuthor">
                            <div class="user-checkbox">
                                <input  type="checkbox" id="creator" disabled>
                                <label style="color: white" for="creator"><span style="background-color: lightyellow"></span>{{Auth::User()->firstname}} {{Auth::User()->lastname}}<br><i class="small pl-4">This user is the creator.</i></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>
        </form>
    </div>
</div>


{{--DELETE A PAPER--}}
<div class="popup modal" id="Paper_delete" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content" action="{{route('paper.delete',['type'=>$type,'id'=>$conference->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Delete Conference</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <input id="pap_id" name="paper_id" value="" hidden required>
                <p style="color: white">Are you sure that you want to delete your paper submission in the conference "{{$conference->title}}" with the title below ?</p>
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



{{--ADD REVIEWERS--}}
<div class="popup modal" id="Paper_reviewrs" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" action="{{ route('paper.reviewers',['type'=>$type, 'id'=>$conference->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('GET')
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">Select reviewers</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <div class="row justify-content-between">
                    <div class="col-md-6" style="border-right: 1px solid white">
                        <input name="paper_id" id="pId" value="" hidden>

                        <h4 style="color: white;">Add Reviewers</h4>
                        <label class="col-form-label" style="color: white" data-dynamic-select><i class="fi fi-sr-member-list"></i> Choose Reviewers</label>
                        <select id="ReviewerSelect" name="user" class="form-control" >
                            <option value="" disabled hidden selected>Select a user</option>
                            @foreach($conference->pcMember as $m)
                                <option value="{{ $m->id }}">
                                    {{$m->user->firstname}} {{$m->user->lastname}}
                                </option>
                            @endforeach
                        </select>
                        <div class="check-area" id="selectedReviewer">

                        </div>
                        <p class="small" id="limit" style="color: white;">You reached the limit of reviewers for this paper. </p>
                    </div>
                    <div class="col-md-6" style="border-right: 1px solid white">
                        <h4 style="color: white;">Remove Reviewers</h4>
                        <label class="col-form-label" style="color: white" data-dynamic-select><i class="fi fi-sr-users"></i> Choose Reviewer</label>
                        <div class="check-area" id="deleteReviewer">

                        </div>
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
    tinyMCE.init({
        selector: 'textarea',
        plugins: 'autolink lists link  charmap  preview wordcount ',
        toolbar: 'undo redo | bold italic underline | bullist | wordcount ',
        menubar: false,
        force_br_newlines: true, // Recognize newlines as line breaks
        height: 330,
        elementpath: false,
        branding: false,
        entity_encoding : "raw",
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave(); // Updates the underlying <textarea>
            });
        }
    });

    $('form').on('submit', function(e) {
        tinymce.triggerSave(); // Force the TinyMCE content to be saved in the <textarea>
    });

    $(document).ready(function() {
        // On click show the create form for a new conference
        $(".create").click(function() {
            tinyMCE.activeEditor.setContent('');

            $("#Paper_create").fadeIn();
        });

        $(".edit").click(function(){
            const {p_id,description,title,keywords}=$(this).data();
            $("#p_id").val(p_id);
            $('#paper_title').val(title);
            $("#paper_keywords").val(keywords);

            tinyMCE.get('update_description').setContent(description);

            $("#Paper_update").fadeIn();

        });


        $(".authors").click(function() {
            const {paper_id, authors}=$(this).data();
            $('#paper_id').val(paper_id);

            $('#selectedAuthor, #deleteAuthor').empty();
            $('#ReviewerSelect').find("option").show();

            var creatorHtml = '<div class="user-checkbox">'+
                '<input  type="checkbox" id="creator" disabled>'+
                '<label style="color: white" for="creator"><span style="background-color: lightyellow"></span>' + '{{Auth::User()->firstname}} {{Auth::User()->lastname}}' + '<br><i class="small pl-4">This user is the creator.</i></label>'+
                '</div>';
            $('#deleteAuthor').append(creatorHtml);

            authors.forEach(function(user) {
                 var checkboxHtml = '<div class="user-checkbox" id="'+user.user_id+'">' +
                    '<input type="checkbox" data-user_id="'+user.user_id+'" id="Author' +user.user_id + '" name="removeAuthors[]" value="' + user.id + '">' +
                    '<label style="color: white" for="Author' + user.user_id + '"><span></span>' + user.user.firstname +' '+user.user.lastname+ '</label>' +
                    '</div>';
                $('#AuthorSelect').find("option[value='" + user.user_id + "']").hide();
                $('#deleteAuthor').append(checkboxHtml);
                        });
            $("#Paper_addAuthors").fadeIn();
        });


    //
        $('#AuthorSelect').change(function (){
            var selectedUserId= $(this).val();
            var selectedUserName=$(this).find("option:selected").text();

            var checkboxHtml = '<div class="user-checkbox">' +
                '<input type="checkbox" id="userCheckbox' + selectedUserId + '" name="addAuthors[]" value="' + selectedUserId + '" checked>' +
                '<label style="color: white" for="userCheckbox' + selectedUserId + '"><span></span>' + selectedUserName + '</label>' +
                '</div>';

            // Hide the selected option in both dropdowns
            $('#AuthorSelect').find("option[value='" + selectedUserId + "']").hide();

            $('#selectedAuthor').append(checkboxHtml);
        });

        // Handle unchecking of checkboxes to show options back in the dropdowns
        $('#selectedAuthor').on('change', 'input[type="checkbox"]', function() {
            if (!this.checked) {
                var userId = $(this).val();

                // Remove the checkbox container
                $(this).closest('.user-checkbox').remove();

                // Show the option in both dropdowns again
                $('#AuthorSelect').find("option[value='" + userId + "']").show();
            }
        });
    //
        // Handle unchecking of checkboxes to show options back in the dropdowns
        $('#deleteAuthor').on('change', 'input[type="checkbox"]', function() {
            var {user_id} = $(this).data();
            if (this.checked) {
                $('#deleteAuthor').find("div[id='" + user_id + "']").hide();


                // Show the option in both dropdowns again
                $('#AuthorSelect').find("option[value='" + user_id + "']").show();
            }

        });

        $(".reviewers").click(function(){
            const {paper_id}=$(this).data();
            $('#pId').val(paper_id);
            $('#selectedReviewer, #deleteReviewer').empty();

            var Data ={paper_id: paper_id};

            // Make Axios GET request
            axios.get('/viewreview', {
                params: Data, // Pass the data as query parameters
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                   const reviews= response.data.message;
                   // console.log(response.data.message);
                   if(reviews.length>0){
                       if(reviews.length==2){
                           $("#ReviewerSelect").prop("disabled", true);
                           $("#limit").show();
                       }else{
                           $("#ReviewerSelect").prop("disabled", false);
                           $("#limit").hide();
                       }

                       reviews.forEach(function(review) {
                               var checkboxHtml = '<div class="user-checkbox" id="'+review.pc_member_id+'">' +
                                   '<input type="checkbox" data-user_id="'+review.pc_member_id+'" id="Reviewer' + review.pc_member_id + '" name="removeReviewers[]" value="' + review.id + '">' +
                                   '<label style="color: white" for="Reviewer' + review.pc_member_id + '"><span></span>' + review.pc_member.user.firstname + ' ' + review.pc_member.user.lastname + '</label>' +
                                   '</div>';
                               $('#ReviewerSelect').find("option[value='" + review.pc_member_id + "']").hide();
                               $('#deleteReviewer').append(checkboxHtml);
                       });

                   }else {
                       console.log('No reviews found.');
                   }

                })
                .catch(error => {
                    console.error('There was an error!', error.response); // Log detailed error
                    if (error.response) {
                        console.log('Server responded with status:', error.response.status);
                        console.log('Response data:', error.response.data);
                    } else if (error.request) {
                        console.log('Request made but no response received:', error.request);
                    } else {
                        console.log('Error in setting up the request:', error.message);
                    }
                });



            $("#Paper_reviewrs").fadeIn();

        });
        $('#ReviewerSelect').change(function (){
            var selectedMemberId= $(this).val();
            var selectedMemberName=$(this).find("option:selected").text();

            var checkboxHtml = '<div class="user-checkbox">' +
                '<input type="checkbox" id="userCheckbox' + selectedMemberId + '" name="addReviewers[]" value="' + selectedMemberId + '" checked>' +
                '<label style="color: white" for="userCheckbox' + selectedMemberId + '"><span></span>' + selectedMemberName + '</label>' +
                '</div>';

            // Hide the selected option in both dropdowns
            $('#ReviewerSelect').find("option[value='" + selectedMemberId + "']").hide();

            $('#selectedReviewer').append(checkboxHtml);

            // Get all unchecked checkboxes inside the #deleteReviewer div
            var uncheckedCheckboxes = $('#deleteReviewer input[type="checkbox"]:not(:checked)');

            // Get all checked checkboxes inside the #selectedReviewer div
            var checkedCheckboxes = $('#selectedReviewer input[type="checkbox"]:checked');

            // Check if the total number of unchecked and checked checkboxes is less than 2
            if (uncheckedCheckboxes.length + checkedCheckboxes.length < 2) {
                $("#ReviewerSelect").prop("disabled", false); // Enable dropdown if less than 2
                $("#limit").hide(); // Hide limit message
            } else {
                $("#ReviewerSelect").prop("disabled", true); // Disable dropdown if 2 or more
                $("#limit").show(); // Show limit message
            }
        });

        // Handle unchecking of checkboxes to show options back in the dropdowns
        $('#selectedReviewer').on('change', 'input[type="checkbox"]', function() {
            if (!this.checked) {
                var pcMemberId = $(this).val();


                // Remove the checkbox container
                $(this).closest('.user-checkbox').remove();

                // Show the option in both dropdowns again
                $('#ReviewerSelect').find("option[value='" + pcMemberId + "']").show();
            }

            // Get all unchecked checkboxes inside the #deleteReviewer div
            var uncheckedCheckboxes = $('#deleteReviewer input[type="checkbox"]:not(:checked)');

            // Get all checked checkboxes inside the #selectedReviewer div
            var checkedCheckboxes = $('#selectedReviewer input[type="checkbox"]:checked');

            // Check if the total number of unchecked and checked checkboxes is less than 2
            if (uncheckedCheckboxes.length + checkedCheckboxes.length < 2) {
                $("#ReviewerSelect").prop("disabled", false); // Enable dropdown if less than 2
                $("#limit").hide(); // Hide limit message
            } else {
                $("#ReviewerSelect").prop("disabled", true); // Disable dropdown if 2 or more
                $("#limit").show(); // Show limit message
            }


        });
        $('#deleteReviewer').on('change', 'input[type="checkbox"]', function() {
            var {user_id} = $(this).data();
            if (this.checked) {

                $('#deleteReviewer').find("div[id='" + user_id + "']").hide();

                // Show the option in both dropdowns again
                $('#ReviewerSelect').find("option[value='" + user_id + "']").show();
            }
            // Get all unchecked checkboxes inside the #deleteReviewer div
            var uncheckedCheckboxes = $('#deleteReviewer input[type="checkbox"]:not(:checked)');

            // Get all checked checkboxes inside the #selectedReviewer div
            var checkedCheckboxes = $('#selectedReviewer input[type="checkbox"]:checked');

            // Check if the total number of unchecked and checked checkboxes is less than 2
            if (uncheckedCheckboxes.length + checkedCheckboxes.length < 2) {
                $("#ReviewerSelect").prop("disabled", false); // Enable dropdown if less than 2
                $("#limit").hide(); // Hide limit message
            } else {
                $("#ReviewerSelect").prop("disabled", true); // Disable dropdown if 2 or more
                $("#limit").show(); // Show limit message
            }


        });


        //  Function to delete a paper
        $(".delete").click(function (){
            const {paper_id, title}=$(this).data();
            $('#pap_id').val(paper_id);
            $(".info").html('<b>"' + title + '"</b><br>');
            $("#Paper_delete").fadeIn();
        });

        // Function to close the popups
        $(".popup-close").click(function() {
            $(".popup").fadeOut();
        });

    });


</script>
