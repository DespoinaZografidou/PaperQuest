@extends('layouts.app')


@section('content')
    <div class="container">

        <div class="row justify-content-center ">
            <div class="col-md-5 pt-4">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black"><i class="fi fi-ss-users-alt"></i> PaperQuest's Users</div>

                    <table class="card-body">
                        <tr>
                            <td>
                                <i class="fi fi-ss-member-list"></i> <b>All Requests:</b><hr>
                                <i class="fi fi-ss-user-add unlocked"></i> Membership Requests:
                                <br><i class="fi fi-sr-remove-user locked"></i> Delete Requests:
                            </td>
                            <td style="text-align: end">
                                <b>{{$requests}} Records</b>
                                <br>{{$requests1}} Records
                                <br>{{$requests0}} Records
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi fi-sr-users"></i> <b>Users:</b><hr>
                                <i class="fi fi-sr-bullet unlocked"></i> Unlocked Users:
                                <br><i class="fi fi-sr-bullet locked"></i> Locked Users:
                            </td>
                            <td style="text-align: end">
                                <b>{{$users}} Records</b>
                                <br>{{$users1}} Records
                                <br>{{$users0}} Records
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi fi-ss-admin"></i> <b>Admin:</b><hr>
                                <i class="fi fi-sr-bullet unlocked"></i> Unlocked Admins:
                                <br><i class="fi fi-sr-bullet locked"></i> Locked Admins:
                            </td>
                            <td style="text-align: end">
                                <b>{{$admins}} Records</b>
                                <br>{{$admins1}} Records
                                <br>{{$admins0}} Records
                            </td>
                        </tr>



                    </table>
                </div>
            </div>

            <div class="col-md-5 pt-4">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black"><i class="fi fi-sr-videoconference"></i> PaperQuest's Conferences</div>

                    <table class="card-body">
                        <tr>
                            <td>
                                <i class="fi fi-sr-videoconference"></i> <b>Conferences:</b><hr>
                                <i class="fi fi-sr-bullet locked"></i> Finalized Conferences:
                                <br><i class="fi fi-sr-bullet unlocked"></i> Running Conferences:
                            </td>
                            <td style="text-align: end">
                                <b>{{ $conferences}} Conferences</b>
                                <br>{{$finalizedConferences}} Conferences
                                <br>{{$conferences-$finalizedConferences}} Conferences
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="card shadow-lg bg-dark mt-4">
                    <div class="card-header bg-black"><i class="fi fi-ss-search-alt"></i> PaperQuest's Papers</div>

                    <table class="card-body">
                        <tr>
                            <td>
                                <i class="fi fi-ss-search-alt"></i> <b>Papers:</b><hr>
                                <i class="fi fi-sr-bullet"></i> Not approved yet:
                                <br><i class="fi fi-sr-bullet locked"></i> Approved:
                                <br><i class="fi fi-sr-bullet unlocked"></i> Disapproved:
                            </td>
                            <td style="text-align: end">
                                <b>{{$papers}} Papers</b>
                                <br>{{$notyetapproved}}  Papers
                                <br>{{$approved}}  Papers
                                <br>{{$papers-$approved-$notyetapproved}}  Papers
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
