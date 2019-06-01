<table class="table">
    <thead>
    <tr>
        <th>Team</th>
        <th>Played</th>
        <th>Won</th>
        <th>Drawn</th>
        <th>Lost</th>
        <th>GF</th>
        <th>GA</th>
        <th>Points</th>
    </tr>
    </thead>
    <tbody>
    @forelse($season->leagueTable as $team)
        <tr>
            <td>{{ $team->team->name }}</td>
            <td>{{ $team->played }}</td>
            <td>{{ $team->won }}</td>
            <td>{{ $team->drawn }}</td>
            <td>{{ $team->lost }}</td>
            <td>{{ $team->goals_for }}</td>
            <td>{{ $team->goals_against }}</td>
            <td>{{ $team->points }}</td>
        </tr>
    @empty
        <td colspan="8">--</td>
    @endforelse
    </tbody>
</table>
