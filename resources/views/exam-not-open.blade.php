@extends('layouts.main')

@section('title' , 'Exam')

@section('style')
<link rel="stylesheet" href="{{asset('css/exam-not-open.css')}}">
@endsection

@section('section')
<section>
    @if ($done == 1)
    <p>You have already taken the exam, please contact your teacher to open another attempt for you</p>
    @else
    <p>The exam has not started yet, it will open at {{$open_time}}</p>
    @endif
 </section>
@endsection