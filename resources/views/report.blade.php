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
                        <tr>
                            <td>{{$violation['type']}}</td>
                            <td>{{$violation['time']}}</td>
                            <td>{{$violation['description']}}</td>
                            <td><a href="/exam/report/prove/{{$violation['path']}}">Listen</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </Table>
            </div>
        </div>
    </section>
@endsection