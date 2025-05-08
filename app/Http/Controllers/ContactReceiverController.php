<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactReceiverStore;
use App\Http\Requests\ContactReceiverUpdate;
use App\Models\ContactReceiver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ContactReceiverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('contacts_receiver.index');

        $receiverStatus = ContactReceiver::STATUS;

        $aryReceiver = ContactReceiver::paginate();

        return view('contacts_receiver.index', compact('receiverStatus', 'aryReceiver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('contacts_receiver.store')) {
            throw new AccessDeniedHttpException;
        }
        return view('contacts_receiver.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(ContactReceiverStore $request)
    {
        $data = $request->validated();

        $receiver = ContactReceiver::create($data);

        //return redirect()->route('contacts_receiver.edit', ['contacts_receiver' => $receiver->id])->with('success', __('Created success'));
        return redirect()->route('contacts_receiver.edit', ['contacts_receiver' => $receiver->id])->with('success', __('Created success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        if (!$request->user()->can('contacts_receiver.update')) {
            throw new AccessDeniedHttpException;
        }

        $receiver = ContactReceiver::where('id', $id)->first();

        return view('contacts_receiver.form', compact('receiver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int    $id
     * @return Response
     */
    public function update(ContactReceiverUpdate $request, $id)
    {
        $data = $request->validated();
        $receiver = ContactReceiver::findOrFail($id);
        $receiver->update($data);

        return redirect()->route('contacts_receiver.edit', ['contacts_receiver' => $receiver->id])->with('success', __('Edited success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user()->can('contacts_receiver.destroy')) {
            throw new AccessDeniedHttpException;
        }
        $contact = ContactReceiver::where('id', $id)->first();

        if (!$contact->delete()) {
            throw new AccessDeniedHttpException;
        }
    }
}
