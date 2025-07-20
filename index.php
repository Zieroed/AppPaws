<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/db.php");
include("includes/header.php");

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["register"])) {
        include_once("accounts/register_handler.php");
    } elseif (isset($_POST["login"])) {
        include_once("accounts/login_handler.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paws</title>
    <link id="stylesheet" rel="stylesheet" href="css/index.css">
</head>
<body>
    <div id="nonregister" class="page-wrapper body">
        <main>
            <!-- Title Page Section --> 
            <section id="home" class="hero">
            <div class="hero-text">
                <h1 class="welcome-title">Welcome to</h1>
                <h1 class="happypaws-title"><span>Happy Paws Animal Care!</span></h1>
                <p><strong>Inquiries:</strong> 0917 548 8176</p>
                <p><strong>Clinic Hours:</strong> 8:00am to 5:00pm, Monday to Saturday</p>
                <p><strong>Socials:</strong> Happy Paws Animal Care Facebook Page</p>
                 <?php if (isset($_SESSION["fname"])): ?>
                    <a href="/AppPaws/appointment.php" class="<?php echo ($current == 'appointment.php') ? 'active' : ''; ?>">Book an Appointment</a>
                <?php else: ?>
                    <a onclick="showRegister()">Book an Appointment</a>
                <?php endif; ?>
            </div>
            <div class="hero-image">
                <img src="/AppPaws/assets/dogCatHomePage.jpg" alt="Dog and Cat" />
            </div>
            </section>

            <!-- Our Clinic Section --> 
            <section id="clinic" class="clinic-section">
            <h1>Our Clinic</h1>
            <p>Happy Paws Veterinary Clinic is a welcoming and reliable space where pets are treated like family. Rooted in compassion and guided by a deep love for animals, the clinic offers a comforting environment where both pets and their owners feel at ease. Known for its professionalism and genuine care, Happy Paws has become a trusted part of the community—committed to supporting the health and happiness of every animal that walks through its doors.</p>
            <img src="/AppPaws/assets/map.png" alt="Clinic Map" class="map-image" />
            <div class="address">
                Orient Bldg., (in front of Meycauayan College), Calvario, Meycauayan, Bulacan, Philippines, 3020
            </div>
            </section>

            <!-- Services Section --> 
            <section id="services" class="services-section">
            <h1>Services</h1>
            <p>Discover the wide range of services we offer to keep your furry companions happy, healthy, and thriving.</p>

            <div class="services-grid">
                <div class="service-card">
                <img src="/AppPaws/assets/preventiveCare.jpg" alt="Preventative Care">
                <div>
                    <h3>Preventative Care</h3>
                    <p>Routine exams, vaccinations, parasite control, and wellness plans to help your pet stay healthy and happy throughout every life stage.</p>
                </div>
                </div>

                <div class="service-card">
                <img src="/AppPaws/assets/surgery.jpg" alt="Surgery">
                <div>
                    <h3>Surgery</h3>
                    <p>Professional grooming services in a clean, pet-friendly environment—baths, trims, nail clipping, and more for your pet's comfort and hygiene.</p>
                </div>
                </div>

                <div class="service-card">
                <img src="/AppPaws/assets/whelping.jpg" alt="Whelping Assistance">
                <div>
                    <h3>Whelping Assistance</h3>
                    <p>From spay/neuter to advanced surgical care, our clinic ensures safe procedures and compassionate recovery under experienced veterinary hands.</p>
                </div>
                </div>

                <div class="service-card">
                <img src="/AppPaws/assets/grooming.jpg" alt="Grooming">
                <div>
                    <h3>Grooming</h3>
                    <p>Expert support before, during, and after birth for expecting pets. We're here to help with monitoring, delivery, and newborn care.</p>
                </div>
                </div>
            </div>

            <div class="others-card-wrapper">
                <div class="service-card others-card">
                <img src="/AppPaws/assets/others.jpg" alt="Other Services">
                <div>
                    <h3>Others</h3>
                    <p>Dental cleanings, diagnostics, microchipping, senior care, and more—all delivered with personalized attention and modern veterinary technology.</p>
                </div>
                </div>
            </div>
            </section>

            <!-- Know Our Vets Section --> 
            <section id="vets" class="about-section">
            <h1>Know Our Vets</h1>
            <div class="vet-container">
                <div class="vet-bio">
                <h3>Dr. Sunshine Magbuhos Arevalo</h3>
                <p>She provides expert veterinary services focused on personalized patient care. Her role may include wellness exams, vaccinations, and client education geared toward ensuring each pet’s health and happiness.</p>
                </div>
                <div class="vet-image">
                <img src="/AppPaws/assets/knowOurVets.jpg" alt="Happy Paws Vets">
                </div>
                <div class="vet-bio">
                <h3>Dr. Jeremiah Arevalo, D.V.M.</h3>
                <p>As the primary veterinarian with over a decade of experience in small-animal general practice, he offers compassionate care and comprehensive veterinary services—from wellness check-ups and preventive medicine to diagnostics and surgery.</p>
                </div>
            </div>
            </section>

            <!-- About Section --> 
            <section id="about" class="about-section">
            <h1>About Us</h1>
            <div class="images-container">
                <img src="/AppPaws/assets/photo1.jpg" alt="photo1">
                <img src="/AppPaws/assets/photo2.jpg" alt="photo2">
                <img src="/AppPaws/assets/photo3.jpg" alt="photo3">
            </div>
            <div class="description">
                <p>Happy Paws Veterinary Clinic is a trusted animal care facility located in Meycauayan, Bulacan, founded by Dr. Jeremiah Arevalo and Dr. Sunshine Magbuhos Arevalo. Built on compassion and expertise, the clinic offers a full range of veterinary services including check-ups, vaccinations, diagnostics, surgery, and wellness care for pets of all kinds.
                <p>Our mission is to provide high-quality, affordable, and compassionate care that promotes the health and happiness of every pet we serve. Guided by values of integrity, excellence, and community, Happy Paws continues to be a warm and welcoming place where pets are treated like family.Happy Paws Veterinary Clinic is a trusted care facility in Meycauayan, Bulacan, founded by Dr. Jeremiah and Dr. Sunshine Arevalo. We offer full-service veterinary care with compassion and dedication.</p>
            </div>
            </section>
        </main>
    </div>


    <!-- Include the login and registration forms -->    
    <?php
    include("accounts/register_form.php");
    include("accounts/login_form.php");
    include_once("includes/footer.php");
    ?>
    <script src="js/main.js"></script>
</body>
</html>
