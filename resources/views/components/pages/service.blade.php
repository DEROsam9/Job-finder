@extends('components.layout.app')

@section('content')
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #111418;
      margin: 0;
      padding: 0;
    }

    .application-pg {
      padding: 2px 2px;
    }

    .pg-title h1 {
      text-align: center;
      font-size: 32px;
      font-weight: bold;
      margin-top: -100px;
      margin-bottom: 10px;
    }

    .page-content {
      max-width: 1200px;
      margin: 0 auto;
    }

    .page-content p {
      font-size: 16px;
      line-height: 1.6;
      padding-bottom: 16px;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
      margin-top: 40px;
    }

    .service-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      background: #ffffff;
      padding: 16px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      text-align: center;
    }

    .service-image-wrapper {
      width: 100%;
      aspect-ratio: 4 / 3;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 16px;
    }

    .service-image-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .service-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .service-desc {
      font-size: 16px;
      line-height: 1.5;
    }

    .footer-note {
      padding: 20px 0;
      font-size: 16px;
    }

    @media (max-width: 500px) {
      .pg-title h1 {
        font-size: 24px;
      }
      .service-title {
        font-size: 16px;
      }
      .service-desc {
        font-size: 14px;
      }
    }
  </style>


  <div class="application-pg">
    <div class="pg-title">
      <h1>Services</h1>
    </div>

    <div class="page-content">
      <p>
        Talent Bridge Careers connects professionals with international job opportunities, offering comprehensive support throughout the process.
      </p>
      <p>
          At Talent Bridge Careers, we are committed to your career growth. Explore global opportunities with our expert support and take the next step in your professional journey.
        </p>

       <div class="pg-title">
      <h3>Our Services</h3>
    </div>
      <div class="services-grid">
        <!-- Service Card 1 -->
        <div class="service-card">
          <div class="service-image-wrapper">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-orS4e2JFHeAI9DTDMMoX2Ad_ARaKDtWt4DnzU__8oI2wWG8yLjyP-S4p4XIzG02KzL-W8_C_4Kh19ObpoUb7sf9BRGrYsulLIhFGm-5rjD_62-sdV9aqLfnXtnnVAvJbMZbwdwKEqluw1t6e6EJZ_dfT7xvOciJY4uBc1LP8dwC-b2eil9nTZnn69EwgL9EUEPuzLxELAc8YxRn3zWOBjlqGsGDnLVQe_jEvvC6BHpIhbajo_hGCCkNApi3fqeJpM26IanF3mapJ" alt="International Job Placement">
          </div>
          <div class="service-title">International Job Placement</div>
          <div class="service-desc">We specialize in placing professionals in various industries across multiple countries. Our network includes top employers seeking skilled talent.</div>
        </div>

        <!-- Service Card 2 -->
        <div class="service-card">
          <div class="service-image-wrapper">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCG3JQtODQE5rDMwrK0J1xNTHU_2ihael9yDpztOjA3bzcE8vkIhAiq9mmHeffDUqrJ2mPPHmheIKK1wRxi0jIEX2EKM4jLFRdFkpekC0FXLwASYjXmV4zkWj2MLHCSwSCwMjz_wEu-jwCPFOYFwsSEDZ0YtM1lfM4l6tLacN515A6B7QSi82BC_vZo3Xd0AeLXZef0VSYTiYgWtVaIMn8bYLm-B1hT7N5mv4L9hqcnpaKQ2Dos_jj_kdZZ3xVE1guVYs7e3AP1R8JS" alt="Pre-Screening & Interview Preparation">
          </div>
          <div class="service-title">Pre-Screening & Interview Preparation</div>
          <div class="service-desc">Our team conducts thorough pre-screening to match candidates with suitable roles. We provide personalized interview coaching to ensure you present your best self.</div>
        </div>

        <!-- Service Card 3 -->
        <div class="service-card">
          <div class="service-image-wrapper">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuB10vK3GFYrNCahRcL7oXpskuyLUK2JV1MCnM66mZRbLbmqMTRCEFzPZrgfyL2xl_UocAia1Hagzp8EByNuZa41LyBcm2JxgZ2PrJ-DJX0XY7GJO5hSeG3J-LTxrMtaGFJAwviMUgtCUt4KAGyWMWCaaxzmy1S3tulhSa5Rxtk9ZbrbpYQS-e_cXjwz6aOnEqefJBDYBLwZ2mlbunQbAkQ3cNaAIfgvJPHb196i5NspcCDDPEnbDlNeqcF1zIyMMiBgm3Fzr8UC0DW3" alt="Visa & Documentation Support">
          </div>
          <div class="service-title">Visa & Documentation Support</div>
          <div class="service-desc">Navigating visa and documentation can be complex. We offer expert guidance to streamline the process, ensuring compliance and timely approvals.</div>
        </div>

        <!-- Service Card 4 -->
        <div class="service-card">
          <div class="service-image-wrapper">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzBtUAvYe8cNsSGLVoTDFVVSM2y2yrf99LAxa9Lp5e7_hYUMJp6wSJwQQ6TDp6SGpcIsJ0I4m7NhMBK5KbbJ7uXLoif421FKnSQenzHHXazltLlflQsZmO3a5rv4uuWAZ3q3_d6057OiHLEepI_IlH6QYm-EMSaLZLD0KzqosvI7hQuNLIwKmIqB3csVg4cShnRj6nSdnjHldnOkridtDt4e4aetNftkboDvQ5gL0TOxZHARGuI3MUx-zrbwnQKrwj9fItcjsdhupX" alt="Relocation & Orientation">
          </div>
          <div class="service-title">Relocation & Pre-Departure Orientation</div>
          <div class="service-desc">We provide comprehensive relocation support and pre-departure orientation to help you settle in smoothly when moving to a new country.</div>
        </div>

        <!-- Service Card 5 -->
        <div class="service-card">
          <div class="service-image-wrapper">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBLMnQ7iZl9tFvetKBa95fkqJjoUC6mPNcpnkqCixExcg74jfHU21aVB7XsxxfkQuah61bJj10J6ZFeF9Tms7jp3VnG-PbDIicxyy9Xuw-O9v8b54qwLJ0o3KDX9J-ROQj-GHn1EVuZpCtl-aKfQNKgU9p-O29MuoiFj9C9QA8TbQ00UNkxjUsSwOK9K1KaplgZbUPG3bgONOfA8eoGUAASu9ebWsRj_B0vjm0W9QLqqOwUlbPuCFwYayB-TmQ1p4EHJj-Vsv15fJdn" alt="Ethical Recruitment">
          </div>
          <div class="service-title">Ethical Recruitment Practices</div>
          <div class="service-desc">We adhere to the highest ethical standards in recruitment, ensuring fair and transparent processes for both candidates and employers.</div>
        </div>
      </div>

      
    </div>
  </div>

      
          

@endsection
