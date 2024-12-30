<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Bus Transport</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
     <div class="navigation">
        <div class="hero-column">
            <div class="nav-container">
                <div class="site-logo">
                    <ul>
                        <li><img src="images/sitelogo.svg" alt="SMIU UniRide Logo"></li>
                    </ul>
                </div>
                <div class="navbar">
                    <nav>
                        <ul>
                            <li><a href="index.php">HOME</a></li>
                            <li><a href="#about">ABOUT US</a></li>
                            <li><a href="#service">SERVICES</a></li>
                            <li><a href="#process">PROCESS</a></li>
                            <li><a href="login.php">LOGIN</a></li>
                            <li><a href="signup.php">SIGN UP</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="call-container">
                    <div class="call">
                        <div class="call-icon">
                            <img src="images/call-icon.svg" alt="Call Icon">
                        </div>
                        <div class="call-content">
                            <h2>CALL CENTER</h2>
                            <p><a href="tel:(+654) 8654 6543">(+654) 8654 6543</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
     <main>
        <Section class="hero-section">
            <div class="hero-column">
                <div class="hero-container home-container">
                    <div class="hero-content-caontainer">
                        <h1 class="hero-heading">Seamless campus travel safe, timely, and your way</h1>
                        <p>Hop on board for a smooth ride. Join us for reliable, comfortable, and timely travel.</p>
                        <a href="login.php" class="join-button">
                            <div>
                                <div class="join-button-text"><p>join us</p></div>
                                <img src="images/button-arrow-icon.svg" alt="Button Icon">
                            </div>
                        </a>
                    </div>

                    <div class="hero-image-caontainer">
                        <img src="images/uniride-bus-hero.svg" alt="UniRide Bus">
                    </div>
                </div>
            </div>
        </Section>

        <Section class="book-ride-section">
            <div class="book-ride-container home-container">
                <div class="ride-container">
                    <div class="ride-content">
                        <h2>Book your ride <span style="text-transform: capitalize;">NOW</span></h2>
                        <p>Reserve your seat - Apply now! Start your journey with us today</p>
                    </div>
                    <div class="ride-content">
                        <div class="call">
                            <div class="call-icon">
                                <img src="images/call-24-icon.svg" alt="Call Icon">
                            </div>
                            <div class="call-content">
                                <h2>CALL CENTER</h2>
                                <p>call for detail information</p>
                                <p><a href="tel:(+654) 8654 6543">(+654) 8654 6543</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="apply-button">
                    <a href="login.php">Book Now</a>
                </div>
            </div>
        </Section>

        <Section class="about-section" id="about">
            <div class="about-us-container home-container">
                <div class="about-container">
                    <div class="about-heading-content">
                        <h3>who we are</h3>
                        <h2>Enjoy the journey with uscomfort, reliability, and convenience in every ride</h2>
                    </div>
                    <div class="about-content">
                        <p>Dolor augue curae montes eget sollicitudin diam praesent non mus in lobortis. Ligula magna himenaeos dictumst cubilia dolor morbi letius tempor in convallis. Semper litora suscipit facilisis scelerisque aenean rhoncus tempus mauris interdum dis parturient. Ultrices feugiat adipiscing pharetra penatibus praesent non fusce ipsum class. Sociosqu turpis scelerisque laoreet pulvinar fermentum posuere nam mollis porttitor convallis dictumst.</p>
                    </div>
                </div>
            </div>
        </Section>

        <Section class="service-section" id="service">
            <div class="service-container home-container">
                <div class="service-container">
                    <div class="services">
                        <img src="images/safety-guarantee.svg" alt="Safety Guarantee">
                        <h2>Safety Guarantee</h2>
                        <p>Your safety, our priority every time.</p>
                    </div>
                    <div class="services">
                        <img src="images/professional.svg" alt="Professional">
                        <h2>Professional</h2>
                        <p>Safe & professionally managed.</p>
                    </div>
                    <div class="services service-bg">
                        <img src="images/support.svg" alt="24/7 SUPPORT">
                        <h2>24/7 Support</h2>
                        <p>Reliable professionally managed.</p>
                    </div>
                    <div class="services">
                        <img src="images/at-time.svg" alt="At Time">
                        <h2>At Time</h2>
                        <p>Reliable professionally managed.</p>
                    </div>
                </div>
            </div>
        </Section>

        <Section class="rental-section">
            <div class="rental-column">
                <div class="rental-container home-container">
                    <div class="rent">
                        <div class="rental-content-caontainer">
                            <h2>Seamless campus travel safe, timely, and your way</h1>
                            <p>Hop on board for a smooth ride. Join us for reliable, comfortable, and timely travel.</p>
                            <div class="counter">
                                <div class="number-counter">
                                    <h3>20+</h3>
                                    <p>Bus Ready</p>
                                </div>
                                <div class="number-counter">
                                    <h3>200+</h3>
                                    <p>Satisfied Customer</p>
                                </div>
                            </div>
                        </div>

                        <div class="rental-image-caontainer">
                            <img src="images/rental-bus.svg" alt="UniRide Bus">
                        </div>
                    </div>
                </div>
            </div>
        </Section>

        <Section class="process-section" id="process">
            <div class="process-column">
                <div class="process-container home-container">
                    <h2>How We Work</h2>
                    <h3>Steps To Booking a Bus</h3>
                    <div class="process">
                        <div class="process-content">
                            <img src="images/select-bus.svg" alt="select your BUS">
                            <h2>select your BUS</h2>
                            <p>select Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus luctus nec.</p>
                        </div>
                        <div class="process-content">
                            <img src="images/book-bus.svg" alt="Bus Booking">
                            <h2> Bus Booking</h2>
                            <p>select Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus luctus nec.</p>
                        </div>
                        <div class="process-content">
                            <img src="images/payment.svg" alt="Payment">
                            <h2>Payment</h2>
                            <p>select Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus luctus nec.</p>
                        </div>
                        <div class="process-content">
                            <img src="images/enjoy-trip.svg" alt="Enjoy your Trip">
                            <h2>Enjoy your Trip</h2>
                            <p>select Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus luctus nec.</p>
                        </div>
                    </div>
                </div>
            </div>
        </Section>

        <Section class="news-letters-section">
            <div class="news-letters-container home-container">
                <div class="news-container">
                    <div class="news-letters-heading-content">
                        <h3>News Letters</h3>
                        <h2>Subscribe Us Now</h2>
                    </div>
                    <div class="news-letters-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
                <div class="news-letters-form">
                    <form action="" class="news-form">
                        <input class="newsletter-input" type="email" name="emil" id="email" placeholder="Email" required>
                        <button type="submit" class="newsletter-sub-button">Submit</button>
                    </form>
                </div>
            </div>
        </Section>
    </main>

    <!-- Footer Bar -->
    <footer>
        <div class="footer">
            <div class="home-container footer-container">
                <div class="footer-columns footer-logo-column">
                    <div class="site-logo">
                        <div class="nav">
                            <ul>
                                <li><a href="index.php"><img src="images/sitelogo.svg" alt="SMIU UniRide Logo">SMI UNIRIDE</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus.</p>
                    </div>
                    <div class="footer-location icon">
                        <img src="images/location-icon.svg" alt="Location Icon">
                        <p>Karachi, PAKISTAN</p>
                    </div>
                </div>
                <div class="footer-columns">
                    <div class="nav">
                        <h2>Navigation</h2>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#service">Services</a></li>
                            <li><a href="#process">Process</a></li>
                        </ul>
                    </div>
                    <div class="footer-phone icon">
                        <img src="images/footer-call-icon.svg" alt="Call Icon">
                        <p><a href="tel:+92 333 3293481">+92 333 3293481</a></p>
                    </div>
                </div>
                <div class="footer-columns">
                    <div class="nav">
                        <h2>Process</h2>
                        <ul>
                            <li><a href="#process">select your BUS</a></li>
                            <li><a href="#process">Bus Booking</a></li>
                            <li><a href="#process">Payment</a></li>
                            <li><a href="#process">Enjoy Your Trip</a></li>
                        </ul>
                    </div>
                    <div class="footer-email icon">
                        <img src="images/email-icon.svg" alt="Email Icon">
                        <p><a href="mailto:uniride.smiu@gmail.com">uniride.smiu@gmail.com</a></p>
                    </div>
                </div>
                <div class="footer-columns">
                    <div class="nav">
                        <h2>Services</h2>
                        <ul>
                            <li><a href="#service">Safety Guarantee</a></li>
                            <li><a href="#service">Professional</a></li>
                            <li><a href="#service">24/7 SUPPORT</a></li>
                            <li><a href="#service">At Time</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="home-container copy-right-container">
                <div class="copyright">
                    <p>Copyright © 2024 Uniride, All rights reserved. Powered by MoxCreative</p>
                </div>
                <div class="copyright">
                    <p>Terms of use | Privacy Policy | Cookie Policy</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
