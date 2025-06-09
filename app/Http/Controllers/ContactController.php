<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact; // <--- ini yang kamu tambahin

class ContactController extends Controller
{
    /**
     * GET  /contact
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * POST /contact
     */
    public function send(Request $request)
{
    $data = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email',
        'phone'   => 'nullable|string|max:20', // phone optional
        'message' => 'required|string',
    ]);

    Contact::create($data);

    return back()->with('success', 'Your Message has been Sent! Thank You!');
}

}
