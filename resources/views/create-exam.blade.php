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
                <input type="number" placeholder="Pass Mark" name="pass-mark">
                <input class="create" type="submit" value="Create">
            </form>
        </div>
        <div class="Add-Q">
            <div>
                <button class="add" id="add">Add a Question</button>
                <div class="contant" id="contant">
                    <form action="">
                        <textarea placeholder="Write the question"></textarea>
                        <input type="number" placeholder="Grade">
                        <select name="" id="select-type">
                            <option value="" selected>Question type</option>
                            <option value="1">Multiple choice</option>
                            <option value="2">True or False</option>
                        </select>
                        <div class="t-O-Q">
                            <div class="t-o-f" id="t-o-f">
                                <div class="true">
                                    <input type="radio" id="t" name="5">
                                    <label for="t">True</label>
                                </div>
                                <div class="true">
                                    <input type="radio" id="f" name="5">
                                    <label for="f">False</label>
                                </div>
                            </div>
                            <div class="m-c" id="m-c">
                                <div class="choice">
                                    <input type="text" placeholder="First choice">
                                    <div class="choice">
                                        <input type="checkbox" id="f-choice">
                                        <label for="f-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" placeholder="second choice">
                                    <div class="choice">
                                        <input type="checkbox" id="s-choice">
                                        <label for="s-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" placeholder="Thierd choice">
                                    <div class="choice">
                                        <input type="checkbox" id="t-choice">
                                        <label for="t-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" placeholder="Fourth choice">
                                    <div class="choice">
                                        <input type="checkbox" id="fo-choice">
                                        <label for="fo-choice">This is the correct answer</label>
                                    </div>
                                </div>
                            </div>
                            <input class="save" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="qes">
            <p>What is the purpose of a foreign key in a relational database?</p>
            <div>
                <input type="radio" name="1" disabled>
                <label>To store large amounts of data efficiently</label>
            </div>
            <div>
                <input type="radio" name="1" checked>
                <label>To establish a link between two tables</label>
            </div>
            <div>
                <input type="radio" name="1" disabled>
                <label>To improve the performance of queries</label>
            </div>
            <div>
                <input type="radio" name="1" disabled>
                <label>To automatically generate unique values</label>
            </div>
            <p class="correct">The correct answer is <span>To establish a link between two tables</span></p>
            <p>Grade <span>2</span></p>
        </div>
        <div class="qes">
            <p>What is the purpose of a foreign key in a relational database?</p>
            <div>
                <input type="radio" name="2" disabled>
                <label>To store large amounts of data efficiently</label>
            </div>
            <div>
                <input type="radio" name="2" checked>
                <label>To establish a link between two tables</label>
            </div>
            <div>
                <input type="radio" name="2" disabled>
                <label>To improve the performance of queries</label>
            </div>
            <div>
                <input type="radio" name="2" disabled>
                <label>To automatically generate unique values</label>
            </div>
            <p class="correct">The correct answer is <span>To establish a link between two tables</span></p>
            <p>Grade <span>2</span></p>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{asset('JS/create-exam.js')}}"></script>
@endsection