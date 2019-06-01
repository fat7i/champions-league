<table class="table">
    <thead>
    <tr>
        <th>Team</th>
        <th></th>

    </tr>
    </thead>
    <tbody>
    @forelse($predictions as $team)
        <tr>
            <td>{{ $team['name'] }}</td>
            <td>%{{ $team['percentage'] }}</td>
        </tr>
    @empty
        <td colspan="8">--</td>
    @endforelse
    </tbody>
</table>
