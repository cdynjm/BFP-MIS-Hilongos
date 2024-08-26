<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Safety Evaluation Clearance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;

        }

        .certificate {
            width: 800px;
            margin: 3px auto;
            padding: 40px;

            background-color: #fff;
            border: 1px solid #000;
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .certificate-outside {
            width: 888px;
            margin: auto;
            background-color: #fff;
            border: 3px solid #000;
            position: relative;
        }

        .header {
            text-align: center;
            position: relative;
            margin-bottom: 20px;
        }

        .header img.logo-left,
        .header img.logo-right {
            width: 90px;
            position: absolute;
            top: 0;
        }

        .header img.logo-left {
            left: 0;
        }

        .header img.logo-right {
            right: 0;
        }

        .header h1,
        .header h2,
        .header h3,
        .header h4 {
            margin: 2px 0;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 16px;
            font-weight: bold;
        }

        .header h3 {
            font-size: 14px;
            font-weight: normal;
        }

        .header h4 {
            font-size: 14px;
            font-weight: normal;
        }

        .fsic-number {
            text-align: left;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }

        .fsic-number .fsic-red {
            color: red;
        }

        .certificate-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .certificate-title .sub-title {
            font-size: 14px;
            margin-top: 5px;
        }

        .content {
            font-size: 14px;
            line-height: 1.5;
            text-align: justify;
            margin-top: 10px;
        }

        .content .underline {
            text-decoration: underline;
        }

        .content .bold {
            font-weight: bold;
        }

        .content .highlight {
            color: red;
            font-weight: bold;
        }

        .blank-field {
            display: inline-block;
            border-bottom: 2px solid #000;
            width: auto;
            padding: 0 5px;
            margin-right: 5px;
        }

        .description-section {
            margin: 20px 0;
            font-size: 14px;
        }

        .fees-approval {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
        }

        .fees-approval .fees,
        .fees-approval .approval {
            width: 48%;
        }

        .signature-section {
            margin-top: 20px;
        }

        .signature-section .signatures {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .signature-section .signatures .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-section .signatures .signature-box .name {
            display: inline-block;
            border-bottom: 1px solid #000;
            padding: 5px;
            width: 80%;
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .footer .main-concern {
            font-size: 14px;
            font-weight: bold;
            color: navy;
        }

        .footer .warning {
            font-size: 12px;
            color: red;
            margin-top: 5px;
            text-transform: uppercase;
        }

        .footer .bfp-copy {
            font-size: 12px;
            color: black;
            margin-top: 5px;
            text-align: left;
        }

        .styled-box {
            box-shadow: 2px 2px 10px gray;
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #000;
            border-radius: 8px;
            background: repeating-linear-gradient(45deg,
                    #d2a3de,
                    #f0f0f0 10px,
                    #c695d0 10px,
                    #e0e0e0 20px);
            position: relative;
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-shadow: 1px 1px 2px #000;
            color: #000;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
        $copy = [];
        $copy[0] = 'BFP COPY';
        $copy[1] = "Applicant/Owner's COPY";
        $copy[2] = "OBO/BPLO's COPY";
    @endphp

    @if (Auth::user()->role != 3)
        @for ($i = 0; $i <= 2; $i++)
            <div class="page-break">
                <div class="certificate-outside">
                    <div class="certificate">
                        <div class="header">
                            <img class="logo-left"
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Department_of_the_Interior_and_Local_Government_%28DILG%29_Seal_-_Logo.svg/480px-Department_of_the_Interior_and_Local_Government_%28DILG%29_Seal_-_Logo.svg.png"
                                alt="DILG Logo">
                            <img class="logo-right"
                                src="https://upload.wikimedia.org/wikipedia/commons/4/42/Bureau_of_Fire_Protection.png"
                                alt="BFP Logo">
                            <p style="margin-bottom: 5px;">Republic of the Philippines</p>
                            <h2 style="margin-top: 5px;">Department of the Interior and Local Government</h2>
                            <h1 style="font-size: 22px; color: rgb(2, 2, 92);">BUREAU OF FIRE PROTECTION</h1>
                            <p style="margin: 0">Region VIII</p>
                            <h3 style="font-weight: bold; font-size: 16px;">Province of Leyte</h3>
                            <h3>Hilongos Fire Station</h3>
                            <h4>Capt. Vilbar St., Hilongos, Leyte</h4>
                            <h4>Mobile Number: 09263678055</h4>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="fsic-number" style="color: red; font-size: 18px;">
                                FSEC NO. <span class="fsic-red"><input type="text"
                                        style="font-size: 18px; border: none; border-bottom: 3px solid black; text-align: center; color: red; font-weight: bold; background: transparent"
                                        value="{{ $fi->FSECNumber }}" disabled></span>
                            </div>
                            <div style="color: red; font-size: 18px;">
                                <input type="text"
                                    style="font-size: 15px; border: none; border-bottom: 3px solid black; text-align: center; font-weight: bold; background: transparent"
                                    value="{{ date('d-M-Y', strtotime($fi->dateFSEC)) }}" disabled>
                                <br>
                                <center style="color: black; font-size: 15px;">Date</center>
                            </div>
                        </div>



                        <div class="certificate-title" style="color: rgb(2, 2, 92);">
                            <h2>FIRE SAFETY EVALUATION CLEARANCE</h2>
                        </div>

                        <div class="content">
                            <h4>TO WHOM IT MAY CONCERN:</h4>
                            <p style="text-align: justify; font-size: 17px;"><span style="margin-left: 50px;">By virtue
                                    of the provisions of RA 9514 otherwise known as the Fire Code of the Philippines of
                                    2008,</span>
                                the application for <span style="font-weight: bold;">FIRE SAFETY EVALUATION
                                    CLEARANCE</span>
                                <span class="blank-field"
                                    style="font-weight: bold; width: 100%; text-align: center;">{{ strtoupper($fi->buildingName) }}</span>
                                <br><span class="blank-field"
                                    style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                        of Building/Structure/Facility)</i></span> <br>
                                to be constructed/ renovated/ altered/ modified/ change of occupancy located at
                                <span class="blank-field"
                                    style="font-weight: bold; text-align: center; width: 100%;">{{ strtoupper($fi->address) }}</span>
                                <span class="blank-field"
                                    style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Address)</i></span>
                                owned by
                                <span class="blank-field"
                                    style="width: 60%; text-align: center;"><b>{{ strtoupper($fi->owner) }}</b></span>
                                is hereby <b>GRANTED</b>
                                <span class="blank-field"
                                    style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                        of Owner/Representative)</i></span>


                                after the building plans and other documents conform to the fire safety and life safety
                                requirements of the Fire Code of the Philippines of 2008 and its Revised Implementing
                                Rules and regulations and that the recommendations in the Fire Safety Checklist (FSC)
                                will be adopted
                            </p>
                        </div>



                        <div class="content">
                            <p style="font-size: 17px; text-align: justify;">
                                <span style="margin-left: 50px;"> Violation of Fire Code provisions shall cause this
                                    certificate null and void after appropriate</span>
                                proceeding and shall hold the owner liable to the penalties provided for by the Fire
                                Code.
                            </p>
                        </div>
                        <div class="fees-approval">
                            <div class="fees">
                                <p><span class="bold" style="font-weight: bold;">Fire Code Fees: </span></p>
                                <p><span class="bold">Amount Paid:</span> <b><span class="blank-field"
                                            style="width: 50%; text-align: right;">₱
                                            {{ number_format($fi->amountPaid, 2) }}</span></b></p>
                                <p><span class="bold">O.R. Number:</span> <span class="blank-field"
                                        style="width: 50%; text-align: right;"><b>{{ $fi->ORNumber }}</b></span></p>
                                <p><span class="bold">Date:</span> <span class="blank-field"
                                        style="width: 68%; text-align: right;"><b>{{ date('F d, Y', strtotime($fi->dateOR)) }}</b></span>
                                </p>
                            </div>
                            <div class="approval" style="margin-left: 150px;">
                                <p style="margin-bottom: 30px;"><span class="bold"
                                        style="font-weight: bold;">RECOMMEND APPROVAL: </span></p>
                                <p><span class="blank-field"
                                        style="width: 80%; text-align: center; font-weight: bold;">{{ strtoupper($fi->recommendApproval) }}</span>
                                </p>
                                <div style="margin-left: 80px;">{{ strtoupper($fi->recommendPosition) }}</div>
                                <br>
                                <p><span class="bold" style="font-weight: bold;">APPROVED: </span></p>
                                <p>
                                <div class="blank-field" style="width: 80%; text-align: center; font-weight: bold;">
                                    {{ strtoupper($fi->approved) }}</div>
                                </p>
                                <div>{{ strtoupper($fi->approvedPosition) }}</div>
                            </div>
                        </div>

                        <div class="signature-section">
                            <div class="signatures">
                                <div class="signature-box">

                                </div>
                            </div>
                        </div>

                        <div class="footer">
                            <div style="font-size: 17px;"><b><i>NOTE: “This Clearance is accompanied by Fire Safety
                                        Checklist on Building Plans and does not take the place of any license required
                                        by law and is not transferable. Any change or alteration in the design and
                                        specification during construction shall require a new clearance"</i></b></div>
                            <br><br>
                            <div class="warning"><b>PAALALA: “MAHIGPIT NA IPINAGBABAWAL NG PAMUNUAN NG BUREAU OF FIRE
                                    PROTECTION SA MGA
                                    KAWANI NITO ANG MAGBENTA O MAGREKOMENDA NG ANUMANG BRAND NG FIRE EXTINGUISHER”</b>
                            </div>
                            <center>
                                <h1 style="color: rgb(2, 2, 92);">"FIRE SAFETY IS OUR MAIN CONCERN"</h1>
                            </center>
                        </div>
                        <div class="styled-box">
                            <i>{{ $copy[$i] }}</i>
                        </div>

                    </div>
                </div>

                <div style="font-size: 13px; font-weight: bold; margin-top: 10px;">BFP-QSF-FSED-005 Rev. 03 (03.06.20)
                </div>
            </div>
        @endfor
    @else
        <div class="page-break">
            <div class="certificate-outside">
                <div class="certificate">
                    <div class="header">
                        <img class="logo-left"
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Department_of_the_Interior_and_Local_Government_%28DILG%29_Seal_-_Logo.svg/480px-Department_of_the_Interior_and_Local_Government_%28DILG%29_Seal_-_Logo.svg.png"
                            alt="DILG Logo">
                        <img class="logo-right"
                            src="https://upload.wikimedia.org/wikipedia/commons/4/42/Bureau_of_Fire_Protection.png"
                            alt="BFP Logo">
                        <p style="margin-bottom: 5px;">Republic of the Philippines</p>
                        <h2 style="margin-top: 5px;">Department of the Interior and Local Government</h2>
                        <h1 style="font-size: 22px; color: rgb(2, 2, 92);">BUREAU OF FIRE PROTECTION</h1>
                        <p style="margin: 0">Region VIII</p>
                        <h3 style="font-weight: bold; font-size: 16px;">Province of Leyte</h3>
                        <h3>Hilongos Fire Station</h3>
                        <h4>Capt. Vilbar St., Hilongos, Leyte</h4>
                        <h4>Mobile Number: 09263678055</h4>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="fsic-number" style="color: red; font-size: 18px;">
                            FSEC NO. <span class="fsic-red"><input type="text"
                                    style="font-size: 18px; border: none; border-bottom: 3px solid black; text-align: center; color: red; font-weight: bold; background: transparent"
                                    value="{{ $fi->FSECNumber }}" disabled></span>
                        </div>
                        <div style="color: red; font-size: 18px;">
                            <input type="text"
                                style="font-size: 15px; border: none; border-bottom: 3px solid black; text-align: center; font-weight: bold; background: transparent"
                                value="{{ date('d-M-Y', strtotime($fi->dateFSEC)) }}" disabled>
                            <br>
                            <center style="color: black; font-size: 15px;">Date</center>
                        </div>
                    </div>



                    <div class="certificate-title" style="color: rgb(2, 2, 92);">
                        <h2>FIRE SAFETY EVALUATION CLEARANCE</h2>
                    </div>

                    <div class="content">
                        <h4>TO WHOM IT MAY CONCERN:</h4>
                        <p style="text-align: justify; font-size: 17px;"><span style="margin-left: 50px;">By virtue of
                                the provisions of RA 9514 otherwise known as the Fire Code of the Philippines of
                                2008,</span>
                            the application for <span style="font-weight: bold;">FIRE SAFETY EVALUATION
                                CLEARANCE</span>
                            <span class="blank-field"
                                style="font-weight: bold; width: 100%; text-align: center;">{{ strtoupper($fi->buildingName) }}</span>
                            <br><span class="blank-field"
                                style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                    of Building/Structure/Facility)</i></span> <br>
                            to be constructed/ renovated/ altered/ modified/ change of occupancy located at
                            <span class="blank-field"
                                style="font-weight: bold; text-align: center; width: 100%;">{{ strtoupper($fi->address) }}</span>
                            <span class="blank-field"
                                style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Address)</i></span>
                            owned by
                            <span class="blank-field"
                                style="width: 60%; text-align: center;"><b>{{ strtoupper($fi->owner) }}</b></span>
                            is hereby <b>GRANTED</b>
                            <span class="blank-field"
                                style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                    of Owner/Representative)</i></span>


                            after the building plans and other documents conform to the fire safety and life safety
                            requirements of the Fire Code of the Philippines of 2008 and its Revised Implementing Rules
                            and regulations and that the recommendations in the Fire Safety Checklist (FSC) will be
                            adopted
                        </p>
                    </div>



                    <div class="content">
                        <p style="font-size: 17px; text-align: justify;">
                            <span style="margin-left: 50px;"> Violation of Fire Code provisions shall cause this
                                certificate null and void after appropriate</span>
                            proceeding and shall hold the owner liable to the penalties provided for by the Fire Code.
                        </p>
                    </div>
                    <div class="fees-approval">
                        <div class="fees">
                            <p><span class="bold" style="font-weight: bold;">Fire Code Fees: </span></p>
                            <p><span class="bold">Amount Paid:</span> <b><span class="blank-field"
                                        style="width: 50%; text-align: right;">₱
                                        {{ number_format($fi->amountPaid, 2) }}</span></b></p>
                            <p><span class="bold">O.R. Number:</span> <span class="blank-field"
                                    style="width: 50%; text-align: right;"><b>{{ $fi->ORNumber }}</b></span></p>
                            <p><span class="bold">Date:</span> <span class="blank-field"
                                    style="width: 68%; text-align: right;"><b>{{ date('F d, Y', strtotime($fi->dateOR)) }}</b></span>
                            </p>
                        </div>
                        <div class="approval" style="margin-left: 150px;">
                            <p style="margin-bottom: 30px;"><span class="bold" style="font-weight: bold;">RECOMMEND
                                    APPROVAL: </span></p>
                            <p><span class="blank-field"
                                    style="width: 80%; text-align: center; font-weight: bold;">{{ strtoupper($fi->recommendApproval) }}</span>
                            </p>
                            <div style="margin-left: 80px;">{{ strtoupper($fi->recommendPosition) }}</div>
                            <br>
                            <p><span class="bold" style="font-weight: bold;">APPROVED: </span></p>
                            <p>
                            <div class="blank-field" style="width: 80%; text-align: center; font-weight: bold;">
                                {{ strtoupper($fi->approved) }}</div>
                            </p>
                            <div>{{ strtoupper($fi->approvedPosition) }}</div>
                        </div>
                    </div>

                    <div class="signature-section">
                        <div class="signatures">
                            <div class="signature-box">

                            </div>
                        </div>
                    </div>

                    <div class="footer">
                        <div style="font-size: 17px;"><b><i>NOTE: “This Clearance is accompanied by Fire Safety
                                    Checklist on Building Plans and does not take the place of any license required by
                                    law and is not transferable. Any change or alteration in the design and
                                    specification during construction shall require a new clearance"</i></b></div>
                        <br><br>
                        <div class="warning"><b>PAALALA: “MAHIGPIT NA IPINAGBABAWAL NG PAMUNUAN NG BUREAU OF FIRE
                                PROTECTION SA MGA
                                KAWANI NITO ANG MAGBENTA O MAGREKOMENDA NG ANUMANG BRAND NG FIRE EXTINGUISHER”</b></div>
                        <center>
                            <h1 style="color: rgb(2, 2, 92);">"FIRE SAFETY IS OUR MAIN CONCERN"</h1>
                        </center>
                    </div>
                    <div class="styled-box">
                        <i>{{ $copy[1] }}</i>
                    </div>

                </div>
            </div>

            <div style="font-size: 13px; font-weight: bold; margin-top: 10px;">BFP-QSF-FSED-005 Rev. 03 (03.06.20)
            </div>
        </div>

    @endif
</body>

</html>
