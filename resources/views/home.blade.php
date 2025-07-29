@extends('layouts.main')

@section('title', 'Home')

@section('style')
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection

@section('section')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-contant">
            <h1>Secure & Smart Exams Start Here</h1>
            <p>
                An AI-powered online exam system designed to ensure academic integrity and deliver detailed reports with
                documented evidence after each session.
            </p>
            <div class="buttons">
                <a href="#demo">Try Now</a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="demo">
        <h2 class="section-title">Powerful Features</h2>
        <div class="feature-grid">
            <div class="feature">Optimized to work even with slow or unstable internet connections</div>
            <div class="feature">Fast and responsive user experience across devices</div>
            <div class="feature">Verifies student identity before starting the exam</div>
            <div class="feature">Analyzes facial expressions and emotions during the exam</div>
            <div class="feature">Tracks head movement and gaze direction</div>
            <div class="feature">Monitors surrounding sound during the exam</div>
            <div class="feature">Detects the presence of multiple faces on the screen</div>
            <div class="feature">Detects the absence of the student in front of the camera during the exam</div>
            <div class="feature">Generates detailed reports for instructors with visual and audio evidence when needed</div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how">
        <h2 class="section-title">How It Works for Teachers</h2>
        <div class="steps">
            <div class="step"><strong>1. Create Account</strong> – The teacher signs up and selects "Teacher" as the account
                type</div>
            <div class="step"><strong>2. Create Exam</strong> – The teacher creates a new exam with custom settings</div>
            <div class="step"><strong>3. Add Questions</strong> – Questions are added easily through a simple interface
            </div>
            <div class="step"><strong>4. Share Link</strong> – The system generates an exam link to share with students
            </div>
            <div class="step"><strong>5. View Reports</strong> – After submission, the teacher receives detailed reports for
                each student</div>
        </div>
    </section>

    <section class="how-it-works" id="how">
        <h2 class="section-title">How It Works for Students</h2>
        <div class="steps">
            <div class="step"><strong>1. Login</strong> – The student signs into the platform</div>
            <div class="step"><strong>2. Access Exam</strong> – The student clicks the exam link shared by the teacher</div>
            <div class="step"><strong>3. Accept Instructions</strong> – Important guidelines are displayed; the student must
                review and accept them</div>
            <div class="step"><strong>4. Identity Verification</strong> – The system captures a photo of the student’s face
                and ID for verification</div>
            <div class="step"><strong>5. Start Exam</strong> – Once verified, the exam begins with AI monitoring in the
                background.</div>
            <div class="step"><strong>6. View Results</strong> – After finishing, the student can review answers and see
                their score</div>
        </div>
    </section>

    <!-- Demo Video -->
    <section class="demo">
        <h2 class="section-title">System Demo</h2>
        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
    </section>

    <!-- FAQ -->
    <section class="faq">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-item">
            <strong>Does the system work on low-end devices?</strong>
            <div class="faq-answer">Yes, the system is designed to run efficiently on low-end devices while maintaining
                stable performance and a smooth user experience.</div>
        </div>
        <div class="faq-item">
            <strong>Does the platform work on mobile devices?</strong>
            <div class="faq-answer">It's recommended to use a computer or laptop for the best experience, although some
                features may work on mobile devices.
            </div>
        </div>
        <div class="faq-item">
            <strong>What types of questions are supported?</strong>
            <div class="faq-answer">The platform supports two types of questions: Multiple Choice and True or False.</div>
        </div>
        <div class="faq-item">
            <strong>Does it prevent cheating?</strong>
            <div class="faq-answer">The system detects suspicious behavior and provides evidence in the report, but
                doesn’t block the user in real-time.</div>
        </div>
        <div class="faq-item">
            <strong>Do I need high-speed internet?</strong>
            <div class="faq-answer">No, the system is designed to function well with average connections.</div>
        </div>
        <div class="faq-item">
            <strong>Can I reuse the same exam for multiple groups?</strong>
            <div class="faq-answer">Yes, you can use the same exam and share it with more than one group of students.</div>
        </div>
        <div class="faq-item">
            <strong>Can I edit the questions after creating the exam?</strong>
            <div class="faq-answer">You can edit the questions as long as no student has started the exam.</div>
        </div>
        <div class="faq-item">
            <strong>Do I need to install any software to use the platform?</strong>
            <div class="faq-answer">No, everything runs directly in the browser without the need to install any additional software.</div>
        </div>
        <div class="faq-item">
            <strong>What should I do if the system doesn't recognize my face or ID?</strong>
            <div class="faq-answer">Make sure you have good lighting and a clear image. If the problem persists, contact your teacher.</div>
        </div>
        <div class="faq-item">
            <strong>Can I turn off the camera during the exam?</strong>
            <div class="faq-answer">No, the camera must remain active throughout the exam for monitoring purposes.</div>
        </div>
    </section>

    <!--footer-->
    <footer class="footer">
        <div class="links">
            <div class="link">
                <h4>Links</h4>
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Profile</a>
            </div>
            <div class="link">
                <h4>Links</h4>
                <a href="#">Signup</a>
                <a href="#">Login</a>
                <a href="#">Logout</a>
            </div>
            <div class="contact">
                <h4>Contact Us</h4>
                <span>+970597456498</span>
                <span>+972597456498</span>
                <span>nova@gmail.com</span>
            </div>
        </div>
        <p>© 2025 NOVA for Integrated Solutions. All rights reserved.</p>
        <p>Contact us at: nova@nova.ps</p>
    </footer>
@endsection

@section('js')
    <script>
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('active');
                const answer = item.querySelector('.faq-answer');
                answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
@endsection