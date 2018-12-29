<table class="table p-0 m-0">
    @isset($columns)
        <thead>
            <tr class="text-uppercase">
                @foreach($columns as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
    @endisset
    <tbody>
        {{ $slot }}
    </tbody>
</table>