{{--POP UP THAT SHOWS ALL THE PAPER'S INFO AND REVIEWS--}}
<div class="popup modal" id="View_Paper" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white"> </h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <div class="tab-wrap">
                    <!-- active tab on page load gets checked attribute -->
                    <input type="radio" id="tab1" name="tabGroup1" class="tab" checked>
                    <label for="tab1">Introduction</label>

                    <input type="radio" id="tab2" name="tabGroup1" class="tab">
                    <label for="tab2">Paper</label>

                    <input type="radio" id="tab3" name="tabGroup1" class="tab">
                    <label for="tab3">Reviews</label>

                    <div class="tab__content row justify-content-between">
                        <div class="col-lg-7 shadow-lg mt-2">
                            <h5 class="pt-4">Description</h5><hr><br>
                            <label class="form-label" style="font-weight: bold;" id="tit" ></label>
                            <div id="des" style="overflow: auto; height: 350px;">

                            </div>
                        </div> <br>
                        <div class="col-lg-5 mt-2">
                            <div class="shadow-lg p-4">
                                <h5><i class="fi fi-sr-member-list"></i> Authors</h5><hr><br>
                                <div id="paper_authors" class="container" style="text-align: center; height: 175px; overflow: auto; ">

                                </div>

                            </div><br>
                            <div class="shadow-lg p-4">
                                <h5><i class="fi fi-sr-member-list"></i> Reviewers</h5><hr><br>
                                <div id="paper_reviewers" class="container" style="text-align: center; height: 100px; overflow: auto; ">
                                   The reviewers are not defined yet.
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="tab__content embed">

                    </div>

                    <div class="tab__content row justify-content-between">
                        <div class="col-lg-7 shadow-lg mt-2">
                            <h5 class="pt-4"><i class="fi fi-sr-feedback-alt"></i> Reviews</h5><hr>
                            <div id="rev" style="overflow: auto; height: 400px;">
                                <div class="chat-container">
                                    <ul class="chat allreviews"></ul>
                                </div>

                            </div>
                        </div> <br>
                        <div class="col-lg-5 mt-2">
                            <div class="shadow-lg p-4">
                                <h5><i class="fi fi-sr-test"></i> Evaluation</h5><hr><br>
                                <div id="grades" class="container" style="text-align: center; height: 175px; overflow: auto; ">

                                </div>

                            </div><br>
                            <div class="shadow-lg p-4">
                                <h5><i class="fi fi-sr-member-list"></i> Approval Status</h5><hr><br>
                                <div id="approval" class="container" style="text-align: center; height: 100px; overflow: auto; ">
                                    Not yet approved.
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-black">

            </div>
        </div>
    </div>
</div>

{{-- FORM FOR ADDING A REVIEW TO A PAPER--}}
<div class="popup modal" id="Review_Paper" style="background-color: rgba(240, 240, 240, 0.2)">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" action="{{route('paper.review',['type'=>$type, 'id'=>$conference->id])}}" method="post">@method('GET') @csrf
            <div class="modal-header bg-black">
                <h5 class="modal-title" style="color: white">My Review</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark container">
                <input type="text" id="rev_id" name="rev_id" val="" hidden>
                <input type="text" id="rev_review" name="rev_review" val="" hidden>
                <input type="number" id="rev_grade" name="mygrade" val="" min='0'  step='0.25' max='10' hidden>
                <div class="tab-wrap show_the_review">
                </div>
            </div>

            <div class="modal-footer bg-black">
                <button type="submit" class="button-84 col-md-12">Save</button>
            </div>

        </form>
    </div>
</div>


<script>
    $(document).ready(function () {
        const baseUrl = '{{ asset('') }}'; // Get base URL to the public folder from Laravel

        //If there is an authenticated user show the papers info accordingly the role in the conference
        @auth
        $('.view_paper').click(function () {
            const {paper_id} = $(this).data();  // 'file' contains the relative file path

            var Data = { p_id: paper_id, user_id: {{json_encode(Auth::User()->id)}}, con_id:{{ json_encode($conference->id)}} };


            // Make Axios GET request
            axios.get('/viewpaper', {
                params: Data, // Pass the data as query parameters
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    const papers = response.data.message; // This is the array of papers
                    const reviews= response.data.reviews;
                    if (papers.length > 0) {
                        const paper = papers[0]; // Since it's an array, access the first element

                        var approval = '';

                        if (paper.approved === 0) {
                            approval = 'Disapproved';
                        } else if (paper.approved === 1) {
                            approval = 'Approved';
                        } else if(paper.approved ===null){
                            approval = 'Not yet approved';
                        }


                        // You can now use these in your HTML elements
                        $('#tit').html(paper.title);
                        $('#des').html(paper.description); // Assuming paper has a description
                        let authorsHtml = "<div class='row'><div class='sidebar_image_div'>"+
                            "<div class='sidebar_image_frame neon_border neon-white'>"+
                                "<img id='imagePreview' src='"+ baseUrl + paper.creator.profile_picture+"' class='sidebar_image' alt=''/>"+
                           " </div>"+
                            "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ paper.creator.firstname + " " + paper.creator.lastname +"</div><div>";

                        // Loop through each author and concatenate their full names to `authorsHtml`
                        paper.author.forEach(function(author) {
                            authorsHtml += "<div class='row pt-2'><div class='sidebar_image_div'>"+
                                "<div class='sidebar_image_frame neon_border neon-white'>"+
                                "<img id='imagePreview' src='"+ baseUrl + author.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                " </div>"+
                                "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ author.user.firstname + " " + author.user.lastname +"</div><div>";
                        });
                        $('#paper_authors').html(authorsHtml);

                        let reviewers='';
                        let allreviews='';
                        let grades='';
                        reviews.forEach(function(review) {
                            reviewers += "<div class='row pt-2'><div class='sidebar_image_div'>"+
                                "<div class='sidebar_image_frame neon_border neon-white'>"+
                                "<img id='imagePreview' src='"+ baseUrl + review.pc_member.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                " </div>"+
                                "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ review.pc_member.user.firstname + " " + review.pc_member.user.lastname +"</div><div>";

                            allreviews+="<li class='message left'>"+
                                "<img class='logo' src='"+ baseUrl + review.pc_member.user.profile_picture+"' alt=''>"+
                                "<p>" + ((review.reasoning !== null) ? review.reasoning : '...') + "</p>"+
                            "</li>";

                            grades+="<div class='row pt-2'>" +
                                "<div class='sidebar_image_div'>"+
                                "<div class='sidebar_image_frame neon_border neon-white'>"+
                                "<img id='imagePreview' src='"+ baseUrl + review.pc_member.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                " </div>"+
                                "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ review.pc_member.user.firstname + " " + review.pc_member.user.lastname +"</div><br><label class='form-label text-end'>"+((review.grade !== null) ? review.grade : '-')+"/10</label></div>";
                        });
                        $('#grades').html(grades);
                        $('.allreviews').html(allreviews);
                        $('#paper_reviewers').html(reviewers);
                        $('#approval').html(approval);



                        // Now set the HTML content of the `#paper_authors` element
                        if (paper.file) {
                            // If the file exists, embed it
                            $('.embed').html('<embed src="' + baseUrl + paper.file + '" height="500" width="100%" />');
                        } else {
                            // If the file is null, show a custom message
                            $('.embed').html('<div style="height: 500px; width: 100%; display: flex; align-items: center; justify-content: center; background-color: #333; color: white;"><p>No paper available to display. This paper is not yet approved.</p></div>');
                        }

                    } else {
                        console.log('No papers found.');
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


            $('#View_Paper').fadeIn();
        });

       // if there is an authenticated user show the form to add a new review if the user is a pcmember and a reviewer in this paper
        // or a Pc Chair this conference
        $('.review').click(function(){
            const {paper_id} = $(this).data();  // 'file' contains the relative file path

            var Data = { paper_id: paper_id};
            axios.get('/viewreview', {
                params: Data, // Pass the data as query parameters
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    const reviews= response.data.message;
                    var conference_creator_id = {{ $conference->creator_id }};
                    var pc_chairs = {!! json_encode($conference->pcChair ?? []) !!};
                    const IsCreatorOfConference = (conference_creator_id === {{ Auth::user()->id }});
                    const IsPcChair = pc_chairs.some(pc_chair => pc_chair.user_id === {{ Auth::user()->id }});
                    var Tabs='';
                    var TabContent='';
                    var i=1;
                    var checked='checked';


                        reviews.forEach(function(review) {

                                var approval = 'Not yet approved';

                            if(IsCreatorOfConference===true || IsPcChair===true){
                                Tabs+= '<input type="radio" id="tab' + review.id + '" name="tabGroup2" class="tab" data-review="'+review.reasoning+'" data-grade="'+review.grade+'" '+ checked +'>'+
                                      '<label id="tab' + review.id + '"><img class="logo" src="'+ baseUrl + review.pc_member.user.profile_picture+'" style="position: static;  width: 30px;height: 30px; box-shadow: none;" alt=""> Review of '+review.pc_member.user.firstname + " " + review.pc_member.user.lastname+'</label>';
                                TabContent+='<div class="tab__content row justify-content-between">'+
                                        '<div class="col-lg-7 shadow-lg mt-2">'+
                                            '<h5 class="pt-4"><i class="fi fi-sr-feedback-alt"></i> Reviews</h5><hr>'+
                                            '<div style="overflow: auto; height: 350px;">'+
                                                '<div class="chat-container">'+
                                                    '<ul class="chat">'+
                                                        '<li class="message right">'+
                                                            '<img class="logo" src="'+ baseUrl + review.pc_member.user.profile_picture+'" alt="">'+
                                                            '<div id="new_review' + review.id + '">'+
                                                                '<p>' + ((review.reasoning !== null) ? review.reasoning : '...') + '</p>'+
                                                            '</div>'+
                                                        '</li>'+
                                                    '</ul>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div style="position: relative;" class="align-content-start">'+
                                                '<input type="text" class="form-control col-md-11 fc mb-3" style="border-radius: 10px;" id="reasoning' + review.id + '">'+
                                                '<button type="button" id="submit_reasoning' + review.id + '" class="close" style="position: absolute; right:5px;top:7px"><i class="fi fi-ss-paper-plane"></i></button>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-lg-5 mt-4">'+
                                            '<div class="shadow-lg p-4">'+
                                                '<h5><i class="fi fi-sr-test"></i> Evaluation</h5><hr><br>'+
                                                '<div id="mygrade" class="container" style="text-align: center; height: 115px; overflow: auto; ">'+
                                                    "<div class='row pt-2'>" +
                                                        "<div class='sidebar_image_div'>"+
                                                            "<div class='sidebar_image_frame neon_border neon-white'>"+
                                                                "<img id='imagePreview' src='"+ baseUrl + review.pc_member.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                                            " </div>"+
                                                        "</div>" +
                                                        "<div class='pt-2 pl-4' style='width: 80%;text-align: start;'>"+ review.pc_member.user.firstname + " " + review.pc_member.user.lastname +" <br> "+
                                                            "<input type='number' value='"+review.grade+"' id='mygrade" + review.id + "' class='form-control fc text-end' min='0'  step='0.25' max='10'>"+
                                                        "</div>" +
                                                    "</div>"+
                                                '</div>'+
                                            '</div><br>'+
                                            '<div class="shadow-lg p-4">'+
                                                '<h5><i class="fi fi-sr-member-list"></i> Approval Status</h5><hr><br>'+
                                                '<div id="my_approval" class="container" style="text-align: center; height: 100px; overflow: auto; ">'+
                                                    approval+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                                i++;
                                checked='';
                                $("#rev_id").val(review.id);
                                $("#rev_grade").val(review.grade);
                                $("#rev_review").val(review.reasoning);
                            }

                            if(review.pc_member.user.id === @json(Auth::user()->id)){

                                Tabs='<input type="radio" id="tab' + review.id + '" name="tabGroup2" class="tab" data-review="'+review.reasoning+'" data-grade="'+review.grade+'" checked>'+
                                    '<label id="tab' + review.id + '">My Review</label>';
                                TabContent='<div class="tab__content row justify-content-between">'+
                                    '<div class="col-lg-7 shadow-lg mt-2">'+
                                    '<h5 class="pt-4"><i class="fi fi-sr-feedback-alt"></i> Reviews</h5><hr>'+
                                    '<div style="overflow: auto; height: 350px;">'+
                                    '<div class="chat-container">'+
                                    '<ul class="chat">'+
                                    '<li class="message right">'+
                                    '<img class="logo" src="'+ baseUrl + review.pc_member.user.profile_picture+'" alt="">'+
                                    '<div id="new_review' + review.id + '">'+
                                    '<p>' + ((review.reasoning !== null) ? review.reasoning : '...') + '</p>'+
                                    '</div>'+
                                    '</li>'+
                                    '</ul>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div style="position: relative;" class="align-content-start">'+
                                    '<input type="text" class="form-control col-md-11 fc mb-3" style="border-radius: 10px;" id="reasoning' + review.id + '">'+
                                    '<button type="button" id="submit_reasoning' + review.id + '" class="close" style="position: absolute; right:5px;top:7px"><i class="fi fi-ss-paper-plane"></i></button>'+
                                    '</div>'+
                                    '</div><br><br>'+
                                    '<div class="col-lg-5 mt-2">'+
                                    '<div class="shadow-lg p-4">'+
                                    '<h5><i class="fi fi-sr-test"></i> Evaluation</h5><hr><br>'+
                                    '<div id="mygrade" class="container" style="text-align: center; height: 115px; overflow: auto; ">'+
                                    "<div class='row pt-2'>" +
                                    "<div class='sidebar_image_div'>"+
                                    "<div class='sidebar_image_frame neon_border neon-white'>"+
                                    "<img id='imagePreview' src='"+ baseUrl + review.pc_member.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                    " </div>"+
                                    "</div>" +
                                    "<div class='pt-2 pl-4' style='width: 80%;text-align: start;'>"+ review.pc_member.user.firstname + " " + review.pc_member.user.lastname +" <br> "+
                                    "<input type='number' value='"+review.grade+"' id='mygrade" + review.id + "' class='form-control fc text-end' min='0'  step='0.25' max='10'>"+
                                    "</div>" +
                                    "</div>"+
                                    '</div>'+
                                    '</div><br>'+
                                    '<div class="shadow-lg p-4">'+
                                    '<h5><i class="fi fi-sr-member-list"></i> Approval Status</h5><hr><br>'+
                                    '<div id="my_approval" class="container" style="text-align: center; height: 100px; overflow: auto; ">'+
                                        approval+
                                    '</div>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>';
                                $("#rev_id").val(review.id);
                                $("#rev_grade").val(review.grade);
                                $("#rev_review").val(review.reasoning);
                            }
                            $('.show_the_review').html(Tabs+TabContent);
                        });

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

            $('#Review_Paper').fadeIn();
        });


        $(document).on('click', 'button[id^=submit_reasoning]', function() {
            // Get the ID of the clicked button (e.g., "submit_reasoning1", "submit_reasoning2", etc.)
            var tabId = $(this).attr('id').replace('submit_reasoning', ''); // Extract the tab ID by removing "submit_reasoning"

            // Get the reasoning input value for the current tab
            var reasoning = $('#reasoning' + tabId).val();

            // Update the review content based on the reasoning
            var my_review = reasoning ? reasoning : '...';
            $('#new_review' + tabId).html(my_review);
            console.log('#new_review' + tabId);

            // Update hidden review field with the reasoning value
            $('#rev_review').val("<p>" + reasoning + "</p>");

            // Clear the reasoning input field
            $('#reasoning' + tabId).val("");
        });

        $(document).on('click', '.popup-close', function() {
            $(".popup").fadeOut();    // Only fade out the modal
        });

        $(document).on('click', 'label[id^=tab]', function() {
            // Get the ID of the clicked label
            var tabId = $(this).attr('id');

            // Find the corresponding radio button (input) and check it
            var radioInput = $('input#' + tabId);
            radioInput.prop('checked', true);

            // Use `.attr()` to get the data attributes
            var review = radioInput.attr('data-review');  // Fetching attribute from the input
            var grade = radioInput.attr('data-grade');    // Fetching attribute from the input

            // Set the review and grade in the form inputs
            $('#rev_id').val(tabId.replace('tab', ''));  // Removes "tab" and keeps only the number
            $('#rev_grade').val(grade);
            $('#rev_review').val(review);
        });
        $(document).on('change', 'input[id^=mygrade]', function() {
            // Capture the ID of the changed input field
            var gradeId = $(this).attr('id');  // e.g., "mygrade1", "mygrade2", etc.

            // Extract the numerical part (review id) from the id (removes "mygrade")
            var reviewId = gradeId.replace('mygrade', '');

            // Get the new grade value from the input field
            var newGrade = $(this).val();

            // Log or perform actions with the new grade and reviewId
            console.log("Review ID: " + reviewId + ", New Grade: " + newGrade);

            // If you need to update a hidden field or perform another action:
            $('#rev_grade').val(newGrade);
        });



        @else

        $('.view_paper').click(function () {
            const {paper_id} = $(this).data();  // 'file' contains the relative file path

            var Data = { p_id: paper_id };


            // Make Axios GET request
            axios.get('/viewpapervisitor', {
                params: Data, // Pass the data as query parameters
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    const papers = response.data.message; // This is the array of papers
                    const reviews= response.data.reviews;
                    if (papers.length > 0) {
                        const paper = papers[0]; // Since it's an array, access the first element

                        // You can now use these in your HTML elements
                        $('#tit').html(paper.title);
                        $('#des').html(paper.description); // Assuming paper has a description
                        let authorsHtml = "<div class='row'><div class='sidebar_image_div'>"+
                            "<div class='sidebar_image_frame neon_border neon-white'>"+
                            "<img id='imagePreview' src='"+ baseUrl + paper.creator.profile_picture+"' class='sidebar_image' alt=''/>"+
                            " </div>"+
                            "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ paper.creator.firstname + " " + paper.creator.lastname +"</div><div>";

                        // Loop through each author and concatenate their full names to `authorsHtml`
                        paper.author.forEach(function(author) {
                            authorsHtml += "<div class='row pt-2'><div class='sidebar_image_div'>"+
                                "<div class='sidebar_image_frame neon_border neon-white'>"+
                                "<img id='imagePreview' src='"+ baseUrl + author.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                " </div>"+
                                "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ author.user.firstname + " " + author.user.lastname +"</div><div>";
                        });
                        $('#paper_authors').html(authorsHtml);

                        let reviewers='';
                        let allreviews='';
                        let grades='';
                        reviews.forEach(function(review) {
                            reviewers += "<div class='row pt-2'><div class='sidebar_image_div'>"+
                                "<div class='sidebar_image_frame neon_border neon-white'>"+
                                "<img id='imagePreview' src='"+ baseUrl + review.pc_member.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                " </div>"+
                                "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ review.pc_member.user.firstname + " " + review.pc_member.user.lastname +"</div><div>";

                            allreviews+="<li class='message left'>"+
                                "<img class='logo' src='"+ baseUrl + review.pc_member.user.profile_picture+"' alt=''>"+
                                "<p class='small'>You have to log in to see my review.</p>"+
                                "</li>";

                            grades="<div class='row pt-2'><div class='sidebar_image_div'>"+
                                "<div class='sidebar_image_frame neon_border neon-white'>"+
                                "<img id='imagePreview' src='"+ baseUrl + review.pc_member.user.profile_picture+"' class='sidebar_image' alt=''/>"+
                                " </div>"+
                                "</div><div class='pt-2 pl-4' style='width: 70%;text-align: start;'>"+ review.pc_member.user.firstname + " " + review.pc_member.user.lastname +"</div>" +
                                "<div class='pl-5 small'>You have to log in to see the evaluation</div>"+
                                "<div>";
                        });
                        $('#grades').html(grades);
                        $('.allreviews').html(allreviews);
                        $('#paper_reviewers').html(reviewers);



                        // Now set the HTML content of the `#paper_authors` element
                        if (paper.file) {
                            // If the file exists, embed it
                            $('.embed').html('<embed src="' + baseUrl + paper.file + '" height="500" width="100%" />');
                        } else {
                            // If the file is null, show a custom message
                            $('.embed').html('<div style="height: 500px; width: 100%; display: flex; align-items: center; justify-content: center; background-color: #333; color: white;"><p>No paper available to display. This paper is not yet approved.</p></div>');
                        }

                    } else {
                        console.log('No papers found.');
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


            $('#View_Paper').fadeIn();
        });

        // Function to close the popups
        $(".popup-close").click(function() {
            $(".popup").fadeOut();
        });


        @endauth
    });





</script>
