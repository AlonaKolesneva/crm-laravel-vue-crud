<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Requests\ClientManualRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Client::all()->except(['created_at', 'updated_at']), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientManualRequest $request)
    {
        Client::create($request->validated());
        return response()->json(['message'=>'Successfully added'], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientManualRequest $request, string $id)
    {
        $credentials = $request->validated();
        $client = Client::find($id);
        $client->update($credentials);
        return response()->json(['message'=>'Successfully Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json(['message'=>'Successfully Deleted'], 200);
    }
}
