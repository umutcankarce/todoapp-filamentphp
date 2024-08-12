<?php

use App\Filament\Resources\EventResource;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/events',function(){
    return  Event::all()->map(function($event){
        return [
            "title" => $event->title,
            "start" => $event->start_time,
            "end"   => $event->end_time,
        ];
    });
});


