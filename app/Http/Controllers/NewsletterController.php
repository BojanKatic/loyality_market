<?php

namespace App\Http\Controllers;

use App\Newsletter;
use App\Clients;
use Illuminate\Http\Request;
use App\Mail\NewsletterMail;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletter = Newsletter::all();
        
        return view('newsletter.index', compact('newsletter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newsletter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newsletter_text = request('text');
        $clients = Clients::all();

        foreach($clients as $client_email){

            \Mail::to($client_email->email)->send(
                new NewsletterMail($newsletter_text, $client_email)  
            );
        }
        $atributes = request()->validate([
            'text' => 'required|min:5'
        ]);

        Newsletter::create([
            'text'=> request('text'),
            'sent_by'=> auth()->user()->id
        ]); 

        $request->session()->flash('status', 'Newslettert sending email to clients was successful!');
        return redirect('/newsletter'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        //
    }
}
