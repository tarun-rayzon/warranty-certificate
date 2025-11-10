<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    policy: String,
});
</script>

<script>
import { CheckCircleIcon } from "@zhuowenli/vue-feather-icons";

export default {
  components: {
    CheckCircleIcon
  },
};
</script>

<template>
    <Head title="Privacy Policy" />
    <BContainer>
        <BRow class="justify-content-center">
            <BCol col lg="10">
                <BCard no-body>
                    <div class="bg-warning-subtle position-relative">
                        <BCardBody class="p-5">
                            <div class="text-center">
                                <h3>Privacy Policy</h3>
                                <p class="mb-0 text-muted">Last update: 27 December, 2024</p>
                            </div>
                        </BCardBody>
                        <div class="shape">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="1440" height="60" preserveAspectRatio="none" viewBox="0 0 1440 60">
                                <g mask="url(&quot;#SvgjsMask1001&quot;)" fill="none">
                                    <path d="M 0,4 C 144,13 432,48 720,49 C 1008,50 1296,17 1440,9L1440 60L0 60z" style="fill: var(--vz-secondary-bg);"></path>
                                </g>
                                <defs>
                                    <mask id="SvgjsMask1001">
                                        <rect width="1440" height="60" fill="#ffffff"></rect>
                                    </mask>
                                </defs>
                            </svg>
                        </div>
                    </div>
                    <BCardBody class="p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <CheckCircleIcon class="text-success icon-dual-success icon-xs" />
                            </div>
                            <div class="flex-grow-1">
                                <h5>Privacy Policy for Rayzon CRM</h5>
                                <p class="text-muted">Rayzon Solar operates the CRM application accessible at Rayzon CRM. This Privacy Policy outlines how we collect, use, and protect your information when you use our Service. By using the Service, you agree to the practices described in this Privacy Policy.</p>
                                <p class="text-muted">If you have additional questions or require more information about our Privacy
                                    Policy, do not hesitate to contact us through email at Email@Website.com</p>
                                <p class="text-muted">This privacy policy applies only to our online activities and is valid for
                                    users of our CRM with regards to the information that they shared and/or collect in Rayzon CRM. This policy is not applicable to any information collected offline or via channels other than
                                    this CRM.</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <CheckCircleIcon class="text-success icon-dual-success icon-xs" />
                            </div>
                            <div class="flex-grow-1">
                                <h5>How we use your information</h5>
                                <p class="text-muted">If you contact us directly, we may receive additional information about you such
                                    as your name, email address, phone number, the contents of the message and/or attachments you may send
                                    us, and any other information you may choose to provide.</p>
                                <p class="text-muted">Communicate with you, either directly or through one of our partners, including
                                    for customer service, to provide you with updates and other information relating to the website, and
                                    for marketing and promotional purposes.</p>
                                <p class="text-muted">We use the information we collect in various ways, including to:</p>
                                <ul class="text-muted">
                                    <li>
                                        <p>To provide, operate, and maintain the Service.</p>
                                    </li>
                                    <li>
                                        <p>To improve user experience and customize features.</p>
                                    </li>
                                    <li>
                                        <p>To facilitate communication with users regarding account updates, Service changes, or security alerts.</p>
                                    </li>
                                    <li>
                                        <p>To analyze and monitor usage trends and system performance.</p>
                                    </li>
                                    <li>
                                        <p>To ensure compliance with legal and regulatory requirements.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <CheckCircleIcon class="text-success icon-dual-success icon-xs" />
                            </div>
                            <div class="flex-grow-1">
                                <h5>Data Security</h5>
                                <p class="text-muted">We implement industry-standard security measures to protect your data from unauthorized access, alteration, disclosure, or destruction. Despite these efforts, no system can guarantee absolute security. Users are responsible for maintaining the confidentiality of their login credentials.</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <CheckCircleIcon class="text-success icon-dual-success icon-xs" />
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted">We retain your data only for as long as necessary to fulfill the purposes outlined in this Privacy Policy or comply with legal obligations.</p>
                                <p class="text-muted"><b>We may update this Privacy Policy from time to time. Any changes will be posted on this page, and the "Effective Date" will be updated accordingly. We encourage you to review this Privacy Policy periodically.</b></p>
                            </div>
                        </div>


                        <div class="text-end">
                            <BLink href="#!" class="btn btn-danger">I'm Understand</BLink>
                        </div>
                    </BCardBody>
                </BCard>
            </BCol>
        </BRow>
    </BContainer>
</template>
