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

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConferenceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  Middleware that checks if there request comes from a logged in user
        $this->middleware('auth')->except(['ShowVisitorConference','SearchVisitorsPapers','ViewPaperVisitor']);
        //  Middleware that checks if the user has active account and has a role in the system
        $this->middleware('checkAccess')->except(['ShowVisitorConference','SearchVisitorsPapers', 'ViewPaperVisitor']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // Function that returns a specific conference by the role of the user in this conference (for authenticated users)
    public function ShowConference($type,$conference_id)
    {
        $users=[];
        $user = Auth::user();

        // the conference with the PcMember and PcChairs
        $conference = Conference::where('id', $conference_id)
            ->with(['creator', 'pcChair.user', 'pcMember.user']) // Eager load PC Chairs and PC Members with their associated users
            ->first();
        // all the conference's paper with the all the authors
        $papers = Paper::where('conference_id', $conference_id)->with(['creator', 'author.user'])->paginate(10);

        //if the user is an author or a visitor(logged in user that are trying to see a conference from his/her home page)
        // return all the user that are not  PcChairs or Pc Member.
        //  These users are for adding authors to their possible new paper if they want to add a new one
        if ($type==='Author' || $type==='Visitor'){
            // Get the IDs of the PC Members and PC Chairs
            $conferenceCreator = $conference->pluck('creator_id')->toArray();
            $pcChairIds = $conference->pcChair->pluck('user_id')->toArray(); // Get PC Chair user IDs
            $pcMemberIds = $conference->pcMember->pluck('user_id')->toArray(); // Get PC Member user IDs
            $pcAuthorsIds = [];
            foreach ($papers as $paper) {
                $authorIds = $paper->author->pluck('user_id')->toArray(); // Collect author user IDs for each paper
                $pcAuthorsIds = array_merge($pcAuthorsIds, $authorIds); // Merge them into the main array
            }

            $pcCreatorsIds=$papers->pluck('creator_id')->toArray();

            // Merge the arrays to get all excluded IDs (including the logged-in user)
            $excludedIds = array_merge($pcChairIds, $pcMemberIds,$pcAuthorsIds,$pcCreatorsIds,[$user->id],$conferenceCreator);

            // Fetch all users except the logged-in user, PC Members, and PC Chairs
            $users = User::whereNotIn('id', $excludedIds)
            ->where('system_role', 'User')
            ->orderBy('firstname')
            ->get();
        }

        return view('allRoles/theConference', ['conference' => $conference, 'type'=>$type, 'papers'=>$papers,'users'=>$users]);
    }

    //Function for searching papers of a conference by the title or by keywords (for authenticated users)
    public function SearchPapers($type,$conference_id,Request $request){
        $users=[];
        $user = Auth::user();
        $keyword=$request->input('key');

        $conference = Conference::where('id', $conference_id)
            ->with(['creator', 'pcChair.user', 'pcMember.user']) // Eager load PC Chairs and PC Members with their associated users
            ->first();
        $papers = Paper::where('conference_id', $conference_id);

        if(!empty($keyword)){
            $words = explode(' ', $keyword);
            $papers= $papers->where(function($query) use ($words){
                foreach ($words as $word){
                    $query->where(function ($q) use ($word){
                        $q->where('title', 'like', '%' . $word . '%')
                            ->orWhere('keywords', 'like', '%' . $word . '%');
                    });
                }
            });

        }
        $papers=$papers->with(['creator', 'author.user'])->paginate(10);

        //  If the user is an author or a visitor( logged in user that are trying to see a conference from his/her home page)
        //  return all the user that are not  PcChairs or Pc Member.
        //  These users are for adding authors to their possible new paper if they want to add a new one
        if ($type=='Author' || $type=='Visitor'){
            // Get the IDs of the PC Members and PC Chairs
            $conferenceCreator= $conference->pluck('creator_id')->toArray();
            $pcChairIds = $conference->pcChair->pluck('user_id')->toArray(); // Get PC Chair user IDs
            $pcMemberIds = $conference->pcMember->pluck('user_id')->toArray(); // Get PC Member user IDs
            $pcAuthorsIds = [];
            foreach ($papers as $paper) {
                $authorIds = $paper->author->pluck('user_id')->toArray(); // Collect author user IDs for each paper
                $pcAuthorsIds = array_merge($pcAuthorsIds, $authorIds); // Merge them into the main array
            }

            $pcCreatorsIds=$papers->pluck('creator_id')->toArray();

            // Merge the arrays to get all excluded IDs (including the logged-in user)
            $excludedIds = array_merge($pcChairIds, $pcMemberIds,$pcAuthorsIds,$pcCreatorsIds,[$user->id],$conferenceCreator);

            // Fetch all users except the logged-in user, PC Members, and PC Chairs
            $users = User::whereNotIn('id', $excludedIds)
                ->where('system_role', 'User')
                ->orderBy('firstname')
                ->get();
        }

        return view('allRoles/theConference', ['conference' => $conference, 'type'=>$type, 'papers'=>$papers,'users'=>$users]);

    }

    //  Function that returns a conference to a quest
    public function ShowVisitorConference($type,$conference_id)
    {

        $users=[];

        $conference = Conference::where('id', $conference_id)
            ->with(['creator', 'pcChair.user', 'pcMember.user']) // Eager load PC Chairs and PC Members with their associated users
            ->first();
        $papers = Paper::where('conference_id', $conference_id)->with(['creator', 'author.user'])->paginate(10);


        return view('allRoles/theConference', ['conference' => $conference, 'type'=>$type, 'papers'=>$papers,'users'=>$users]);
    }

    //  Function that allows a quest to search papers of a conference by the title or by keywords
    public function SearchVisitorsPapers($type,$conference_id,Request $request){
        $users=[];

        $keyword = $request->input('key');

        $conference = Conference::where('id', $conference_id)
            ->with(['creator', 'pcChair.user', 'pcMember.user']) // Eager load PC Chairs and PC Members with their associated users
            ->first();
        $papers = Paper::where('conference_id', $conference_id);

        if(!empty($keyword)){
            $words = explode(' ', $keyword);
            $papers= $papers->where(function($query) use ($words){
                foreach ($words as $word){
                    $query->where(function ($q) use ($word){
                        $q->where('title', 'like', '%' . $word . '%')
                            ->orWhere('keywords', 'like', '%' . $word . '%');
                    });
                }
            });

        }
        $papers=$papers->with(['creator', 'author.user'])->paginate(10);



        return view('allRoles/theConference', ['conference' => $conference, 'type'=>$type, 'papers'=>$papers,'users'=>$users]);

    }

    //   Function that allows an authenticated user to submit/create a new paper in a conference
    public function SubmitPaper($type,$c_id,Request $request){

        $creator_id=Auth::user()->id;
        // check if the state of this conference is SUBMISSION or FINAL SUBMISSION that allow the users to create a new paper
        if($this->CheckStateCreate($c_id)){

            $title=$request->input('title');
            $keywords=$request->input('keywords');
            $file= $request->file('file');
            $description=$request->input('description');

            //check if the title is unique
            $validator = Validator::make($request->all(), [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('papers')->where(function ($query) use ($c_id) {
                        return $query->where('conference_id', $c_id);
                    }),
                ],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('warning', "This Paper's title is taken for this conference!");
            }
            //  Check the type of the paper
            $validator = Validator::make($request->all(), [
                'file' => [
                    'required', // File is required
                    'file',     // Ensure the input is a file
                    'mimes:pdf', // Allowed file types: PDF, DOC, DOCX
                ],
            ]);

            // If the validation fails, redirect back with an error message
            if ($validator->fails()) {
                return redirect()->back()->with('warning', 'The paper must be a PDF file.');
            }

            // upload the paper
             $filename= $c_id.'_'.$creator_id.'_'.$file->getClientOriginalName();
             $file->move(public_path('Papers'),$filename);


            //  Create the new paper
            Paper::create([
                'creator_id' => $creator_id,
                'conference_id'=> $c_id,
                'title' => $title,
                'description' => $description,
                'keywords'=>$keywords,
                'file'=>'Papers/'.$filename
            ]);

        }else{
            return redirect()->back()->with('warning', 'You can submit a paper only if the conference state is Submission or Final Submission.');
        }

        return redirect()->back()->with('message', 'The Paper has been submitted successfully!');

    }

    // Function that allows the authors to update their paper
    public function UpdatePaper($type,$c_id,Request $request){
        $user_id=Auth::user()->id;
        $paper_id=$request->input('paper_id');
        $paper= Paper::where('id', $paper_id)->first();
        $creator_id=$paper->creator_id;

        if($this->CheckStateCreate($c_id) && $this->CheckIfAuthor($user_id,$paper_id)){

            $title=$request->input('title');
            $keywords=$request->input('keywords');
            $file= $request->file('file');
            $description=$request->input('description');

            // Check if the paper's title in this cocnference is unique
            $validator = Validator::make($request->all(), [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('papers')->where(function ($query) use ($c_id) {
                        return $query->where('conference_id', $c_id);
                    })->ignore($paper_id, 'id'),
                ],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('warning', "This Paper's title is taken for this conference!");
            }

            if($file!==null){
                // if there is a new paper, chekck the file's type
                $validator = Validator::make($request->all(), [
                    'file' => [
                        'file',     // Ensure the input is a file
                        'mimes:pdf', // Allowed file types: PDF
                    ],
                ]);

                // If the validation fails, redirect back with an error message
                if ($validator->fails()) {
                    return redirect()->back()->with('warning', 'The paper must be a PDF file.');
                }

                // Find the existing file with the same pattern and delete it
                $existingFiles = glob(public_path('Papers/' . $c_id . '_' . $creator_id . '_*'));
                foreach ($existingFiles as $existingFile) {
                    if (file_exists($existingFile)) {
                        unlink($existingFile);  // Delete the existing file
                    }
                }

                //upload the file
                $filename= $c_id.'_'.$creator_id.'_'.$file->getClientOriginalName();
                $file->move(public_path('Papers'),$filename);


                //  update the paper
                Paper::Where('id',$paper_id)->update([
                    'title' => $title,
                    'description' => $description,
                    'keywords'=>$keywords,
                    'file'=>'Papers/'.$filename
                ]);
            }else{
                // update the paper
                Paper::where('id', $paper_id)->update([
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                ]);
            }

        }else{
            return redirect()->back()->with('warning', 'You can submit a paper only if the conference state is Submission or Final Submission.');
        }

        return redirect()->back()->with('message', 'The Paper has been submitted successfully!');
    }

    // Function that allows the authors to add or remove authors
    public function AddAuthors($type,$c_id,Request $request) {
        $addAuthors=$request->input('addAuthors');
        $removeAuthors=$request->input('removeAuthors');
        $paper_id=$request->input('paper_id');

        //if there is a list with new authors add them to the paper
        if (!empty($addAuthors)) {
            $data = [];
            foreach ($addAuthors as $user_id) {
                $data[] = [
                    'user_id' => $user_id,
                    'paper_id' => $paper_id,
                ];
            }
            Author::insert($data);  // Insert all records in one query
        }
        //  if there is the list for deleting authors then delete them from the authors
        if(!empty($removeAuthors)){
            Author::whereIn('id', $removeAuthors)->delete();
        }
        return redirect()->back()->with('message','The Paper\'s Authors were successfully updated!');

    }

    // Function that allow the authors to delete their paper from a conference
    public function DeletePaper($type, $c_id, Request $request)
    {
        $user_id = Auth::User()->id;
        $paper_id = $request->input('paper_id');

        // Correct the authority check: Block if the user is not the author
        if ($this->CheckIfAuthor($user_id, $paper_id) === false) {
            return redirect()->back()->with('warning', 'You don’t have the authority to delete this paper!');
        }

        // Find the paper record
        $paper = Paper::where('id', $paper_id)->first();

        // Check if the paper exists
        if ($paper) {
            $filename = $paper->file;

            // Check if the file exists and delete it
            if (file_exists(public_path($filename))) {
                unlink(public_path($filename));
            }

            // Delete the paper record from the database
            Paper::where('id', $paper_id)->delete();

            return redirect()->back()->with('message', 'The paper has been deleted successfully!');
        } else {
            return redirect()->back()->with('warning', 'The paper does not exist.');
        }
    }

    // Function that ckeckIf a user is a pc chair in a conference
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

    // A function that checks if the conference's state is SUBMISSION OR FINAL SUBMISSION
    protected function CheckStateCreate($id)
    {
        $dates = Conference::select('created_at', 'submission_at')->where('id', $id)->first();
        if ($dates) {
            // Get the current date (without time)
            $currentDate = Carbon::now()->format('Y-m-d');

            // Extract the date part (without time) from the retrieved timestamps
            $submissionAtDate = Carbon::parse($dates->submission_at)->format('Y-m-d');
            $assignmentAtDate = Carbon::parse($dates->assignment_at)->format('Y-m-d');

            // Extract the date part (without time) from the retrieved timestamps
            $finalSubmissionAtDate = Carbon::parse($dates->final_submission_at)->format('Y-m-d');
            $finalAtDate = Carbon::parse($dates->final_at)->format('Y-m-d');


            // Perform the comparison
            if ( $dates->assignment_at==null|| $submissionAtDate <= $currentDate && $assignmentAtDate > $currentDate) {
                return true;
            }
            if($dates->final_at==null|| $finalSubmissionAtDate <= $currentDate && $finalAtDate > $currentDate){
                return true;
            }
            else {
                return false;
            }
        }


    }

    //  Function that checks if the user is an author of a paper
    protected function CheckIfAuthor($user_id, $paper_id)
    {
        $check1 = Paper::where([['id', $paper_id], ['creator_id', $user_id] ])->exists();
        $check2 = Author::where([['paper_id', $paper_id], ['user_id', $user_id]])->exists();
        if ($check1 || $check2) {
            return true;
        } else {
            return false;
        }

    }


    // Function that returns the paper's information (and reviews) for the user to see.
    //  The user can see a paper according to their role in the system
    public function ViewPaper(Request $request){
        $p_id=$request->input('p_id');
        $user_id= $request->input('user_id');
        //returns the first paper
        $papers = Paper::where('id', $p_id)->with(['creator', 'author.user'])->get();
        $paper=$papers->first();
        $conference_id= $request->input('con_id'); //returns the conference's id
        $IfpcReviewer=false;

        // check if the paper is not approved yet.
       if($paper->approved == null){
            //check if the user who makes the request is a pc Member
            $IfpcMember = PcMember::where([
                ['conference_id', $conference_id],
                ['user_id', $user_id]
            ])->first();

            //if the user is a pc member ckeck if the user is a reviewer to this specific paper
            if($IfpcMember) {
                $IfpcReviewer = Review::where(['paper_id' => $p_id, 'pc_member_id' => $IfpcMember->id])->exists();
            }

            //if is not a reviewer don't return the paper's file
            if(!$this->CheckIfAuthor($user_id,$p_id) && !$this->CheckIfPcChair($user_id,$conference_id) && $IfpcReviewer===false){
                foreach ($papers as $paper) {
                    $paper->file = null;
                }
            }
       }


        // Fetch reviews with the related pcMember and user
        $reviews = Review::where('paper_id', $p_id)->with(['pcMember.user'])->get();

        return response()->json(['message' => $papers,'reviews'=>$reviews]);

    }

    //Function that returns a paper's information for the quest to see
    public function ViewPaperVisitor(Request $request){
        $p_id=$request->input('p_id');

        $papers = Paper::where('id', $p_id)->with(['creator', 'author.user'])->get();
        $paper=$papers->first();

        if($paper->approved == null){
            foreach ($papers as $paper) {
                $paper->file = null;
            }
        }
        // Fetch reviews with the related pcMember and user
        $reviews = Review::where('paper_id', $p_id)->with(['pcMember.user'])->get();
        return response()->json(['message' => $papers,'reviews'=>$reviews]);
    }


    // Function that allows the PcChairs to add or remove reviewer to a paper
    public function AddReviewers($type,$c_id,Request $request) {
        $addReviewers=$request->input('addReviewers');
        $removeAuthors=$request->input('removeReviewers');
        $paper_id=$request->input('paper_id');

        if (!empty($addReviewers)) {
            $data = [];
            foreach ($addReviewers as $user_id) {
                $data[] = [
                    'pc_member_id' => $user_id,
                    'paper_id' => $paper_id,
                ];
            }
            Review::insert($data);  // Insert all records in one query
        }
        if(!empty($removeAuthors)){
            Review::whereIn('id', $removeAuthors)->delete();
        }
        return redirect()->back()->with('message','The Paper\'s Reviewers were successfully updated!');

    }

    // Function that returns all the paper's reviews when a user (a reviewer or a pcChair) make a request to add or update his review
    public function ReturnReviews(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'paper_id' => 'required|exists:papers,id',
        ]);

        // Get paper_id from the validated input
        $p_id = $validated['paper_id'];

        // Fetch reviews with the related pcMember and user
        $reviews = Review::where('paper_id', $p_id)->with(['pcMember.user'])->get();

        // Return the reviews as JSON
        return response()->json(['message' => $reviews]);
    }

    // Function that checks is a user is a reviewer to a paper
    public function CheckIfReviewer(Request $request){
        $user_id=$request->input('user_id');
        $conference_id=$request->input('con_id');
        $paper_id=$request->input('p_id');

        $IfpcMember = PcMember::where([
            ['conference_id', $conference_id],
            ['user_id', $user_id]
        ])->first();

        if($IfpcMember){
            $IfpcReviewer= Review::where(['paper_id'=>$paper_id, 'pc_member_id'=>$IfpcMember->id])->exists();
            if($IfpcReviewer){
                return response()->json(['message' => true]);
            }
            return response()->json(['message' => false]);
        }

        return response()->json(['message' => false]);
    }

    // Function that allows the pc members/reviewers or pc chairs to update a review
    public function UpdateReview(Request $request){
        $review_id=$request->input("rev_id");
        $reasoning=$request->input("rev_review");
        $grade=$request->input("mygrade");

        Review::Where('id', $review_id)->update([
            'reasoning' => $reasoning, // Convert reasoning to string
            'grade' => round($grade, 2), // Round the grade to 2 decimal places and keep it as a number
        ]);

        return redirect()->back()->with('message', 'The Review of this paper has been updated successfully!');

    }

    // Function that allows the Pc Chairs to Approve a paper
    public function ApprovePaper($type, $c_id, Request $request){
        $p_id =$request->input('p_id');
        if($this->CheckIfPcChair(Auth::user()->id,$c_id)){

            Paper::where('id',$p_id)->update(['approved'=>1]);
        }
        else{
            return redirect()->back()->with('message', 'You do not have the authority to do this action.');
        }
        return redirect()->back()->with('message', 'The paper has been approved successfully');
    }
    // Function that allows the Pc Chairs to  disapprove a paper
    public function DisapprovedPaper($type, $c_id,Request $request){
        $p_id =$request->input('p_id');
        if($this->CheckIfPcChair(Auth::user()->id,$c_id)){

            Paper::where('id',$p_id)->update(['approved'=>0]);
        }
        else{
            return redirect()->back()->with('message', 'You do not have the authority to do this action.');
        }
        return redirect()->back()->with('message', 'The paper has been disapproved successfully');
    }

    //delete all the disapproved papers when a conference is in a state final

    public function finalizeConference(Request $request){
        $c_id=$request->input('con_id');

        Paper::where([['conference_id',$c_id],['approved',0]])->delete();
        return response()->json(['message' => 'finalized successfully']);

    }

}
