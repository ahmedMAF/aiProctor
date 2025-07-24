@extends("layouts.main")

@section("title", "Report")

@section("style")
    <link rel="stylesheet" href="{{asset('css/report.css')}}">
@endsection

@section("section")
    <section>
        <div class="continer">
            <div class="info">
                <h3>Student information</h3>
                <p>Student name: <span>{{$student->user->name}}</span></p>
                <p>Start Time: <span>{{$student->start_time}}</span></p>
                <p>End Time: <span>{{$student->end_time}}</span></p>
            </div>
            @php
                $Data = json_decode($student->report, true);
                $emotions = null;
            @endphp
            <div class="violation">
                <h3>Violations and Breaches</h3>
                <Table>
                    <thead>
                        <tr>
                            <th>Violation Type</th>
                            <th>Timestamp (HH:MM:SS)</th>
                            <th>Description</th>
                            <th>Video Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Data as $violation)
                            @if ($violation['type'] == 'emotion')
                                @php
                                    $emotions = $violation;  
                                @endphp
                                @continue
                            @endif
                            <tr>
                                <td>{{$violation['type']}}</td>
                                <td>{{$violation['time']}}</td>
                                <td>{{$violation['description']}}</td>
                                @if ($violation['type'] == 'audio')
                                    <td><a href="/exam/report/prove/{{$violation['path']}}/audio">Listen</a></td>
                                @else
                                    <td><a href="/exam/report/prove/{{$violation['path']}}/video">Watch</a></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </Table>
            </div>
            <div class="emotion">
                @php
                    $emotions = json_decode($emotions['data'], true);
                @endphp
                {{$emotions['neutral']}}
            </div>
        </div>
    </section>
@endsection