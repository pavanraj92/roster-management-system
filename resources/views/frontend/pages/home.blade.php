@extends('frontend.layouts.master')

@section('title', 'Home - Roster Management System')

@section('main_class', '')

@section('content')

<!-- Hero Banner Section -->
<section class="hero-banner" style="color: #ffffff; position: relative; overflow: hidden; padding: 90px 0 60px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 wow fadeInLeft" style="animation: fadeInLeft 0.8s ease;">
                <div class="card-soft p-5" style="background: linear-gradient(180deg, rgba(59,149,183,0.04), rgba(42,104,143,0.02));">
                    <h1 class="display-5 fw-bold mb-3" style="font-size: 44px; line-height: 1.15; color: #132235;">Manage Your Staff & Schedules with Ease</h1>
                    <p class="fs-5 mb-4" style="color: var(--muted);">A modern roster management solution to streamline scheduling, improve coordination, and boost efficiency.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary btn-modern" style="background: linear-gradient(90deg,var(--brand-500),var(--brand-700)); border: none; color: #fff;">Get Started Free</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-modern" style="background: transparent; border: 1px solid rgba(34,50,80,0.08); color: var(--brand-700);">Sign In</a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-primary btn-modern" style="background: linear-gradient(90deg,var(--brand-500),var(--brand-700)); border: none; color: #fff;">Go to Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInRight" style="animation: fadeInRight 0.8s ease; animation-delay: 0.2s;">
                <div class="card-soft p-3" style="display:flex;align-items:center;justify-content:center;border-radius:18px;">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=900&h=600&fit=crop" alt="Roster Management" class="img-fluid" style="border-radius:12px; max-height:380px; object-fit:cover;">
                </div>
            </div>
        </div>
    </div>
    <div style="position: absolute; inset: auto 0 0 0; height: 140px; background: linear-gradient(180deg, transparent, #f8f9fa); pointer-events:none;"></div>
</section>



<!-- Features Section -->
<section class="features-section py-80" style="padding: 80px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row mb-5 text-center wow fadeInUp">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-4" style="color: #2a3f5f;">Key Features</h2>
                <p class="fs-5 mb-3" style="color: #6c757d;">
                    Packed with powerful features to make workforce management simple and efficient
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="feature-box p-4 rounded-lg shadow-sm" style="background: white; border-left: 4px solid #3b95b7; transition: all 0.3s ease;">
                    <div style="font-size: 40px; color: #3b95b7; margin-bottom: 15px;">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Smart Scheduling</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Create optimized schedules in minutes with our intelligent algorithm that considers staff availability and preferences.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" style="animation-delay: 0.1s;">
                <div class="feature-box p-4 rounded-lg shadow-sm" style="background: white; border-left: 4px solid #3b95b7; transition: all 0.3s ease;">
                    <div style="font-size: 40px; color: #3b95b7; margin-bottom: 15px;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Staff Management</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Maintain comprehensive staff profiles with skills, certifications, and availability preferences all in one place.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" style="animation-delay: 0.2s;">
                <div class="feature-box p-4 rounded-lg shadow-sm" style="background: white; border-left: 4px solid #3b95b7; transition: all 0.3s ease;">
                    <div style="font-size: 40px; color: #3b95b7; margin-bottom: 15px;">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Analytics & Reports</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Get actionable insights with detailed analytics to optimize scheduling and improve workforce efficiency.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" style="animation-delay: 0.3s;">
                <div class="feature-box p-4 rounded-lg shadow-sm" style="background: white; border-left: 4px solid #3b95b7; transition: all 0.3s ease;">
                    <div style="font-size: 40px; color: #3b95b7; margin-bottom: 15px;">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Notifications</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Automated notifications keep your team informed about schedule changes and shift updates in real-time.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" style="animation-delay: 0.4s;">
                <div class="feature-box p-4 rounded-lg shadow-sm" style="background: white; border-left: 4px solid #3b95b7; transition: all 0.3s ease;">
                    <div style="font-size: 40px; color: #3b95b7; margin-bottom: 15px;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Secure & Reliable</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Enterprise-grade security and 99.9% uptime guarantee to keep your data safe and your operations running smoothly.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" style="animation-delay: 0.5s;">
                <div class="feature-box p-4 rounded-lg shadow-sm" style="background: white; border-left: 4px solid #3b95b7; transition: all 0.3s ease;">
                    <div style="font-size: 40px; color: #3b95b7; margin-bottom: 15px;">
                        <i class="bi bi-phone"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Mobile Ready</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Full mobile support allows your team to check schedules and request shifts from anywhere, anytime.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-works py-80" style="padding: 80px 0;">
    <div class="container">
        <div class="row mb-5 text-center wow fadeInUp">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-4" style="color: #2a3f5f;">How It Works</h2>
                <p class="fs-5 mb-3" style="color: #6c757d;">
                    Simple 4-step process to get started with our platform
                </p>
            </div>
        </div>

        <div class="row g-4 align-items-center">
            <div class="col-lg-3 col-md-6 wow fadeInUp">
                <div class="text-center">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: white;">
                        1
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Create Account</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Sign up in minutes with your email and basic organization details.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 wow fadeInUp" style="animation-delay: 0.1s;">
                <div class="text-center">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: white;">
                        2
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Add Your Team</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Import your staff details and set their roles, skills, and availability.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 wow fadeInUp" style="animation-delay: 0.2s;">
                <div class="text-center">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: white;">
                        3
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Create Schedules</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Build optimized schedules using our smart scheduling tools.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 wow fadeInUp" style="animation-delay: 0.3s;">
                <div class="text-center">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: white;">
                        4
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #2a3f5f;">Share & Manage</h5>
                    <p style="color: #6c757d; line-height: 1.6;">
                        Publish schedules and manage updates in real-time with your team.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-section py-80" style="padding: 80px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 wow fadeInLeft">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&h=500&fit=crop" alt="About Us" class="img-fluid rounded-lg shadow-lg" style="border-radius: 15px;">
            </div>
            <div class="col-lg-7 wow fadeInRight">
                <h2 class="display-5 fw-bold mb-4" style="color: #2a3f5f;">About Our Platform</h2>
                <p class="fs-5 mb-3" style="color: #6c757d; line-height: 1.8;">
                    Welcome to the modern solution for workforce and roster management. Our platform is built with a deep understanding of the challenges faced by managers and supervisors in coordinating staff schedules.
                </p>
                <p class="fs-5 mb-3" style="color: #6c757d; line-height: 1.8;">
                    Whether you're managing a small team or a large workforce across multiple locations, our intuitive system simplifies scheduling, reduces conflicts, and improves team communication.
                </p>
                <p class="fs-5 mb-4" style="color: #6c757d; line-height: 1.8;">
                    We're committed to providing the best tools and support to help your organization succeed and your team stay organized and happy.
                </p>

                <div class="row g-4 mt-4">
                    <div class="col-md-6">
                        <div class="about-stat">
                            <h4 class="fw-bold" style="color: #3b95b7; font-size: 28px;">500+</h4>
                            <p style="color: #6c757d;">Organizations Using</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about-stat">
                            <h4 class="fw-bold" style="color: #3b95b7; font-size: 28px;">10K+</h4>
                            <p style="color: #6c757d;">Active Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials py-80" style="padding: 80px 0;">
    <div class="container">
        <div class="row mb-5 text-center wow fadeInUp">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-4" style="color: #2a3f5f;">What Our Users Say</h2>
                <p class="fs-5" style="color: #6c757d;">Join thousands of satisfied organizations across different industries</p>
            </div>
        </div>

        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            {{-- <div class="carousel-indicators mb-4">
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div> --}}
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="testimonial-card p-4 rounded-lg text-center" style="background: white; box-shadow: 0 8px 30px rgba(30,40,60,0.06);">
                                <div class="mb-3">
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                </div>
                                <p style="color: #6c757d; line-height: 1.6; margin-bottom: 20px;">"This platform has transformed how we manage our retail staff schedules. It's intuitive, powerful, and our team loves it!"</p>
                                <div style="border-top: 1px solid #eef2f5; padding-top: 15px;">
                                    <p class="fw-bold mb-0" style="color: #2a3f5f; font-size: 14px;">Sarah Johnson</p>
                                    <p style="color: #6c757d; font-size: 13px;">Store Manager, Fashion Retail</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="testimonial-card p-4 rounded-lg text-center" style="background: white; box-shadow: 0 8px 30px rgba(30,40,60,0.06);">
                                <div class="mb-3">
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                </div>
                                <p style="color: #6c757d; line-height: 1.6; margin-bottom: 20px;">"Reduced our scheduling time by 70%. The mobile app is a game-changer for communicating with my team."</p>
                                <div style="border-top: 1px solid #eef2f5; padding-top: 15px;">
                                    <p class="fw-bold mb-0" style="color: #2a3f5f; font-size: 14px;">Michael Chen</p>
                                    <p style="color: #6c757d; font-size: 13px;">Operations Director, Healthcare</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="testimonial-card p-4 rounded-lg text-center" style="background: white; box-shadow: 0 8px 30px rgba(30,40,60,0.06);">
                                <div class="mb-3">
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                </div>
                                <p style="color: #6c757d; line-height: 1.6; margin-bottom: 20px;">"Exceptional customer support and regular updates. Best investment we've made for our operations!"</p>
                                <div style="border-top: 1px solid #eef2f5; padding-top: 15px;">
                                    <p class="fw-bold mb-0" style="color: #2a3f5f; font-size: 14px;">Emma Rodriguez</p>
                                    <p style="color: #6c757d; font-size: 13px;">HR Manager, Restaurant Group</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" aria-label="Previous testimonial">
                <span class="carousel-control-prev-icon" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" aria-label="Next testimonial">
                <span class="carousel-control-next-icon" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq py-80" style="padding: 80px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row mb-5 text-center wow fadeInUp">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-4" style="color: #2a3f5f;">Frequently Asked Questions</h2>
                <p class="fs-5" style="color: #6c757d;">
                    Quick answers to common questions about our platform
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item wow fadeInUp" style="border: 1px solid #e9ecef; margin-bottom: 15px; border-radius: 8px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" style="color: #2a3f5f; font-weight: 600;">
                                How do I get started with the platform?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color: #6c757d;">
                                Sign up for a free account, add your staff members, and start creating optimized schedules immediately. No credit card required to get started!
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item wow fadeInUp" style="border: 1px solid #e9ecef; margin-bottom: 15px; border-radius: 8px; animation-delay: 0.1s;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" style="color: #2a3f5f; font-weight: 600;">
                                What is the pricing model?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color: #6c757d;">
                                We offer flexible pricing based on the number of staff members. Start with a free plan and upgrade as you grow. For details, contact our sales team.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item wow fadeInUp" style="border: 1px solid #e9ecef; margin-bottom: 15px; border-radius: 8px; animation-delay: 0.2s;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" style="color: #2a3f5f; font-weight: 600;">
                                Can I import existing staff data?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color: #6c757d;">
                                Yes! We support CSV imports and also offer data migration assistance. Our team can help you import your existing staff data seamlessly.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item wow fadeInUp" style="border: 1px solid #e9ecef; border-radius: 8px; animation-delay: 0.3s;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" style="color: #2a3f5f; font-weight: 600;">
                                Is my data secure and backed up?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color: #6c757d;">
                                Absolutely. We use enterprise-grade encryption, perform daily backups, and maintain 99.9% uptime. Your data is our priority.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="cta-final py-80" style="padding: 80px 0;">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto wow fadeInUp">
                <h2 class="display-4 fw-bold mb-4">Ready to Simplify Your Scheduling?</h2>
                <p class="fs-5 mb-5" style="opacity: 0.95;">
                    Join hundreds of organizations that are already managing their workforce more effectively.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold" style="padding: 14px 45px;">
                            Start Free Trial
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-light btn-lg fw-bold" style="padding: 14px 45px;">
                            Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
    .wow { visibility: hidden; }
    .wow.fadeInLeft, .wow.fadeInRight, .wow.fadeInUp { animation-duration: 0.8s; animation-fill-mode: both; }

    @keyframes fadeInLeft { from { opacity:0; transform:translate3d(-100px,0,0);} to{opacity:1;transform:none;} }
    @keyframes fadeInRight{ from{opacity:0;transform:translate3d(100px,0,0);} to{opacity:1;transform:none;} }
    @keyframes fadeInUp{ from{opacity:0;transform:translate3d(0,50px,0);} to{opacity:1;transform:none;} }

    .rounded-lg{ border-radius:15px; }
    .card-soft{ background:#fff;border-radius:14px;box-shadow:0 12px 30px rgba(39,54,72,0.06); }
    .feature-box{ transition: transform .25s ease, box-shadow .25s ease; }
    .feature-box:hover{ transform: translateY(-6px); box-shadow: 0 18px 40px rgba(39,54,72,0.06) !important; }

    .testimonial-card{ border-radius:12px; }
    .cta-final .btn{ border-radius:12px; }

    /* Responsive hero tweaks */
    @media (max-width: 992px){ .hero-banner{ padding: 60px 0 40px; } .card-soft{ padding:24px; } }
    /* Make carousel side buttons visible and high-contrast */
    #testimonialCarousel { position: relative; }
    #testimonialCarousel .carousel-control-prev,
    #testimonialCarousel .carousel-control-next{
        width:48px; height:48px; top:50%; transform:translateY(-50%); background: rgba(11,37,64,0.85); border-radius:50%; display:flex; align-items:center; justify-content:center; opacity:1; z-index:6; padding:0; border:none;
    }
    #testimonialCarousel .carousel-control-prev{ left:24px; }
    #testimonialCarousel .carousel-control-next{ right:24px; }
    #testimonialCarousel .carousel-control-prev-icon,
    #testimonialCarousel .carousel-control-next-icon{ background-image:none; width:20px; height:20px; display:flex; align-items:center; justify-content:center; }
    #testimonialCarousel .carousel-control-prev-icon i,
    #testimonialCarousel .carousel-control-next-icon i{ color: #fff; font-size: 20px; line-height:1 }
    @media (max-width: 768px){
        #testimonialCarousel .carousel-control-prev,
        #testimonialCarousel .carousel-control-next{ width:40px; height:40px; left:12px; right:12px; }
        #testimonialCarousel .carousel-control-prev-icon i,
        #testimonialCarousel .carousel-control-next-icon i{ font-size:18px }
    }
    /* indicators styling */
    #testimonialCarousel .carousel-indicators{ position: relative; bottom: 0; display:flex; gap:8px; justify-content:center }
    #testimonialCarousel .carousel-indicators [data-bs-target]{ width:10px; height:10px; border-radius:50%; background:#cfdce9; opacity:0.6; }
    #testimonialCarousel .carousel-indicators .active{ background:var(--brand-700); opacity:1 }
</style>
@endpush


