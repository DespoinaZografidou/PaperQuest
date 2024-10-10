@extends('layouts.app')


@section('content')
    <div class="container">

        <div class="row justify-content-center ">
            <div class="col-md-5 pt-4">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black"><i class="fi fi-ss-search-alt"></i> My Papers</div>

                    <table class="card-body">
                        <tr>
                            <td>
                                <i class="fi fi-ss-search-alt"></i> <b>My Papers:</b><hr><br>
                                <i class="fi fi-ss-member-list"></i> Not Reviewed yet:
                                <br><br><i class="fi fi-ss-member-list"></i> Reviewed:
                                <br><i class="fi fi-sr-bullet unlocked pl-4"></i> Approved:
                                <br><i class="fi fi-sr-bullet locked pl-4"></i> Disapproved:
                            </td>
                            <td style="text-align: end">
                                <b>{{$Author + $PostAuthor}} Papers</b><br>
                                <br>{{$NotApprovedYet}} Papers
                                <br><br>{{$ApprovedPapers + $DisapprovedPapers}} Papers
                                <br>{{$ApprovedPapers}} Papers
                                <br>{{$DisapprovedPapers}} Papers
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-5 pt-4">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black"><i class="fi fi-sr-videoconference"></i> My Conferences</div>

                    <table class="card-body">
                        <tr>
                            <td>
                                <i class="fi fi-sr-videoconference"></i> <b>My Conferences:</b><hr><br>
                                <i class="fi fi-sr-member-list "></i> I am Author to:
                                <br><i class="fi fi-sr-bullet pl-4"></i> Posted papers by me:
                                <br><i class="fi fi-sr-bullet pl-4"></i> Posted papers by others:
                                <br><br><i class="fi fi-sr-users "></i> I am Pc Member to:
                                <br><i class="fi fi-sr-review pl-4"></i> I am reviewer to:
                                <br><i class="fi fi-sr-feedback-alt pl-4"></i> I reviewed:
                                <br><br><i class="fi fi-sr-admin "></i> I am Pc Chair to:
                                <br><i class="fi fi-sr-bullet unlocked pl-4"></i> Finalized Conferences:
                                <br><i class="fi fi-sr-bullet locked pl-4"></i> Running Conferences:
                            </td>
                            <td style="text-align: end">
                                <b>{{$Author + $PostAuthor + $pcMember + $pcChair+ $PostPcChair}} Conferences</b><br>
                                <br>{{$Author + $PostAuthor}} Conferences
                                <br>{{$Author}} Papers
                                <br>{{$PostAuthor}} Papers
                                <br><br>{{$pcMember}} Conferences
                                <br>{{$reviewer}} Papers
                                <br>{{$reviews}} Papers
                                <br><br>{{$pcChair+ $PostPcChair}} Conferences
                                <br>{{$FinalizedConferences}} Conferences
                                <br>{{$pcChair+ $PostPcChair-$FinalizedConferences}} Conferences



                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('sidebar')
    @include('navbars.SideBar')
@endsection
