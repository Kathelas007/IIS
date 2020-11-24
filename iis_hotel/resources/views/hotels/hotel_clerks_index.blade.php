            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">
                            Assigned receptionists
                        </div>
                        <div class="col-0 text-right">
                            <a href= "{{route('hotels.clerk_choose', $hotel)}}" }}>Assign</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @foreach ($clerks as $clerk)
                    <div class="row">
                        <div class="col-3 text-left">
                            {{ $clerk->lastname }}
                        </div>
                        <div class="col-5 text-left">
                            {{ $clerk->email }}
                        </div>
                        <div class="col text-right">
                        {{--<form method="POST", action="/hotel_clerk/{{ $clerk->id }}">--}}
                        <form method="POST", action="{{route('hotels.clerk_unassign', ['id' => $clerk->id, 'hotel' => $hotel])}}">
                                @csrf
                                @method('DELETE')
                                <div class="form-group row mb-0">
                                   <div class="col text-right">
                                        <button class="btn btn-primary">
                                            Unassign
                                       </button>
                                   </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
