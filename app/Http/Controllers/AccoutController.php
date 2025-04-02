<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AccoutController extends Controller
{
   public function register(){
      return view('account.register');
   }

   // This method will register a user
   public function processRegister(Request $request){
     $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:5',
        'password_confirmation' => 'required',
     ];

     $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
         return redirect()->route('account.register')->withInput()->withErrors($validator);
      }

    // Now Register User
    $user = new User();
    $user->name = $request->name; 
    $user->email = $request->email; 
    $user->password = Hash::make($request->password); 
    $user->save();

    return redirect()->route('account.login')->with('success','You have register successfully');
   }

   public function login(){
      return view('account.login');
   }

   public function authenticate(Request $request){

      $authrules = [
        'email' => 'required|email',
        'password' => 'required',
      ];
      
     $validator = Validator::make($request->all(), $authrules);

      if($validator->fails()){
         return redirect()->route('account.login')->withInput()->withErrors($validator);
      }

      if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
         return redirect()->route('account.profile');
      }else{
         return redirect()->route('account.login')->with("error", "Either Email/Password is Incorrect.");
      }
   }

   // This method will show  profile page
   public function profile() {
     $user = User::find(Auth::user()->id);
     return view("account.profile", [
      'user' => $user
     ]);
   }
   
   //This method update profile
   public function updateProfile(Request $request)
   {  
      $user = User::find(Auth::user()->id);

      $profileRules = [
         'name' => 'required|min:3',
         'email' => 'required|email|unique:users,email,' . Auth::user()->id . ',id',
      ];

      // Apply image validation only if an image is uploaded
      if (!empty($request->image)) {
         $profileRules['image'] = 'image|mimes:jpg,jpeg,png,gif|max:2048'; // Ensure it's an image and limit size to 2MB
      }

      // Validate the input data
      $validator = Validator::make($request->all(), $profileRules);

      if ($validator->fails()) {
         return redirect()->route('account.profile')->withInput()->withErrors($validator);
      }

      // Update user information
      $user->name = $request->name;
      $user->email = $request->email;
      $user->save();

      // Handle image upload
      if (!empty($request->image)) {

         //Delete old image here
         File::delete(public_path('uploads/profile/'. $user->image));

         $image =  $request->image;
         $ext = $image->getClientOriginalExtension();
         $imageName = time() . '.' . $ext; // Generate a unique image name

         // Move the uploaded image to the public/uploads/profile folder
         $image->move(public_path('uploads/profile'), $imageName);

         // Store the image path in the user record
         $user->image = $imageName;
         $user->save();
      }

      return redirect()->route('account.profile')->with("success", "Profile updated successfully.");
   }


   public function logout(){
     Auth::logout();
     return redirect()->route('account.login');
   }

   public function myReviews(){
      $reviews = Review::with('book')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(3);

      return view('account.my-reviews.my-reviews',[
         'reviews' => $reviews
      ]);
   }

   //this method will show edit review page
   public function editReview($id){
         
       $review = Review::where([
         'id' => $id,
         'user_id' => Auth::user()->id
       ])->with('book')->first();

      return view('account.my-reviews.edit-review',[
         'review' => $review
      ]);
   }

    //This method will update review
    public function updateReview($id, Request $request){
        
        $review = Review::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'rating' => 'required'
        ]);

        if ($validator->fails()){
            return redirect()->route('account.myReviews.editReview', $id)->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();

        session()->flash('success', 'Review updated successfully.');

        return redirect()->route('account.myReviews');
    }
}
