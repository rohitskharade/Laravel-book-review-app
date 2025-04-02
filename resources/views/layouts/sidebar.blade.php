   <div class="card border-0 shadow-lg">
       <div class="card-header  text-white">
           Welcome, {{ Auth::user()->name }}
       </div>
       <div class="card-body">
           <div class="text-center mb-3">
               @if (Auth::user()->image != "")
               <img src="{{ asset('uploads/profile/'.Auth::user()->image) }}" class="img-fluid rounded-circle"
                   alt="Luna John">
               @endif
           </div>
           <div class="h5 text-center">
               <strong>{{ Auth::user()->name }} </strong>
               <p class="h6 mt-2 text-muted">{{ (Auth::user()->reviews->count() > 1) ? Auth::user()->reviews->count(). " Reviews" : Auth::user()->reviews->count()." Review"}} </p>
           </div>
       </div>
   </div>
   <div class="card border-0 shadow-lg mt-3">
       <div class="card-header  text-white">
           Navigation
       </div>
       <div class="card-body sidebar">

           <ul class="nav flex-column">
               @if (Auth::user()->role == 'admin')
               <li class="nav-item">
                   <a href="{{ route('books.index') }}">Books</a>
               </li>
               <li class="nav-item">
                   <a href="{{ route('account.reviews') }}">Reviews</a>
               </li>
               @endif
               <li class="nav-item">
                   <a href="{{ route('account.profile') }}">Profile</a>
               </li>
               <li class="nav-item">
                   <a href="{{ route('account.myReviews') }}">My Reviews</a>
               </li>
               {{-- <li class="nav-item">
                   <a href="change-password.html">Change Password</a>
               </li> --}}
               <li class="nav-item">
                   <a href="{{ route('account.logout') }}">Logout</a>
               </li>
           </ul>
       </div>
   </div>