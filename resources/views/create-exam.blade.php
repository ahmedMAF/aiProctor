@extends('layouts.main')

@section('title' , 'Create An Exam')

@section('style')
<link rel="stylesheet" href="{{asset('css/create-exam.css')}}">
@endsection

@section('section')
<section>
    <div class="continer">
        <div class="info">
            <form method="POST" action="/teacher/add">
                @csrf
                <input type="text" placeholder="Exam Name" name="name">
                <textarea placeholder="Description" name="description"></textarea>
                <div class="Navigation">
                    <h3>Navigation Style</h3>
                    <div class="nav">
                        <input type="radio" id="se" name="nav" value="1">
                        <label for="se">Sequential</label>
                    </div>
                    <div class="nav">
                        <input type="radio" id="fr" name="nav" value="0">
                        <label for="fr">Free</label>
                    </div>
                </div>
                <div class="nav">
                    <input type="checkbox" id="sh" name="Shuffling" value="1">
                    <label for="sh">Shuffling Questions</label>
                </div>
                <div>
                    <label for="op">Open Time</label>
                    <input type="datetime-local" id="op" name="open-time">
                </div>
                <div>
                    <label for="cl">Close Time</label>
                    <input type="datetime-local" id="cl" name="close-time">
                </div>
                <input type="number" placeholder="Duration in minutes" name="duration">
                <input type="number" placeholder="Full Mark" name="full-mark">
                <input type="number" placeholder="Pass Mark" name="pass-mark">
                <input class="create" type="submit" value="Create">
            </form>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{asset('JS/create-exam.js')}}"></script>
@endsection