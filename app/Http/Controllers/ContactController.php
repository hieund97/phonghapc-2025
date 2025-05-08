<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStore;
use App\Http\Requests\ContactUpdate;
use App\Models\Contact;
use App\Models\ContactReceiver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('contacts.index');

        $contactStatus = Contact::STATUS;

        $aryContact = Contact::paginate();

        return view('contacts.index', compact('contactStatus', 'aryContact'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('contacts.store')) {
            throw new AccessDeniedHttpException;
        }

        $aryContactReceiver = ContactReceiver::all();
        return view('contacts.form', compact('aryContactReceiver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(ContactStore $request)
    {
        $data = $request->validated();
        $contact = Contact::create($data);

        return redirect()->route('contacts.edit', ['contact' => $contact->id])->with('success', __('Created success'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request$request, $id)
    {
        if (!$request->user()->can('contacts.update')) {
            throw new AccessDeniedHttpException;
        }

        $contact = Contact::where('id', $id)->first();

        $aryContactReceiver = ContactReceiver::all();


        return view('contacts.form', compact('contact', 'aryContactReceiver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id, ContactUpdate $request)
    {
        $data = $request->validated();
        $contact = Contact::findOrFail($id);
        $contact->update($data);

        return redirect()->route('contacts.edit', ['contact' => $contact->id])->with('success', __('Edited success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user()->can('contacts.destroy')) {
            throw new AccessDeniedHttpException;
        }
        $contact = Contact::where('id', $id)->first();

        if (!$contact->delete()) {
            throw new AccessDeniedHttpException;
        }
    }
}
