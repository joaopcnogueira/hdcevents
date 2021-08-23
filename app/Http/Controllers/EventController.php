<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUsers;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {

        $search = request('search');

        if($search) {
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
        } else {
            $events = Event::all();
        }

        return view('events.index', compact('events', 'search'));
    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $request) {

        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;
        $event->date = $request->date;

        // Image Upload
        if($request->hasFile('image') and $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . '.' . $extension;

            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;
    
        $event->save();

        return redirect()
                ->route('events.index')
                ->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id) {
        // dd($event);
        $event = Event::findOrFail($id);

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        $user = auth()->user();
        $userHasJoined = $user->eventsAsParticipant->contains($id);

        return view('events.show', compact('event', 'eventOwner', 'userHasJoined'));
        
    }

	public function dashboard()
	{
        $user = auth()->user();
        $events = $user->events;
        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', compact('events', 'eventsAsParticipant'));
	}

	public function destroy($id)
	{
		$event = Event::where('id', $id)->first();
        $event->delete();

        return redirect()
                ->route('dashboard')
                ->with('msg', 'Evento deletado com sucesso!');

	}

	public function edit($id)
	{
        $user = auth()->user();
        $event = Event::where('id', $id)->first();

        if($user->id != $event->user->id) {
            return redirect()
                    ->route('dashboard');
        };

        return view('events.edit', compact('event'));
	}

	public function update(Request $request, $id)
	{
        $data = $request->all();

        // Image Upload
        if($request->hasFile('image') and $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . '.' . $extension;

            $requestImage->move(public_path('img/events'), $imageName);
            $data['image'] = $imageName;
        }

		$event = Event::where('id', $id)->first();
        $event->update($data);

        return redirect()
        ->route('dashboard')
        ->with('msg', 'Evento editado com sucesso!');

	}

	public function join($id)
	{
        $user = auth()->user();

        $userHasJoined = $user->eventsAsParticipant->contains($id);

        if($userHasJoined) {
            return redirect()
                    ->back()
                    ->with('msg', 'Você já possui presença confirmada nesse evento!');
        }

        
        $user->eventsAsParticipant()->attach($id);
        $event = Event::findOrFail($id);

        return redirect()
                ->back()
                ->with('msg', 'Sua presença está confirmada no evento ' . $event->title);
	}

	public function leave($id) {
		$user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect()
                ->back()
                ->with('msg', 'Sua presença no evento ' . $event->title . ' foi cancelada.');
	}
}
