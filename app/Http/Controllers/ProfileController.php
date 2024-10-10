<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
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
        //  Middleware that checks if the user has active account and has a role in the system
        $this->middleware('checkAccess');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    // Function that returns the user's profile page
    public function ShowMyProfile()
    {
        return view('allRoles/profile');
    }

    // Function that updates the data of the user from the form in the user's profile page
    public function UpdateProfile(Request $request){
        $id=$request->input('id');

        // Takes the current email of the user before updating the new data
        $current_email= User::where('id',$id)->first();
        $current_email=$current_email->email;
        // Takes the new email
        $email=$request->input('email');

        // validate the email of the user ( we want to be unique)
        $request->validate(['email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)]]);

        // If there is a new profile picture upload the image and update the row of the user in the database
        // the user can update the profile picture and the email of the account
        if($request->file('image')!=null){
            $image = $request->file('image');
            $filename = time() . '_' .$image->getClientOriginalName();
            // Move the uploaded file to a desired directory
            $image->move(public_path('profile_pictures'), $filename);

            User::where('id',$id)->update([
                'email'=>$email,
                'profile_picture'=>'profile_pictures/'.$filename
            ]);
         // if there is not a new profile update only the email of he user
        }else{
            User::where('id',$id)->update([
                'email'=>$email,
            ]);
        }

        //If the new email is different from the current on then delete the user's token and log the user out of his account.
        if($email!==$current_email){
            DB::table('oauth_access_tokens')
                ->where("user_id", Auth::user()->id)
                ->delete();
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect('/login')->with('warning',"You must login again because you changed your profile's email.");
        }

        return redirect()->back()->with('message',"Your profile has been successfully updated!");

    }


    // Function that changes the user's password
    public function ChangePassword(Request $request)
    {
        $id = $request->input('id');
        $user = User::where('id',$id)->first(); // Correctly retrieve the user instance
        $password = $request->input('password');

        // Track failed attempts using session or cache
        $failedAttempts = Cache::get('password_change_failed_attempts_'.$user->id, 0);


        // Validate the data from the form
        //  The new password must be the same with the conformation password
        //  The  current password must be correct
        //   A password must have a size of at least 8 characters and comprise both capital and
        //  lowercase letters, digits and special characters (e.g., !, ~, $, etc.). The username must be also
        //  validated: it must always begin with a letter and should comprise at least 5 characters that
        //  must be either alphanumeric or the ‘_’ one
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ])->after(function ($validator) use ($request, $user) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                $validator->errors()->add('current_password', 'The current password is incorrect.');
            }
        });

        // If the user tries unsuccessfully to change his/her password
        if ($validator->fails()) {
            $failedAttempts++;
            Cache::put('password_change_failed_attempts_'.$user->id, $failedAttempts, now()->addMinutes(15)); // 15 minutes lockout period

            // Check if the user has failed 3 times
            if ($failedAttempts >= 3) {
                $user->update(['account_status' => 0]); // Lock the account of this user

                // delete the token
                DB::table('oauth_access_tokens')
                    ->where("user_id", Auth::user()->id)
                    ->delete();

                Auth::logout();// lock the user out
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect('/login')->with('warning','Your account has been locked due to too many failed attempts.');
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Reset failed attempts on successful password change
        Cache::forget('password_change_failed_attempts_'.$user->id);


        // if the validation is successfull then update the user's password
        $user->update([
            'password' => Hash::make($password), // Hash the new password
        ]);


        // Log the user out because and delete the user's token
        DB::table('oauth_access_tokens')
            ->where("user_id", Auth::user()->id)
            ->delete();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login')->with('warning', "You must log in again because you changed your password.");
    }

    // Function that allow the user to make a delete request
    // That means that deletes from the user's account the role and locks this account
    public function DeleteRequest(Request $request){
        $id = $request->input('id');
        User::where('id',$id)->update([
            'system_role'=>null,
            'account_status'=>0
        ]);
        return redirect()->back()->with('message',"Your account deletion request has been successfully submitted!");
    }


}
