<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Mail\InvitationAuColocation;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
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
        return view('invitations.create');
    }

    public function invite(Colocation $colocation)
    {
        //dd($colocation);
        return view('invitations.create', compact('colocation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function stored(InvitationRequest $request, Colocation $colocation)
    {
        $validatedInvitation = $request->validated();
        $validatedInvitation["status"] = 'pending';
        $validatedInvitation['user_id'] = auth()->id();

       $c = [
           'email' => $validatedInvitation['email'],
            'colocation_id' => $colocation->id,
       ];
        $payload = json_encode($c, JSON_THROW_ON_ERROR);
        $token = Crypt::encryptString($payload);
        $token = urlencode($token);
        $validatedInvitation['token'] = $token;
        $mailer = new InvitationAuColocation($validatedInvitation['email'], $validatedInvitation['token']);
        Mail::to('aythmadnhylt@gmail.com')->send($mailer);
        Invitation::create($validatedInvitation);
        return redirect()->route('colocations.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($token)
    {
        $token = urldecode($token); // decode URL safe
        $payload = Crypt::decryptString($token);

        return view('invitations.show', compact('payload', 'token'));
    }

    public function accept(Request $request, $token)
    {
        $token = urldecode($token);
        $payload = json_decode(Crypt::decryptString($token));

        $user = auth()->user();
        if($user->email !== $payload->email){
            abort(403, "Email mismatch");
        }
        $colocation = Colocation::find($payload->colocation_id);

        $colocation->users()->attach($user->id, [
            'role' => 'membre',
            'joined_at' => now()
        ]);


        // supprimer invitation
        Invitation::where('token', $token)->delete();

        return redirect()->route('colocations.index')->with('success', 'Vous avez rejoint la colocation !');
    }

    public function decline(Request $request, $token)
    {
        $token = urldecode($token);
        // juste supprimer invitation
        Invitation::where('token', $token)->delete();

        return redirect()->route('dashboard')->with('info', 'Invitation déclinée');
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
    public function update(Request $request, string $id)
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
