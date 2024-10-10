<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Paper;
use App\Models\PcChair;
use App\Models\PcMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersConferencesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  Middleware that checks if there request comes from a logged in user
        $this->middleware('auth');
        //  Middleware that checks if the user is a user and has active account
        $this->middleware('checkRoleAndStatus:User');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // Show the user's conferences by the role of the user role
    public function ShowConferences($type)
    {
        $conferences = [];
        $user = Auth::user();
        $users=[];
        if ($type == 'Pc Member') {
            $conferences = Conference::whereHas('pcMember', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->with(['creator','pcChair.user', 'pcMember.user']) // Eager load PC Chairs and PC Members with their associated users
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        if ($type == 'Pc Chair') {
            $conferences = Conference::where('creator_id', $user->id)
                ->orWhereHas('pcChair', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['creator','pcChair.user', 'pcMember.user']) // Eager load PC Chairs and PC Members with their associated users
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $users=User::where('system_role', 'User')->where('id', '!=', $user->id)->orderBy('firstname')->get();

        }
        if($type == 'Author'){
            // Get conferences where the user is the creator of any paper
            $conferencesAsPaperCreator = Conference::whereHas('paper', function ($query) use ($user) {
                $query->where('creator_id', $user->id);
            });

            // Get conferences where the user is an author on any paper
            $conferencesAsAuthor = Conference::whereHas('paper.author', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });

            // Combine the queries using `union`
            $conferences = $conferencesAsPaperCreator->union($conferencesAsAuthor);
            $conferences = $conferences->with(['creator','pcChair.user', 'pcMember.user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        }



        return view('allRoles/conferences', ['conferences' => $conferences, 'type' => $type,'users'=>$users]);
    }

    public function CreateNewConference(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $creator_id = Auth::User()->id;

        date_default_timezone_set('Europe/Athens');
        $current_date = Carbon::now();


        $validator = Validator:: make($request->all(), [
            'title' => ['required', 'string', 'max:255', Rule::unique('conferences')],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', "This Conference's title is taken!");
        }

        // Create the conference
        Conference::create([
            'creator_id' => $creator_id,
            'title' => $title,
            'description' => $description,
            'created_at' => $current_date,
        ]);
        return redirect()->back()->with('message', 'The conference has been created successfully!');

    }

    public function UpdateConference(Request $request)
    {
        $conference=$request->input('conference_id');
        $title = $request->input('title');
        $description = $request->input('description');
        $user_id = Auth::User()->id;

        $validator = Validator:: make($request->all(), [
            'title' => ['required', 'string', 'max:255', Rule::unique('conferences')->ignore($conference)],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', "This Conference's title is taken!");
        }
        if ($this->CheckIfPcChair($user_id, $conference)===false) {
            return redirect()->back()->with('warning', 'You dont have the authority to update this conference!');
        }

        // Update the conference
        Conference::where('id', $conference)->update([
            'title' => $title,
            'description' => $description,
        ]);
        return redirect()->back()->with('message', 'The conference has been updated successfully!');

    }


    public function DefineDates(Request $request)
    {
        $conference=$request->input('conference_id');
        $user_id = Auth::User()->id;

        date_default_timezone_set('Europe/Athens');
//         Use Carbon to handle date inputs and ensure no day is subtracted
        $submission_at = $request->input('submission') ? Carbon::parse($request->input('submission'))->startOfDay() : null;
        $assigment_at = $request->input('assigment') ? Carbon::parse($request->input('assigment'))->startOfDay() : null;
        $review_at = $request->input('review') ? Carbon::parse($request->input('review'))->startOfDay() : null;
        $decision_at = $request->input('decision') ? Carbon::parse($request->input('decision'))->startOfDay() : null;
        $final_submission_at = $request->input('finalSubmission') ? Carbon::parse($request->input('finalSubmission'))->startOfDay() : null;
        $final_at = $request->input('final') ? Carbon::parse($request->input('final'))->startOfDay() : null;


        if ($this->CheckIfPcChair($user_id, $conference)===false) {
            return redirect()->back()->with('warning', 'You dont have the authority to define the dates in the conference!');
        }

        // Update the conference
        Conference::where('id', $conference)->update([
            'submission_at'=>$submission_at,
            'assigment_at'=>$assigment_at,
            'review_at'=>$review_at,
            'decision_at'=>$decision_at,
            'final_submission_at'=>$final_submission_at,
            'final_at'=>$final_at
        ]);

        return redirect()->back()->with('message', 'The conference has been created successfully!');

    }


    public function DeleteConference(Request $request)
    {

        $id = $request->input('conference_id');
        $user = Auth::User()->id;
        if ($this->CheckIfPcChair($user, $id)===false) {
            return redirect()->back()->with('warning', 'You dont have the authority to delete this conference!');
        }
        if ($this->CheckStateCreate($id)===false) {
            return redirect()->back()->with('warning', 'You can not delete this conference because is not still in the state Create!');
        }
        //check if there are any submissions

        Conference::where('id', $id)->delete();

        return redirect()->back()->with('message', 'The conference has been deleted successfully!');
    }


    protected function CheckIfPcChair($user_id, $conference_id)
    {
        $check1 = Conference::where([ ['id', $conference_id], ['creator_id', $user_id] ])->exists();
        $check2 = PcChair::where([['conference_id', $conference_id], ['user_id', $user_id]])->exists();
        if ($check1 || $check2) {
            return true;
        } else {
            return false;
        }

    }

    protected function CheckIfPcMember($user_id, $conference_id)
    {

        $check = PcMember::where([['conference_id' => $conference_id], ['user_id', $user_id]])->exists();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    protected function CheckStateCreate($id)
    {
        $dates = Conference::select('created_at', 'submission_at')->where('id', $id)->first();
        if ($dates) {
            // Get the current date (without time)
            $currentDate = Carbon::now()->format('Y-m-d');

            // Extract the date part (without time) from the retrieved timestamps
            $createdAtDate = Carbon::parse($dates->created_at)->format('Y-m-d');
            $submissionAtDate = Carbon::parse($dates->submission_at)->format('Y-m-d');

            // Perform the comparison
            if ( $dates->submission_at==null|| $createdAtDate <= $currentDate && $submissionAtDate > $currentDate) {
                return true;
            } else {
                return false;
            }
        }


    }


    public function SearchConferences(Request $request, $type)
    {
        $key = $request->input("key");
        $user = Auth::user();
        $conferences = Conference::query(); // Start with a base query
        $users=[];

        if ($type == 'Pc Member') {
            $conferences = $conferences->whereHas('pcMember', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } if ($type == 'Pc Chair') {
            $conferences = $conferences->where(function ($query) use ($user) {
                $query->where('creator_id', $user->id)
                    ->orWhereHas('pcChair', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
            $users=User::where('system_role', 'User')->where('id', '!=', $user->id)->orderBy('firstname')->get();
        }
        if($type == 'Author'){
            // Get conferences where the user is the creator of any paper
            $conferencesAsPaperCreator = Conference::whereHas('paper', function ($query) use ($user) {
                $query->where('creator_id', $user->id);
            });

            // Get conferences where the user is an author on any paper
            $conferencesAsAuthor = Conference::whereHas('paper.author', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });

            // Combine the queries using `union`
            $conferences = $conferencesAsPaperCreator->union($conferencesAsAuthor);

        }


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

        // Eager load PC Chairs and PC Members along with their associated users
        $conferences = $conferences->with(['creator','pcChair.user', 'pcMember.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('allRoles/conferences', ['conferences' => $conferences, 'type' => $type,'users'=>$users]);
    }


    public function AddDeleteMembers(Request $request){
        $addPcChairs=$request->input('addPcChairs');
        $addPcMembers=$request->input('addPcMembers');
        $removePcChairs=$request->input('removePcChairs');
        $removePcMembers=$request->input('removePcMembers');

        $conference_id=$request->input('conference_id');

        $user_id=Auth::user()->id;

        if ($this->CheckIfPcChair($user_id, $conference_id)===false) {
            return redirect()->back()->with('warning', 'You dont have the authority to add members in the conference!');
        }

        if (!empty($addPcChairs)) {
            $data = [];
            foreach ($addPcChairs as $u) {
                $data[] = [
                    'user_id' => $u,
                    'conference_id' => $conference_id,
                ];
            }

            PcChair::insert($data);  // Insert all records in one query
        }

        if (!empty($addPcMembers)) {
            $data = [];
            foreach ($addPcMembers as $u) {
                $data[] = [
                    'user_id' => $u,
                    'conference_id' => $conference_id,
                ];
            }

            PcMember::insert($data);  // Insert all records in one query
        }

        if(!empty($removePcChairs)){
            PcChair::whereIn('id', $removePcChairs)->delete();
        }

        if(!empty($removePcMembers)){
                PcMember::whereIn('id', $removePcMembers)->delete();
        }
        return redirect()->back()->with('message', 'The conference\'s members has been defined successfully!');
    }






}
