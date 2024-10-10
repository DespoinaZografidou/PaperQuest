@extends('layouts.app')
@section('content')

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 pt-4">
                    <div class="card bg-dark">
                        <div class="card-body con">
                            <div style="display: flex;">
                                <div  class="sidebar_image_div">
                                    <div class="sidebar_image_frame">
                                        <img src="{{ asset($conference->creator->profile_picture) }}" class="sidebar_image" alt=""/>
                                    </div>
                                </div>
                                <div class="pl-2" style="width: 150px; color: white">
                                    <b>{{ $conference->creator->firstname }} {{$conference->creator->lastname}}</b>
                                    <p class="small">Created at: {{ date('d-m-Y', strtotime($conference->created_at)) }}</p>
                                </div>
                            </div>
                            <b style="color: white">{{ $conference->title }}</b>
                            <hr style="color: white">
                            <div class="mt-2 pl-3 pr-3 " style="overflow: auto; height: 320px;">
                                <span style="color: darkgrey">{!! $conference->description !!}</span>
                            </div>
                            <hr style="color: white">
                            <div style="display: flex; justify-content: end;">
                                <i style="color: white" class="small state pl-2 pr-2 "></i>
                            </div>

                        </div>
                        <div class="card-footer bg-light container">
                            <div class="row justify-content-center">
                            <div class="tool t1 col-4" style="color: darkgrey" data-toggle="tooltip" data-placement="left" data-html="true"
                                 title="<br> <i class='fi fi-sr-calendar-clock'></i> <b>Dates of States</b><br>
                                  Submission at: {{ $conference->submission_at ? date('d/m/Y', strtotime($conference->submission_at)) : 'Not defined' }}<br>
                                  Assigment at: {{ $conference->assigment_at ? date('d/m/Y', strtotime($conference->assigment_at)) : 'Not defined' }}<br>
                                  Review at: {{ $conference->review_at ? date('d/m/Y', strtotime($conference->review_at)) : 'Not defined' }}<br>
                                  Decision at: {{ $conference->decision_at ? date('d/m/Y', strtotime($conference->decision_at)) : 'Not defined' }}<br>
                                  Final Submission at: {{ $conference->final_submission_at ? date('d/m/Y', strtotime($conference->final_submission_at)) : 'Not defined' }}<br>
                                  Final at: {{ $conference->final_at ? date('d/m/Y', strtotime($conference->final_at)) : 'Not defined' }}">

                                <button type="button" class="close">
                                    <i class="fi fi-sr-calendar-clock"></i> <b>Dates of States</b>
                                </button>
                            </div>
                            <div class="tool t2 col-4" style="color: darkgrey" data-toggle="tooltip" data-placement="left" data-html="true"
                                 title="<br><i class='fi fi-sr-admin'></i> <b>Pc Chairs</b><br>
                                 {{ $conference->creator->firstname }} {{$conference->creator->lastname}}
                                 @foreach($conference->pcChair as $ch)
                                , {{ $ch->user->firstname }} {{$ch->user->lastname}}
                                 @endforeach">

                                <button type="button" class="close">
                                    <i class='fi fi-sr-admin'></i> <b>Pc Chairs</b>
                                </button>
                            </div>
                                <div class="tool t3 col-4" style="color: darkgrey" data-toggle="tooltip" data-placement="left" data-html="true"
                                     title="<br><i class='fi fi-sr-users'></i> <b>Pc Members</b><br>
                                              @foreach($conference->pcMember as $m)
                                              {{ $m->user->firstname }} {{$m->user->lastname}},
                                              @endforeach">

                                    <button type="button" class="close">
                                        <i class='fi fi-sr-users'></i><b> Pc Members</b>
                                    </button>
                                </div>
                        </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="container pt-4">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <form action=" @auth {{ route('paper.search',['type'=>$type, 'id'=>$conference->id]) }} @else {{route('home.paper.search',['type'=>$type, 'id'=>$conference->id])}} @endauth" method="post" class="form_search"> @method('GET') @csrf
                        <input type="text" class="form-control input_search" name="key" id="key" placeholder="Search by title or keyword">
                        <button type="submit" style="border: none;">
                            <i class="fi fi-bs-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

<div class="container">

    <div class="row justify-content-center pt-4">
        <div class="col-md-7">
            <div class="card shadow-lg bg-dark">
                <div class="card-header bg-black" style="display:flex;justify-content: space-between;">
                    <div><i class="fi fi-sr-scroll"></i> Papers</div>
                    @auth
                    <div style="width: 120px;" >
                        <button type="submit" class="button-7 create"> <i class="fi fi-rs-plus"></i>&nbsp;&nbsp;&nbsp;Paper</button>
                    </div>
                    @endauth
                </div>

                <table class="card-body" style="background-color: rgb(36, 37, 38);">
                    @if(!empty($papers))
                        @foreach($papers as $p)
                    <tr class="paper" style="background-color: rgb(36, 37, 38);" data-authors="{{$p->author}}" data-creator="{{$p->creator_id}}">
                        <td class="bg-light view_paper" style="width:95%;" data-file="{{ $p->file }}" data-paper_id="{{$p->id}}">
                            <div style="display: flex;">
                                <div  class="avatar_div">
                                    <div class="avatar_frame">
                                        <img src="{{ asset($p->creator->profile_picture) }}" class="avatar" alt=""/>
                                    </div>
                                </div>
                                <div class="pl-2">
                                    <b>{{ $p->creator->firstname }} {{$p->creator->lastname}}</b>
                                    <p class="small">Submitted at: {{ date('d-m-Y', strtotime($conference->created_at)) }}</p>
                                </div>
                            </div>
                            <div class="ml-2 mr-2">
                                <b>{{$p->title}}</b><hr>
                                <div class="mt-2 pl-3 pr-3 " style="overflow: hidden; height: 52px;">
                                    <span style="color: dimgrey;">{!!  $p->description!!}</span>
                                </div><hr>

                                <div style="display: flex; justify-content: end;">
                                    <i class="small pl-2 pr-2 ">
                                        @if($p->approved===null)
                                            Not yet approved
                                        @elseif($p->approved===1)
                                            <i class="fi fi-sr-hexagon-check unlocked"></i> Approved
                                        @elseif($p->approved===0)
                                            <i class="fi fi-sr-times-hexagon locked"></i> Disapproved
                                        @endif
                                    </i>
                                </div>
                            </div>
                        </td>

                        <td class="bg-light authorstools" >
                            @auth

                                <form method="post" class="approveStatus" action="{{ route('paper.approve',['type'=>$type, 'id'=>$conference->id]) }}">@csrf @method("GET")
                                    <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                                        <input type="text" name="p_id" value="{{$p->id}}" hidden>
                                        <i class="fi fi-sr-hexagon-check unlocked"></i>
                                    </button>
                                </form>

                            <div class="edit mt-3 mb-3" data-p_id="{{$p->id}}" data-keywords="{{$p->keywords}}"
                                 data-description="{{$p->description}}" data-title="{{$p->title}}">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fi fi-ss-pen-circle"></i>
                                </button>
                            </div><br>

                            <div class="delete mt-3" data-paper_id="{{$p->id}}" data-title="{{$p->title}}">
                                <button type="button" class="close del" data-dismiss="modal" aria-label="Close">
                                    <i class="fi fi-sr-circle-trash"></i>
                                </button>
                            </div><br>

                            <div class="authors mt-3 mb-3" data-paper_id="{{$p->id}}" data-authors="{{$p->author}}" >
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fi fi-sr-member-list"></i>
                                </button>
                            </div><br>

                            <div class="reviewers mt-3 mb-3" data-paper_id="{{$p->id}}" >
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <i class="fi fi-sr-review"></i>
                                 </button>
                            </div><br>
                            <div class="review mt-3 mb-3" data-paper_id="{{$p->id}}" >
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <i class="fi fi-sr-feedback-alt"></i>
                                 </button>
                            </div><br>
                                <form method="post" class="disapproveStatus" action="{{ route('paper.disapprove',['type'=>$type, 'id'=>$conference->id]) }}" >@csrf @method("GET")
                                    <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                                        <input type="text" name="p_id" value="{{$p->id}}" hidden>
                                        <i class="fi fi-sr-times-hexagon locked"></i>
                                    </button>
                                </form>
                            @endauth

                        </td>
                    </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
        <script>
            $(document).ready(function () {
                function calculateState() {
                    var currentdate = new Date().toLocaleDateString('en-CA');
                    var stateElement = $(".state");
                    $('.authors').hide();
                    $('.reviewers').hide(); // Hides all edit buttons initially
                    $('.review').hide(); // Hides all edit buttons initially
                    $('.delete').hide(); // Hides all delete buttons initially
                    $('.edit').hide(); // Hides all edit buttons initially
                    $('.create').hide();
                    $('.approveStatus').hide();//hide
                    $('.disapproveStatus').hide();

                    // Check if the date is empty or not set, and set the flag accordingly
                    var submission = "{{ $conference->submission_at }}" ? 1 : 0;
                    var assigment = "{{ $conference->assigment_at }}" ? 1 : 0;
                    var review = "{{ $conference->review_at }}" ? 1 : 0;
                    var decision = "{{ $conference->decision_at }}" ? 1 : 0;
                    var finalsubmition = "{{ $conference->final_submission_at }}" ? 1 : 0;
                    var final = "{{ $conference->final_at }}" ? 1 : 0;

                    // Parse the dates if they exist
                    var created_at = new Date("{{ $conference->created_at }}").toLocaleDateString('en-CA');
                    var submission_at = submission ? new Date("{{ date('Y-m-d', strtotime($conference->submission_at)) }}").toLocaleDateString('en-CA') : null;
                    var assigment_at = assigment ? new Date("{{ date('Y-m-d', strtotime($conference->assigment_at)) }}").toLocaleDateString('en-CA') : null;
                    var review_at = review ? new Date("{{ date('Y-m-d', strtotime($conference->review_at)) }}").toLocaleDateString('en-CA') : null;
                    var decision_at = decision ? new Date("{{ date('Y-m-d', strtotime($conference->decision_at)) }}").toLocaleDateString('en-CA') : null;
                    var finalsubmition_at = finalsubmition ? new Date("{{ date('Y-m-d', strtotime($conference->final_submission_at)) }}").toLocaleDateString('en-CA') : null;
                    var final_at = final ? new Date("{{ date('Y-m-d', strtotime($conference->final_at)) }}").toLocaleDateString('en-CA') : null;

                    var state = '';

                    // Determine state based on date comparisons
                    if (created_at <= currentdate || (submission === 1 && submission_at > currentdate)) {
                        state = 'CREATED';

                        if (submission_at <= currentdate || (assigment === 1 && assigment_at > currentdate)) {
                            state = 'SUBMISSION';

                            if (assigment_at <= currentdate || (review === 1 && review_at > currentdate)) {
                                state = 'ASSIGNMENT';

                                if (review_at <= currentdate || (decision === 1 && decision_at > currentdate)) {
                                    state = 'REVIEW';

                                    if (decision_at <= currentdate || (finalsubmition === 1 && finalsubmition_at > currentdate)) {
                                        state = 'DECISION';

                                        if (finalsubmition_at <= currentdate || (final === 1 && final_at > currentdate)) {
                                            state = 'FINAL SUBMISSION';
                                        }

                                        if (final === 1 && final_at <= currentdate) {
                                            state = 'FINAL';
                                        }
                                    }
                                }
                            }
                        }
                        stateElement.html('<b>State:</b> ' + state);
                    }

                    @auth
                        var conference_creator_id = {{ $conference->creator_id }};
                        var pc_members = {!! json_encode($conference->pcMember ?? []) !!};
                        var pc_chairs = {!! json_encode($conference->pcChair ?? []) !!};
                        //  If a user is logged in and the state is final submission or submission
                        if (state === 'FINAL SUBMISSION' || state === 'SUBMISSION') {

                            //Check if the user who is logged has the role of creator, pc_member or pc_chair in this conference
                            const IsCreatorOfConference = (conference_creator_id === {{ Auth::user()->id }});
                            const IsPcMember = pc_members.some(pc_member => pc_member.user_id === {{ Auth::user()->id }});
                            const IsPcChair = pc_chairs.some(pc_chair => pc_chair.user_id === {{ Auth::user()->id }});
                            const isAdmin = "{{ Auth::user() && Auth::user()->system_role === 'Admin' ? 'true' : 'false' }}";

                            let author_right = true;

                            //  If the user have any of this roles then don't let him to create a new paper
                            if( IsCreatorOfConference===true || IsPcMember===true || IsPcChair===true || isAdmin===true){
                                $('.create').hide();
                                author_right=false;
                            }

                            var rows = $('.paper');

                            // Iterate over each row
                            for (var i = 0; i < rows.length; i++) {
                                var row = rows[i];
                                var editbutton = $(row).find(".edit");
                                var deletebutton = $(row).find(".delete");
                                var authorsbutton= $(row).find(".authors");


                                var authors = $(row).data("authors"); // Assuming you are storing authors as data-authors
                                var paper_creator_id = $(row).data("creator"); // Assuming you store creator ID as data-creator



                                // Check if the current user is either an author or the creator
                                const IsAuthor = authors.some(author => author.user_id === {{ Auth::user()->id }});
                                const IsCreatorOfPaper = (paper_creator_id === {{ Auth::user()->id }});
                                console.log(authors);


                                // if the user is an author or the creator of this paper then show the buttons to edit and delete
                                if (IsAuthor===true || IsCreatorOfPaper===true) {
                                    deletebutton.show();
                                    editbutton.show();
                                    authorsbutton.show();
                                    author_right=false;
                                }
                            }


                            if(author_right && state !== 'FINAL SUBMISSION'){
                                $('.create').show();
                            }
                        }
                        if(state ==='ASSIGNMENT'){
                            //Check if the user who is logged has the role of creator, or pc_chair in this conference
                            const IsCreatorOfConference = (conference_creator_id === {{ Auth::user()->id }});
                            const IsPcChair = pc_chairs.some(pc_chair => pc_chair.user_id === {{ Auth::user()->id }});
                            if(IsCreatorOfConference || IsPcChair){
                                $('.reviewers').show();
                            }

                        }
                    if(state ==='REVIEW'){
                        //Check if the user who is logged has the role of creator, or pc_chair in this conference
                        const IsCreatorOfConference = (conference_creator_id === {{ Auth::user()->id }});
                        const IsPcChair = pc_chairs.some(pc_chair => pc_chair.user_id === {{ Auth::user()->id }});
                        const IsPcMember = pc_members.some(pc_member => pc_member.user_id === {{ Auth::user()->id }});
                        if(IsCreatorOfConference === true || IsPcChair === true){
                            $('.review').show();
                        }
                        if(IsPcMember){
                            $('.review').each(function() {
                                var paper_id = $(this).data('paper_id');
                                var Data = { p_id: paper_id, user_id: {{json_encode(Auth::User()->id)}}, con_id:{{ json_encode($conference->id)}} };
                                axios.get('/checkifreviewer', {
                                    params: Data, // Pass the data as query parameters
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                }).then(response => {
                                    const message = response.data.message; // This is the array of papers
                                    if(message===true){
                                        $(this).show();
                                    }
                                }).catch(error => {
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

                            });


                        }
                    }
                    if (state==='DECISION'){
                        const IsCreatorOfConference = (conference_creator_id === {{ Auth::user()->id }});
                        const IsPcChair = pc_chairs.some(pc_chair => pc_chair.user_id === {{ Auth::user()->id }});
                        if(IsCreatorOfConference===true || IsPcChair===true){
                            $('.approveStatus').show();
                            $('.disapproveStatus').show();
                        }

                    }
                    if(state ==='FINAL'){
                        var Data = { con_id:{{ json_encode($conference->id)}} }
                        axios.get('/finalize', {
                            params: Data, // Pass the data as query parameters
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => {
                                console.log(response.data.message);
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
                    }
                    @endauth
                }

                // Call the calculateState function initially
                calculateState();
            });

            //
            $(document).ready(function () {
                $('.t1').tooltip({
                    placement: 'bottom', // Explicitly set to left
                    trigger: 'hover focus-within',   // Ensure it's triggered on hover (or change as needed)
                    offset: '28px, 7px',    // Adjust the offset: X-axis, Y-axis
                    html: true,
                });
                $('.t2').tooltip({
                    placement: 'bottom', // Explicitly set to left
                    trigger: 'hover focus-within',   // Ensure it's triggered on hover (or change as needed)
                    offset: '0px, 7px',    // Adjust the offset: X-axis, Y-axis
                    html: true,
                });
                $('.t3').tooltip({
                    placement: 'bottom', // Explicitly set to left
                    trigger: 'hover focus-within',   // Ensure it's triggered on hover (or change as needed)
                    offset: '-28px, 7px',    // Adjust the offset: X-axis, Y-axis
                    html: true,
                });

            });

        </script>
        @auth
            @include('allRoles.popUpForms.Create_Update_Delete_Papers')
        @endauth
        @include('allRoles.popUpForms.View_Review_Paper')
@endsection

@section('sidebar')
    @include('navbars.SideBar')
@endsection
