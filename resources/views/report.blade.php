@extends("layouts.main")

@section("title" , "Report")

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
                    <tr>
                        <td>Looked away from screen</td>
                        <td>00:12:45</td>
                        <td>Student looked away for <span>5</span> seconds</td>
                        <td><a href="">Watch Video</a></td>
                    </tr>
                    <tr>
                        <td>Face out of frame</td>
                        <td>00:25:30	</td>
                        <td>Student's face was not detected for <span>10</span> seconds</td>
                        <td><a href="">Watch Video</a></td>
                    </tr>
                    <tr>
                        <td>Suspicious sound detected</td>
                        <td>00:40:15</td>
                        <td>Background voices detected</td>
                        <td><a href="">Watch Video</a></td>
                    </tr>
                </tbody>
            </Table>
        </div>
    </div>
</section>
@endsection