@extends('layouts.main')

@section('title', 'Exams')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
@endsection

@section('section')
    <section>
        <div class="continer">

            @if ($user->account_type)
                {{-- for reacher --}}
                <div class="exams">
                    <h2>Exams created</h2>
                    @if ($exams->isEmpty())
                        <h2 style="text-align: center">No exams created yet</h2>
                    @else
                        <div class="group">
                            @foreach ($exams as $exam)
                                <div class="exam">
                                    <p>Exam Name: <span>{{ $exam->name }}</span></p>
                                    <p class="des">Description: <span>{{ $exam->description }}</span></p>
                                    <p>Navigation Style: <span>
                                            @if ($exam->is_sequential == 1)
                                                Sequential
                                            @else
                                                Free
                                            @endif
                                        </span></p>
                                    <p>Shuffling Questions: <span>
                                            @if ($exam->do_mix == 1)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </span></p>
                                    <p>Open Time: <span>{{ $exam->open_time }}</span></p>
                                    <p>Close Time: <span>{{ $exam->close_time }}</span></p>
                                    <p>Duration: <span>{{ $exam->duration }}m</span></p>
                                    <p>Full Mark: <span>{{ $exam->full_mark }}</span></p>
                                    <p>Pass Mark: <span>{{ $exam->pass_mark }}</span></p>
                                    <p>Exam link: <span>/student/examlink/{{ $exam->id }}</span></p>
                                    <div class="button">
                                        <a href="/teacher/addQ/{{ $exam->id }}" class="btn">Questions</a>
                                        <a href="/teacher/students/{{ $exam->id }}" class="btn">Students</a>
                                        <button class="btn" onclick="deleteExam({{ $exam->id }})">Delete</button>
                                        <a href="/teacher/update/{{ $exam->id }}" class="btn">Update</a>
                                    </div>
                                </div>
                            @endforeach
                    @endif
                </div>
        </div>
        <div class="exams">
            <a href="/teacher/add" class="btn">Add an Exam</a>
        </div>
        <form id="delete-form" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    @else
        {{-- for steadent --}}
        <div class="exams">
            <h2>Exams completed</h2>
            <div class="group">
                @foreach ($exams as $exam)
                    <div class="exam">
                        <p>Exam Name: <span>{{ $exam->exam->name }}</span></p>
                        <p>Start Time: <span>{{ $exam->start_time }}</span></p>
                        <p>End Time: <span>{{ $exam->end_time }}</span></p>
                        <p>Duration: <span>{{ $exam->start_time->diffInMinutes($exam->end_time) }}m</span></p>
                        <p>Mark: <span>{{ $exam->mark }}</span></p>
                        <a href="/student/review/{{ $exam->exam->id }}" class="btn">Review</a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        </div>

    </section>
@endsection

@if ($user->account_type)
    @section('js')
        <script>
            let form = document.getElementById('delete-form');

            function deleteExam(id) {
                form.action = '/teacher/delete/' + id;
                form.submit();
            }
        </script>
    @endsection
@endif
