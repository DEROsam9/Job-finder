@extends('components.layout.app')

@section('content')
    <style>
        .service-carousel {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
            background: #f6f6f6;
            border-radius: 8px;
        }

        .carousel-wrapper {
            display: flex;
            transition: transform 1s ease-in-out;
            width: calc(800px * 5); /* 5 slides */
        }

        .service-slide {
            position: relative;
            flex: 0 0 800px;
            height: 320px;
        }

        .service-image-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .service-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }


        .overlay-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: rgba(0, 0, 0, 0.4); /* semi-transparent background */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;  /* vertical centering */
            align-items: center;      /* horizontal centering */
            text-align: center;
            border-radius: 8px;
        }

        .overlay-text h3,
        .overlay-text p {
            margin: 25px 0;
        }
        .overlay-text p, .overlay-text ul {
            font-size: 1rem;
            margin: 0;
        }

        .overlay-text ul {
            padding-left: 20px;
        }.accordion {
             width: 100%;
             max-width: 800px;
             margin: 40px auto;
             border-radius: 8px;
             overflow: hidden;
         }

        .accordion-item {
            border-bottom: 1px solid #ccc;
            
        }
        .accordion-item:last-child{
          border-bottom: none;
        }

        .accordion button {
            width: 100%;
            background-color: #fff;
            border: none;
            outline: none;
            text-align: left;
            padding: 18px 20px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
        }

        .accordion button:hover {
            background-color: #f1f1f1;
        }

        .accordion .icon::after {
            content: '+';
            position: absolute;
            right: 20px;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .accordion button[aria-expanded="true"] .icon::after {
            content: '−';
            transform: rotate(180deg);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background: #fafafa;
            padding: 0 20px;
        }

        .accordion-title {
            font-family: "Montserrat", sans-serif !important;
            font-size: 14px;
        }

        .accordion-content p {
            padding: 15px 0;
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            font-family: "Montserrat", sans-serif !important;
        }


    </style>
    {{-- Starter --}}
    <div class="row" id="home">
        <div class="container">
            <div class="col-md-12">
                <div class="pg-title">
                    <h2>Your Dream Career Awaits</h2>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="page-content">
                <p>
                    Discover life-changing job opportunities across top global cities.
                    Apply today and take the first step toward your future.
                </p>
                <!-- <form>
                  <input type="search" name="search" placeholder="Search">
                </form> -->
                <div class="dream-img">
                    <img src="{{ asset('images/v27_51.jpg') }}">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="apply-section">
                <a href="/application-form">Apply now</a>
            </div>
        </div>
    </div>

    <div class="row" id="about-us">
        <div class="container">
            <div class="col-md-12">
                <div class="pg-title">
                    <h2>About Us</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="page-content">
                    <div class="dream-img">
                        <img src="images/v27_67.jpg">
                    </div>
                    <p>
                        Talent Bridge Careers is a leading international recruitment agency committed to connecting skilled professionals with rewarding job opportunities abroad.

                        We specialize in placing skilled talent with top-tier employers across diverse sectors. Whether you're a sales professional, hospitality expert, skilled administrator, or aiming to grow in fast-paced industries like retail, administration, hospitality or real estate, we’ve got verified, high-quality job openings tailored for you.

                        At Talent Bridge, we offer comprehensive recruitment support—from application to placement—including personalized assistance with visa processing, relocation logistics, and onboarding.
                    </p>
                    <h2>Our goal</h2>
                    <p>To help you succeed abroad with confidence and dignity.

                        We’re passionate about helping people move, grow, and thrive.</p>

                    <h2>Mission</h2>
                    <p>

                        To deliver ethical, transparent, and effective recruitment solutions globally.</p>

                    <h2>Vision</h2>
                    <p>To transform lives through global opportunities.</p>
                    </p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="apply-section">
                    <a href="/application-form">Apply now</a>
                </div>
            </div>
        </div>
    </div>


    {{-- Partners --}}
    <div class="row" id="partners">
        <div class="container">
            <div class="col-md-12">
                <div class="pg-title">
                    <h2>Partners</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="page-content">
                    <div class="col-md-3">
                        <div class="partner">
                            <div class="partner-pic">
                                <img src="images/v54_724.png">
                            </div>
                            <h3>Janta</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="partner">
                            <div class="partner-pic">
                                <img src="images/accurex.png">
                            </div>
                            <h3>Accurex</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="partner">
                            <div class="partner-pic">
                                <img src="images/mal.png">
                            </div>
                            <h3>MAL Consultancy</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="partner">
                            <div class="partner-pic">
                                <img src="images/hr.png">
                            </div>
                            <h3>Hallmark</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Experiences --}}
    <div class="row" id="testimonials">
        <div class="container">
            <div class="col-md-12">
                <div class="pg-title">
                    <h2>Experiences</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="page-content">
                    <div class="experiences-pics row">
                        @php
                            $experiences = [
                              ['img' => 'v108_550.jpg', 'name' => 'Kevin Muriithi'],
                              ['img' => 'v108_548.jpg', 'name' => 'Mary Mweni'],
                              ['img' => 'v108_407.jpg', 'name' => 'Joseph Ochiel'],
                              ['img' => 'v108_406.jpg', 'name' => 'Martin Muriithi']
                            ];
                        @endphp

                        @foreach($experiences as $exp)
                            <div class="col-md-3">
                                <div class="experience-pic">
                                    <img src="images/{{ $exp['img'] }}">
                                    <h3>{{ $exp['name'] }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--FAQ-->
    <div class="container">
        <div class="pg-title">
            <h2 class="bold text-center"> FAQs </h2>
        </div>
        <div class="accordion">
            <div class="accordion-item">
                <button id="accordion-button-1" aria-expanded="false">
                    <span class="accordion-title">What does Talent Bridge Careers LTD do?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>
                        Talent Bridge Careers LTD is a licensed recruitment agency that connects qualified candidates with job opportunities abroad. We specialize in placing individuals in industries like healthcare, education, hospitality, and skilled trades across the Middle East, Europe, and North America.
                    </p>                
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-2" aria-expanded="false">
                    <span class="accordion-title">Who can apply for overseas jobs through your agency?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>
                        We welcome applications from qualified individuals with verifiable work experience, academic credentials, and valid identification documents. Specific qualifications depend on the job category and destination country.
                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-3" aria-expanded="false">
                    <span class="accordion-title">How do I apply?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>
                    You can apply by:

                    Filling out our online application form on our website or visiting our office.

                    Submitting your updated CV, academic certificates, work experience documents, and a copy of your ID/passport.

                    Attending scheduled interviews or training (as required).
                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-4" aria-expanded="false">
                    <span class="accordion-title">What is the registration fee and why is it required?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>
                        The registration fee is a one-time, non-refundable fee that helps us:
                        Verify and process your documents.
                        Pre-screen and shortlist your profile for active job openings.
                        Set up your candidate profile in our system.
                        Provide initial consultation and recruitment guidance.
                        This fee ensures serious applicants are considered and helps us manage quality and commitment.
                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-2" aria-expanded="false">
                    <span class="accordion-title">Do you charge an agency fee?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>

                        Yes, <strong>we charge an agency fee once you have secured a job offer and are ready for deployment.</strong> This covers:
                        Job placement facilitation.
                        Interview preparation.
                        Visa guidance and documentation assistance.
                        Pre-departure orientation.
                        Coordination with the employer or overseas agency.
                        The fee varies depending on the country, job category, and employer arrangement. It will be clearly communicated before any commitment.                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-5" aria-expanded="false">
                    <span class="accordion-title">Do you charge an agency fee?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>

                        Yes, <strong>we charge an agency fee once you have secured a job offer and are ready for deployment.</strong> This covers:
                        Job placement facilitation.
                        Interview preparation.
                        Visa guidance and documentation assistance.
                        Pre-departure orientation.
                        Coordination with the employer or overseas agency.
                        The fee varies depending on the country, job category, and employer arrangement. It will be clearly communicated before any commitment.                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-6" aria-expanded="false">
                    <span class="accordion-title">Is the registration fee a guarantee of employment?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>
                    No. While we work hard to match you with suitable opportunities, the registration fee is not a guarantee of employment. It supports the administrative and processing services provided during your application process.
                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-7" aria-expanded="false">
                    <span class="accordion-title">What happens if I’m not selected for a job after registering?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>

                        Your profile will remain active in our database for up to 12 months. We will continue to match you with any new job opportunities that fit your qualifications and preferences.
                         </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-8" aria-expanded="false">
                    <span class="accordion-title">Can I get a refund of the registration or agency fee?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>
                    Registration fees are non-refundable once paid.

Agency fees are only charged upon successful job placement. If an employer cancels or fails to proceed after payment, refund eligibility will depend on the specific case and agreements signed.               </p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-9" aria-expanded="false">
                    <span class="accordion-title">Will you help me with my visa process?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>

                       Yes. We guide you through the visa application process, help you gather the right documents, and coordinate with employers or immigration consultants where needed. However, we do not guarantee visa approval, as this is at the discretion of the respective embassy or immigration authority.
</p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-10" aria-expanded="false">
                    <span class="accordion-title">What documents do I need to apply?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>Commonly required documents include:

Updated CV (in English)

National ID or passport

Academic certificates

Professional licenses (if applicable)

Passport-sized photos

Police clearance and medical report (may be needed later</p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-10" aria-expanded="false">
                    <span class="accordion-title">How long does it take to get placed?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>Timelines vary by industry, country, and employer responsiveness. Some placements take a few weeks; others may take several months. We’ll keep you informed at every stage.</p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-10" aria-expanded="false">
                    <span class="accordion-title">Will I be trained before deployment?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>Depending on the job and employer requirements, some candidates may undergo training or orientation sessions before departure to ensure they’re job-ready and understand cultural/workplace expectations abroad.</p>
                </div>
            </div>
            <div class="accordion-item">
                <button id="accordion-button-10" aria-expanded="false">
                    <span class="accordion-title">How do I know if an overseas job is legitimate?</span>
                    <span class="icon" aria-hidden="true"></span>
                </button>
                <div class="accordion-content">
                    <p>All job opportunities we provide come from verified employers and licensed partners. We do not promote unverified jobs. We prioritize ethical recruitment, and you will receive an official employment contract and offer letter before proceeding.</p>
                </div>
            </div>
            
            
            
                
                
            </div>
        </div>
        </div>
    </div>
    <script>
        const wrapper = document.getElementById('carouselWrapper');
        const totalSlides = document.querySelectorAll('.service-slide').length;
        let currentIndex = 0;

        function autoSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            wrapper.style.transform = `translateX(-${currentIndex * 800}px)`;
        }

        setInterval(autoSlide, 4000); // change slide every 4 seconds
        const items = document.querySelectorAll('.accordion button');
        // FAQ Accordion Toggle
        const accordionButtons = document.querySelectorAll(".accordion button");

        accordionButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const expanded = button.getAttribute("aria-expanded") === "true";

                // Close all other accordions
                accordionButtons.forEach((btn) => {
                    btn.setAttribute("aria-expanded", "false");
                    btn.nextElementSibling.style.maxHeight = null;
                });

                // Toggle current accordion
                if (!expanded) {
                    button.setAttribute("aria-expanded", "true");
                    const content = button.nextElementSibling;
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        });


    </script>
@endsection

