<?php

namespace App\Http\Controllers;

use PDF;
use App\Http\Controllers\Controller;
use App\Mail\TicketNewMessage;
use App\Mail\TicketStatusUpdated;
use App\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $tickets = $user->role === 'admin' ? Ticket::orderBy('created_at', 'desc')->get() : Ticket::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

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
            'status' => 'open', // default status, open yra naujas, in_progress yra vykdomas, closed yra uzbaigtas
            'user_id' => $user->id,
        ]);

        $ticket->attachCategories($request->category_id);

        $ticket->messages()->create([
            'message' => $request->message,
            'user_id' => $user->id,
            //'category_id' => $request->category_id,
        ]);

        return redirect(route('tickets.index'))
            ->with('success', __('Your Ticket Was created successfully.'));
    }

    public function edit(Ticket $ticket)
    {
        Gate::authorize('update', $ticket);

        $categories = Category::all();
        return view('tickets.edit', compact('ticket', 'categories'));
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

        $ticket->messages()->create([
            'message' => $request->message,
            'user_id' => Auth::id(),
        ]);

        Mail::to($ticket->user->email)->send(new TicketNewMessage($ticket, $request->message));

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        Gate::authorize('delete', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function show(Ticket $ticket)
    {
        Gate::authorize('view', $ticket);
        $ticket->load('messages.user');


        return view('tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        Gate::authorize('update', $ticket);

        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        Mail::to($ticket->user->email)->send(new TicketStatusUpdated($ticket));

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket status updated successfully.');
    }

    public function addComment(Request $request, Ticket $ticket)
    {
        Gate::authorize('view', $ticket);

        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'message' => $request->message,
            'user_id' => Auth::id(),
        ]);

        if ($ticket->user_id !== Auth::id()) {
        Mail::to($ticket->user->email)->send(new TicketNewMessage($ticket, $request->message));
    }

        return redirect()->route('tickets.show', $ticket)->with('success', 'Comment added successfully.');
    }

    public function exportPdf()
    {
        // Get all active tickets for the current user (or all if admin)
        $tickets = Auth::user()->isAdmin()
            ? Ticket::where('status', '!=', 'closed')->get()
            : Ticket::where('user_id', Auth::id())
            ->where('status', '!=', 'closed')
            ->get();

        $html = view('tickets.pdf', compact('tickets'))->render();

        $pdf = PDF::loadHTML($html);

        // Download the PDF
        return $pdf->download('active-tickets.pdf');
    }
}
