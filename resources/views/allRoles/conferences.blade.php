@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <form action="{{ route('my.conferences.search',['type'=>$type]) }}" method="post" class="form_search"> @method('GET') @csrf
                    <input type="text" class="form-control input_search" name="key" id="key" placeholder="Search by title or by description">
                    <button type="submit" style="border: none;">
                        <i class="fi fi-bs-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 pt-4">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black" style="display:flex;justify-content: space-between;">
                        <div><i class="fi fi-sr-videoconference"></i> I am {{$type}} to Conferences</div>
                        @if($type=='Pc Chair')
                            <div style="width: 120px;">
                                <button type="submit" class="button-7 create"> <i class="fi fi-rs-plus"></i>&nbsp;&nbsp;&nbsp;Conferences</button>
                            </div>
                        @endif
                    </div>
                </div>

                    {{--If the are results for the users' table then show the results--}}
                @if(count($conferences)!=0)
                    @foreach($conferences as $c)
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="pt-2" style="display: flex; flex-direction: row; justify-content: space-between">
                                    <div class="card bg-dark mb-2" style="width:85%">
                                        <div class="card-body con" data-title="{{ $c->title }}" data-description="{{ $c->description }}" data-id="{{$c->id}}"
                                             data-created="{{ $c->created_at }}" data-submission="{{ $c->submission_at }}" data-assigment="{{ $c->assigment_at }}"
                                             data-review="{{$c->review_at}}" data-decision="{{$c->decision_at}}" data-finalsubmition="{{ $c->final_submission_at }}" data-final="{{ $c->final_at }}"
                                             data-conid="{{$c->id}}">
                                                <div style="display: flex;">
                                                    <div  class="sidebar_image_div">
                                                        <div class="sidebar_image_frame">
                                                            <img src="{{ asset($c->creator->profile_picture) }}" class="sidebar_image" alt=""/>
                                                        </div>
                                                    </div>
                                                    <div class="pl-2" style="width: 150px; color: white">
                                                        <b>{{ $c->creator->firstname }} {{$c->creator->lastname}}</b>
                                                        <p class="small">Created at: {{ date('d-m-Y', strtotime($c->created_at)) }}</p>
                                                    </div>
                                                </div>
                                                <b style="color: white">{{ $c->title }}</b>
                                                <hr style="color: white">
                                                <div class="mt-2 pl-3 pr-3 " style="overflow: hidden; height: 45px;">
                                                    <span style="color: darkgrey">{!! $c->description !!}</span>
                                                </div><hr style="color: white">
                                                <div style="display: flex; justify-content: end;">
                                                    <i style="color: white" class="small state pl-2 pr-2 "></i>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="card mb-2">
                                        <div class="card-body bg-light conference_tr" data-title="{{ $c->title }}" data-description="{{ $c->description }}"
                                             data-id="{{$c->id}}" data-created="{{ $c->created_at }}" data-submission="{{ $c->submission_at }}"
                                             data-assigment="{{ $c->assigment_at }}" data-review="{{$c->review_at}}" data-decision="{{$c->decision_at}}"
                                             data-finalsubmition="{{ $c->final_submission_at }}" data-final="{{ $c->final_at }}" data-pcchair="{{$c->pcChair}}"
                                             data-pcmember="{{$c->pcMember}}" data-creator="{{$c->creator}}">
                                            @if($type=='Pc Chair')
                                            <div class="edit mt-1 pt-1 mb-3">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fi fi-ss-pen-circle"></i>
                                                </button>
                                            </div><br>
                                            <div class="delete mb-3" >
                                                <button type="button" class="close del" data-dismiss="modal" aria-label="Close">
                                                    <i class="fi fi-sr-circle-trash"></i>
                                                </button>
                                            </div><br>
                                            @endif
                                            <div class="dates mb-3 @if($type!=='Pc Chair') mt-3 mb-5 @endif" data-toggle="tooltip" data-placement="left" data-html="true"
                                                 title="<br><b>Dates of States</b><br>
                                                   Submission at: {{ $c->submission_at ? date('d/m/Y', strtotime($c->submission_at)) : 'Not defined' }}<br>
                                                   Assigment at: {{ $c->assigment_at ? date('d/m/Y', strtotime($c->assigment_at)) : 'Not defined' }}<br>
                                                   Review at: {{ $c->review_at ? date('d/m/Y', strtotime($c->review_at)) : 'Not defined' }}<br>
                                                   Decision at: {{ $c->decision_at ? date('d/m/Y', strtotime($c->decision_at)) : 'Not defined' }}<br>
                                                   Final Submission at: {{ $c->final_submission_at ? date('d/m/Y', strtotime($c->final_submission_at)) : 'Not defined' }}<br>
                                                   Final at: {{ $c->final_at ? date('d/m/Y', strtotime($c->final_at)) : 'Not defined' }}">
                                                <button type="button" class="close">
                                                    <i class="fi fi-sr-calendar-clock"></i>
                                                </button>
                                            </div><br>
                                            <div class="members @if($type!=='Pc Chair') mt-5  @endif" data-toggle="tooltip" data-placement="left" data-html="true"
                                                 title="<i class='fi fi-sr-admin'></i> <b>Pc Chairs</b><br>
                                                    {{ $c->creator->firstname }} {{$c->creator->lastname}}
                                                     @foreach($c->pcChair as $ch)
                                                    , {{ $ch->user->firstname }} {{$ch->user->lastname}}
                                                     @endforeach <br><br>
                                                     <i class='fi fi-sr-users'></i><b>Pc Members</b><br>
                                                     @foreach($c->pcMember as $m)
                                                     {{ $m->user->firstname }} {{$m->user->lastname}},
                                                     @endforeach">
                                                <button type="button" class="close">
                                                    <i class="fi fi-sr-circle-user"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{ $conferences->links('pagination::bootstrap-4') }}
                    @endforeach
                @endif
                    {{--If there is not any results for this user's table then show the following message--}}
                @if(count($conferences)==0)
                    <table class="card-body">
                        <tr class="shadow-lg">
                            <td>
                                <p>There are not any conferences yet.</p>
                            </td>
                        </tr>
                    </table>
                @endif
            </div>
        </div>
    </div>


    @if($type==='Pc Chair')
        @include('allRoles.popUpForms.Create_Delete_Update_Conferences')
    @endif

        <script>
            $(document).ready(function () {

                function calculateState() {
                    var rows = $('.con');
                    var currentdate = new Date().toLocaleDateString('en-CA');


                    for (var i = 0; i < rows.length; i++) {
                        var row = rows[i];
                        var stateElement = row.getElementsByClassName("state")[0];

                        var submission = row.getAttribute("data-submission") === null || row.getAttribute("data-submission") === '' ? 0 : 1;
                        var assigment = row.getAttribute("data-assigment") === null || row.getAttribute("data-assigment") === '' ? 0 : 1;
                        var review = row.getAttribute("data-review") === null || row.getAttribute("data-review") === '' ? 0 : 1;
                        var decision = row.getAttribute("data-decision") === null || row.getAttribute("data-decision") === '' ? 0 : 1;
                        var finalsubmition = row.getAttribute("data-finalsubmition") === null || row.getAttribute("data-finalsubmition") === '' ? 0 : 1;
                        var final = row.getAttribute("data-final") === null || row.getAttribute("data-final") === '' ? 0 : 1;

                        var created_at = new Date(row.getAttribute("data-created")).toLocaleDateString('en-CA');
                        var submission_at = submission ? new Date(row.getAttribute("data-submission")).toLocaleDateString('en-CA'): null;
                        var assigment_at = assigment ? new Date(row.getAttribute("data-assigment")).toLocaleDateString('en-CA'): null;
                        var review_at = review ? new Date(row.getAttribute("data-review")).toLocaleDateString('en-CA'): null;
                        var decision_at = decision ? new Date(row.getAttribute("data-decision")).toLocaleDateString('en-CA'): null;
                        var finalsubmition_at = finalsubmition ? new Date(row.getAttribute("data-finalsubmition")).toLocaleDateString('en-CA'): null;
                        var final_at = final ? new Date(row.getAttribute("data-final")).toLocaleDateString('en-CA'): null;

                        if(created_at<=currentdate || (submission==1 && submission_at>currentdate)){
                            stateElement.innerHTML = '<b>State:</b> CREATED';


                            if(submission_at<=currentdate ||(assigment==1  && assigment_at>currentdate)){
                                stateElement.innerHTML = '<b>State:</b> SUBMISSION';

                                if(assigment_at<=currentdate || (review==1 &&  review_at>currentdate)){
                                    stateElement.innerHTML = '<b>State:</b> ASSIGNMENT';


                                        if(review_at<=currentdate ||(decision==1 && decision_at>currentdate)){
                                            stateElement.innerHTML = '<b>State:</b> REVIEW';

                                            if(decision_at<=currentdate || (finalsubmition==1 &&  finalsubmition_at>currentdate)){
                                                stateElement.innerHTML = '<b>State:</b> DECISION';

                                                if(finalsubmition_at<=currentdate || (final==1 && final_at>currentdate)){
                                                    stateElement.innerHTML = '<b>State:</b> FINAL SUBMISSION';

                                                }
                                                if (final==1 && final_at<=currentdate) {
                                                    stateElement.innerHTML = '<b>State:</b> FINAL';

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                    }
                // Call the calculateState function initially
                calculateState();
            });

            $(document).ready(function () {
                $('.dates').tooltip({
                    placement: 'left', // Explicitly set to left
                    trigger: 'hover focus-within',   // Ensure it's triggered on hover (or change as needed)
                    @if($type=='Pc Chair')
                        offset: '-7px, 16px',    // Adjust the offset: X-axis, Y-axis
                    @else
                        offset: '63px, 16px', // Adjust the offset: X-axis, Y-axis
                    @endif

                    html: true
                });
            });
            $(document).ready(function () {
                $('.members').tooltip({
                    placement: 'left', // Explicitly set to left
                    trigger: 'hover focus-within',   // Ensure it's triggered on hover (or change as needed)
                    @if($type=='Pc Chair')
                        offset: '-46px, 16px',    // Adjust the offset: X-axis, Y-axis
                    @else
                        offset: '-40, 16px',    // Adjust the offset: X-axis, Y-axis
                    @endif
                    html: true
                });
            });

            $(document).ready(function () {
                $(".con").click(function () {
                    const {conid} = $(this).data();

                    var url = "/myconferences/" + encodeURIComponent("{{ $type }}") + "/" + encodeURIComponent(conid);
                    console.log(url);
                    window.location.href = url;
                });
            });
        </script>


@endsection
@section('sidebar')
    @include('navbars.SideBar')
@endsection

