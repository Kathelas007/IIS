            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">
                            <a data-toggle="collapse" href="#collapseClerks" role="button" aria-expanded="false" aria-controls="collapseClerks">
                               Show Assigned receptionists
                              </a>

                        </div>
                        <div class="col text-right">
                            <a class="btn btn-primary" href= "{{route('hotels.clerk_choose', $hotel)}}" }}>Assign</a>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="collapseClerks">
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
            </div>
