@foreach($matches as $match)
    <p id="match_{{$match->id}}">
        {{ $match->home->name }}
        <small>({{ $match->home_team_score }})</small>
        vs
        <small>({{ $match->away_team_score }})</small>
        {{ $match->away->name }}
    </p>
@endforeach