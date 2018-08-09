
@foreach ($datasheets as $datasheet)
    <div class="card mb-5">
        <div class="card-header">
            {{ $datasheet->name }}
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <td>&nbsp;</td>
                        @foreach (\Config::get('warhammer.profiles') as $profile)
                            <td>{{ $profile }}</td>
                        @endforeach
                    </tr>
                </thead>
                @foreach ($datasheet->miniatures as $mini)
                    <tr>
                        <td>{{ $mini->name }}</td>
                        @foreach (\Config::get('warhammer.profiles') as $profile)
                            <td>{{ $mini->$profile }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
            <div class="">
                @foreach ($datasheet->abilities as $ability)
                    <span class="badge">{{ $ability->name }}</span>
                @endforeach
            </div>
            <div class="">
                @foreach ($datasheet->specialists as $name => $specialists)
                    <div class="">
                        {{ $name }}:
                        @foreach ($specialists as $specialist)
                            <span class="badge">{{ $specialist }}</span>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="">
                @foreach ($datasheet->keywords as $keyword)
                    <span class="badge">{{ $keyword->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
