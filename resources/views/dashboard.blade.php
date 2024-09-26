<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end">
                <x-primary-button class="ms-3" onclick="newEvent()">
                    {{ __('Create New Event') }}
                </x-primary-button>
            </div>

            <div class="mt-6 shadow-sm grid grid-cols-1 lg:grid-cols-3 gap-4 p-6">
                @foreach ($events as $event)
                    <a href="{{route('event.detail',['eventId' => $event->id])}}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                        <h1 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$event->name}}</h1>
                        <p class="font-normal text-gray-500">{{$event->registrations}} registrations</p>
                        <p class="font-normal text-gray-600" style="text-align: right;">{{$event->date}}</p>
                    </a>
                @endforeach
            </div>
            
            

        </div> 
    </div>

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
                <form id="eventForm" method="POST" action="{{route("event.create")}}">
                    @csrf
                    <div>
                        <x-input-label for="eventName" :value="__('Name')" />
                        <x-text-input id="eventName" class="block mt-1 w-full" type="text" name="eventName" :value="old('eventName')" required autofocus />
                        <x-input-error :messages="$errors->get('eventName')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="eventSlug" :value="__('Slug')" />
                        <x-text-input id="eventSlug" class="block mt-1 w-full" type="text" name="eventSlug"  pattern="[a-z0-9\-]+" title="Apenas letras minúsculas, números e hífen são permitidos." :value="old('eventSlug')" required autofocus />
                        <x-input-error :messages="$errors->get('eventSlug')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="eventDate" :value="__('Date')" />
                        <x-text-input id="eventDate" class="block mt-1 w-full" type="date" name="eventDate" :value="old('eventDate')" required autofocus />
                        <x-input-error :messages="$errors->get('eventDate')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 mt-5">
                        <x-secondary-button id="eventModalCancelBtn">Cancel</x-secondary-button>
                        <x-primary-button id="">Save</x-primary-button>
                    </div>

                </form>
            </div>
            
        </div>
    </div>

    <script>
        // Event
        let eventModalDiv = document.getElementById("eventModalDiv");
        let eventModalCancelBtn = document.getElementById("eventModalCancelBtn");


        // Event methods
        function newEvent() {
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
    </script>
</x-app-layout>
