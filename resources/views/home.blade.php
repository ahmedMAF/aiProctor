@extends('layouts.main')

@section('title' , 'Home')

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
        <section class="features">
            <h2 class="section-title">Powerful Features</h2>
            <div class="feature-grid">
                <div class="feature">Face recognition for identity verification</div>
                <div class="feature">Live face and eye tracking</div>
                <div class="feature">Sound detection during the exam</div>
                <div class="feature">Emotion analysis and stress detection</div>
                <div class="feature">Comprehensive report with video evidence</div>
                <div class="feature">User-friendly for both students and instructors</div>
                <div class="feature">Fast and efficient performance</div>
                <div class="feature">Works with average internet connection</div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="how-it-works" id="how">
            <h2 class="section-title">How It Works</h2>
            <div class="steps">
                <div class="step"><strong>1. Login</strong> – The student signs into the platform</div>
                <div class="step"><strong>2. Identity Verification</strong> – Using face recognition</div>
                <div class="step"><strong>3. Start Exam</strong> – AI monitoring runs in the background</div>
                <div class="step"><strong>4. Receive Report</strong> – The system generates a detailed report after the
                    session</div>
            </div>
        </section>

        <!-- Demo Video -->
        <section class="demo" id="demo">
            <h2 class="section-title">System Demo</h2>
            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
        </section>

        <!-- FAQ -->
        <section class="faq">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="faq-item">
                <strong>Does the system work on low-end devices?</strong>
                <div class="faq-answer">Yes, it’s optimized to work smoothly on devices with modest specifications.
                </div>
            </div>
            <div class="faq-item">
                <strong>Does it support Arabic?</strong>
                <div class="faq-answer">Yes, full Arabic interface and support are available.</div>
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