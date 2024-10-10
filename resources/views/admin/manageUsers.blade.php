@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <form action="{{ route('manage.search',['type'=>$title]) }}" method="post" class="form_search" > @method('GET') @csrf
                    <input type="text" class="form-control input_search" name="key" id="key" placeholder="Search by fullname or by email">
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

                        <div> <i class="fi fi-sr-users-alt"></i> @if(isset($stat_b) && $stat_b===1) @if($title=='Request') Membership @else Unlocked @endif {{$title}}s @elseif(isset($stat_b) && $stat_b===0) @if($title=='Request') Delete @else Locked @endif {{$title}}s @else  All {{$title}}s @endif</div>

                        <div class="row justify-content-end">
                            <form action="{{ route('manage.unlocked',['type'=>$title]) }}" method="post"  style="width: 80px"> @csrf @method('GET')
                                <button type="submit" class="button-7 @if( isset($stat_b) && $stat_b===1) neon_border neon-green @endif">Unlocked</button>
                            </form>
                            <form action="{{ route('manage.locked',['type'=>$title]) }}" method="post" style="width: 80px"> @csrf @method('GET')
                                <button type="submit" class="button-7 @if( isset($stat_b) && $stat_b===0) neon_border neon-red @endif">Locked</button>
                            </form>
                        </div>
                    </div>

                    <table class="card-body" style="background-color: rgb(36, 37, 38);">
                        {{--If the are results for the users' table then show the results--}}
                        @if(count($users)!=0)
                            @foreach($users as $u)
                            <tr class="user_tr"
                                data-firstname="{{ $u->firstname }}" data-lastname="{{ $u->lastname }}"
                                data-email="{{ $u->email }}" data-status="{{ $u->account_status }}" data-id="{{ $u->id }}"
                                data-role="{{ $u->system_role }}" data-image="{{$u->profile_picture}}">
                                <td style="text-align: center;">
                                    <div class="avatar_div">
                                        <div class="avatar_frame neon_border @if($u->account_status==1) neon-green @elseif($u->account_status==0) neon-red @endif">
                                            <img src="{{ asset($u->profile_picture) }}" class="avatar" alt=""/>
                                        </div>
                                        <div class="avatar_status @if($u->account_status==1) active_account @elseif($u->account_status==0) unactive_account @endif"></div>
                                    </div>
                                </td>

                                <td><i class="small"><b>{{ $u->firstname}} {{ $u->lastname}}</b><br>{{ $u->email}}</i></td>

                                <td><i class="small">{{ date('d-m-Y H:i:s', strtotime($u->created_at)) }}</i></td>

                                <td class="delete">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fi fi-sr-circle-trash"></i>
                                    </button>
                                </td>
                            </tr>
                          @endforeach
                        @endif

                        {{--If there is not any results for this user's table then show the following message--}}
                        @if(count($users)==0)
                            <tr class="shadow-lg">
                                <td>
                                    <p>There are not users yet.</p>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                {{--the links for the next page of results--}}
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    @include('admin.popUpForms.Update_Delete_Users')



@endsection
@section('sidebar')
    @include('navbars.SideBar')
@endsection

