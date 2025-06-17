<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Commerce Version 5 - The Future of Online Commerce</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: white;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .glow-text {
            text-shadow: 0 0 10px #ff00cc, 0 0 20px #3333ff;
        }

        .glow-button {
            background: linear-gradient(to right, #ff00cc, #3333ff);
            box-shadow: 0 0 10px #ff00cc, 0 0 20px #3333ff;
            color: white;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .glow-button:hover {
            filter: brightness(1.1);
            transform: translateY(-2px); /* Slight lift on hover */
        }

        .section-title::after {
            content: '';
            display: block;
            height: 4px;
            width: 80px;
            margin: 10px auto 0;
            background: linear-gradient(to right, #ff00cc, #3333ff);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            backdrop-filter: blur(8px);
            min-height: 150px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* Subtle glass shadow */
            border: 1px solid rgba(255, 255, 255, 0.2); /* Subtle glass border */
        }

        .glass-card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        main {
            flex: 1;
        }

        /* Toast positioning */
        .toast-container {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            z-index: 1080; /* Higher than Bootstrap's default modals */
        }

        /* Custom toast style to match theme */
        .custom-toast {
            background-color: rgba(48, 43, 99, 0.9); /* #302b63 with opacity */
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }
        .custom-toast .btn-close {
            filter: invert(1); /* Makes the close button white */
        }
    </style>
</head>
<body>

<header class="container pt-5 pb-3">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto text-center" data-aos="fade-up">
            <h1 class="display-4 fw-bold glow-text">E-Commerce API v5: Powering Tomorrow's Marketplaces</h1>
            <p class="lead text-light mt-3 mb-4">Unleash the full potential of your online business with our robust, scalable, and secure API. Build modern e-commerce experiences with unparalleled flexibility.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('api-docs') }}" class="btn glow-button px-4 py-2" data-aos="zoom-in" data-aos-delay="200">Explore API Docs</a>
                <a href="{{ route('products.index') }}" class="btn glow-button px-4 py-2" data-aos="zoom-in" data-aos-delay="300">See Live Demo</a>
            </div>
        </div>
    </div>
</header>

<main>
    <section class="py-5">
        <div class="container">
            <h2 class="text-center h3 fw-bold section-title mb-5" data-aos="fade-up">Core E-Commerce Capabilities</h2>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3" data-aos="fade-right">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">🛒 Product Management</h3>
                            <p class="text-light small">Comprehensive tools to create, update, and manage product catalogs, inventory levels, detailed descriptions, and high-quality images. Supports variations and bundles.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" data-aos="fade-right" data-aos-delay="100">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">📦 Order Processing</h3>
                            <p class="text-light small">Efficiently handle order creation, status tracking, fulfillment workflows, shipping integrations, and automated notifications for a smooth customer journey.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" data-aos="fade-left" data-aos-delay="200">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">👥 Customer Relationship Management</h3>
                            <p class="text-light small">Centralized management of customer profiles, order history, preferences, and communication. Personalize experiences and foster loyalty with ease.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" data-aos="fade-left" data-aos-delay="300">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">💳 Secure Payment Gateways</h3>
                            <p class="text-light small">Seamless integration with leading payment providers. Ensure secure transactions, handle refunds, and support various payment methods globally.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="container my-5" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"/>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center h3 fw-bold section-title mb-5" data-aos="fade-up">Why Developers Love Our API</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">🚀 Blazing Fast Performance</h3>
                            <p class="text-light small">Engineered for speed, our optimized RESTful endpoints ensure minimal latency and provide rapid data retrieval, enhancing user experience.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">🔒 Enterprise-Grade Security</h3>
                            <p class="text-light small">Your data's safety is our priority. We implement industry-leading encryption, authentication, and authorization protocols to keep your platform secure.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">🔌 Effortless Integration</h3>
                            <p class="text-light small">Designed with developers in mind, our API features intuitive endpoints, clear error handling, and language-agnostic compatibility for quick setup.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">📈 Infinitely Scalable Architecture</h3>
                            <p class="text-light small">Built on a microservices architecture, our API can effortlessly scale to handle millions of transactions, supporting your growth from startup to global enterprise.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">🔄 Real-time Data Synchronization</h3>
                            <p class="text-light small">Experience live updates across inventory, orders, and customer activities. Keep your users informed and your operations agile with real-time data flow.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 glow-text mb-2">🛠️ Customizable & Extensible</h3>
                            <p class="text-light small">Our flexible design allows for deep customization. Extend functionalities, build custom modules, and integrate third-party services seamlessly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="container my-5" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"/>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center h3 fw-bold section-title mb-5" data-aos="fade-up">Empowering Your E-Commerce Vision</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="glass-card h-100">
                        <h3 class="h5 glow-text mb-3">Accelerate Your Development Cycle</h3>
                        <p class="text-light">Bypass the complexities of backend infrastructure. Our API provides pre-built, robust modules for essential e-commerce functions, allowing your team to focus on innovative front-end experiences and unique business logic.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="glass-card h-100">
                        <h3 class="h5 glow-text mb-3">Tailored for Any Business Model</h3>
                        <p class="text-light">Whether you're launching a niche boutique, a sprawling enterprise store, or a dynamic multi-vendor marketplace, our API's modular design adapts to your specific requirements, providing the tools you need to succeed.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="glass-card h-100">
                        <h3 class="h5 glow-text mb-3">Developer-Centric Documentation & Tools</h3>
                        <p class="text-light">Jumpstart your integration with our comprehensive, up-to-date documentation. Featuring clear API references, practical code examples in multiple languages, and guided tutorials to ensure a smooth development journey.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                    <div class="glass-card h-100">
                        <h3 class="h5 glow-text mb-3">Dedicated Support & Community</h3>
                        <p class="text-light">Our commitment extends beyond the code. Benefit from a responsive support team ready to assist with your queries, alongside an active developer community where you can share insights and find solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="container my-5" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"/>

    <section class="py-5 text-center">
        <div class="container" data-aos="zoom-in">
            <h2 class="h3 fw-bold glow-text mb-4">Ready to Innovate Your E-Commerce Platform?</h2>
            <p class="lead text-light mb-4">Join hundreds of successful businesses and developers building the next generation of online shopping experiences with E-Commerce API v5.</p>
            <a href="{{ route('api-docs') }}" class="btn glow-button px-5 py-3 fs-5" data-aos="zoom-in" data-aos-delay="200">Start Building Today!</a>
        </div>
    </section>

</main>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto text-center" data-aos="fade-up">
            <h2 class="h3 fw-bold glow-text mb-4">Stay Connected for Updates</h2>
            <p class="text-light mb-4">Get the latest news, feature releases, tutorials, and insights directly in your inbox. Don't miss out on what's new with E-Commerce API v5.</p>
            <form id="subscribeForm" class="d-flex justify-content-center">
                <input type="email" id="subscribeEmail" class="form-control me-2" placeholder="Your Email Address" required>
                <button type="submit" class="btn glow-button">Subscribe</button>
            </form>
        </div>
    </div>
</div>

<footer class="text-center py-4 text-white-50 small mt-auto">
    <p class="mb-1">&copy; 2025 E-Commerce API v5 — Built for modern commerce platforms.</p>
    <p class="mb-0">Developed By: <a href="https://github.com/SokEtak" class="text-white-50 text-decoration-none">SokEtak</a></p>
</footer>

<div class="toast-container">
    <div id="subscribeToast" class="toast custom-toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header custom-toast">
            <strong class="me-auto text-white">Subscription Status</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            You've successfully subscribed to our newsletter!
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800, // values from 0 to 3000, with step 50ms
        once: true,    // whether animation should happen only once - while scrolling down
    });

    // JavaScript for the subscribe form and toast
    document.getElementById('subscribeForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission (page reload)

        const emailInput = document.getElementById('subscribeEmail');
        const toastElement = document.getElementById('subscribeToast');
        const toastBody = toastElement.querySelector('.toast-body');

        // Simple validation check (can be expanded)
        if (emailInput.value.trim() === '') {
            toastBody.textContent = 'Please enter a valid email address.';
            toastElement.classList.add('text-danger'); // Optional: Add a class for error styling
        } else {
            // In a real application, you'd send this email to your server
            console.log('Subscribing email:', emailInput.value);

            toastBody.textContent = 'You\'ve successfully subscribed to our newsletter!';
            toastElement.classList.remove('text-danger'); // Remove error class if previously set
            emailInput.value = ''; // Clear the input field
        }

        // Show the toast
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    });
</script>

</body>
</html>