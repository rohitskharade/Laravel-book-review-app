@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layouts.sidebar')
            </div>
            <div class="col-md-9">
                @include('layouts.message')
                <div class="card border-0 shadow">
                    @if ($reviews->isNotEmpty())
                    <div class="card-header  text-white">
                        My Reviews
                    </div>
                    <div class="card-body pb-0">
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            <tbody>
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>{{ $review->book->title }}</td>
                                            <td>{{ $review->review }}</td>
                                            <td>{{ $review->rating }}</td>
                                            <td>
                                                @if ($review->status == 1)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Block</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('account.myReviews.editReview', $review->id)}}" class="btn btn-primary btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                            </thead>
                        </table>
                        {{ $reviews->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection