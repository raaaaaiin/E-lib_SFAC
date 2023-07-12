<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowedController extends Controller
{
    //
    public function __construct()
    { $this->middleware('auth');
    }

    public function index()
    {
        return view("back.book.issue");
    }

    public function edit($id)
    {
        $edit_book_id = $id;
        return view("back.book.issue", compact("edit_book_id"));
    }

    public function indexReceiveBooks(Request $request)
    {
        if ($request->has('search')) {
            $search = $request->get("search");
            return view("back.book.issued_books", compact("search"));
        } else {
            return view("back.book.issued_books");
        }
    }
}
