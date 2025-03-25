<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{
    // Show User List
    public function index()
    {
        $users = User::with('company')->get();
        return view('company_users.index', compact('users'));
    }

    // Show Add User Form
    public function create()
    {
        $companies = Company::all();
        return view('company_users.create', compact('companies'));
    }

    // Store New User
    public function store(Request $request)
    {
      
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'company_id' => 'required|exists:companies,id'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'company_id' => $request->company_id
        ]);

        return redirect()->route('company.users.index')->with('success', 'User added successfully!');
    }
}

