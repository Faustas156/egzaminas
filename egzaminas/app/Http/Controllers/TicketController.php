<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $user = Auth::user();

        return view('tickets.index', compact('tickets', 'user'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        /** @var User */
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'status' => 'open', // default status, 1 yra naujas, 2 yra vykdomas, 3 yra uzbaigtas (open, in progress, closed)
            'user_id' => $user->id,
        ]);

        $ticket->attachCategories($request->category_id);

        $ticket->messages()->create([
            'message' => $request->message,
            'user_id' => $user->id,
            //'category_id' => $request->category_id,
        ]);

        return redirect(route('dashboard'))
            ->with('success', __('Your Ticket Was created successfully.'));
    }

    public function allTickets()
    {
        $tickets = Ticket::with(['categories', 'messages'])->orderBy('created_at', 'desc')->get();
        $user = Auth::user();

        return view('tickets.index', compact('tickets'));
    }

    public function edit(Ticket $ticket)
    {
        Gate::authorize('update', $ticket);

        $categories = Category::all();
        return view('tickets.edit', compact('ticket', 'categories'));
        // return view('tickets.edit', ['ticket' => $ticket, 'user' => Auth::user()]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        Gate::authorize('update', $ticket);

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket->update([
            'title' => $request->title,
        ]);

        $ticket->categories()->sync([$request->category_id]);

        // Add a new message as an update note
        $ticket->messages()->create([
            'message' => $request->message,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        // Authorization
        Gate::authorize('delete', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function createCategory()
    {
        // If you create a category/categories seperated from the ticket and wants to
        // associate it to a ticket, you may do the following.
        // $category = Category::create(...);

        // $category->tickets()->attach($ticket);

        // // or maybe
        // $category->tickets()->detach($ticket);
    }
}
