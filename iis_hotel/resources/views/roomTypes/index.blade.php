            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">
                            <a data-toggle="collapse" href="#collapseTypes" role="button" aria-expanded="false" aria-controls="Types">
                               Show Room Types
                            </a>
                        </div>
                        <div class="col text-right">
                            <a class="btn btn-primary" href="{{ route('roomTypes.create', $hotel)}}">Add type</a>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="collapseTypes">
                    <div class="card-body">
                     @foreach ($roomTypes as $roomType)
                        <div class="row mt-1">
                            <div class="col-4 text-left">
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
                                <a href="{{ route('roomTypes.edit', ['hotel' => $hotel, 'roomType' => $roomType]) }}">
                                    <button class="btn btn-primary">
                                        Edit
                                     </button>
                                </a>
                            </div>
                            <div class="col text-right">
                            <form method="POST", action="{{ route('roomTypes.destroy', ['hotel' => $hotel, 'id' => $roomType->id]) }}">
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
            </div>
