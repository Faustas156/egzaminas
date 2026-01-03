<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
public function store(Request $request)
{
    /** @var User */
    $user = Auth::user();
 
    $ticket = $user->tickets()
                    ->create($request->validated());
 
    $categories = Category::first();
    $labels = Label::first();
 
    $ticket->attachCategories($categories);
    $ticket->attachLabels($labels);
 
    // or you can create the categories & the tickets directly by:
    // $ticket->categories()->create(...);
    // $ticket->labels()->create(...);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $ticket = Ticket::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'category' => $request->category_id,
        'user_id' => $user->id,
    ]);
 
    return redirect(route('tickets.show', $ticket->uuid))
            ->with('success', __('Your Ticket Was created successfully.'));
}
 
public function createLabel()
{
    // If you create a label seperated from the ticket and wants to
    // associate it to a ticket, you may do the following.
    $label = Label::create($ticket);
 
    $label->tickets()->attach($ticket);
 
    // or maybe
    $label->tickets()->detach($ticket);
}
 
public function createCategory()
{
    // If you create a category/categories seperated from the ticket and wants to
    // associate it to a ticket, you may do the following.
    $category = Category::create(...);
 
    $category->tickets()->attach($ticket);
 
    // or maybe
    $category->tickets()->detach($ticket);
}
}
