<table class="table table-striped p-0 m-0">
    <thead>
    <tr>
        @foreach($columns as $column)
            <th>{{ $column }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>