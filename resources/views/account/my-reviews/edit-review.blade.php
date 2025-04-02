@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layouts.sidebar')            
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Edit Review
                    </div>
                    <div class="card-body pb-0">            
                         <form action="{{ route('account.myReviews.updateReview', $review->id) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Book</label>
                                <div><strong>{{ $review->book->title }}</strong></div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Review</label>
                                <textarea placeholder="Review" class="form-control @error('review')
                                    is-invalid
                                @enderror" name="review" id="review">{{ old('review', $review->review) }}</textarea>
                                @error('review')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Rating</label>
                                <select name="rating" id="rating" class="form-control @error('rating')
                                    is-invalid
                                @enderror">
                                    <option value="1" {{ ($review->status == 1) ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ ($review->status == 2) ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ ($review->status == 3) ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ ($review->status == 4) ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ ($review->status == 5) ? 'selected' : '' }}>5</option>
                                </select>
                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="btn btn-primary mt-2">Update</button> 
                        </form>    
                    </div>
                </div>                
            </div>
        </div>       
    </div>
@endsection