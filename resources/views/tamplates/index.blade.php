@extends('layouts.index-app')

@section('title', 'Home Page')

@section('content')

    <!-- Hero Section -->
    <header class="hero-section bg-light py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Welcome School management system </h1>
                    <p class="lead mb-4">Transforming students to transform the world through easy data access, community, and mission.</p>
                    <div class="d-flex gap-3">
                        <a href="#about" class="btn btn-primary btn-lg px-4">Learn More</a>
                        <a href="#events" class="btn btn-outline-primary btn-lg px-4">Upcoming features</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="" alt="USCF Students" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </header>

    <!-- Gallery Section -->
    <section id="gallery" class="py-5 bg-white">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-5 fw-bold">Gallery</h2>
                <div class="divider bg-primary mx-auto"></div>
                <p class="lead">Moments from our customers</p>
            </div>

            <div class="row g-3">
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery1.jpg' %}" class="img-fluid rounded shadow-sm" alt="school Event">
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery2.jpg' %}" class="img-fluid rounded shadow-sm" alt="books Study">
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery3.jpg' %}" class="img-fluid rounded shadow-sm" alt="academic">
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery4.jpg' %}" class="img-fluid rounded shadow-sm" alt="schools">
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery5.jpg' %}" class="img-fluid rounded shadow-sm" alt="play">
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery6.jpg' %}" class="img-fluid rounded shadow-sm" alt="Community Service">
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery7.jpg' %}" class="img-fluid rounded shadow-sm" alt="advancing">
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <img src="{% static 'images/gallery8.jpg' %}" class="img-fluid rounded shadow-sm" alt="Conference">
                    </a>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary">View More Photos</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-header mb-5">
                        <h2 class="display-5 fw-bold">Contact Us</h2>
                        <div class="divider bg-primary"></div>
                        <p class="lead">Get in touch with school management system</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="h5"><i class="fas fa-map-marker-alt text-primary me-2"></i> Location</h3>
                        <p>CyberNova Solutions Office<br>Kibondo-Kigoma</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="h5"><i class="fas fa-clock text-primary me-2"></i> Meeting Times</h3>
                        <p>Any time in ours of work: Monday to saturday 08:30 AM -7:30 PM<br>
                    </div>

                    <div class="mb-4">
                        <h3 class="h5"><i class="fas fa-envelope text-primary me-2"></i> Email</h3>
                        <p>cybernovasolutions@gmail.com</p>
                    </div>

                    <div class="social-links">
                        <h3 class="h5"><i class="fas fa-hashtag text-primary me-2"></i> Follow Us</h3>
                        <div class="d-flex gap-3 mt-3">
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h4 mb-4">Send us a message</h3>
                            <form method="post">
                                {% csrf_token %}
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="h1 mb-4">Stay Updated</h2>
                    <p class="lead mb-4">Subscribe to our newsletter to receive updates about schools</p>
                    <form class="row g-2 justify-content-center">
                        <div class="col-md-8">
                            <input type="email" class="form-control form-control-lg" placeholder="Your email address">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-light btn-lg w-100">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

   

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Photo Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" class="img-fluid" id="galleryImage" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{% static 'js/script.js' %}"></script>
</body>
</html>