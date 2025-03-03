<?php

namespace App\Http\Controllers\Api\V1;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Models\Ticket;
use App\Http\Resources\V1\TicketResource;
use App\Http\Filters\V1\TicketFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters)
    {
        // if($this->include('author')) {
        //     return TicketResource::collection(Ticket::with('user')->paginate());
        // }
        return TicketResource::collection(Ticket::filter($filters)->paginate());
        // return TicketResource::collection(Ticket::paginate());
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
         try{
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
         }catch(ModelNotFoundException $e){
            return $this->ok('Author not found', [
                'error' => 'Error! Author not found '
            ]);
         }

         $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $user->id
         ];
         return new TicketResource(Ticket::create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        if($this->include('author')) {
            return new TicketResource($ticket->load('author'));

        }
        return new TicketResource($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try{
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->delete();
            return $this->ok('Ticket deleted successfully', [
                'message' => 'Ticket deleted successfully'
            ]);
        }catch(ModelNotFoundException $e){  
            return $this->error('Ticket not found', 404);
            
        }
    }
}
