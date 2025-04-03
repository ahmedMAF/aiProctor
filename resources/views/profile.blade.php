@extends('layouts.main')

@section('title' , 'Profile')

@section('style')
<link rel="stylesheet" href="{{asset('css/student.css')}}">
@endsection

@section('section')
<section>
    <div class="continer">
        <div class="info">
            <form action="">
                <div class="image">
                    <img src="{{asset('uploads/profile_pics/'.$user->profile_pic)}}" alt="Error">
                    <input id="pen" type="file" hidden>
                    <label for="pen" class="pen"></label>
                </div>
                <div class="email">
                    <h3>{{$user->email}}</h3>
                </div>
                <div class="name">
                    <h3>{{$user->name}}</h3>
                </div>
                <input class="btn m-t" type="submit" value="Update">
            </form>
        </div>
        <div class="password">
            <form action="" method="">
                <h2>Change Password</h2>
                <div class="input"><input type="password" required placeholder="Old Password"></div>
                <div class="input"><input type="password" required placeholder="New Password"></div>
                <div class="input"><input type="password" required placeholder="Confirm New Password"></div>
                <input class="btn m-t" type="submit" value="Change">
            </form>
        </div>
@if ($user->account_type)
{{--for reacher--}}
        <div class="exams">
            <h2>Exams created</h2>
            <div class="group">
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p class="des">Description: <span>this is a final exam, For math course, Good luck</span></p>
                    <p>Navigation Style: <span>Sequential</span></p>
                    <p>Shuffling Questions: <span>Yes</span></p>
                    <p>Open Time: <span>13/9/2020</span></p>
                    <p>Close Time: <span>13/9/2020</span></p>
                    <p>Duration: <span>20m</span></p>
                    <p>Full Mark: <span>100</span></p>
                    <p>Pass Mark: <span>60</span></p>
                    <p>Exam link: <span>https://www.google.com/exam</span></p>
                    <div class="button">
                        <button class="btn">Browse</button>
                        <button class="btn">Students</button>
                        <button class="btn">Delete</button>
                        <button class="btn">Update</button>
                    </div>
                </div>
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p class="des">Description: <span>this is a final exam, For math course, Good luck</span></p>
                    <p>Navigation Style: <span>Free</span></p>
                    <p>Shuffling Questions: <span>No</span></p>
                    <p>Open Time: <span>13/9/2020</span></p>
                    <p>Close Time: <span>13/9/2020</span></p>
                    <p>Duration: <span>20m</span></p>
                    <p>Full Mark: <span>100</span></p>
                    <p>Pass Mark: <span>60</span></p>
                    <p>Exam link: <span>https://www.google.com/exam</span></p>
                    <div class="button">
                        <button class="btn">Browse</button>
                        <button class="btn">Students</button>
                        <button class="btn">Delete</button>
                        <button class="btn">Update</button>
                    </div>
                </div>
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p class="des">Description: <span>this is a final exam, For math course, Good luck</span></p>
                    <p>Navigation Style: <span>Sequential</span></p>
                    <p>Shuffling Questions: <span>Yes</span></p>
                    <p>Open Time: <span>13/9/2020</span></p>
                    <p>Close Time: <span>13/9/2020</span></p>
                    <p>Duration: <span>20m</span></p>
                    <p>Full Mark: <span>100</span></p>
                    <p>Pass Mark: <span>60</span></p>
                    <p>Exam link: <span>https://www.google.com/exam</span></p>
                    <div class="button">
                        <button class="btn">Browse</button>
                        <button class="btn">Students</button>
                        <button class="btn">Delete</button>
                        <button class="btn">Update</button>
                    </div>
                </div>
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p class="des">Description: <span>this is a final exam, For math course, Good luck</span></p>
                    <p>Navigation Style: <span>Sequential</span></p>
                    <p>Shuffling Questions: <span>Yes</span></p>
                    <p>Open Time: <span>13/9/2020</span></p>
                    <p>Close Time: <span>13/9/2020</span></p>
                    <p>Duration: <span>20m</span></p>
                    <p>Full Mark: <span>100</span></p>
                    <p>Pass Mark: <span>60</span></p>
                    <p>Exam link: <span>https://www.google.com/exam</span></p>
                    <div class="button">
                        <button class="btn">Browse</button>
                        <button class="btn">Students</button>
                        <button class="btn">Delete</button>
                        <button class="btn">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="exams">
            <a href="/teacher/add" class="btn">Add an Exam</a>
        </div>
@else
{{--for steadent--}}
        <div class="exams">
            <h2>Exams completed</h2>
            <div class="group">
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p>Start Time: <span>10/9/2020</span></p>
                    <p>End Time: <span>13/9/2020</span></p>
                    <p>Duration: <span>20m</span></p>
                    <p>Mark: <span>60 from 100</span></p>
                    <button class="btn">Review</button>
                </div>
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p>Start Time: <span>10/9/2020</span></p>
                    <p>End Time: <span>13/9/2020</span></p>
                    <p>Duration: <span>20m</span></p>
                    <p>Mark: <span>60 from 100</span></p>
                    <button class="btn">Review</button>
                </div>
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p>Start Time: <span>10/9/2020</span></p>
                    <p>End Time: <span>13/9/2020</span></p>
                    <p>Duration <span>20m</span></p>
                    <p>Mark: <span>60 from 100</span></p>
                    <button class="btn">Review</button>
                </div>
                <div class="exam">
                    <p>Exam Name: <span>Math</span></p>
                    <p>Start Time: <span>10/9/2020</span></p>
                    <p>End Time: <span>13/9/2020</span></p>
                    <p>Duration: <span>20m</span></p>
                    <p>Mark: <span>60 from 100</span></p>
                    <button class="btn">Review</button>
                </div>
            </div>
        </div>
@endif
    </div>
</section>
@endsection

