<!doctype html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #1a1a1a;
            font-size: 11.5px;
        }

        @page {
            margin: 0;
        }

        .page {
            page-break-after: always;
            padding: 18px;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .page-border-outer {
            border: 2px solid #095763;
            height: 100%;
            width: 100%;
            padding: 6px;
        }

        .page-border-inner {
            border: 1px solid #c4c4c4;
            height: 100%;
            width: 100%;
            padding: 20px 24px 26px 24px;
            position: relative;
        }

        .content-wrap {
            position: relative;
            z-index: 2;
        }

        /* NEW — Watermark lowered + softer */
        .watermark {
            position: absolute;
            top: 65%;
            left: 20%;
            width: 55%;
            transform: translate(-50%, -50%);
            opacity: 0.055;
            z-index: 1;
            text-align: center;
        }

        .watermark img {
            max-width: 100%;
        }

        /* HEADER */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 14px;
        }

        .header-left,
        .header-right {
            display: table-cell;
            vertical-align: middle;
        }

        .header-left img {
            height: 38px;
        }

        .header-right {
            text-align: right;
            font-size: 10px;
            color: #555;
        }

        .header-right strong {
            font-size: 11px;
        }

        .top-divider {
            border-bottom: 1px solid #e0e0e0;
            margin-top: 6px;
            margin-bottom: 12px;
        }

        /* TITLE & META */
        .title-block {
            text-align: center;
            margin-bottom: 12px;
        }

        .certificate-title {
            font-size: 20px;
            font-weight: 700;
            color: #095763;
            letter-spacing: 1px;
        }

        .certificate-sub {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }

        .certificate-meta {
            margin-top: 10px;
        }

        .certificate-box {
            display: inline-block;
            padding: 5px 12px;
            border: 1px solid #333;
            border-radius: 3px;
            margin-bottom: 4px;
        }

        /* SECTIONS */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            margin-top: 18px;
            margin-bottom: 6px;
            border-left: 4px solid #095763;
            padding-left: 8px;
        }

        .info-row {
            width: 100%;
            display: table;
        }

        .info-col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding-right: 10px;
        }

        .info-col:last-child {
            padding-right: 0;
        }

        .info-box {
            border: 1px solid #c7c7c7;
            background: #f5f5f5;
            padding: 10px;
            border-radius: 3px;
            font-size: 11.5px;
            line-height: 1.55;
        }

        .small-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #777;
            letter-spacing: 0.5px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 11.5px;
        }

        th {
            background: #e9e9e9;
            padding: 7px;
            border: 1px solid #a8a8a8;
            font-weight: 600;
        }

        td {
            padding: 7px;
            border: 1px solid #a8a8a8;
        }

        /* MODEL MATRIX */
        .model-matrix {
            margin-top: 14px;
            font-size: 11.5px;
        }

        .model-matrix ul {
            margin-top: 6px;
            padding-left: 18px;
        }

        .model-matrix li {
            margin-bottom: 5px;
        }

        .footer-note {
            margin-top: 14px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }

        /* PAGE LABEL */
        .page-label {
            position: absolute;
            bottom: 6px;
            left: 24px;
            font-size: 9px;
            color: #999;
        }

        /* ===== PAGE 2 (TERMS) ===== */

        .terms-title-block {
            text-align: center;
            margin-bottom: 16px;
        }

        .terms-main-title {
            font-size: 16px;
            font-weight: 700;
            color: #095763;
        }

        .terms-subtitle {
            font-size: 11px;
            color: #666;
        }

        .terms-section {
            margin-top: 14px;
        }

        .terms-heading {
            font-size: 12.5px;
            font-weight: 700;
            color: #095763;
            margin-bottom: 6px;
        }

        .terms-paragraph {
            font-size: 11.5px;
            line-height: 1.55;
            margin-bottom: 6px;
            text-align: justify;
        }

        .terms-list {
            margin: 4px 0 6px 18px;
        }

        .terms-list li {
            margin-bottom: 4px;
        }

        /* ===== NEW — ANNEXURE QR (CENTER PAGE) ===== */

        .qr-center-wrapper {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .qr-box {
            width: 110px;
            height: 110px;
            border: 1px solid #999;
            margin: 0 auto 6px auto;
            display: table;
        }

        .qr-inner {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            font-size: 10px;
            color: #999;
        }

        .qr-label {
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- ================= PAGE 1 ================= -->
    <div class="page">
        <div class="page-border-outer">
            <div class="page-border-inner">

                <!-- Watermark -->
                <div class="watermark">
                    <img src="{{ $logoBase64 }}" alt="watermark">
                </div>

                <div class="content-wrap">

                    <!-- Header -->
                    <div class="header">
                        <div class="header-left">
                            <img src="{{ $logoBase64 }}">
                        </div>
                        <div class="header-right">
                            <strong>Rayzon Solar Private Limited</strong><br>
                            Warranty Certificate – PV Modules
                        </div>
                    </div>
                    <div class="top-divider"></div>

                    <!-- Title -->
                    <div class="title-block">
                        <div class="certificate-title">WARRANTY CERTIFICATE</div>
                        <div class="certificate-sub">Photovoltaic Module Product & Performance Warranty</div>

                        <div class="certificate-meta">
                            <div class="certificate-box">
                                Certificate No: {{ $certificateNo ?? 'N/A' }}
                            </div>
                            <div>Issued: {{ $issuedAt ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Customer & Purchase Info -->
                    <div class="info-row">
                        <div class="info-col">
                            <div class="section-title">Customer Details</div>
                            <div class="info-box">
                                <div class="small-label">Name</div>
                                {{ $req->customer->name }}<br><br>

                                <div class="small-label">Email</div>
                                {{ $req->customer->email }}<br><br>

                                <div class="small-label">Address</div>
                                {{ $req->customer->address }},
                                {{ $req->customer->city }},
                                {{ $req->customer->state }} -
                                {{ $req->customer->pincode }}
                            </div>
                        </div>

                        <div class="info-col">
                            <div class="section-title">Purchase Information</div>
                            <div class="info-box">
                                <div class="small-label">Invoice No.</div>
                                {{ $req->invoice_no }}<br><br>

                                <div class="small-label">Purchase Date</div>
                                {{ \Carbon\Carbon::parse($req->purchase_date)->format('d-m-Y') }}<br><br>

                                <div class="small-label">Module Model</div>
                                {{ $moduleModel ?? 'N/A' }}<br><br>

                                <div class="small-label">Number of Modules</div>
                                {{ $req->items->count() }}
                            </div>
                        </div>
                    </div>

                    <!-- Serial Table -->
                    <div class="section-title">Module Serial Numbers</div>
                    <table>
                        <thead>
                            <tr>
                                <th width="45">#</th>
                                <th>Serial Number</th>
                                <th width="110">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($req->items as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->serial }}</td>
                                    <td>Covered</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Model Matrix -->
                    <div class="model-matrix">
                        <strong>Model-wise Warranty Terms:</strong>
                        <ul>
                            <li>RSB540WC / 545WC / 550WC / 555WC — Linear 30 yrs (2% 1st yr, 0.6% thereafter), 12 yrs
                                product warranty.</li>
                            <li>RSG540WC / 545WC / 550WC — Linear 30 yrs (2% 1st yr, 0.45% thereafter), 15 yrs product
                                warranty.</li>
                            <li>RS540WC / 545WC / 550WC — Linear 30 yrs (2% 1st yr, 0.6% thereafter), 12 yrs product
                                warranty.</li>
                            <li>RS560144TGC / RS580144TGC / RS585144TGC — Linear 30 yrs (1% 1st yr, 0.4% thereafter), 15
                                yrs product warranty.</li>
                        </ul>
                    </div>

                    <div class="footer-note">
                        This certificate is digitally generated and does not require a physical signature.
                    </div>
                </div>

                <div class="page-label">Page 1 of 2</div>

            </div>
        </div>
    </div>

    <!-- ================= PAGE 2 (TERMS + ANNEXURE QR) ================= -->
    <div class="page">
        <div class="page-border-outer">
            <div class="page-border-inner">

                <!-- Watermark -->
                <div class="watermark">
                    <img src="{{ $logoBase64 }}" alt="watermark">
                </div>

                <div class="content-wrap">

                    <div class="terms-title-block">
                        <div class="terms-main-title">WARRANTY TERMS & CONDITIONS</div>
                        <div class="terms-subtitle">Applicable to Photovoltaic Modules Supplied by Rayzon Solar Pvt.
                            Ltd.</div>
                    </div>

                    <!-- TERMS HERE (SHORTEND FOR DEMO — USE YOUR FULL TEXT) -->
                    <div class="terms-section">
                        <div class="terms-heading">1. LIMITED PRODUCT WARRANTY</div>
                        <p class="terms-paragraph">
                            Subject to the exclusions contained below, Rayzon Solar Private Limited ("Rayzon") warrants
                            to the buyer (the "Buyer") that the module shall be free from defects in materials and
                            workmanship that have an effect on module functionality under normal application,
                            installation, use and service conditions as specified in Rayzon's standard product
                            documentation. Rayzon warrants following Product Warranty period:
                        </p>
                        <ul>
                            <li>TOPCon Bifacial (Dual Glass) -15 Years</li>
                            <li>TOPCon Bifacial (Transparent Backsheet) -12 Years</li>
                            <li>TOPCon Monofacial -12 Years</li>
                            <li>L'Lios Bifacial (Dual Glass) -15 Years</li>
                            <li>L'Lios Bifacial (Transparent Backsheet) -12 Years</li>
                            <li>L'Lios Monofacial -12 Years</li>
                            <li>Sparkle series -10 Years</li>
                            <li>Elena series -5 Years</li>
                            <li>Fusion series - 5 Years</li>
                        </ul>
                        <p class="terms-paragraph">
                            Rayzon warrants that the module will maintain the mechanical integrity and stability in
                            accordance with approved operation methods described in Rayzon's installation manual and its
                            annexes; the glass of the module will maintain its integrity provided there are no
                            indications of
                            localized impacts or external forces; and the cable and connector plug of the module will
                            remain safe and operational provided the module is professionally installed. Any damage
                            caused by abrasion, improper installation, artificial damage or animals are excluded from
                            this warranty. The list of defects covered under the Limited Product Warranty is given in
                            Annexure-1.
                        </p>
                        <p class="terms-paragraph">
                            Claims under this warranty will only be accepted if the Buyer can provide proof that the
                            malfunctioning or nonconformity of the module results exclusively from defects in materials
                            and/or workmanship under normal application, installation, use and service conditions
                            specified in
                            Rayzon's standard product documentation.
                        </p>
                        <p class="terms-paragraph">
                            Any color change of the module or any other changes in module appearance do not represent
                            defects, insofar as the change in appearance does not stem from defects in material and/or
                            workmanship, and does not cause degradation of functionality of the module.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">2. PERFORMANCE WARRANTY</div>
                        <p class="terms-paragraph">
                            Rayzon Solar warrants the following Performance Warranty terms,
                            provided the modules are installed as per the Installation Manual and
                            the usage terms defined in clause 3.
                        </p>
                        <p class="terms-paragraph">
                            <strong>For Polycrystalline Modules:</strong>
                            1st year power degradation (including LID): 2.5%
                            Linear power degradation rate from year 2 to year 27 : 0.67 %/year
                        </p>
                        <p class="terms-paragraph">
                            <strong>For Monocrystalline Modules:</strong>
                            1st year power degradation (including LID): 2%
                            Linear power degradation rate from year 2 to year 30 : 0.67 %/year
                        </p>
                        <p class="terms-paragraph">
                            <strong>For Mono PERC modules (Monofacial)</strong>
                            1st year power degradation (including LID): 2%
                            Linear power degradation rate from year 2 to year 30: 0.6 %/year
                        </p>

                        <p class="terms-paragraph">
                            <strong>For Mono PERC modules (Bifacial with transparent Backsheet)</strong>
                            1st year power degradation (including LID): 2%
                            Linear power degradation rate from year 2 to year 30: 0.6 %/year
                        </p>

                        <p class="terms-paragraph">
                            <strong>For Mono PERC modules (Bifacial with Dual Glass)</strong>
                            1st year power degradation (including LID): 2%
                            Linear power degradation rate from year 2 to year 30: 0.45 %/year
                        </p>

                        <p class="terms-paragraph">
                            <strong>For TOPCon modules (Bifacial with Dual Glass)</strong>
                            1st year power degradation (including LID): 1%
                            Linear power degradation rate from year 2 to year 30: 0.4 %/year
                        </p>

                        <p class="terms-paragraph">
                            The actual power output of the module shall be determined for
                            verification at Standard Test Condition (Temperature: 25 °C, irradiance:
                            1000 W/sq. m, Air mass: AM1.5G) only. The actual power measurement
                            is either carried out by Rayzon facility or by a Rayzon recognised third-
                            party testing institute. Testing equipment uncertainty will be applied to
                            all actual power output measurements.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">3. MODULE APPLICATION AREA</div>
                        <p class="terms-paragraph">Rayzon Solar has restricted the use of certain types of modules in
                            some application zones considering the performance and durability
                            of the modules (as indicated below), and Rayzon Solar warranty is not
                            valid if modules are installed in these areas without following the
                            guidelines. (i) Only modules with dual glass structure (no backsheet)
                            can be installed on water surface floating systems or in areas having
                            continuous high humidity exceeding 8596 RH. (ii) Modules should not
                            be installed in areas having continuous high ambient temperature
                            exceeding 50 deg. C. (iii) Modules should not be installed within 5
                            meters of chimney exhaust hood. (iv) Modules should not be installed
                            on mobile platforms (except photovoltaic tracker systems) like
                            vehicles or ships. (v) In areas having heavy snowfall, the mounting
                            structure should be designed such that the snow does not accumulate
                            unevenly on the panels (max. allowable uniform snow load is 3600
                            Pa).</p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">4. WARRANTY EFFECTIVE DATE</div>
                        <p class="terms-paragraph">The warranty effective date shall be defined as the Invoice date,
                            installation date or ninety (90) days after the delivery by Rayzon,
                            whichever date is earlier.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">5. EXCEPTIONS</div>
                        <p class="terms-paragraph">The limited warranties (product warranty and power warranty) set
                            forth herein DO NOT apply to any module which has beensubjected
                            to: <br><br>

                            i) negligence in transportation, handling, storage or use <br>

                            ii) tampering, or repaired without the prior written consent of Rayzon
                            Solar or otherwise inconsistent with Rayzon’s written instructions <br>

                            iii) removed from original location of installation and re-installed at a
                            different site without written consent of Rayzon Solar <br>

                            iv) extraordinary salt or chemical exposure <br>

                            v) improper system design leading to continuous shading on the panels <br>

                            vi) exposed to high voltage exceeding the allowable system voltage (at the lowest
                            temperature of the location), or power surges <br>

                            vii) improper installation, application, alteration, or unauthorized service <br>

                            viii) defective components in the structure on which the module is mounted <br>

                            ix) pest damage, flood, fire, direct or indirect lightning strikes, or force majeure <br>

                            x) installation in off-shore or marine applications, having direct exposure to saltwater
                            (like on piers or boats) <br>

                            xi) Exposure to mild discoloration or similar external effects <br>

                            xii) accidental breakage, vandalism, explosions, acts of war, orother events outside of
                            Rayzon’s control <br>

                            xiii} Non-compliance with instructions in the Installation Manual <br>

                            xiv) Design and installation by agencies not complying to the relevant IEC standards (IEC
                            63049, IECTS 62738, IEC63049 and IEC62446-1). <br>

                            xv) Failure to meet the agreed commercial terms with Rayzon Solar <br>

                            xvi) Failureto provide proof of purchase or product information In addition, the limited
                            product warranty does not apply to any cosmetic change in appearance stemming from the normal wear and tear over time of product
                            materials. Further, any power loss due to cracks in the solar cells developed due to negligence during the transportation,
                            installation or operation & maintenance of the solar panels is not covered under Rayzon warranty. Also refer to the list of defects covered under
                            the Limited Product Warranty (Annexure-1). <br>

                            xvii) Damages due to 2nd point delivery / modules shifted to another vehicle
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">6. REMEDIES</div>
                        <p class="terms-paragraph">
                            If the product fails to conform to the warranties set forth above, Rayzon Solar, at its sole
                            discretion, will undertake any one of the
                            following options: <br>
                            i) repair the product, or <br>
                            ii) replace the product, or <br>
                            iii) provide additional modules to make up the total wattage loss, or <br>
                            iv) provide an appropriate salvage value of the defective product(s) as compensation.
                            For options (iii) & (iv) above, the Wattage loss and salvage value shall be calculated based
                            on the front-side power rating as per the following formulae: <br>
                            Wattage Loss =S1-S2 <br>
                            Where, <br>
                            $1 = Sum of the remaining theoretical power of defective modules as per warranty terms (in
                            Watt) <br>
                            $2 = Sum of the actual power measured at STC condition, of the defective modules (in Watt) <br>
                            Salvage value = MP x NPxR/L <br>
                            Where, <br>
                            MP = market price at the time of payout (price of same technology module per Watt-peak) <br>
                            NP = original guaranteed nameplate power (based on front-side illumination) <br>
                            R=remaining warranty period <br>
                            L= total warranty period
                        </p>
                        <p class="terms-paragraph">
                            All remedies shall be based upon the warranted power output of the
                            module at the reporting time of the warranty claim. Rayzon shall cover
                            reasonable transportation costs for returning the affected product to
                            Rayzon and shipping the additional, repaired or replaced product to
                            the Buyer.
                        </p>
                        <p class="terms-paragraph">
                            If Rayzon adopts repair as the remedy, Rayzon shall cover reasonable
                            material and labor costs related to the repair. The costs and expenses
                            for the removal, installation or reinstallation of the module shall
                            remain with the Buyer.
                        </p>
                        <p class="terms-paragraph">
                            Any repair or replacement of an affected product shall not increase
                            the applicable warranty period. The warranty period for replaced or
                            repaired product is the remainder of the warranty for the affected
                            product.
                        </p>
                        <p class="terms-paragraph">
                            Rayzon reserves the right to deliver a similar product (of similarsize,
                            color, shape, and/or power output) in replacement of the returned
                            product should the production of the returned model be discontinued
                            or is otherwise unavailable. Ownership of all products which have
                            been replaced is passed to Rayzon.
                        </p>
                        <p class="terms-paragraph">
                            Defective Products or end of lifetime Products shall be disposed off by
                            the buyer (if legally permissible) accordance with local applicable laws
                            or regulations, unless Rayzon Solar agrees or where legally mandatory
                            takes them back. If Rayzon Solar decides or where legallymandatory
                            takes the defective products back, the goods property of these
                            products shall belong to Rayzon Solar without any limitation.
                        </p>
                        <p class="terms-paragraph">
                            EXCEPT AS OTHERWISE PROVIDED BY APPLICABLE LAW, THE
                            FOREGOING REMEDIES STATE RAYZON SOLAR PRIVATE LIMITED'S
                            SOLE AND EXCLUSIVE OBLIGATION AND THE BUYER'S SOLE AND
                            EXCLUSIVE REMEDY FOR A BREACH OF THE FOREGOING LIMITED
                            WARRANTY.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">7. CLAIM PROCESS</div>
                        <p class="terms-paragraph">If the Buyer believes that it has a justified claim covered by the
                            limited
                            warranties set forth above, then the Buyer shall submit such claim
                            including but not limited to the claimed quantity, serial numbers,
                            purchasing invoices and proofs (including photos of theinstallation,cleaning and maintenance
                            records, and generation data of at least 1
                            year or since the installation date if installed within 1 year) in writing
                            to Rayzon within the applicable warranty period specified above to
                            the following address, or such future address as Rayzon may provide
                            from time to time:
                        </p>
                        <address>
                            RAYZON SOLAR PRIVATE LIMITED <br>
                            Block No. 105, B/H Aron Pipes, B/H Hariya Talav, Kim Mandvi Road, <br>
                            Karanj, Surat-394110, Gujarat, India. <br>
                            Email: <a href="mailto:info@rayzonenergies.com">info@rayzonenergies.com</a>
                        </address>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">8. WARRANTY ASSIGNMENT</div>
                        <p class="terms-paragraph">For modules received at site in broken condition, following details
                            are to be submitted by the buyer to Rayzon Solar before installation of
                            panels at site (otherwise warranty claim cannot be processed):
                        </p>

                        <p class="terms-paragraph">
                            (i) Unloading Video: A complete, uninterrupted video of the unloading
                            process, from unstrapping to unloading the pallet.
                        </p>

                        <p class="terms-paragraph">
                            (ii) Full Image of the damaged Module: A clear photo (or video) of the
                            broken module, highlighting the area where the breakage occurred.
                        </p>

                        <p class="terms-paragraph">
                            iii) Position on the Pallet: Details about the exact position of the
                            broken module on the pallet.
                        </p>

                        <p class="terms-paragraph">
                            (iv) Pallet Number: The pallet number for proper tracking and
                            reference.
                        </p>

                        <p class="terms-paragraph">
                            (v) Unpacking Video: The video showing the process of unpacking the
                            broken pallet.
                        </p>

                        <p class="terms-paragraph">
                            (vi) Pallet Position on the Vehicle: Information on the position of the
                            pallet on the vehicle (e.g., front, middle, or rear section).
                        </p>

                        <p class="terms-paragraph">
                            Rayzon Solar does not entertain warranty claims for broken glass
                            modules after the modules have been installed (unless it is a case of
                            spontaneous glass breakage).
                        </p>

                        <p class="terms-paragraph">
                            It is recommended that a short installation video should be made by the buyer/installer and
                            sent to Rayzon Solar for future reference.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">9. SAFETY AMD INSTALLATION INSTRUCTIONS</div>
                        <p class="terms-paragraph">
                            The installation and handling of PV modules requires professional skills and should only be
                            performed by qualified professionals. Please read the safety and installation instructions
                            before using modules.
                        </p>

                        <p class="terms-paragraph">
                            To the maximum level permitted by the law applicable, Rayzon
                            shall have no responsibility or liability at all for damage or injury to
                            person or property for any other type of loss or injury, results from
                            any cause whatsoever arising out of related to any module including.
                            any type of defect in solar module, including without laminations,
                            during using or installation of Solar module. To the maximum
                            extent permitted by applicable law, under no circumstances shall
                            Rayzon be liable for incidental, consequential or special damages,
                            howsoever caused, even if Rayzon has been advised of or
                            reasonably could have foreseen such damages. Loss of use, loss of
                            profits, loss of production and loss of revenues are hereby
                            specifically, and without limitation, excluded to the maximum
                            extent permitted by applicable law. Notwithstanding anything
                            contained elsewhere in this document, Rayzon’s aggregate liability,
                            if any, for damages or otherwise shall not exceed the amount paid
                            by the customer for the module that gave rise to the warranty
                            claim.
                        </p>

                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">10. DISPUTE RESOLUTION</div>
                        <p class="terms-paragraph">
                            In case any dispute related to warranty claims, shall be referred to and
                            finally resolved pursuant to the governing law clauses and dispute
                            finally resolved pursuant to the governing law clauses and dispute
                            resolution procedures under the purchase agreement between the Buyer
                            and Rayzon.
                        </p>

                        <p class="terms-paragraph">
                            Any dispute on technical facts relating to claims brought under this
                            Limited Warranty for defects of Products shall be determined by
                            expert determination. Rayzon Solar and the Buyer will, at the Buyer's
                            or Rayzon Solar's request, appoint as independent expert and
                            appraiser a reputable researcher from a Rayzon recognised NABL
                            accredited third-part testing laboratory (like Mitsui Chemicals Testing
                            Laboratory, Ahmedabad, or UL India testing laboratory, Bangalore, or
                            Hi Physix Testing Laboratory, Maharashtra), and so on ("Technical
                            Expert"). The determination by such Technical Expert shall be final, onclusive, binding and
                            enforceable in any proceeding brought hereunder. The Technical Expert shall (i) act as an
                            expert; (ii) allow the parties a reasonable opportunity to make representations and
                            counter-representations; (iii) take those representations and counter-representations into
                            account; and (iv) if required by either party give
                            written reasons for his orher determination.
                        </p>

                        <p class="terms-paragraph">
                            The packaging and transportation of the solar panels to the test laboratory and associated
                            testing charges shall be in the scope of the Buyer.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">11. NOT INDEPENDENT WARRANTIES</div>
                        <p class="terms-paragraph">
                            The Buyer has the right to pursue claims under each of the warranties
                            set forth above; provided that if claims arise under multiple limited
                            warranties from a single incident, then if Rayzon remedies such
                            incidents as set forth above, Rayzon shall be deemed to have resolved
                            all applicable warranty claims arising from such an incident.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">12. DISCLAIMERS</div>
                        <p class="terms-paragraph">
                            The limited warranties set forth herein are in lieu of and exclude all
                            other express or implied warranties, including but not limited to
                            warranties of merchantability and fitness for a particular purpose or
                            application, and all other obligations on the part of Rayzon unless such
                            other warranties and obligations are agreed to in writing by Rayzon.
                            Some jurisdictions limit or do not permit disclaimers of warranty, so
                            this provision may not apply to the buyer.
                        </p>
                    </div>

                    <div class="terms-section">
                        <div class="terms-heading">13. LIMITATION OF LIABILITY</div>
                        <p class="terms-paragraph">
                            To the maximum extent permitted by applicable law,
                            Rayzon hereby disclaims, and shall have no responsibility
                            or liability whatsoever for, damage or injury to persons or
                            property or for other loss or injury resulting from any cause
                            whatsoever arising out of or related to any of its products
                            or their use. To the maximum extent permitted by
                            applicable law, under no circumstances shall Rayzon be
                            liable to the buyer, or to any third party claiming through
                            or under the buyer, for any lost profits, loss of use, or
                            equipment downtime, or for any incidental, consequential
                            or special damages of any kind, howsoever arising, related
                            to the products, even if Rayzon has been advised of the
                            possibility of such damages. To the maximum extent
                            permitted by applicable law, Rayzon's aggregate liability, if
                            any, in damages or otherwise, shall not exceed the
                            purchase price paid to Rayzon by the buyer for the product
                            in the case of a warranty claim. The buyer acknowledges
                            that the foregoing limitations on liability are an essential
                            element of the agreement between the parties and that in
                            the absence of such limitations the purchase price of the
                            products would be substantially different. Some
                            jurisdictions limit or do not permit disclaimers of liability,
                            so this provision may not apply to the buyer. Some
                            jurisdictions do not allow limitations on the exclusion of
                            damages so the above limitations or exclusions may not
                            apply to the buyer. You may have specific legal rights
                            outside this warranty, and you may also have other rights
                            that vary from state to state or country to country. This
                            limited warranty does not affect any additional rights you
                            have under laws in your jurisdiction governing the sale of
                            consumer goods. Some states or countries do not allow the
                            exclusion or limitation of incidential or consequential
                            damages, so the limitations or exclusions in this limited
                            warranty statement may not apply.
                        </p>
                    </div>

                    <!-- ======= CENTER QR (Option A Box Style) ======= -->
                    <div class="qr-center-wrapper">
                        <div class="qr-box">
                            <div class="qr-inner">
                                ANNEXURE<br>QR
                            </div>
                        </div>
                        <div class="qr-label">Annexure QR (Demo)</div>
                    </div>

                </div>

                <div class="page-label">Page 2 of 2</div>

            </div>
        </div>
    </div>

</body>

</html>
