<?php

namespace App\Jawaban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;

class NomorEmpat {

    public function getJson()
    {
        $userId = Auth::id();
        
        $events = Event::all();  
        
        $formattedEvents = $events->map(function ($event) use ($userId) {
            return [
                'id' => $event->id,
                'title' => $event->name . ' - ' . $event->user->name,
                'start' => $event->start->toIso8601String(),  
                'end' => $event->end ? $event->end->toIso8601String() : null,  
                'color' => ($event->user_id == $userId) ? 'primary' : 'gray',  
            ];
        });

        return response()->json($formattedEvents);
    }


}

?>