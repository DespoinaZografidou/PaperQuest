<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Conference;
use App\Models\Paper;
use App\Models\PcChair;
use App\Models\PcMember;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  Middleware that checks if there request comes from a logged in user
        $this->middleware('auth')->only('adminHome','userHome','index');
        //  Middleware that checks if the user is an admin and has active account
        $this->middleware('checkRoleAndStatus:Admin')->only('adminHome');
        //  Middleware that checks if the user is a user and has active account
        $this->middleware('checkRoleAndStatus:User')->only('userHome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
//    // Function that returns the home page for the guests
//    public function index()
//    {
//        return view('home');
//    }

    // Function that returns the home page for the users
    public function userHome()
    {
        $pcMember= PcMember::where('user_id',Auth::User()->id)->count();
        $pcChair=PcChair::where('user_id',Auth::User()->id)->count() ;
        $PostPcChair= Conference::where('creator_id',Auth::User()->id)->count();
        $Author=Author::where('user_id',Auth::User()->id)->count();
        $PostAuthor=Paper::where('creator_id',Auth::User()->id)->count();

        $pcMemberId=PcMember::where('user_id',Auth::User()->id)->pluck('id')->toArray();
        $reviewer=Review::whereIn('pc_member_id',$pcMemberId)->count();
        $reviews = Review::whereIn('pc_member_id',$pcMemberId)->count();


        // Count of papers created by the authenticated user that are not approved (approved is null)
        $CreatorNotApprovedPapers = Paper::where('creator_id', Auth::user()->id)
            ->whereNull('approved')
            ->count();

        // Get IDs of all not approved papers
        $NotApprovedPapersIds = Paper::whereNull('approved')
            ->pluck('id')
            ->toArray();

        // Count of papers where the user is an author but not approved
        $AuthorNotApprovedPapers = Author::whereIn('paper_id', $NotApprovedPapersIds)
            ->where('user_id', Auth::user()->id)
            ->count();

        // Sum of not approved papers where the user is either the creator or author
        $NotApprovedYet = $CreatorNotApprovedPapers + $AuthorNotApprovedPapers;

        // Count of papers created by the authenticated user that are approved (approved is null)
        $ApprovedCreatorPapers = Paper::where([['creator_id', Auth::user()->id],['approved',1]])->count();
        // Count of papers created by the authenticated user that are disapproved (approved is null)
        $DisapprovedCreatorPapers = Paper::where([['creator_id', Auth::user()->id],['approved',0]])->count();

        // Get IDs of all approved papers
        $AuthorApprovedPapersIds = Paper::where('approved',1)
            ->pluck('id')
            ->toArray();

        // Get IDs of all disapproved papers
        $AuthorDisapprovedPapersIds = Paper::where('approved',0)
            ->pluck('id')
            ->toArray();

        // Count of papers where the user is an author but approved
        $AuthorApprovedPapers = Author::whereIn('paper_id', $AuthorApprovedPapersIds)
            ->where('user_id', Auth::user()->id)
            ->count();
        // Count of papers where the user is an author but disapproved
        $AuthorDisapprovedPapers = Author::whereIn('paper_id', $AuthorDisapprovedPapersIds)
            ->where('user_id', Auth::user()->id)
            ->count();

        // Sum of disapproved papers where the user is either the creator or author
        $DisapprovedPapers=$DisapprovedCreatorPapers+$AuthorDisapprovedPapers;
        // Sum of approved papers where the user is either the creator or author
        $ApprovedPapers=$ApprovedCreatorPapers+$AuthorApprovedPapers;



        $currentDate = Carbon::now()->format('Y-m-d');

// Get the IDs of conferences with a final date on or after the current date
        $FinalizedConferencesIds = Conference::whereDate('final_at', '<=', $currentDate)->whereNotNull('final_at')
            ->pluck('id')->toArray();

// Count conferences where the user is a PC Chair and the conference is finalized
        $pcChairConference = PcChair::whereIn('conference_id', $FinalizedConferencesIds)
            ->where('user_id', Auth::user()->id)
            ->count();

// Count conferences where the user is the creator and the conference is finalized
        $CreatedConferences = Conference::where('creator_id', Auth::user()->id)
            ->whereDate('final_at', '<=', $currentDate)->whereNotNull('final_at')
            ->count();

// Total finalized conferences where the user is either a PC Chair or the creator
        $FinalizedConferences = $pcChairConference + $CreatedConferences;


        return view('users.user_home',['pcMember'=>$pcMember, 'pcChair'=>$pcChair,
            'PostPcChair'=>$PostPcChair, 'Author'=>$Author,'PostAuthor'=>$PostAuthor,
            'reviewer'=>$reviewer,'reviews'=>$reviews, 'NotApprovedYet'=>$NotApprovedYet,
            'ApprovedPapers'=>$ApprovedPapers, 'DisapprovedPapers'=>$DisapprovedPapers,'FinalizedConferences'=>$FinalizedConferences ]);
    }

    // Function that returns the home page for the admins
    public function adminHome()
    {
        $requests=User::where('system_role', null)->count();
        $requests0=User::where([['system_role', null],['account_status',0]])->count();
        $requests1=User::where([['system_role', null],['account_status',1]])->count();

        $users=User::where('system_role', 'User')->count();
        $users0=User::where([['system_role', 'User'],['account_status',0]])->count();
        $users1=User::where([['system_role', 'User'],['account_status',1]])->count();

        $admins=User::where('system_role', 'Admin')->count();
        $admins0=User::where([['system_role', 'Admin'],['account_status',0]])->count();
        $admins1= User::where([['system_role', 'Admin'],['account_status',1]])->count();


        $conferences = Conference::count();
        $currentDate = Carbon::now()->format('Y-m-d');
        $finalizedConferences = Conference::whereDate('final_at', '<=', $currentDate)->whereNotNull('final_at')
            ->count();

        $papers=Paper::count();
        $notyetapproved=Paper::where('approved',null)->count();
        $approved= Paper::where('approved',1)->count();





        return view('admin.admin_home',
            ['users'=>$users,'users0'=>$users0,'users1'=>$users1,
                'admins'=>$admins,'admins0'=>$admins0,'admins1'=>$admins1,
                'requests'=>$requests, 'requests0'=>$requests0, 'requests1'=>$requests1,
                'conferences'=>$conferences,'finalizedConferences'=>$finalizedConferences,
                'papers'=>$papers, 'notyetapproved'=>$notyetapproved, 'approved'=>$approved]);
    }

    //  Function that returns the home page for the quests
    //  The home page shows the all the conferences
    public function VisitorConferences(){
        $conferences = Conference::with(['creator','pcChair.user', 'pcMember.user'])
            ->orderBy('final_at', 'desc')
            ->paginate(10);

        return view('visitorConferences', ['conferences' => $conferences]);
    }


    //  Function that allow the quest to search the conferences by the title or the description
    public function SearchVisitorConference(Request $request){
        $key = $request->input("key");
        $conferences = Conference::query(); // Start with a base query

        // Apply search filters on the Conference model's title and description
        if (!empty($key)) {
            $words = explode(' ', $key); // Split the key into individual words
            $conferences = $conferences->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->where(function ($q) use ($word) {
                        $q->where('title', 'like', '%' . $word . '%')
                            ->orWhere('description', 'like', '%' . $word . '%');
                    });
                }
            });
        }

        // returns all the conferences with the PcChairs and The PcMembers
        $conferences = $conferences->with(['creator','pcChair.user', 'pcMember.user'])->orderBy('final_at', 'desc')->paginate(10);

        return view('visitorConferences', ['conferences' => $conferences]);
    }


}
