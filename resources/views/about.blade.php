@extends('layouts.main')

@section('title', 'About Us')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endsection

@section('section')
    <header>
        <h1>About Our AI-Powered Exam System</h1>
    </header>

    <div class="container">
        <section>
            <h2>About the System</h2>
            <p>
                A cutting-edge online examination platform that leverages artificial intelligence to maintain academic
                integrity.
                Our system ensures secure, reliable, and stress-free exams for both students and educators,
                while providing insightful reports with verified evidence after each session.
            </p>
        </section>

        <section>
            <h2>Our Mission</h2>
            <p>
                To revolutionize online assessments by integrating intelligent technologies that uphold fairness,
                accuracy, and ease of use.
            </p>
        </section>

        <section>
            <h2>Why Choose Our Platform?</h2>
            <ul>
                <li>AI-driven proctoring and analytics</li>
                <li>User-friendly interface</li>
                <li>Minimal internet and hardware requirements</li>
                <li>Detailed post-exam reports with visual and audio evidence</li>
                <li>Secure and privacy-focused infrastructure</li>
            </ul>
        </section>

        <section>
            <h2>Meet Our Team</h2>
            <p>
                We are a dedicated team of engineers, developers, and AI experts from Palestine,
                passionate about creating innovative and trustworthy educational technologies.
            </p>
        </section>

        <section class="cta">
            <h2>Let’s Work Together</h2>
            <p>Interested in using our platform or partnering with us?</p>
            <a href="mailto:ahmedafana652001@gmail.com">Get in Touch</a>
        </section>
    </div>

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
