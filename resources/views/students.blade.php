@extends("layouts.main")

@section("title" , "Students")

@section("style")
<link rel="stylesheet" href="{{asset('css/students.css')}}">
@endsection

@section("section")
<section>
    <div class="continer">
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Student name</th>
                        <th>Mark</th>
                        <th>Report</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr>
                        <td>{{$student->user->name}}</td>
                        <td>{{$student->mark}} out of {{$fullMark}}</td>
                        <td><a href="">Report</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection