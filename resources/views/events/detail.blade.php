


<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Details of ').$event->name }}
            </h2>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{  __('Actions')}}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link onclick="editEvent()">
                        {{ __('Edit') }}
                    </x-dropdown-link>

                    <x-dropdown-link onclick="deleteEvent()" class="text-red-700">
                        {{ __('Delete') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
            {{-- <x-secondary-button class="ms-3" onclick="editEvent()">
                {{ __('Edit Event') }}
            </x-secondary-button> --}}
        </div>
    </x-slot>
    
    @if(session('success'))
        <div class="bg-green-100 text-green-800 border border-green-700 font-bold rounded-lg py-2 px-4 my-4 max-w-7xl mx-auto">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-200 text-red-800 border border-red-700 font-bold rounded-lg py-2 px-4 my-4 max-w-7xl mx-auto">
            {{ __('Invalid information') }}
        </div>
    @endif

    <div class="py-12 px-2">
        <div class="max-w-7xl mx-auto sm:p-6 lg:px-8">
            <div id="ticket">
                <div class="flex flex-row justify-between">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Ticket
                    </h2>
                    <x-secondary-button class="ms-3" onclick="newTicket()">
                        {{ __('New Ticket') }}
                    </x-secondary-button>
                </div>


                {{-- <div class="block p-6 bg-amber-100 border border-amber-700 rounded-lg shadow">
                        <h1 class="mb-2 text-xl font-bold tracking-tight text-amber-800">{{$ticket['name']}} - Expired</h1> --}}

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-6">
                    @foreach ($event->tickets as $ticket)
                    <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                        <h1 class="mb-2 text-xl font-bold tracking-tight text-gray-900">{{$ticket['name']}}</h1>
                        <p class="font-normal text-gray-500">
                            @if($ticket['special_validity'])
                                @if($ticket['special_validity']['type'] == 'amount')
                                    {{$ticket['special_validity']['amount']}} tickets available
                                @endif
                                @if($ticket['special_validity']['type'] == 'date')
                                    Availabel until {{$ticket['special_validity']['date']}}
                                @endif
                            @else
                                No limit
                            @endif
                        </p>
                        <p class="font-normal text-gray-600">{{$ticket['registration']}} registrations</p>
                        <p class="text-right">
                            <a id="deleteTicket{{$ticket['id']}}" class="text-lg p-1 cursor-pointer"><i class="fa-regular fa-trash-can text-red-700"></i></a>
                            <a id="editTicket{{$ticket['id']}}" class="text-lg p-1 cursor-pointer"><i class="fa-solid fa-pen-to-square text-blue-800"></i></a>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div id="conferences" class="mt-6 py-6">
                <div class="flex flex-row justify-between">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Conferences
                    </h2>
                    <x-secondary-button class="ms-3" onclick="newConference()">
                        {{ __('New Conference') }}
                    </x-secondary-button>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6 p-2 bg-white border border-gray-200">
                    <table class="w-full text-sm text-center text-gray-500 ">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-2">Title</th>
                                <th scope="col" class="px-6 py-2">Date</th>
                                <th scope="col" class="px-6 py-2">Time</th>
                                <th scope="col" class="px-6 py-2">Type</th>
                                <th scope="col" class="px-6 py-2">Speaker</th>
                                <th scope="col" class="px-6 py-2">Channel</th>
                                <th scope="col" class="px-6 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($event->conferences as $conference)
                            <tr class="bg-white">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{$conference['title']}}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{$conference['date']}}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{$conference['start']." - ".$conference['end']}}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{$conference['type']}}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{$conference['speaker']}}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{$conference['channel']}} / {{$conference['room']}}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a id="deleteConference{{$conference['id']}}" class="p-1 cursor-pointer"><i class="fa-regular fa-trash-can text-red-700"></i></a>
                                    <a id="editConference{{$conference['id']}}" class="p-1 cursor-pointer"><i class="fa-solid fa-pen-to-square text-blue-800"></i></a>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="channels" class="mt-6 py-6">
                <div class="flex flex-row justify-between">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Channels
                    </h2>
                    <x-secondary-button class="ms-3" onclick="newChannel()">
                        {{ __('New Channel') }}
                    </x-secondary-button>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-6">
                    @foreach ($event->channels as $channel)
                        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                            <h1 class="mb-2 text-xl font-bold tracking-tight text-gray-900">{{$channel['name']}}</h1>
                            <p class="font-normal text-gray-500">
                                {{$channel['conferences']}} conferences, {{$channel['rooms']}} rooms
                            </p>
                            <p class="text-right">
                                <a id="deleteChannel{{$channel['id']}}" class="text-lg p-1 cursor-pointer"><i class="fa-regular fa-trash-can text-red-700"></i></a>
                                <a id="editChannel{{$channel['id']}}" class="text-lg p-1 cursor-pointer"><i class="fa-solid fa-pen-to-square text-blue-800"></i></a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="rooms" class="mt-6 py-6">
                <div class="flex flex-row justify-between">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Rooms
                    </h2>
                    <x-secondary-button class="ms-3" onclick="newRoom()">
                        {{ __('New Room') }}
                    </x-secondary-button>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-6">
                    <style>
                        .progress-bar-container {
                            width: 100%;
                            overflow: hidden; /* Garante que o conteúdo não ultrapasse as bordas */
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra para dar profundidade */
                        }

                    </style>
                    @foreach ($event->rooms as $room)
                        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                            <div class="flex items-center justify-between">
                                <h1 class="mb-2 text-xl font-bold tracking-tight text-gray-900">{{$room['name']}}</h1>
                                <p>
                                    <a id="deleteRoom{{$room["id"]}}" class="text-lg cursor-pointer p-1"><i class="fa-regular fa-trash-can text-red-700"></i></a>
                                    <a id="editRoom{{$room["id"]}}" class="text-lg cursor-pointer p-1"><i class="fa-solid fa-pen-to-square text-blue-800"></i></a>
                                </p>
                            </div>
                            <p class="font-normal text-gray-600">Max capacity: {{$room['capacity']}} registrations</p>
                            <p class="font-normal text-gray-600 mt-3">Registrations by conference:</p>
                            <div class="grid grid-cols-1 lg:grid-cols-2 p-2 gap-2">
                                @foreach ($room["conferences"] as $conference)
                                <div class="block p-2 bg-white border border-gray-200 rounded-lg shadow">
                                    <p class="mb-2 text-lg tracking-tight text-gray-900">{{$conference['name']}}</p>
                                    <div class="progress-bar-container rounded-lg bg-gray-300">
                                        @if (round(($conference['registrations'] / $room['capacity']) * 100) <= 15)
                                            <div class="h-6 p-2 text-white font-bold flex items-center justify-center text-center bg-gray-500 rounded-l-lg" role="progressbar">

                                                {{ round(($conference['registrations'] / $room['capacity']) * 100) }}%
                                                
                                            </div>
                                        @elseif (round(($conference['registrations'] / $room['capacity']) * 100) >= 100)
                                            <div class="h-6 p-2 text-white font-bold flex items-center justify-center text-center rounded-l-lg w-full bg-red-600" role="progressbar">

                                                {{ round(($conference['registrations'] / $room['capacity']) * 100) }}%

                                            </div>
                                        @else
                                            <div class="h-6 p-2 text-white font-bold flex items-center justify-center text-center bg-gray-800 rounded-l-lg " role="progressbar"
                                                style="width: {{round(($conference['registrations'] / $room['capacity']) * 100)}}%;">

                                                {{ round(($conference['registrations'] / $room['capacity']) * 100) }}%

                                            </div>
                                        @endif
                                        
                                    </div>                                    
                                    <p>{{$conference['registrations']}} occupants</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div> 
    </div>

    {{-- Event Modal --}}
    <div id="eventModalDiv" class="fixed left-0 top-0 bg-black bg-opacity-50 w-screen h-screen z-10 flex justify-center items-center transition-opacity duration-500 hidden opacity-0">
        <div class="bg-white rounded shadow-md p-8 xl:w-1/2 md:w-7/12 w-4/5">
            <div class="flex items-start gap-5">
                <div class="bg-violet-200 rounded-full p-5 text-violet-900 flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-7">Event</h1>
                </div>
            </div>
            <div class="w-9/12 mx-auto">
                <form id="eventForm" method="POST" action="{{route("event.edit", ["eventId" => $event->id])}}">
                    @csrf
                    <div>
                        <x-input-label for="eventName" :value="__('Name')" />
                        <x-text-input id="eventName" class="block mt-1 w-full" type="text" name="eventName" :value="old('eventName')" required autofocus />
                        <x-input-error :messages="$errors->get('eventName')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="eventSlug" :value="__('Slug')" />
                        <x-text-input id="eventSlug" class="block mt-1 w-full" type="text" name="eventSlug"  pattern="[a-z0-9\-]+" title="{{__('Only lowercase letters, numbers and hyphens are allowed.')}}" :value="old('eventSlug')" required autofocus />
                        <x-input-error :messages="$errors->get('eventSlug')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="eventDate" :value="__('Date')" />
                        <x-text-input id="eventDate" class="block mt-1 w-full" type="date" name="eventDate" :value="old('eventDate')" required autofocus />
                        <x-input-error :messages="$errors->get('eventDate')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 mt-5">
                        <x-secondary-button id="eventModalCancelBtn">Cancel</x-secondary-button>
                        <x-primary-button>Save</x-primary-button>
                    </div>

                </form>
            </div>
            
        </div>
    </div>

    {{-- Ticket Modal --}}
    <div id="ticketModalDiv" class="fixed left-0 top-0 bg-black bg-opacity-50 w-screen h-screen z-10 flex justify-center items-center transition-opacity duration-500 hidden opacity-0">
        <div class="bg-white rounded shadow-md p-8 xl:w-1/2 md:w-7/12 w-4/5">
            <div class="flex items-start gap-5">
                <div class="bg-violet-200 rounded-full p-5 text-violet-900 flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-7">Ticket</h1>
                </div>
            </div>
            <div class="w-9/12 mx-auto">
                <form id="ticketForm" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div>
                        <x-input-label for="ticketName" :value="__('Name')" />
                        <x-text-input id="ticketName" class="block mt-1 w-full" type="text" name="ticketName" :value="old('ticketName')" required autofocus />
                        <x-input-error :messages="$errors->get('ticketName')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="ticketValidity" :value="__('Special Validity')" />
                        <select class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    id="ticketValidity" name="ticketValidity">
                            <option  value="">{{__('None')}}</option>
                            <option @if ($errors->get('ticketNumber')) @selected(true) @endif value="amount">{{__('Limited amount')}}</option>
                            <option @if ($errors->get('ticketDate')) @selected(true) @endif value="date">{{__('Purchaseable till date')}}</option>
                        </select>
                    </div>

                    <div id="validityDate" class="mt-4">
                        <x-input-label for="ticketDate" :value="__('Tickets can be sold until')" />
                        <x-text-input id="ticketDate" class="block mt-1 w-full"
                                        type="date"
                                        name="ticketDate"
                                        min="{{date('Y-m-d')}}"
                                         />
            
                        <x-input-error :messages="$errors->get('ticketDate')" class="mt-2" />
                    </div>

                    <div id="validityAmount" class="mt-4">
                        <x-input-label for="ticketNumber" :value="__('Maximum amount of tickets to be sold')" />
                        <x-text-input id="ticketNumber" class="block mt-1 w-full"
                                        type="number"
                                        name="ticketNumber"
                                         />
            
                        <x-input-error :messages="$errors->get('ticketNumber')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 mt-5">
                        <x-secondary-button id="ticketModalCancelBtn">Cancel</x-secondary-button>
                        <x-primary-button>Save</x-primary-button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    {{-- Conference Modal --}}
    <div id="conferenceModalDiv" class="fixed left-0 top-0 bg-black bg-opacity-50 w-screen h-screen z-10 flex justify-center items-center transition-opacity duration-500 hidden opacity-0">
        <div class="bg-white rounded shadow-md p-8 xl:w-1/2 md:w-7/12 w-4/5">
            <div class="flex items-start gap-5">
                <div class="bg-violet-200 rounded-full p-5 text-violet-900 flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-users-rectangle"></i>
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-7">Conference</h1>
                </div>
            </div>
            <div class=" w-4/5 lg:w-9/12 mx-auto max-h-[65vh] overflow-y-auto">
                <form id="conferenceForm" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div>
                        <x-input-label for="conferenceTitle" :value="__('Title')" />
                        <x-text-input id="conferenceTitle" class="block mt-1 w-full" type="text" name="conferenceTitle" :value="old('conferenceTitle')" required autofocus />
                        <x-input-error :messages="$errors->get('conferenceTitle')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="conferenceDescription" :value="__('Description')" />
                        <textarea id="conferenceDescription" class="block mt-1 w-full h-24 p-2 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm overflow-y-auto resize-none"
                                    name="conferenceDescription" minlength="25" required autofocus>{{old('conferenceDescription')}}</textarea>

                        <x-input-error :messages="$errors->get('conferenceDescription')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="mt-4">
                            <x-input-label for="conferenceType" :value="__('Type')" />
                            <select class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        id="conferenceType" name="conferenceType">
                                <option value="talk">{{__('Talk')}}</option>
                                <option value="workshop">{{__('Workshop')}}</option>
                           </select>
                        </div>
    
                        <div class="mt-4">
                            <x-input-label for="conferenceSpeaker" :value="__('Speaker')" />
                            <x-text-input id="conferenceSpeaker" class="block mt-1 w-full"
                                            type="text"
                                            name="conferenceSpeaker"
                                            required />
                
                            <x-input-error :messages="$errors->get('conferenceSpeaker')" class="mt-2" />
                        </div>
    
                        <div class="mt-4">
                            <x-input-label for="conferenceRoom" :value="__('Room')" />
                            <select class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        id="conferenceRoom" name="conferenceRoom">
                                @foreach ($event->rooms as $room)
                                    <option value="{{$room['id']}}">{{$room['name']}}</option>
                                @endforeach
                            </select>
                
                            <x-input-error :messages="$errors->get('conferenceRoom')" class="mt-2" />
                        </div>
    
                        <div class="mt-4">
                            <x-input-label for="conferenceDate" :value="__('Date')" />
                            <x-text-input id="conferenceDate" class="block mt-1 w-full"
                                            type="date"
                                            name="conferenceDate"
                                            min="{{$event->date}}"
                                            required />
                
                            <x-input-error :messages="$errors->get('conferenceStartDate')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="conferenceStart" :value="__('Start')" />
                            <x-text-input id="conferenceStart" class="block mt-1 w-full"
                                            type="time"
                                            name="conferenceStart"
                                            min="{{date('TH:i')}}"
                                            required />
                
                            <x-input-error :messages="$errors->get('conferenceStart')" class="mt-2" />
                        </div>
                        
                        <div class="mt-4">
                            <x-input-label for="conferenceEnd" :value="__('End')" />
                            <x-text-input id="conferenceEnd" class="block mt-1 w-full"
                                            type="time"
                                            name="conferenceEnd"
                                            min="{{date('TH:i')}}"
                                            required />
                
                            <x-input-error :messages="$errors->get('conferenceEnd')" class="mt-2" />
                        </div>
                    </div>
                    
                    <input type="hidden" name="eventDate" value="{{$event->date}}">

                    <div class="flex justify-end gap-4 mt-5">
                        <x-secondary-button id="conferenceModalCancelBtn">Cancel</x-secondary-button>
                        <x-primary-button>Save</x-primary-button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    {{-- Channel Modal --}}
    <div id="channelModalDiv" class="fixed left-0 top-0 bg-black bg-opacity-50 w-screen h-screen z-10 flex justify-center items-center transition-opacity duration-500 hidden opacity-0">
        <div class="bg-white rounded shadow-md p-8 xl:w-1/2 md:w-7/12 w-4/5">
            <div class="flex items-start gap-5">
                <div class="bg-violet-200 rounded-full p-5 text-violet-900 flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-users-rectangle"></i>
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-7">Channel</h1>
                </div>
            </div>
            <div class="w-9/12 mx-auto">
                <form id="channelForm" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div>
                        <x-input-label for="channelName" :value="__('Name')" />
                        <x-text-input id="channelName" class="block mt-1 w-full" type="text" name="channelName" :value="old('channelName')" required autofocus />
                        <x-input-error :messages="$errors->get('channelName')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 mt-5">
                        <x-secondary-button id="channelModalCancelBtn">Cancel</x-secondary-button>
                        <x-primary-button>Save</x-primary-button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    {{-- Room Modal --}}
    <div id="roomModalDiv" class="fixed left-0 top-0 bg-black bg-opacity-50 w-screen h-screen z-10 flex justify-center items-center transition-opacity duration-500 hidden opacity-0">
        <div class="bg-white rounded shadow-md p-8 xl:w-1/2 md:w-7/12 w-4/5">
            <div class="flex items-start gap-5">
                <div class="bg-violet-200 rounded-full p-5 text-violet-900 flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-users-rectangle"></i>
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-7">Room</h1>
                </div>
            </div>
            <div class="w-9/12 mx-auto">
                <form id="roomForm" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div>
                        <x-input-label for="roomName" :value="__('Name')" />
                        <x-text-input id="roomName" class="block mt-1 w-full" type="text" name="roomName" :value="old('roomName')" required autofocus />
                        <x-input-error :messages="$errors->get('roomName')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="roomChannel" :value="__('Channel')" />
                        <select class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    id="roomChannel" name="roomChannel">
                            @foreach ($event->channels as $channel)
                                <option value="{{$channel['id']}}">{{$channel['name']}}</option>
                            @endforeach
                        </select>
            
                        <x-input-error :messages="$errors->get('roomChannel')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="roomCapacity" :value="__('Capacity')" />
                        <x-text-input id="roomCapacity" class="block mt-1 w-full"
                                        type="number"
                                        name="roomCapacity"
                                        min="{{date('Y-m-d\TH:i')}}"
                                        required />
            
                        <x-input-error :messages="$errors->get('roomCapacity')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 mt-5">
                        <x-secondary-button id="roomModalCancelBtn">Cancel</x-secondary-button>
                        <x-primary-button>Save</x-primary-button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModalDiv" class="fixed left-0 top-0 bg-black bg-opacity-50 w-screen h-screen z-10 flex justify-center items-center transition-opacity duration-500 hidden opacity-0">
        <div class="bg-white rounded shadow-md p-8 w-11/12 md:w-1/2 lg:w-1/3">
            <div class="flex items-start gap-5">
                <div class="bg-red-200 rounded-full p-5 text-red-600 flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg mb-2">Delete</h1>
                    <p>{{ __('Are you sure you want to delete? The data will be permanently removed. This action cannot be undone.') }}</p>
                </div>
            </div>
            <div class="flex justify-end gap-4 mt-5">
                <form id="formDelete" method="POST">
                    @csrf
                    <x-secondary-button id="deleteModalCancelBtn">{{ __('Cancel') }}</x-secondary-button>
                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                </form>
                
            </div>
        </div>
    </div>

    
    <script>
        const event = @json($event);

        // Event
        let eventModalDiv = document.getElementById("eventModalDiv");
        let eventName = document.getElementById("eventName");
        let eventSlug = document.getElementById("eventSlug");
        let eventDate = document.getElementById("eventDate");
        let eventModalCancelBtn = document.getElementById("eventModalCancelBtn");



        // Ticket
        let ticketForm = document.getElementById("ticketForm");
        let ticketModalDiv = document.getElementById("ticketModalDiv");
        let ticketModalCancelBtn = document.getElementById("ticketModalCancelBtn");
        let ticketName = document.getElementById("ticketName");
        let ticketValidity = document.getElementById("ticketValidity");
        let ticketDate = document.getElementById("ticketDate");
        let ticketNumber = document.getElementById("ticketNumber");
        let validityAmount = document.getElementById("validityAmount");
        let validityDate = document.getElementById("validityDate");


        // Conference
        let conferenceModalDiv = document.getElementById("conferenceModalDiv");
        let conferenceForm = document.getElementById("conferenceForm");
        let conferenceTitle = document.getElementById("conferenceTitle");
        let conferenceDescription = document.getElementById("conferenceDescription");
        let conferenceType = document.getElementById("conferenceType");
        let conferenceSpeaker = document.getElementById("conferenceSpeaker");
        let conferenceRoom = document.getElementById("conferenceRoom");
        let conferenceDate = document.getElementById("conferenceDate");
        let conferenceStart = document.getElementById("conferenceStart");
        let conferenceEnd = document.getElementById("conferenceEnd");
        let conferenceModalCancelBtn = document.getElementById("conferenceModalCancelBtn");


        //Channel
        let channelModalDiv = document.getElementById("channelModalDiv");
        let channelForm = document.getElementById("channelForm");
        let channelName = document.getElementById("channelName");
        let channelModalCancelBtn = document.getElementById("channelModalCancelBtn");


        //Room
        let roomModalDiv = document.getElementById("roomModalDiv");
        let roomForm = document.getElementById("roomForm");
        let roomName = document.getElementById("roomName");
        let roomChannel = document.getElementById("roomChannel");
        let roomCapacity = document.getElementById("roomCapacity");
        let roomModalCancelBtn = document.getElementById("roomModalCancelBtn");


        // Delete
        let deleteModalDiv = document.getElementById("deleteModalDiv");
        let deleteModalCancelBtn = document.getElementById("deleteModalCancelBtn");



        // Event methods
        function editEvent() {
            eventName.value = event.name;
            eventSlug.value = event.slug;
            eventDate.value = event.date;

            eventModalDiv.classList.remove("hidden");
            setTimeout(() => {
                eventModalDiv.classList.remove('opacity-0');
            }, 20);
        }
        
        eventModalCancelBtn.addEventListener('click', () => {
            eventModalDiv.classList.add('opacity-0');
            setTimeout(() => {
                eventModalDiv.classList.add('hidden');
            }, 500)
        });

        function deleteEvent() {
            deleteModalDiv.classList.remove("hidden");
            setTimeout(() => {
                deleteModalDiv.classList.remove('opacity-0');
            }, 20);

            formDelete.action = "{{route("event.delete", ["eventId" => $event->id])}}";
        }



        // Ticket methods
        function newTicket() {
            ticketName.value = "";
            ticketNumber.value = "";
            ticketDate.value = "";
            ticketValidity.value = "";
            validityDate.classList.add("hidden");
            validityAmount.classList.add("hidden");
            ticketForm.action = "{{route('ticket.create')}}";
            ticketModalDiv.classList.remove("hidden");
            setTimeout(() => {
                ticketModalDiv.classList.remove('opacity-0');
            }, 20);
        }

        event.tickets.map(ticket => {
            const editTicketId = `editTicket${ticket.id}`;
            const deleteTicketId = `deleteTicket${ticket.id}`;
            
            const deleteButton = document.getElementById(deleteTicketId);
            const editButton = document.getElementById(editTicketId);

            if (editButton) {
                editButton.addEventListener('click', () => {
                    ticketName.value = "";
                    ticketNumber.value = "";
                    ticketDate.value = "";
                    ticketValidity.value = "";

                    ticketModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        ticketModalDiv.classList.remove('opacity-0');
                    }, 20);

                    ticketForm.action = "{{ url('tickets/edit/') }}"+"/"+ticket.id
                    ticketName.value = ticket.name;
                    if(ticket.special_validity) {
                        switch (ticket.special_validity.type){
                            case 'amount':
                                validityAmount.classList.remove("hidden");
                                validityDate.classList.add("hidden");
                                ticketNumber.value = ticket.special_validity.amount;
                                ticketValidity.value = "amount";
                                break;
                            case 'date':
                                validityDate.classList.remove("hidden");
                                validityAmount.classList.add("hidden");
                                ticketDate.value = ticket.dateUnFormatted;
                                ticketValidity.value = "date";
                                break;
                        }
                    } else{
                        ticketNumber.value = "";
                        ticketDate.value = "";
                        ticketValidity.value = "";
                        validityDate.classList.add("hidden");
                        validityAmount.classList.add("hidden");
                    }
                });
            }

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                   
                    deleteModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        deleteModalDiv.classList.remove('opacity-0');
                    }, 20);

                    formDelete.action = "{{ url('tickets/delete/') }}"+"/"+ticket.id;
                    
                });
            }
        });

        ticketModalCancelBtn.addEventListener('click', () => {
            ticketModalDiv.classList.add('opacity-0');
            setTimeout(() => {
                ticketModalDiv.classList.add('hidden');
            }, 500)
        });

        ticketValidity.addEventListener("change", function() {
            switch (this.value){
                case 'amount':
                    validityAmount.classList.remove("hidden");
                    validityDate.classList.add("hidden");
                    ticketNumber.value = "";
                    ticketDate.value = "";
                    break;
                case 'date':
                    validityDate.classList.remove("hidden");
                    validityAmount.classList.add("hidden");
                    ticketNumber.value = "";
                    ticketDate.value = "";
                    break;
                default:
                    validityDate.classList.add("hidden");
                    validityAmount.classList.add("hidden");
                    ticketNumber.value = "";
                    ticketDate.value = "";
                    break;
            }
        });

        switch (ticketValidity.value) {
            case 'amount':
                validityAmount.classList.remove("hidden");
                validityDate.classList.add("hidden");
                break;
            case 'date':
                validityDate.classList.remove("hidden");
                validityAmount.classList.add("hidden");
                break;
            default:
                validityDate.classList.add("hidden");
                validityAmount.classList.add("hidden");
                break;
        }


        // Conference methods
        function newConference() {
            conferenceTitle.value = "";
            conferenceDescription.value = "";
            conferenceType.value = "";
            conferenceSpeaker.value = "";
            conferenceRoom.value = "";
            conferenceDate.value = "";
            conferenceStart.value = "";
            conferenceEnd.value = "";
            conferenceForm.action = "{{route('conference.create')}}";
            conferenceModalDiv.classList.remove("hidden");
            setTimeout(() => {
                conferenceModalDiv.classList.remove('opacity-0');
            }, 20);
        }

        event.conferences.map(conference => {
            const editConferenceId = `editConference${conference.id}`;
            const deleteConferenceId = `deleteConference${conference.id}`;
            
            const deleteButton = document.getElementById(deleteConferenceId);
            const editButton = document.getElementById(editConferenceId);

            if (editButton) {
                editButton.addEventListener('click', () => {
                    conferenceTitle.value = "";
                    conferenceDescription.value = "";
                    conferenceType.value = "";
                    conferenceSpeaker.value = "";
                    conferenceRoom.value = "";
                    conferenceDate.value = "";
                    conferenceStart.value = "";
                    conferenceEnd.value = "";

                    conferenceModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        conferenceModalDiv.classList.remove('opacity-0');
                    }, 20);

                    conferenceForm.action = "{{ url('conferences/edit/') }}"+"/"+conference.id;

                    conferenceTitle.value = conference.title;
                    conferenceDescription.value = conference.description;
                    conferenceSpeaker.value = conference.speaker;
                    conferenceRoom.value = conference.room_id;
                    conferenceDate.value = conference.date;
                    conferenceStart.value = conference.start;
                    conferenceEnd.value = conference.end;
                    conferenceType.value = conference.type.toLowerCase();

                });
            }

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                   
                    deleteModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        deleteModalDiv.classList.remove('opacity-0');
                    }, 20);

                    formDelete.action = "{{ url('conferences/delete/') }}"+"/"+conference.id;
                    
                });
            }
        });

        conferenceModalCancelBtn.addEventListener('click', () => {
            conferenceModalDiv.classList.add('opacity-0');
            setTimeout(() => {
                conferenceModalDiv.classList.add('hidden');
            }, 500);
        });


        //Channel methods
        function newChannel() {
            channelName.value = "";
            channelForm.action = "{{route('channel.create')}}";
            channelModalDiv.classList.remove("hidden");
            setTimeout(() => {
                channelModalDiv.classList.remove('opacity-0');
            }, 20);
        }

        event.channels.map(channel => {
            const editChannelId = `editChannel${channel.id}`;
            const deleteChannelId = `deleteChannel${channel.id}`;
            
            const deleteButton = document.getElementById(deleteChannelId);
            const editButton = document.getElementById(editChannelId);

            if (editButton) {
                editButton.addEventListener('click', () => {
                    channelName.value = "";
                    channelModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        channelModalDiv.classList.remove('opacity-0');
                    }, 20);
                    channelForm.action = "{{ url('channels/edit/') }}"+"/"+channel.id;
                    channelName.value = channel.name;
                });
            }

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                   
                    deleteModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        deleteModalDiv.classList.remove('opacity-0');
                    }, 20);

                    formDelete.action = "{{ url('channels/delete/') }}"+"/"+channel.id;
                    
                });
            }
        });

        channelModalCancelBtn.addEventListener('click', () => {
            channelModalDiv.classList.add('opacity-0');
            setTimeout(() => {
                channelModalDiv.classList.add('hidden');
            }, 500)
        });


        //Room methods
        function newRoom() {
            roomName.value = "";
            roomChannel.value = "";
            roomCapacity.value = "";
            roomForm.action = "{{route('room.create')}}";
            roomModalDiv.classList.remove("hidden");
            setTimeout(() => {
                roomModalDiv.classList.remove('opacity-0');
            }, 20);
        }

        event.rooms.map(room => {
            const editRoomId = `editRoom${room.id}`;
            const deleteRoomId = `deleteRoom${room.id}`;
            
            const deleteButton = document.getElementById(deleteRoomId);
            const editButton = document.getElementById(editRoomId);

            if (editButton) {
                editButton.addEventListener('click', () => {
                    roomName.value = room.name;
                    roomChannel.value = room.channel_id;
                    roomCapacity.value = room.capacity;
                    roomModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        roomModalDiv.classList.remove('opacity-0');
                    }, 20);
                    roomForm.action = "{{ url('rooms/edit/') }}"+"/"+room.id;
                    
                });
            }

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                   
                    deleteModalDiv.classList.remove("hidden");
                    setTimeout(() => {
                        deleteModalDiv.classList.remove('opacity-0');
                    }, 20);

                    formDelete.action = "{{ url('rooms/delete/') }}"+"/"+room.id;
                    
                });
            }
        });

        roomModalCancelBtn.addEventListener('click', () => {
            roomModalDiv.classList.add('opacity-0');
            setTimeout(() => {
                roomModalDiv.classList.add('hidden');
            }, 500)
        });


        // Delete Modal methods
        deleteModalCancelBtn.addEventListener('click', () => {
            deleteModalDiv.classList.add('opacity-0');
            setTimeout(() => {
                deleteModalDiv.classList.add('hidden');
            }, 500)
        });
    </script>

</x-app-layout>