<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //This method will show the listing page
    public function index(Request $request) {

      $books = Book::orderBy('created_at', 'DESC');

      if(!empty($request->keyword)){
         $books->where('title', 'like','%'.$request->keyword.'%');
      }

      $books = $books->withCount('reviews')->withSum('reviews','rating')->paginate(3);

      return view('books.list', [
        'books' => $books
      ]);
    }

    //This method will show create book page
    public function create() {
        return view('books.create');
    }

    //This method will book in database
    public function store(Request $request){
        $rules = [
            'title'  => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
        ];
        
        if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(),$rules);

        //dd($validator);

        if($validator->fails()){
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }
        
        //Save Book in DB
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->save();
        
        //upload book image here
        if(!empty($request->image)){
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName =  time().'.'.$ext;
            $image->move(public_path('uploads/books'), $imageName);
            
            $book->image = $imageName;
            $book->save();
        }
        return redirect()->route('books.index')->with('success', 'Book added successfully');

    }

    //This method will show edit book page
    public function edit($id){
        $book = Book::findOrFail($id);
        return view('books.edit', [
            'book' => $book
        ]); 
    }

    //This method will update the book
    public function update($id, Request $request){
        $book = Book::findOrFail($id);
 
         $rules = [
            'title'  => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
        ];
        
        if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(),$rules);

        //dd($validator);

        if($validator->fails()){
            return redirect()->route('books.edit', $book->id)->withInput()->withErrors($validator);
        }
        
        //Update Book in DB
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->save();
        
        //upload book image here
        if(!empty($request->image)){

            //this will delete old image file from book directory
            File::delete(public_path('uploads/books'.$book->image));

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName =  time().'.'.$ext;
            $image->move(public_path('uploads/books'), $imageName);
            
            $book->image = $imageName;
            $book->save();
        }
        return redirect()->route('books.index')->with('success', 'Book updated successfully');

    }

    //This method will delete a book from database
    public function destroy(Request $request){
        $book = Book::find($request->id);

        if($book == null){
           session()->flash('error', 'Book not found');
           return response()->json([
                'status' => false,
                'message' =>  'Book not found'
            ]);
        } else{
            File::delete(public_path('uploads/books/'.$book->image));
            $book->delete();

            session()->flash('success', 'Book deleted successfully');
            
            return response()->json([
                'status' => true,
                'message' =>  'Book deleted successfully'
            ]);
        }
    }
}
