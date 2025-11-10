<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 position-sticky top-0 z-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="@assets/images/logo-dark.png" alt="Company Logo" height="35" class="me-2" />
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center gap-lg-3 pt-3 pt-lg-0">

                    <li class="nav-item">
                        <button class="btn btn-link text-muted visit-link px-2 fw-semibold" @click="openLoginModal">
                            Login
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-link text-muted visit-link px-2 fw-semibold" @click="goToDashboard">
                            Dashboard
                        </button>
                    </li>
                    <li class="nav-item">
                        <a href="#warranty-form" class="btn btn-link text-muted visit-link px-2 fw-semibold">
                            Register
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://rayzonsolar.com/" target="_blank"
                            class="btn btn-link visit-link px-2 fw-semibold">
                            Visit Us <i class="bi bi-arrow-right"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <teleport to="body">
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true"
            data-bs-backdrop="static" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-1 pb-3 border-bottom-dashed">
                        <h5 class="modal-title fw-semibold" id="loginModalLabel">
                            {{ showOtpField ? "Enter OTP" : "Login with Email" }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Email Field -->
                        <div v-if="!showOtpField">
                            <label class="form-label fw-semibold mb-2">Registered Email</label>
                            <input type="email" v-model="email" placeholder="Enter your email" class="form-control mb-1"
                                :class="{ 'is-invalid': emailError }" required />
                            <div v-if="emailError" class="invalid-feedback d-block">
                                {{ emailError }}
                            </div>

                            <button class="btn btn-primary w-100 mt-3" :disabled="isLoading" @click="sendOtp">
                                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>
                                {{ isLoading ? "Sending..." : "Send OTP" }}
                            </button>
                        </div>

                        <!-- OTP Field -->
                        <div v-else>
                            <p class="text-muted mb-3 text-center">
                                We’ve sent a 6-digit OTP to <strong>{{ email }}</strong>
                            </p>

                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <input v-for="(digit, index) in otp" :key="index" v-model="otp[index]" maxlength="1"
                                    class="form-control text-center" :id="`otp-${index}`"
                                    @input="handleLoginOtpInput($event, index)"
                                    style="width: 45px; font-size: 1.5rem;" />
                            </div>

                            <button class="btn btn-primary w-100 mb-2" @click="verifyLoginOtp">Verify OTP</button>
                            <button class="btn btn-link text-danger text-decoration-none w-100 mx-auto"
                                @click="resendLoginOtp">
                                Resend OTP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </teleport>

    <section class="hero-section d-flex align-items-center position-relative">
        <div class="hero-bg" :style="{ backgroundImage: `url(${bannerImage})` }">
            <div class="hero-overlay"></div>
        </div>

        <div class="container position-relative">
            <div class="row align-items-start">
                <div class="col-lg-7">

                    <div class="mb-4 d-inline-flex align-items-center gap-2 px-3 py-2 rounded border backdrop-blur">
                        <i class="bi bi-file-earmark-check text-white"></i>
                        <span class="text-white small fw-semibold">
                            Enterprise-Grade Portal
                        </span>
                    </div>

                    <h1 class="display-4 fw-bold text-warning">
                        <transition name="fade" mode="out-in">
                            <span class="animated-word d-inline-block" :key="currentIndex" aria-live="polite">
                                {{ textList[currentIndex] }}
                            </span>
                        </transition>
                    </h1>

                    <h1 class="display-4 fw-bold">
                        <span class="text-white mb-4">Warranty Certificate</span>
                    </h1>

                    <p class="lead text-light opacity-75 mb-4">
                        Streamlined access to all your solar panel warranty documentation.
                        Manage certificates, track expiration dates, and submit claims.
                    </p>

                    <div class="system-info">
                        <div class="d-sm-flex d-block align-items-center justify-content-between gap-4">
                            <div class="d-flex flex-column text-center mb-sm-0 mb-3">
                                <span class="h3 text-light">15 years</span>
                                <span class="text-light opacity-75">Materials Warranty</span>
                            </div>
                            <span class="status-dot bg-warning"></span>
                            <div class="d-flex flex-column text-center mb-sm-0 mb-3">
                                <span class="h3 text-light">30 years</span>
                                <span class="text-light opacity-75">80% Power Warranty</span>
                            </div>
                            <span class="status-dot bg-warning"></span>
                            <div class="d-flex flex-column text-center mb-sm-0 mb-3">
                                <span class="h3 text-light">ISO</span>
                                <span class="text-light opacity-75">27001 Certified</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="container mb-4">
        <section class="about-us py-5" data-aos="fade-up" data-aos-duration="3000">
            <!-- Section Header -->
            <p class="text-uppercase text-primary fw-semibold mb-3" data-aos="fade-up">Who We
                Are</p>
            <div class="text-start mb-5 row">
                <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-up">
                    <h2 class="fw-bold display-6 mb-3">We are Rayzon Solar</h2>
                </div>

                <div class="col-lg-7">
                    <p class="text-muted">
                        Rayzon Solar, India’s top solar panel manufacturing company, has emerged as a
                        leader in the
                        industry with its innovative solutions and widespread presence PAN India. Renowned for our
                        commitment to quality, Rayzon Solar has been
                        consistently recognized as one of the top manufacturer of solar panel since 2017.
                    </p>
                    <p class="text-muted">As a leading manufacturer Of PV module and smart energy solution, Rayzon
                        delivers world class
                        solar PV products, applications, and services to promote global sustainable development.</p>
                </div>
            </div>

            <!-- Steps Row -->
            <div class="row g-4">
                <!-- Step 1 -->
                <div class="col-lg-3 col-sm-6" data-aos="flip-left" data-aos-duration="3000">
                    <div class="h-100 border rounded-3 p-4 bg-white ribbon-box right">
                        <div class="mb-4">
                            <div class="ribbon-three ribbon-three-primary">
                                <span>Quality</span>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            We ensure uncompromising quality through 100% Visual & EL Testing, TUV IMS Certification,
                            and stringent HAST Testing for every product we deliver.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-3 col-sm-6" data-aos="flip-left" data-aos-duration="3000" data-aos-delay="100">
                    <div class="h-100 border rounded-3 p-4 bg-white ribbon-box right">
                        <div class="mb-4">
                            <div class="ribbon-three ribbon-three-primary">
                                <span>Technology</span>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            Driven by advanced nanometric & innovation, precision coating ensures high cell
                            efficiency and guarantees minimum deterioration for long-lasting performance.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-3 col-sm-6" data-aos="flip-left" data-aos-duration="3000" data-aos-delay="200">
                    <div class="h-100 border rounded-3 p-4 bg-white ribbon-box right">
                        <div class="mb-4">
                            <div class="ribbon-three ribbon-three-primary">
                                <span>Reliability</span>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            Built with PID-resistant G2G structure and tested for accelerated aging, our modules ensure
                            just 0.4% annual degradation for unmatched long-term reliability.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-lg-3 col-sm-6" data-aos="flip-left" data-aos-duration="3000" data-aos-delay="300">
                    <div class="h-100 border rounded-3 p-4 bg-white ribbon-box right">
                        <div class="mb-4">
                            <div class="ribbon-three ribbon-three-primary">
                                <span>Vision</span>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            To make our future more vibrant and sustainable by using green energy to save the
                            earth.Through the utilization of renewable resources.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-works py-5">
            <p class="text-uppercase text-primary fw-semibold mb-3" data-aos="fade-up">What We Do</p>
            <div class="row">
                <!-- Left Side Heading -->
                <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-up">
                    <h2 class="fw-bold display-6 mb-3">
                        How it works
                    </h2>
                    <p class="text-muted">
                        From our first release to serving hundreds of clients worldwide,
                        here’s how Futurehub grew from an idea into a trusted solution for
                        teams everywhere.
                    </p>
                </div>

                <!-- Timeline Section -->
                <div class="col-lg-7" data-aos="fade-up" data-aos-duration="3000">
                    <div class="timeline position-relative ms-2">
                        <!-- Vertical Line -->
                        <div class="timeline-line position-absolute top-0 start-0 bg-primary"></div>

                        <!-- Milestone 1 -->
                        <div class="timeline-item position-relative pb-5">
                            <div class="timeline-dot bg-primary"></div>
                            <div class="ps-4">
                                <p class="text-uppercase fw-semibold text-primary">Form</p>
                                <h5 class="fw-bold mt-2">First Fill the Form</h5>
                                <p class="text-muted mb-0">
                                    Do fill the warranty registration form with accurate details to ensure
                                    your warranty is valid and easily accessible when needed.
                                </p>
                            </div>
                        </div>

                        <!-- Milestone 2 -->
                        <div class="timeline-item position-relative pb-5">
                            <div class="timeline-dot bg-primary"></div>
                            <div class="ps-4">
                                <p class="text-uppercase fw-semibold text-primary">OTP</p>
                                <h5 class="fw-bold mt-2">OTP Validation</h5>
                                <p class="text-muted">
                                    After filling the form, on submit you will receive an OTP (One Time Password) via
                                    email. Enter the OTP to verify your identity and complete the registration process.
                                </p>
                            </div>
                        </div>

                        <!-- Milestone 3 -->
                        <div class="timeline-item position-relative pb-5">
                            <div class="timeline-dot bg-primary"></div>
                            <div class="ps-4">
                                <p class="text-uppercase fw-semibold text-primary">Dashboard</p>
                                <h5 class="fw-bold mt-2">Redirect to Dashboard</h5>
                                <p class="text-muted mb-0">
                                    After successful OTP validation, you will be redirected to your warranty
                                    dashboard where you can view and manage your warranty details.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="warranty-form pt-5" id="warranty-form">
            <div class="text-center mb-5" data-aos="zoom-in">
                <h2 class="fw-bold display-6 mb-3">Warranty Certificate Registration</h2>
                <p class="text-muted">
                    Complete this form to register your solar panel warranty
                </p>
            </div>

            <div class="row">
                <div class="col-lg-4" data-aos="fade-up">
                    <div style="display: flex; flex-direction: column; gap: 25px; justify-content: center;">
                        <img src="@assets/images/gt-collab.png" alt="">
                        <img src="@assets/images/kiwa.png" alt="">
                        <img src="@assets/images/mahindra.png" alt="">
                    </div>
                </div>
                <div class="col-lg-8 " data-aos="fade-up" data-aos-duration="3000">
                    <!-- Success Message -->
                    <div v-if="submitted" class="alert alert-success d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>
                            Form submitted successfully! Your warranty certificate is being processed.
                        </span>
                    </div>

                    <!-- Form Card -->
                    <div class="card shadow border-0">
                        <div class="card-body p-4 p-md-5">
                            <form @submit.prevent="handleSubmit">
                                <!-- Personal Information -->
                                <FormSection title="Personal Information" description="Enter your basic details">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" v-model="formData.name" placeholder="Name"
                                                required class="form-control" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" v-model="formData.email"
                                                placeholder="Email" required class="form-control" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" name="phone" v-model="formData.phone" placeholder="phone"
                                                required class="form-control" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Purchase Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="purchaseDate" v-model="formData.purchaseDate"
                                                required class="form-control" />
                                        </div>
                                    </div>
                                </FormSection>

                                <hr class="my-4" />

                                <!-- Address Information -->
                                <FormSection title="Address Information" description="Provide your complete address">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Street Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="address" v-model="formData.address"
                                            placeholder="Add Address" required class="form-control" />
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">City <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="city" v-model="formData.city"
                                                placeholder="Add City" required class="form-control" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">State <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="state" v-model="formData.state"
                                                placeholder="Add State" required class="form-control" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Pincode <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="pincode" v-model="formData.pincode"
                                                placeholder="000000" required class="form-control" />
                                        </div>
                                    </div>
                                </FormSection>

                                <hr class="my-4" />

                                <!-- Product Information -->
                                <FormSection title="Product Information" description="Provide your product details">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Serial Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="serial" v-model="formData.serial_no"
                                            @input="formatCommaSeparated"
                                            placeholder="Enter your product serial number, comma separated" required
                                            class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Invoice Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="invoice" v-model="formData.invoice_no"
                                            placeholder="Enter product invoice number" required class="form-control" />
                                    </div>
                                </FormSection>

                                <hr class="my-4" />

                                <!-- Document Upload -->
                                <FormSection title="Invoice Document"
                                    description="Upload a copy of your purchase invoice">
                                    <div class="rounded-3 p-4 text-center bg-light position-relative">
                                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" id="invoice-upload"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                            @change="handleFileChange" required />
                                        <label for="invoice-upload"
                                            class="d-block border border-dashed p-3 border-primary rounded-3 mb-0">
                                            <div class="mb-3">
                                                <i class="bi bi-upload fs-2 text-primary"></i>
                                            </div>
                                            <p class="fw-semibold mb-1">
                                                {{ formData.invoice ?
                                                    formData.invoice.name :
                                                    "Click to upload or drag and drop" }}
                                            </p>
                                            PDF, JPG or PNG (Max 5MB)
                                        </label>
                                    </div>
                                </FormSection>

                                <!-- Submit -->
                                <div class="pt-2">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold"
                                        :disabled="isLoading">
                                        <span v-if="isLoading" class="d-flex align-items-center justify-content-center">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Processing...
                                        </span>
                                        <span v-else>Generate Warranty Certificate</span>
                                    </button>

                                    <p class="text-center text-muted mt-3 mb-0">
                                        Your information is secure and will only be used for warranty registration.
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <teleport to="body">
            <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true"
                data-bs-backdrop="static" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-semibold" id="otpModalLabel">Email Verification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="text-muted mb-4">
                                We’ve sent a 6-digit code to <strong>{{ formData.email }}</strong>
                            </p>

                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <input v-for="(digit, index) in otp" :key="index" v-model="otp[index]" maxlength="1"
                                    class="form-control text-center" :id="`otp-${index}`"
                                    @input="handleOtpInput($event, index)" style="width: 45px; font-size: 1.5rem;" />
                            </div>

                            <button class="btn btn-primary w-100 mb-3" @click="verifyOtp">Verify OTP</button>
                            <button class="btn btn-link text-decoration-none" @click="resendOtp">Resend OTP</button>
                        </div>
                    </div>
                </div>
            </div>
        </teleport>
    </div>

    <div class="warranty-footer">
        <div class="footer-sections">
            <div class="container">
                <div class="row py-5 mb-4 align-items-start">
                    <!-- Company Column -->
                    <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                        <h6 class="fw-bold mb-3">Who we are</h6>
                        <ul class="list-unstyled footer-links">
                            <li><a href="https://rayzonsolar.com/about" class="footer-link" target="_blank">About Us</a>
                            </li>
                            <li><a href="https://rayzonsolar.com/products" class="footer-link"
                                    target="_blank">Products</a></li>
                            <li><a href="https://rayzonsolar.com/events" class="footer-link" target="_blank">Events</a>
                            </li>
                            <li><a href="https://rayzonsolar.com/gujarat-titans" class="footer-link"
                                    target="_blank">Renewable Partners</a></li>
                            <li><a href="https://rayzonsolar.com/contact-us" class="footer-link"
                                    target="_blank">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Navigation Column -->
                    <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                        <h6 class="fw-bold mb-3">Our Companies</h6>
                        <ul class="list-unstyled footer-links">
                            <li><a href="https://rayzonsolar.com/" class="footer-link" target="_blank">Rayzon Solar</a>
                            </li>
                            <li><a href="https://rayzongreen.com/" class="footer-link" target="_blank">Rayzon Green</a>
                            </li>
                            <li><a href="https://rayzonindustries.com/" class="footer-link" target="_blank">Rayzon
                                    Industries</a></li>
                            <li><a href="#" class="footer-link" target="_blank">Rayzon Energy</a></li>
                            <li><a href="https://rayzongreen.com/" class="footer-link" target="_blank">Rayzon
                                    Engineering</a></li>
                            <li><a href="https://www.delucecare.com/" class="footer-link" target="_blank">Rayzon Bio
                                    Care</a></li>
                        </ul>
                    </div>

                    <!-- Contact Column -->
                    <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                        <h6 class="fw-bold mb-3">Contact</h6>

                        <div class="d-flex align-items-center gap-2 mb-3 contact-item">
                            <i class="bi bi-envelope-paper"></i>
                            <span>contact@rayzonenergies.com</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-3 contact-item">
                            <i class="bi bi-telephone"></i>
                            <span>+91 96380 00461 / 62</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 contact-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>Surat, Gujarat - India</span>
                        </div>
                    </div>

                    <!-- Language & Social Icons Column -->
                    <div
                        class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0 d-flex flex-column align-items-lg-end align-items-start">
                        <!-- Social icons -->
                        <div class="d-flex gap-3 contact-item">
                            <a href="https://www.linkedin.com/company/rayzonsolar" class="social-icon"><i
                                    class="bi bi-linkedin fs-5"></i></a>
                            <a href="https://www.instagram.com/rayzon_solar" class="social-icon"><i
                                    class="bi bi-instagram fs-5"></i></a>
                            <a href="https://www.facebook.com/RayzonSolar/" class="social-icon"><i
                                    class="bi bi-facebook fs-5"></i></a>
                            <a href="https://www.youtube.com/@rayzon-solar" class="social-icon"><i
                                    class="bi bi-youtube fs-5"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <footer class="footer">
            <BContainer>
                <BRow>
                    <BCol col sm="6">
                        {{ new Date().getFullYear() }} © Rayzon.
                    </BCol>
                    <BCol col sm="6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Rayzon
                        </div>
                    </BCol>
                </BRow>
            </BContainer>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick, onUnmounted } from "vue";
import { Modal } from "bootstrap";
import FormSection from "./FormSection.vue";
import { router } from '@inertiajs/vue3';
import { BCol, BContainer, BRow } from "bootstrap-vue-next";

import bannerImage from '@assets/images/banner-image.png'

let loginModal = null;
const email = ref("");
const emailError = ref("");
const showOtpField = ref(false);
const submitted = ref(false);
const isLoading = ref(false);
const otp = ref(["", "", "", "", "", ""]);
let otpModal = null;

const textList = ["Generate", "Manage", "Download"];
const currentIndex = ref(0);
let timer = null;

// interval in ms
const DELAY = 2500;

onMounted(() => {
    timer = setInterval(() => {
        currentIndex.value = (currentIndex.value + 1) % textList.length;
    }, DELAY);
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});

onMounted(() => {
    const modalEl = document.getElementById("loginModal");
    loginModal = new Modal(modalEl, { backdrop: "static" });
});

function openLoginModal() {
    showOtpField.value = false;
    email.value = "";
    otp.value = ["", "", "", "", "", ""];
    loginModal.show();
}

function goToDashboard() {
    router.visit("/warranty-dashboard");
}

function sendOtp() {
    emailError.value = "";

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!email.value) {
        emailError.value = "Please enter your email address.";
        return;
    }

    if (!emailPattern.test(email.value)) {
        emailError.value = "Please enter a valid email address (e.g. name@gmail.com).";
        return;
    }

    // ✅ Passed validation
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        showOtpField.value = true;
    }, 1000);

}

function verifyLoginOtp() {
    const enteredOtp = otp.value.join("");
    if (enteredOtp.length < 6) {
        alert("Please enter all 6 digits of OTP.");
        return;
    }

    loginModal.hide();

    // ✅ Redirect to dashboard
    router.visit("/warranty-dashboard");
}

function resendLoginOtp() {
    alert(`OTP resent to ${email.value}`);
}

function handleLoginOtpInput(e, index) {
    const value = e.target.value;
    if (value && index < 5) {
        const nextInput = document.querySelector(`#otp-${index + 1}`);
        nextInput?.focus();
    }
    if (!value && index > 0 && e.inputType === "deleteContentBackward") {
        const prevInput = document.querySelector(`#otp-${index - 1}`);
        prevInput?.focus();
    }
}

const formData = ref({
    name: "",
    email: "",
    phone: "",
    address: "",
    city: "",
    state: "",
    pincode: "",
    purchaseDate: "",
    invoice: null,
    serial_no: "",
    invoice_no: "",
});

const formatCommaSeparated = () => {
    formData.serial_no = String(formData.serial_no)
        .replace(/\s+/g, ",")
        .replace(/,+/g, ",")
        .replace(/,\s*,/g, ",")
        .replace(/,\s*$/, "");
};


function handleFileChange(e) {
    const target = e.target;
    if (target.files?.[0]) {
        formData.value.invoice = target.files[0];
    }
}

onMounted(() => {
    const modalEl = document.getElementById("otpModal");
    otpModal = new Modal(modalEl, { backdrop: "static" });
});

function handleSubmit() {
    // Start loading
    isLoading.value = true;

    // Simulate OTP sending API
    setTimeout(() => {
        isLoading.value = false;
        showOtpModal();
    }, 1000);
}

function showOtpModal() {
    nextTick(() => {
        otpModal.show();
        // Clear previous OTP
        otp.value = ["", "", "", "", "", ""];
    });
}

function verifyOtp() {
    const enteredOtp = otp.value.join("");
    if (enteredOtp.length < 6) {
        alert("Please enter all 6 digits of OTP.");
        return;
    }

    alert(`OTP Verified Successfully: ${enteredOtp}`);
    otpModal.hide();

    // Proceed with actual form submission
    submitted.value = true;

    setTimeout(() => {
        submitted.value = false;
        Object.assign(formData.value, {
            name: "",
            email: "",
            phone: "",
            address: "",
            city: "",
            state: "",
            pincode: "",
            purchaseDate: "",
            invoice: null,
        });

        router.visit("/warranty-dashboard");
    }, 1000);
}

function resendOtp() {
    alert("OTP resent to your email.");
}

function handleOtpInput(e, index) {
    const value = e.target.value;
    if (value && index < 5) {
        const nextInput = document.querySelector(`#otp-${index + 1}`);
        nextInput?.focus();
    }
    if (!value && index > 0 && e.inputType === "deleteContentBackward") {
        const prevInput = document.querySelector(`#otp-${index - 1}`);
        prevInput?.focus();
    }
}

</script>