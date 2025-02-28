<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\TicketResource;
use App\Filters\V1\TicketFilter;
use App\Models\Ticket;


class AuthorTicketsController extends Controller
{
    public function index($authorId, TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::where('user_id', $authorId)->filter($filters)->paginate());
    }
}
