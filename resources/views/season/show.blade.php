@extends('layout.default')

@section('content')

    <div class="row">
        <div class="col-12">
            <h2>Season {{ $season->name }}</h2>
        </div>
    </div>

    <div class="row">
    <div class="col-12">
    <div class="col-8 float-left">
        <h2>League Table</h2>
        <div id="league-table">
            @include('season.partials.league-table')
        </div>
    </div>

    <div class="col-4 float-left">
        <h2>Predictions Championship</h2>

        <div id="predictions-table">
            @include('season.partials.predictions-box')
        </div>
    </div>
    </div>
    </div>

<hr />


@include('season.partials.week-box', ['weeks' => $season->weeks])

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.play-all').on('click',function () {

                var weekId = $(this).attr('wid');

                $.post("{{ route('play_week') }}", {id: weekId, _token: "{{ csrf_token() }}"}, function(result){

                    $.each(result, function(i, item) {
                        if (item) {
                            updateWeekDiv('match_'+item.id, item.home.name, item.home_team_score, item.away.name, item.away_team_score);
                        }
                    });

                }, "json").promise().done(function(){
                    updateLeagueTable();
                    updatePredictionsTable();
                });

                $(this).hide();
            });
        });

        function updateWeekDiv(divId, homeTeam, homeTeamScore, awayTeam, awayTeamScore) {
            var html = "";
            html += homeTeam;
            html += " <small>("+ homeTeamScore + ")</small>";
            html += " vs ";
            html += "<small>("+ awayTeamScore + ")</small> ";
            html += awayTeam;

            $('#'+divId).html(html);
        }

        function updateLeagueTable() {
            $.get("{{ route('get_season_table', ['id'=>$season->id]) }}", function(result){
                $('#league-table').html(result);
            });
        }

        function updatePredictionsTable() {
            $.get("{{ route('get_season_predictions', ['id'=>$season->id]) }}", function(result){
                $('#predictions-table').html(result);
            });
        }
    </script>
@endsection
