
        <div class="row">
    @forelse($weeks as $week)
        <div class="col-4 mt-2" id="week_{{ $week->id }}">
            <div class="card h-100">
                <div class="card-body">

                    <h4 class="card-title mt-2">Week {{ $week->name }}</h4>

                    <div class="matches">
                        @include('season.partials.match-box', ['matches' => $week->matches])
                    </div>

                    @if($week->isPlayed->is_played==0)
                        <button class="btn btn-primary btn-card my-4 float-left play-all" wid="{{ $week->id }}">Play All</button>

                    @endif
                    <!--
                    TODO slide weeks div
                    <button class="btn btn-primary btn-card my-4 float-right">Next Week</button>
                    -->
                </div>
            </div>
        </div>
    @empty
        <p colspan="8">--</p>
    @endforelse
        </div>
