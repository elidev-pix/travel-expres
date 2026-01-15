<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function getList()
    {
    
    $students = Student::all();
    return view('profile.partials.listing.student-list',compact('students'));
    
    }

}
