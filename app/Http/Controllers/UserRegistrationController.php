<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\User;
use App\Models\UserRegistration;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Str;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class UserRegistrationController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            //'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string|max:255',
            'tel_no' => 'required|digits:10',
            'dob' => 'nullable|date',
            'gender' => 'required|string|in:male,female',
            //'password' => 'required|string|min:8|confirmed',           
            'parent_first_name' => 'required|string|max:255',
            'parent_last_name' => 'required|string|max:255',
            'parent_phone_number' => 'required|digits_between:10,15',
            'relationship_to_student' => 'required|string|max:255',
            //'role' => 'required|string',
            'grade' => 'required|string|max:255',
            'courses' => 'array', // Array of selected course IDs
        ]);


        $password = "sdadasdadadadadd"; // Generate a random password of 12 characters

        // Create the user in the users table
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name, // Full name,
            'email' => $request->email,
            'password' => Hash::make($password), // Hash the password before saving
        ]);

        // Create the user registration details in user_registrations table

        UserRegistration::create([
            'title' => $request->input('title', 'default_title'), // Add title if needed
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'tel_no' => $request->tel_no,
            'address' => $request->address,
            'image' => null, // Set a default value or leave null if not uploaded
            'status' => 'active', // Set a default status if required
            'user_id' => $user->id, // Reference the newly created user
            'role_id' => $request->role_id,
            'added_by' => $user->id, // Assuming you're getting the current user's ID


        ]);

        
        $parent = Parents::create([
            'first_name' => $request->parent_first_name,
            'last_name' => $request->parent_last_name,
            'tel_no'=> $request-> parent_phone_number,
            'relationship_type' => $request->relationship_to_student,
        ]);

        
        $student = Student::create([
            'student_id' => $user->id,
            'grade' => $request->grade,
            'QR_id' => null,
            'parent_id' => $parent->parent_id,
            'user_id' => $user->id,
        ]);


         // Insert courses into the student_courses table
        foreach ($request->courses as $course) {
            $course = Course::create([
                // TODO:  Please create a course before registering a student to course
            ]);
        DB::table('student_courses')->insert([
            'registered_date_time' => now(),  //current timestamp
            'status' => 'active', // or any default status
            'student_id' => $student->student_id,
            'course_id' => $course['id'],
        ]);


         // Return a success response
         return redirect()->back()->with('success', 'User registered successfully!');
        // return redirect()->route('dashboard')->with('success', 'Registration successful!');

        //return response()->json(['message' => 'User registered successfully.']);

    }
}
}