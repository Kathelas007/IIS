            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">
                            Room Types
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('roomTypes.create', $hotel)}}">Add type</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @foreach ($roomTypes as $roomType)
                    <div class="row">
                        <div class="col-3 text-left">
                            {{$roomType->name}}
                        </div>
                        <div class="col-2 text-left">
                            {{$roomType->beds_count}} beds
                        </div>
                        <div class="col-2 text-left">
                            {{$roomType->price}} EUR
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('rooms.index', ['hotel' => $hotel, 'roomType' => $roomType]) }}">
                                Rooms
                            </a>
                        </div>
                        <div class="col text-right">
                                {{--<a href="{{ route('hotels.owner_show', $hotel) }}">
                                    <button class="btn btn-primary">
                                        Edit
                                     </button>
                                </a> --}}
                                Edit
                        </div>
                        <div class="col text-right">
                        <form method="POST", action="/room_types/{{ $roomType->id }}">
                                @csrf
                                @method('DELETE')
                                <div class="form-group row mb-0">
                                   <div class="col text-right">
                                        <button class="btn btn-primary">
                                            Delete
                                       </button>
                                   </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
