<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Mail\InvitationAuColocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return view('invitations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        Mail::raw('Test', function ($message) {
//            $message->to('test@test.com')
//                ->subject('Test');
//        });
        //dd(config('mail.mailers.smtp'));

        //dd($mailer->content());
        return view('invitations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvitationRequest $request)
    {
        $validatedInvitation = $request->validated();
        $validatedInvitation["status"] = 'pending';
        $validatedInvitation["token"] = '124635';
        $validatedInvitation['user_id'] = auth()->id();
        $dd = Crypt::encryptString($validatedInvitation['email']);
        $c = ['email' => $validatedInvitation['email'],
            'colocation_id' => $validatedInvitation['user_id']];
        $d = json_encode($c, JSON_THROW_ON_ERROR);
        $validatedInvitation['token'] = encrypt($d);
        //dd($validatedInvitation['token']);

        $mailer = new InvitationAuColocation($validatedInvitation['email'], $validatedInvitation['token']);
        //dd($mailer);
        Mail::to('aythmadnhylt@gmail.com', )->send($mailer);
        Invitation::create($validatedInvitation);
        return redirect()->route('colocations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
