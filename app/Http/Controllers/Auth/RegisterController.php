<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //   A password must have a size of at least 8 characters and comprise both capital and
            //  lowercase letters, digits and special characters (e.g., !, ~, $, etc.). The username must be also
            //  validated: it must always begin with a letter and should comprise at least 5 characters that
            //  must be either alphanumeric or the ‘_’ one
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
        ])->after(function ($validator) use ($data) {
            if ($this->checkIfFullNameExists($data['firstname'], $data['lastname'])) {
                $validator->errors()->add('firstname', 'The combination of firstname and lastname already exists.');
                $validator->errors()->add('lastname', 'The combination of firstname and lastname already exists.');
            }
        });
    }

    protected function checkIfFullNameExists($firstname, $lastname)
    {
        return User::where('firstname', $firstname)
            ->where('lastname', $lastname)
            ->exists();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'system_role' => null,
            'account_status' => 1,
            'profile_picture'=>'profile_pictures/avatar.jpg',
        ]);
    }
}
