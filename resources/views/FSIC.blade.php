<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/bfp.png" />
    <title>Fire Safety Inspection Certificate</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

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
            margin-top: 20px;
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
            margin: 0;
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
        /* Hide the print button when printing */
        @media print {
            .buttons {
                display: none;
            }
        }
        /* Optional styling for your button */
        #content {
            margin-bottom: 20px;
        }

        .printButton {
            padding: 5px 15px;
            background-color: rgb(26, 50, 127);
            color: white;
            border-radius: 10px;
            margin-right: 5px;
            margin-top: 5px;
            margin-left: 5px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            box-shadow: 2px 5px 5px rgb(180, 177, 177);
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .display {
            display: flex
        }

    </style>
</head>

<body>

    <div>
        <div class="buttons">
            <div class="display">
                @if(Auth::user()->role == 1)
                <a class="printButton" href="/admin/inspections/gWu9XD9Y4Jz_EvZ3maYa-x51QE-B7i_AukRjZ5SLmNF3Mp5WPkSWy4FYuWWwK_Kz0tun-PPIdoT8pfYmzDkgg26-Y1hbF17aNAUDj8LRchCGRYg6ANIVIYwNirX_nE8kAh4FYGM4sJFy1hqjQArJdA:ISlAKCMqZiYlXjEyMzQ1Ng">
                    <iconify-icon icon="icon-park-twotone:back" width="20"></iconify-icon> 
                    <small style="margin-left: 5px">Back</small>
                </a>
                @endif
    
                @if(Auth::user()->role == 2)
                <a class="printButton" href="/personnel/inspections/gWu9XD9Y4Jz_EvZ3maYa-x51QE-B7i_AukRjZ5SLmNF3Mp5WPkSWy4FYuWWwK_Kz0tun-PPIdoT8pfYmzDkgg26-Y1hbF17aNAUDj8LRchCGRYg6ANIVIYwNirX_nE8kAh4FYGM4sJFy1hqjQArJdA:ISlAKCMqZiYlXjEyMzQ1Ng">
                    <iconify-icon icon="icon-park-twotone:back" width="20"></iconify-icon> 
                    <small style="margin-left: 5px">Back</small>
                </a>
                @endif
    
                @if(Auth::user()->role == 3)
                <a class="printButton" href="/applicant/inspections/gWu9XD9Y4Jz_EvZ3maYa-x51QE-B7i_AukRjZ5SLmNF3Mp5WPkSWy4FYuWWwK_Kz0tun-PPIdoT8pfYmzDkgg26-Y1hbF17aNAUDj8LRchCGRYg6ANIVIYwNirX_nE8kAh4FYGM4sJFy1hqjQArJdA:ISlAKCMqZiYlXjEyMzQ1Ng">
                    <iconify-icon icon="icon-park-twotone:back" width="20"></iconify-icon> 
                    <small style="margin-left: 5px">Back</small>
                </a>
                @endif
    
                <button class="printButton" onclick="printPage()">
                    <iconify-icon icon="ic:twotone-print" width="20"></iconify-icon> 
                    <small style="margin-left: 5px">Print</small>
                </button>
            </div>
        </div>

        <script>
            function printPage() {
              window.print();
            }
          </script>
    </div>

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
                            <h4>Mobile Number: {{ $cert->contactNumber }}</h4>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="fsic-number" style="color: red; font-size: 18px;">
                                FSIC NO. <span class="fsic-red"><input type="text"
                                        style="font-size: 18px; border: none; border-bottom: 3px solid black; text-align: center; color: red; font-weight: bold; background: transparent"
                                        value="{{ $fi->FSICNumber }}" disabled></span>
                            </div>
                            <div style="color: red; font-size: 18px;">
                                <input type="text"
                                    style="font-size: 15px; border: none; border-bottom: 3px solid black; text-align: center; font-weight: bold; background: transparent"
                                    value="{{ date('d-M-Y', strtotime($fi->dateFSIC)) }}" disabled>
                                <br>
                                <center style="color: black; font-size: 15px;">Date</center>
                            </div>
                        </div>



                        <div class="certificate-title" style="color: rgb(2, 2, 92);">
                            <h2>Fire Safety Inspection Certificate</h2>
                            <input type="text"
                                style="width: 50px; padding: 5px; margin-right: 5px; margin-bottom: 3px; text-align: center; background: transparent"
                                @if ($fi->certType == 2) value="✔" @endif disabled><span>FOR CERTIFICATE OF
                                OCCUPANCY</span><br>
                            <input type="text"
                                style="width: 50px; padding: 5px; margin-right: 5px; margin-bottom: 3px; margin-left: 51.5px; text-align: center; background: transparent"
                                @if ($fi->certType == 3) value="✔" @endif disabled><span>FOR BUSINESS PERMIT
                                (NEW/RENEWAL)</span><br>
                            <input type="text"
                                style="width: 50px; padding: 5px; margin-right: 5px;  margin-bottom: 3px; text-align: center; background: transparent"
                                disabled><span>OTHERS _______________________</span><br>
                        </div>

                        <div class="content">
                            <h4>TO WHOM IT MAY CONCERN:</h4>
                            <p style="text-align: justify; font-size: 17px;"><span style="margin-left: 50px;">By virtue
                                    of
                                    the provisions of RA 9514 otherwise known as the Fire Code of the Philippines of
                                    2008,</span>
                                2008, the application for <span style="font-weight: bold;">FIRE SAFETY INSPECTION
                                    CERTIFICATE</span> of
                                <span class="blank-field"
                                    style="font-weight: bold; width: 100%; text-align: center;">{{ strtoupper($fi->buildingName) }}</span>
                                <br><span class="blank-field"
                                    style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                        of Establishment)</i></span> <br> owned and managed by
                                <span class="blank-field"
                                    style="width: 40%; text-align: center;"><b>{{ strtoupper($fi->owner) }}</b></span>
                                with
                                postal address at
                                <span class="blank-field"
                                    style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                        of Owner/Representative)</i></span>
                                <span class="blank-field"
                                    style="font-weight: bold; text-align: center; width: 100%;">{{ strtoupper($fi->address) }}</span>
                                <span class="blank-field"
                                    style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Address)</i></span>

                                is hereby <b>GRANTED</b> after said building structure or
                                facility has been duly inspected with the findings that it has fully complied with the
                                fire
                                safety and
                                protection requirements of the Fire Code of the Philippines of 2008 and its Implementing
                                Rules and
                                Regulations.
                            </p>
                        </div>

                        <div class="content">
                            <p><span style="margin-left: 50px; font-size: 17px;">The certification is valid for <span
                                        class="blank-field" style="width: 60%;">{{ $fi->description }}</span>

                                    <span class="blank-field"
                                        style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Description)</i></span>

                                    <span class="blank-field" style="width: 50%;"></span> valid until </span><span
                                    class="blank-field"
                                    style="width: 31%; margin-left: 30px;"><strong>{{ date('d-M-Y', strtotime($fi->validUntil)) }}</strong></span>
                            </p>
                        </div>

                        <div class="content">
                            <p style="font-size: 17px; text-align: justify; margin-bottom: 0;">
                                <span style="margin-left: 50px;">Violation of Fire Code provisions shall ipso facto
                                    cause
                                    this certificate null and void, and shall hold the</span>
                                owner of the building liable to the penalties provided for by
                                the said Fire Code.
                            </p>
                        </div>
                        <div class="fees-approval" style="margin-top: 0;">
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
                            <div class="approval" style="margin-left: 150px; text-align: center;">
                                <!-- Recommend Approval Section -->
                                <p style="margin-bottom: 30px;">
                                    <span class="bold" style="font-weight: bold;">RECOMMEND APPROVAL:</span>
                                </p>
                                <p>
                                    <span class="blank-field" 
                                          style="display: inline-block; width: 80%; text-align: center; font-weight: bold;">
                                        {{ strtoupper($fi->recommendApproval) }}
                                    </span>
                                </p>
                                <p style="margin-top: 5px;">{{ strtoupper($fi->recommendPosition) }}</p>
                            
                                <!-- Approved Section -->
                                <p style="margin-top: 30px;">
                                    <span class="bold" style="font-weight: bold;">APPROVED:</span>
                                </p>
                                <p>
                                    <span class="blank-field" 
                                          style="display: inline-block; width: 80%; text-align: center; font-weight: bold;">
                                        {{ strtoupper($fi->approved) }}
                                    </span>
                                </p>
                                <p style="margin-top: 5px;">{{ strtoupper($fi->approvedPosition) }}</p>
                            </div>
                            
                        </div>


                        <div class="footer">
                            <div style="font-size: 16px;"><b><i>NOTE: “This Certificate does not take the place of any
                                        license required by law and is not transferable.
                                        Any change in the use of occupancy of the premises shall require a new
                                        certificate.”</i></b></div>
                            <h2>THIS CERTIFICATE SHALL BE POSTED CONSPICUOUSLY</h2>
                            <div class="warning"><b>PAALALA: “MAHIGPIT NA IPINAGBABAWAL NG PAMUNUAN NG BUREAU OF FIRE
                                    PROTECTION SA MGA
                                    KAWANI NITO ANG MAGBENTA O MAGREKOMENDA NG ANUMANG BRAND NG FIRE EXTINGUISHER”</b>
                            </div>
                            <center>
                                <h1>"FIRE SAFETY IS OUR MAIN CONCERN"</h1>
                            </center>
                        </div>
                        <div class="styled-box">
                            <i>{{ $copy[$i] }}</i>
                        </div>
                    </div>
                </div>

                <div style="font-size: 13px; font-weight: bold; margin-top: 10px; display: flex; justify-content: space-between">
                    <span>{{ $cert->code }}</span>
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
                        <h4>Mobile Number: {{ $cert->contactNumber }}</h4>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="fsic-number" style="color: red; font-size: 18px;">
                            FSIC NO. <span class="fsic-red"><input type="text"
                                    style="font-size: 18px; border: none; border-bottom: 3px solid black; text-align: center; color: red; font-weight: bold; background: transparent"
                                    value="{{ $fi->FSICNumber }}" disabled></span>
                        </div>
                        <div style="color: red; font-size: 18px;">
                            <input type="text"
                                style="font-size: 15px; border: none; border-bottom: 3px solid black; text-align: center; font-weight: bold; background: transparent"
                                value="{{ date('d-M-Y', strtotime($fi->dateFSIC)) }}" disabled>
                            <br>
                            <center style="color: black; font-size: 15px;">Date</center>
                        </div>
                    </div>



                    <div class="certificate-title" style="color: rgb(2, 2, 92);">
                        <h2>Fire Safety Inspection Certificate</h2>
                        <input type="text"
                            style="width: 50px; padding: 5px; margin-right: 5px; margin-bottom: 3px; text-align: center; background: transparent"
                            @if ($fi->certType == 2) value="✔" @endif disabled><span>FOR CERTIFICATE OF
                            OCCUPANCY</span><br>
                        <input type="text"
                            style="width: 50px; padding: 5px; margin-right: 5px; margin-bottom: 3px; margin-left: 51.5px; text-align: center; background: transparent"
                            @if ($fi->certType == 3) value="✔" @endif disabled><span>FOR BUSINESS PERMIT
                            (NEW/RENEWAL)</span><br>
                        <input type="text"
                            style="width: 50px; padding: 5px; margin-right: 5px;  margin-bottom: 3px; text-align: center; background: transparent"
                            disabled><span>OTHERS _______________________</span><br>
                    </div>

                    <div class="content">
                        <h4>TO WHOM IT MAY CONCERN:</h4>
                        <p style="text-align: justify; font-size: 17px;"><span style="margin-left: 50px;">By virtue of
                                the provisions of RA 9514 otherwise known as the Fire Code of the Philippines of
                                2008,</span>
                            2008, the application for <span style="font-weight: bold;">FIRE SAFETY INSPECTION
                                CERTIFICATE</span> of
                            <span class="blank-field"
                                style="font-weight: bold; width: 100%; text-align: center;">{{ strtoupper($fi->buildingName) }}</span>
                            <br><span class="blank-field"
                                style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                    of Establishment)</i></span> <br> owned and managed by
                            <span class="blank-field"
                                style="width: 40%; text-align: center;"><b>{{ strtoupper($fi->owner) }}</b></span>
                            with
                            postal address at
                            <span class="blank-field"
                                style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Name
                                    of Owner/Representative)</i></span>
                            <span class="blank-field"
                                style="font-weight: bold; text-align: center; width: 100%;">{{ strtoupper($fi->address) }}</span>
                            <span class="blank-field"
                                style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Address)</i></span>

                            is hereby <b>GRANTED</b> after said building structure or
                            facility has been duly inspected with the findings that it has fully complied with the fire
                            safety and
                            protection requirements of the Fire Code of the Philippines of 2008 and its Implementing
                            Rules and
                            Regulations.
                        </p>
                    </div>

                    <div class="content">
                        <p><span style="margin-left: 50px; font-size: 17px;">The certification is valid for <span
                                    class="blank-field" style="width: 60%;">{{ $fi->description }}</span>

                                <span class="blank-field"
                                    style="text-align: center; width: 100%; border-bottom: none; font-size: 15px;"><i>(Description)</i></span>

                                    <span class="blank-field" style="width: 50%;"></span> valid until </span><span
                                    class="blank-field"
                                    style="width: 31%; margin-left: 30px;"><strong>{{ date('d-M-Y', strtotime($fi->validUntil)) }}</strong></span>
                            </p>
                    </div>

                    <div class="content">
                        <p style="font-size: 17px; text-align: justify; margin-bottom: 0;">
                            <span style="margin-left: 50px;">Violation of Fire Code provisions shall ipso facto cause
                                this certificate null and void, and shall hold the</span>
                            owner of the building liable to the penalties provided for by
                            the said Fire Code.
                        </p>
                    </div>
                    <div class="fees-approval" style="margin-top: 0;">
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
                        <div class="approval" style="margin-left: 150px; text-align: center;">
                            <!-- Recommend Approval Section -->
                            <p style="margin-bottom: 30px;">
                                <span class="bold" style="font-weight: bold;">RECOMMEND APPROVAL:</span>
                            </p>
                            <p>
                                <span class="blank-field" 
                                      style="display: inline-block; width: 80%; text-align: center; font-weight: bold;">
                                    {{ strtoupper($fi->recommendApproval) }}
                                </span>
                            </p>
                            <p style="margin-top: 5px;">{{ strtoupper($fi->recommendPosition) }}</p>
                        
                            <!-- Approved Section -->
                            <p style="margin-top: 30px;">
                                <span class="bold" style="font-weight: bold;">APPROVED:</span>
                            </p>
                            <p>
                                <span class="blank-field" 
                                      style="display: inline-block; width: 80%; text-align: center; font-weight: bold;">
                                    {{ strtoupper($fi->approved) }}
                                </span>
                            </p>
                            <p style="margin-top: 5px;">{{ strtoupper($fi->approvedPosition) }}</p>
                        </div>
                    </div>


                    <div class="footer">
                        <div style="font-size: 16px;"><b><i>NOTE: “This Certificate does not take the place of any
                                    license required by law and is not transferable.
                                    Any change in the use of occupancy of the premises shall require a new
                                    certificate.”</i></b></div>
                        <h2>THIS CERTIFICATE SHALL BE POSTED CONSPICUOUSLY</h2>
                        <div class="warning"><b>PAALALA: “MAHIGPIT NA IPINAGBABAWAL NG PAMUNUAN NG BUREAU OF FIRE
                                PROTECTION SA MGA
                                KAWANI NITO ANG MAGBENTA O MAGREKOMENDA NG ANUMANG BRAND NG FIRE EXTINGUISHER”</b></div>
                        <center>
                            <h1>"FIRE SAFETY IS OUR MAIN CONCERN"</h1>
                        </center>
                    </div>
                    <div class="styled-box">
                        <i>{{ $copy[1] }}</i>
                    </div>
                </div>
            </div>

            <div style="font-size: 13px; font-weight: bold; margin-top: 10px; display: flex; justify-content: space-between">
                <span>{{ $cert->code }}</span>
               
                <i style="color: red">Note: THIS IS A DUPLICATE COPY</i>
               
            </div>
        </div>
    @endif
</body>

</html>
