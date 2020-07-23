<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Event;
use App\Comment;

class EventController extends Controller
{
    /**
    * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
     protected function validator(array $data)
     {
         return Validator::make($data, [
             'name' => ['required', 'string', 'max:255'],
             'description' => ['required', 'string', 'max:2058'],
             'date' => ['required', 'date'],
             'category' => ['required', 'string'],
         ]);
     }

    /**
     * Show all the events.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Retrieve events from db using eloquent
        $events = Event::all();
        // render the view with the events
        return view('events/index', ['events' => $events]);
    }

    public function find($id)
    {
        $event = Event::find($id);
        // render the view with the event
        return view('events/show', ['event' => $event]);
    }

    public function new()
    {
        return view('events/new');
    }

    public function create(Request $request)
    {
      // validators
      $this->validator($request->all())->validate();
      // create event
      $event = $this->createEvent($request->all());
      // redirect to
      return \Redirect::route('events.show', $event->id)->with('success', 'Event sauvé!');
    }

    /**
     * Create a new event instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Event
     */
    protected function createEvent(array $data)
    {
        $event = new Event([
            'name' => $data['name'],
            'description' => $data['description'],
            'date' => $data['date'],
            'category' =>$data['category'],
        ]);
        Auth::user()->events()->save($event);
        return $event;
    }
    public function edit($id)
    {
        $event = Event::find($id);
        return view('events.edit', ['event' => $event]);
    }
    public function update(Request $request, $id)
    {


        $this->validator($request->all())->validate();
        $event = Event::find($id);
        $event->name =  $request->get('name');
        $event->description = $request->get('description');
        $event->date = $request->get('date');
        $event->category = $request->get('category');
        $event->save();


        return \Redirect::route('events.show', $event->id)->with('success', 'Event modifié!');

    }
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return \Redirect::route('events.index')->with('success', 'Event supprimé!');
    }
}
