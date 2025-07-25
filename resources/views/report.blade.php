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
                    $emotionsPercentage = [];
                    $dangerScore = 0;
                    $weights = [
                        'fear' => 3,
                        'sad' => 2,
                        'angry' => 3,
                        'neutral' => 0,
                        'happy' => 1,
                        'surprised' => 1.5,
                        'tired' => 2,
                        'disgust' => 2.5,
                        'nervous' => 2.5,
                        'worried' => 2.5,
                        'confused' => 2,
                        'indifferent' => 2,
                    ];

                    $emotionsTotal = array_sum($emotions);

                    foreach ($emotions as $key => $value) {
                        $emotionsPercentage[$key] = ($value / $emotionsTotal) * 100;
                    }

                    foreach ($emotions as $key => $value) {
                        if (array_key_exists($key, $weights)) {
                            $dangerScore += ($value * $weights[$key]);
                        }
                    }

                    if ($dangerScore >= 70) {
                        $level = "High";
                        $message = "Significant emotional signals were detected (e.g., fear, nervousness, anger). Immediate review of the session is recommended.";
                    } elseif ($dangerScore >= 40) {
                        $level = "Moderate";
                        $message = "Moderate emotional activity detected. Please review the session to confirm if any unusual behavior occurred.";
                    } else {
                        $level = "Low";
                        $message = "No concerning emotional patterns detected. The session appears within normal emotional range.";
                    }


                @endphp
                <div>
                    <p class="percent">Below is the distribution of facial expressions detected during the exam, reflecting
                        the student’s
                        overall emotional state throughout the session</p>
                    <div>
                        <ol>
                            @foreach ($emotionsPercentage as $emotion => $percent)
                                <li>
                                    <span>{{$emotion}}: </span>
                                    <span>{{ floor($percent)}}%</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <div class="danger-score">
                    <p class="score">Final danger score derived from facial expression analysis during the exam</p>
                    <span>Emotional Alert Score: {{$dangerScore}} </span>
                    <span>Level: {{$level}}</span>
                    <p class="message">{{$message}}</p>
                </div>
            </div>
        </div>
    </section>
@endsection