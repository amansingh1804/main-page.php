<?php
    // Initialize variables for feedback display
    $success = false;
    $error = false;
    $referenceNumber = null;
    $errorMessage = null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitize and assign form data
        $fullname = trim($_POST["fullname"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $phone = trim($_POST["phone"] ?? "");
        $educationLevel = $_POST["educationLevel"] ?? "";
        $workExperience = $_POST["workExperience"] ?? "";
        $specialisation = $_POST["specialisation"] ?? "";

        // Validate essential fields (basic server-side validation)
        if (
            !$fullname ||
            !$email ||
            !$phone ||
            !$educationLevel ||
            !$workExperience ||
            !$specialisation ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            !preg_match('/^[0-9]{10}$/', $phone)
        ) {
            $error = true;
            $errorMessage = "Please fill all fields correctly including a valid email and 10-digit phone number.";
        } else {
            $formData = [
                "fullName" => $fullname,
                "fullname" => $fullname,
                "email" => $email,
                "phone" => $phone,
                "educationLevel" => $educationLevel,
                "workExperience" => $workExperience,
                "specialisation" => $specialisation,
            ];

            $apiResponse = submitToSalesforceAPI($formData);

            if ($apiResponse["error"]) {
                $error = true;
                $errorMessage = $apiResponse["message"];
                error_log("API Error: " . $apiResponse["message"]);
            } else {
                $success = true;
                $referenceNumber = $apiResponse["referenceNumber"];
            }
        }
    }

    function submitToSalesforceAPI($formData)
    {
        // API Configuration
        $apiUrl = "https://emeritus-degree.my.salesforce-sites.com/services/apexrest/leadservice/v1";
        $apiKey = "4Ai4Bz9L"; // Emeritus API key
        $serviceProviderId = "a0gf60000002PAiAAM"; // Emeritus SP ID
        $program = "VIT-MCA";

        $payload = array_merge($formData, [
            "program" => $program,
            "serviceProviderId" => $serviceProviderId,
            "apiKey" => $apiKey,
            "leadSourceData" => "Service Provider - Web",
            "leadSubSourceData" => "Web - Organic",
        ]);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Accept: application/json",
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HEADER => true,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = [
                "error" => true,
                "message" => "API Connection Error: " . curl_error($ch),
                "referenceNumber" => null,
            ];
            curl_close($ch);
            return $error;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);

        curl_close($ch);

        $result = [
            "error" => false,
            "message" => "",
            "referenceNumber" => null,
            "httpCode" => $httpCode,
        ];

        if ($httpCode >= 200 && $httpCode < 300) {
            $responseData = json_decode($body, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                if (isset($responseData["referenceNumber"])) {
                    $result["referenceNumber"] = trim($responseData["referenceNumber"]);
                    $result["message"] = "Successfully submitted with reference number: " . $result["referenceNumber"];
                } else {
                    $result["error"] = true;
                    $result["message"] = "API response missing reference number";
                }
            } else {
                $result["error"] = true;
                $result["message"] = "Invalid JSON response: " . json_last_error_msg();
            }
        } elseif ($httpCode == 400 || $httpCode == 401) {
            $result["error"] = true;
            $result["message"] = "Client input is incorrect. Connect to System Admin [ER-000" . $httpCode . "].";
        } else {
            $result["error"] = true;
            $result["message"] = "API returned HTTP status: " . $httpCode;
            $errorResponse = json_decode($body, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($errorResponse["message"])) {
                $result["message"] .= " - " . $errorResponse["message"];
            }
        }

        return $result;
    }
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <title>Online MCA | VIT University - UGC Entitled Master of Computer Applications</title>
    <meta name="description" content="Master cutting-edge software engineering, AI, Machine Learning, and Cyber Security with VIT University's UGC-entitled Online MCA. Speak to a Career Advisor." />
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    
    <!-- Tailwind CSS & jQuery -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#0a192f',
                        }
                    }
                }
            }
        }

        // Configuration variables as specified in the Landing Page Guide
        const mbaOnlineUrl = "MBA.php";
        const mcaOnlineUrl = "MCA.php";
        const msDsOnlineUrl = "MsDS.php";
        const contactNumber = "+91 87480 34720";
        const contactEmail = "";
        const logo = "images/vit_logo.png";
        const campus_image = "images/2.png"; // Unique hero image for MCA
        const brochureURL = "";
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hero-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .form-glow {
            box-shadow: 0 20px 50px -10px rgba(15, 23, 42, 0.3), 0 0 0 1px rgba(226, 232, 240, 0.8);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white font-sans overflow-x-hidden">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-brand-950 via-blue-900 to-brand-900 text-white text-[11px] sm:text-xs py-2 px-3 sm:px-4 text-center font-medium border-b border-blue-800/40">
        <span class="inline-flex items-center gap-1.5 sm:gap-2 flex-wrap justify-center">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
            <span>Admissions Open • <span class="hidden xs:inline">UGC-Entitled Tech Degree • </span></span>
            <a href="#form-container" class="DownloadBrochure underline text-blue-200 hover:text-white transition font-semibold">Connect with Career Advisor</a>
        </span>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                <!-- University Logo (VIT Standalone, No Co-branding) -->
                <div class="flex items-center gap-3 shrink-0">
                    <a href="index.php" title="Back to All Master's Programs" class="flex items-center gap-3 group">
                        <img src="images/vit_logo.png" alt="VIT University" class="h-10 sm:h-12 w-auto object-contain vit-logo transition-transform duration-200 group-hover:scale-[1.02]" />
                    </a>
                    <div class="hidden xl:block border-l border-slate-200 pl-3 py-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block leading-tight">Centre for Online Education</span>
                        <span class="text-xs text-blue-700 font-semibold block leading-tight">Master of Computer Applications</span>
                    </div>
                </div>

                <!-- Desktop Navigation Links (Clean, No Wrapping) -->
                <nav class="hidden lg:flex items-center gap-5 xl:gap-7 text-xs xl:text-sm font-semibold text-slate-700 whitespace-nowrap">
                    <a href="index.php" class="text-blue-600 hover:text-blue-800 transition whitespace-nowrap font-bold flex items-center gap-1.5"><i class="fas fa-arrow-left text-xs"></i> All Programs</a>
                    <a href="#about" class="hover:text-blue-600 transition whitespace-nowrap">About</a>
                    <a href="#programme" class="hover:text-blue-600 transition whitespace-nowrap">Highlights</a>
                    <a href="#specialisations" class="hover:text-blue-600 transition whitespace-nowrap">Specialisations</a>
                    <a href="#curriculum" class="hover:text-blue-600 transition whitespace-nowrap">Curriculum</a>
                    <a href="#admission" class="hover:text-blue-600 transition whitespace-nowrap">Eligibility & Fees</a>
                    <a href="#contact" class="hover:text-blue-600 transition whitespace-nowrap">Career Advisor</a>
                </nav>

                <!-- Header CTA & Mobile Hamburger Button -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <button class="DownloadBrochure inline-flex items-center justify-center px-3.5 py-2 sm:px-5 sm:py-2.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all duration-200 whitespace-nowrap">
                        <i class="fas fa-file-code mr-1.5 sm:mr-2"></i> Apply Now
                    </button>
                    <!-- Hamburger Toggle Button (Mobile & Tablet) -->
                    <button id="mobileMenuBtn" aria-label="Toggle navigation menu" class="lg:hidden p-2 rounded-xl text-slate-700 hover:text-blue-600 hover:bg-slate-100 transition focus:outline-none">
                        <i class="fas fa-bars text-xl" id="menuToggleIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown Navigation Menu -->
        <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-200/80 bg-white/98 backdrop-blur-lg px-4 pt-3 pb-6 shadow-2xl transition-all duration-200">
            <div class="space-y-1 mb-4">
                <a href="index.php" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 transition mb-2">
                    <span class="flex items-center gap-2"><i class="fas fa-arrow-left text-xs"></i> All Master's Programs</span>
                    <i class="fas fa-chevron-right text-xs text-blue-400"></i>
                </a>
                <a href="#about" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition">
                    <span>About VIT MCA</span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#programme" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition">
                    <span>Program Highlights</span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#specialisations" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition">
                    <span>Tech Specialisations</span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#curriculum" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition">
                    <span>Curriculum & Semesters</span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#admission" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition">
                    <span>Eligibility & Fee Plans</span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#contact" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition">
                    <span>Connect with Career Advisor</span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
            </div>

            <!-- Degree Switcher Pills for Mobile -->
            <div class="pt-3 border-t border-slate-100">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block px-3 mb-2">Switch Online Degree</span>
                <div class="grid grid-cols-3 gap-2 px-1">
                    <a href="MBA.php" class="text-center py-2 px-1 rounded-lg text-xs font-bold bg-slate-50 text-slate-700 border border-slate-200 hover:bg-blue-50 hover:text-blue-700">MBA</a>
                    <a href="MCA.php" class="text-center py-2 px-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">MCA</a>
                    <a href="MsDS.php" class="text-center py-2 px-1 rounded-lg text-xs font-bold bg-slate-50 text-slate-700 border border-slate-200 hover:bg-blue-50 hover:text-blue-700">M.Sc. DS</a>
                </div>
            </div>

            <!-- Direct Career Advisor Contact on Mobile -->
            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="tel:+918748034720" class="text-xs font-bold text-blue-600 hover:underline inline-flex items-center gap-1.5">
                    <i class="fas fa-phone-alt"></i> +91 87480 34720
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section with Integrated Salesforce Lead Form -->
    <section class="relative bg-gradient-to-br from-brand-950 via-slate-900 to-blue-950 text-white py-12 md:py-20 overflow-hidden hero-pattern">
        <!-- Glow Orbs -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-cyan-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column: Programme Information & Trust Credentials -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Badges Row -->
                    <div class="flex flex-wrap gap-2.5 items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-400/20 text-amber-300 border border-amber-400/30">
                            <i class="fas fa-award mr-1.5 text-amber-400"></i> NIRF #10 Overall University
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                            <i class="fas fa-shield-halved mr-1.5 text-emerald-400"></i> AICTE & UGC Approved
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-400/20 text-blue-300 border border-blue-400/30">
                            <i class="fas fa-laptop-code mr-1.5 text-blue-400"></i> 100% Online Computer Labs
                        </span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white">
                        Online Master of Computer Applications
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-sky-300">
                            (Online MCA) from VIT University
                        </span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl">
                        Propel your career in software architecture, cloud platforms, AI, and cybersecurity. A future-ready 2-year UGC-entitled post-graduate degree designed to equip you for leadership in global technology firms.
                    </p>

                    <!-- Key Program Highlights Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-3.5 text-center">
                            <i class="fas fa-code text-blue-400 text-lg mb-1"></i>
                            <div class="text-base font-extrabold text-white">2 Years</div>
                            <div class="text-xs text-slate-300">4 Semesters</div>
                        </div>
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-3.5 text-center">
                            <i class="fas fa-microchip text-blue-400 text-lg mb-1"></i>
                            <div class="text-base font-extrabold text-white">AI & ML Track</div>
                            <div class="text-xs text-slate-300">Hands-on Coding</div>
                        </div>
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-3.5 text-center">
                            <i class="fas fa-lock text-blue-400 text-lg mb-1"></i>
                            <div class="text-base font-extrabold text-white">Cybersecurity</div>
                            <div class="text-xs text-slate-300">Modern Defense</div>
                        </div>
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-3.5 text-center">
                            <i class="fas fa-wallet text-blue-400 text-lg mb-1"></i>
                            <div class="text-base font-extrabold text-white">Easy EMI</div>
                            <div class="text-xs text-slate-300">₹35,000 / Sem</div>
                        </div>
                    </div>

                    <!-- Unique Hero Banner Visual (images/2.png) -->
                    <div class="pt-2">
                        <div class="rounded-2xl overflow-hidden border border-white/15 shadow-2xl relative group">
                            <img src="images/2.png" alt="VIT Technology Campus" class="w-full h-48 sm:h-56 object-cover vit-campus transition-transform duration-500 group-hover:scale-105" />
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-4">
                                <span class="text-xs font-semibold text-slate-200">
                                    <i class="fas fa-server text-cyan-400 mr-1.5"></i> Vellore Institute of Technology • Premier Technology Hub & Innovation Labs
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Elevated Salesforce Lead Capture Card -->
                <div class="lg:col-span-5" id="form-container">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 text-slate-900 form-glow relative border border-slate-100">
                        
                        <!-- Header inside form card -->
                        <div class="border-b border-slate-100 pb-4 mb-5 text-center">
                            <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100 mb-2">
                                Free Admission Assistance
                            </span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Get MCA Syllabus & Details</h2>
                            <p class="text-xs text-slate-500 mt-1">Receive technical curriculum roadmap, fee breakdown, and counselor call.</p>
                        </div>

                        <!-- Feedback Message Handling -->
                        <?php if ($success): ?>
                            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 text-center space-y-3">
                                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-2xl font-bold">
                                    <i class="fas fa-check"></i>
                                </div>
                                <h3 class="text-lg font-extrabold text-emerald-900">Application Submitted!</h3>
                                <p class="text-xs text-emerald-800">
                                    Your details have been registered with the University Lead Center.
                                </p>
                                <div class="bg-white border border-emerald-200 rounded-lg p-3 inline-block">
                                    <span class="text-xs font-medium text-slate-500 block">Lead Reference Number:</span>
                                    <span class="text-base font-extrabold text-blue-700"><?php echo htmlspecialchars($referenceNumber ?? "N/A"); ?></span>
                                </div>
                                <p class="text-xs text-slate-600 pt-2">
                                    A Career Advisor will reach out shortly to assist you with eligibility verification and specialization selection.
                                </p>
                            </div>
                        <?php else: ?>

                            <?php if ($error && $errorMessage): ?>
                                <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-lg p-3.5 mb-4 flex items-start gap-2.5">
                                    <i class="fas fa-triangle-exclamation text-rose-500 mt-0.5"></i>
                                    <div><?= htmlspecialchars($errorMessage) ?></div>
                                </div>
                            <?php endif; ?>

                            <!-- The Lead Form -->
                            <form id="requestForm" method="POST" class="space-y-3.5" novalidate>
                                
                                <!-- Full Name -->
                                <div>
                                    <label for="fullname" class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i class="fas fa-user text-xs"></i>
                                        </div>
                                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required
                                            class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition" />
                                    </div>
                                    <span class="error-message text-rose-600 text-[11px] mt-1 hidden"></span>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i class="fas fa-envelope text-xs"></i>
                                        </div>
                                        <input type="email" id="email" name="email" placeholder="example@gmail.com" required
                                            class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition" />
                                    </div>
                                    <span class="error-message text-rose-600 text-[11px] mt-1 hidden"></span>
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">Mobile Number (10 Digits) *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs font-bold">
                                            +91
                                        </div>
                                        <input type="tel" id="phone" name="phone" maxlength="10" placeholder="9876543210" required
                                            class="w-full pl-11 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition" />
                                    </div>
                                    <span class="error-message text-rose-600 text-[11px] mt-1 hidden"></span>
                                </div>

                                <!-- Education Level -->
                                <div>
                                    <label for="educationLevel" class="block text-xs font-bold text-slate-700 mb-1">Highest Education Level *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i class="fas fa-graduation-cap text-xs"></i>
                                        </div>
                                        <select id="educationLevel" name="educationLevel" required
                                            class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition appearance-none">
                                            <option value="">Select Education Level</option>
                                            <option value="bachelor">Bachelor's Degree (BCA/B.Sc/B.Com/BA/B.Tech)</option>
                                            <option value="master">Master's Degree</option>
                                            <option value="diploma">Diploma</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <span class="error-message text-rose-600 text-[11px] mt-1 hidden"></span>
                                </div>

                                <!-- Work Experience (Exact Picklist Required by API) -->
                                <div>
                                    <label for="workExperience" class="block text-xs font-bold text-slate-700 mb-1">Work Experience *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i class="fas fa-briefcase text-xs"></i>
                                        </div>
                                        <select id="workExperience" name="workExperience" required
                                            class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition appearance-none">
                                            <option value="">Select Work Experience</option>
                                            <option value="Still a Student">Still a Student</option>
                                            <option value="Less than 5 Years">Less than 5 Years</option>
                                            <option value="5-10 Years">5-10 Years</option>
                                            <option value="10-15 Years">10-15 Years</option>
                                            <option value="16-20 Years">16-20 Years</option>
                                            <option value=">20 Years">&gt; 20 Years</option>
                                        </select>
                                    </div>
                                    <span class="error-message text-rose-600 text-[11px] mt-1 hidden"></span>
                                </div>

                                <!-- Preferred Specialisation (MCA Exact Picklist) -->
                                <div>
                                    <label for="specialisation" class="block text-xs font-bold text-slate-700 mb-1">Preferred Technical Track *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i class="fas fa-microchip text-xs"></i>
                                        </div>
                                        <select id="specialisation" name="specialisation" required
                                            class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition appearance-none">
                                            <option value="">Select Specialisation Track</option>
                                            <option value="Artificial intelligence (AI) & Machine learning">Artificial intelligence (AI) & Machine learning</option>
                                            <option value="Cyber security">Cyber security</option>
                                        </select>
                                    </div>
                                    <span class="error-message text-rose-600 text-[11px] mt-1 hidden"></span>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-600/30 hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
                                    <span>Download Brochure & Connect</span>
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </button>

                                <div class="text-[11px] text-center text-slate-500 pt-1">
                                    <i class="fas fa-shield-halved text-emerald-600 mr-1"></i> Data encrypted & secure • No spam policy
                                </div>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Accreditations & Recognitions Bar -->
    <section class="bg-white border-b border-slate-200/80 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-600 text-center mb-6">
                Recognised Worldwide For Computer Science & Engineering Excellence
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center text-center">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-2xl font-black text-blue-900 block">NIRF #10</span>
                    <span class="text-xs font-semibold text-slate-700">Ranked #10 University in India</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-2xl font-black text-emerald-800 block">NAAC A++</span>
                    <span class="text-xs font-semibold text-slate-700">Highest Category Accreditation</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-2xl font-black text-indigo-900 block">AICTE & UGC</span>
                    <span class="text-xs font-semibold text-slate-700">Fully Entitled Online Master's</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-2xl font-black text-cyan-800 block">Global CS Hub</span>
                    <span class="text-xs font-semibold text-slate-700">Top-Tier Tech Placements Network</span>
                </div>
            </div>
        </div>
    </section>

    <!-- About VIT MCA Section (Using Distinct Image images/6.png) -->
    <section id="about" class="py-16 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-6 space-y-6">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-blue-100 text-blue-800">
                        Technological Leadership
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Transform from a Programmer to a High-Impact Software Architect
                    </h2>
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        VIT's <strong>Online Master of Computer Applications (MCA)</strong> is crafted for tech enthusiasts and working developers who want to master enterprise system design, cutting-edge AI integration, and zero-trust cybersecurity architectures.
                    </p>
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        Delivered through the Centre for Distance and Online Education (CDOE), this program bridges academic foundation with real-world developer tools: GitHub, Docker, Kubernetes, cloud microservices, and modern ML pipelines.
                    </p>

                    <div class="space-y-3 pt-2">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">Hands-on virtual lab environments with real-time code execution</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">Equivalence to on-campus MCA for higher studies and MNC recruitment</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">Mentorship from senior software architects and security researchers</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="relative">
                        <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-200">
                            <!-- Unique Image 6.png for MCA About section -->
                            <img src="images/6.png" alt="Advanced Computer Science Lab" class="w-full h-80 sm:h-96 object-cover" />
                        </div>
                        <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-5 border border-slate-100 max-w-xs hidden sm:block">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-cyan-600 text-white flex items-center justify-center text-xl font-bold">
                                    <i class="fas fa-terminal"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-black text-slate-900">Practical Labs</div>
                                    <div class="text-xs font-semibold text-slate-500">Industry Dev Stacks</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MCA Specialisations & Key Features (Using Distinct Image images/14.png) -->
    <section id="specialisations" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-blue-100 text-blue-800 mb-3">
                    High-Growth Technical Tracks
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Specialized MCA Pathways
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3">
                    Choose between two of the most lucrative and future-proof domains in the global IT sector.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Track 1: AI & Machine Learning -->
                <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white rounded-3xl p-8 shadow-xl flex flex-col justify-between border border-blue-800/40 relative overflow-hidden group">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl shadow-lg">
                            <i class="fas fa-brain"></i>
                        </div>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-blue-400">Specialisation 1</span>
                        <h3 class="text-2xl font-black text-white">Artificial Intelligence & Machine Learning</h3>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Master foundational mathematical models, deep neural networks, computer vision, natural language processing (NLP), generative AI architectures, and large language model fine-tuning.
                        </p>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4 space-y-2 text-xs text-slate-300">
                            <div><strong class="text-white">Core Technologies:</strong> Python, TensorFlow, PyTorch, Scikit-learn, LangChain, HuggingFace</div>
                            <div><strong class="text-white">Career Roles:</strong> AI Engineer, ML Architect, Data Platform Engineer, Research Associate</div>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button class="DownloadBrochure inline-flex items-center gap-2 text-xs font-bold px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">
                            <span>Apply for AI & ML Track</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Track 2: Cyber Security -->
                <div class="bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 text-white rounded-3xl p-8 shadow-xl flex flex-col justify-between border border-cyan-800/40 relative overflow-hidden group">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-cyan-600 text-white flex items-center justify-center text-2xl shadow-lg">
                            <i class="fas fa-shield-virus"></i>
                        </div>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-400">Specialisation 2</span>
                        <h3 class="text-2xl font-black text-white">Cyber Security & Information Assurance</h3>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Protect critical infrastructure from advanced threats. Build expertise in penetration testing, ethical hacking, digital forensics, cryptography, cloud security architecture, and regulatory compliance.
                        </p>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4 space-y-2 text-xs text-slate-300">
                            <div><strong class="text-white">Core Focus:</strong> Ethical Hacking, Network Defense, Cryptography, DevSecOps, Cloud Compliance</div>
                            <div><strong class="text-white">Career Roles:</strong> Cybersecurity Analyst, Security Architect, SOC Lead, Penetration Tester</div>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button class="DownloadBrochure inline-flex items-center gap-2 text-xs font-bold px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl transition">
                            <span>Apply for Cyber Security Track</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Distinct Image 14.png Showcase -->
            <div class="mt-12 rounded-3xl overflow-hidden shadow-xl border border-slate-200">
                <img src="images/14.png" alt="Collaborative Innovation Workspace" class="w-full h-64 md:h-80 object-cover" />
            </div>
        </div>
    </section>

    <!-- Curriculum Breakdown Section -->
    <section id="curriculum" class="py-16 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-blue-100 text-blue-800 mb-3">
                    Comprehensive Curriculum
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    MCA Course Structure
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3">
                    4 semesters of deep technical immersion covering algorithms, system programming, cloud architecture, and applied research.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900">Semester 1 • Foundations & Algorithms</h3>
                        <span class="text-xs font-bold px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full">Sem 1</span>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-700">
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Advanced Data Structures and Algorithm Analysis</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Advanced Database Management Systems & SQL</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Mathematical Foundations for Computer Applications</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Object-Oriented Software Engineering & Design Patterns</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Data Structures & Algorithms Virtual Laboratory</li>
                    </ul>
                </div>

                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900">Semester 2 • Cloud & Enterprise Systems</h3>
                        <span class="text-xs font-bold px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full">Sem 2</span>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-700">
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Cloud Computing Architectures & Microservices</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Full-Stack Web Development & Modern Frameworks</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Computer Networks and Distributed Protocols</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Operating Systems Internals and Linux Administration</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-blue-600 text-xs"></i> Enterprise Application Development Lab</li>
                    </ul>
                </div>

                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900">Semester 3 • Specialisation Electives</h3>
                        <span class="text-xs font-bold px-2.5 py-1 bg-indigo-100 text-indigo-800 rounded-full">Sem 3</span>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-700">
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-indigo-600 text-xs"></i> Elective 1: Machine Learning Techniques / Ethical Hacking</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-indigo-600 text-xs"></i> Elective 2: Deep Learning / Cyber Threat Intelligence</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-indigo-600 text-xs"></i> Mobile Application Architecture & Development</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-indigo-600 text-xs"></i> Software Testing, Quality Assurance & DevOps</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-indigo-600 text-xs"></i> Specialisation Project Phase 1</li>
                    </ul>
                </div>

                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900">Semester 4 • Industry Capstone</h3>
                        <span class="text-xs font-bold px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full">Sem 4</span>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-700">
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-600 text-xs"></i> Software Project Management & Agile Methodologies</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-600 text-xs"></i> Professional Ethics, IPR & Cyber Laws</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-600 text-xs"></i> Major Industry Project / Dissertation</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-600 text-xs"></i> Comprehensive Technical Viva Voce</li>
                        <li class="flex items-center gap-2"><i class="fas fa-circle-check text-emerald-600 text-xs"></i> Final Product Deployment & Code Evaluation</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Eligibility & Fee Structure Section (Using Distinct Image images/20.png) -->
    <section id="admission" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-blue-100 text-blue-800 mb-3">
                    Admission Information
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Eligibility Criteria & Fee Structure
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3">
                    Structured installment plans designed to be accessible for working professionals and career switchers.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                
                <!-- Eligibility Card -->
                <div class="lg:col-span-6 bg-slate-50 rounded-2xl p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Eligibility Requirements</h3>
                                <span class="text-xs text-slate-500">As per UGC & AICTE Guidelines</span>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm text-slate-700">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-emerald-600 text-base mt-0.5"></i>
                                <div>
                                    <strong class="text-slate-900 block">Qualifying Degree:</strong>
                                    Passed BCA / B.Sc. (Computer Science / IT) or any recognized Bachelor's Degree with Mathematics at 10+2 level or Graduation level.
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-emerald-600 text-base mt-0.5"></i>
                                <div>
                                    <strong class="text-slate-900 block">Minimum Marks:</strong>
                                    Minimum <strong>50% marks</strong> in aggregate in the qualifying examination (45% for reserved categories).
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-emerald-600 text-base mt-0.5"></i>
                                <div>
                                    <strong class="text-slate-900 block">Bridge Course Available:</strong>
                                    Candidates without prior programming experience undergo a foundational preparatory bridge module.
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-emerald-600 text-base mt-0.5"></i>
                                <div>
                                    <strong class="text-slate-900 block">Examinations:</strong>
                                    100% Online Proctored Semester Examinations conducted in flexible time windows.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unique Image 20.png for MCA -->
                    <div class="mt-8 rounded-xl overflow-hidden border border-slate-200">
                        <img src="images/20.png" alt="Tech Students Learning" class="w-full h-44 object-cover" />
                    </div>
                </div>

                <!-- Fee Structure Card -->
                <div class="lg:col-span-6 bg-gradient-to-br from-slate-900 via-brand-950 to-blue-950 text-white rounded-2xl p-8 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6 border-b border-white/10 pb-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-400">Total Program Investment</span>
                                <h3 class="text-2xl font-black text-white">Affordable Fee Schedule</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                                0% No-Cost EMI
                            </span>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-sm text-slate-300 font-medium">Semester 1 Fee</span>
                                <span class="text-base font-extrabold text-white">₹35,000</span>
                            </div>
                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-sm text-slate-300 font-medium">Semester 2 Fee</span>
                                <span class="text-base font-extrabold text-white">₹35,000</span>
                            </div>
                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-sm text-slate-300 font-medium">Semester 3 Fee</span>
                                <span class="text-base font-extrabold text-white">₹35,000</span>
                            </div>
                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-sm text-slate-300 font-medium">Semester 4 Fee</span>
                                <span class="text-base font-extrabold text-white">₹35,000</span>
                            </div>
                        </div>

                        <div class="bg-blue-600/20 border border-blue-400/30 rounded-xl p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-blue-200 block">Total Program Fee (All 4 Semesters)</span>
                                    <span class="text-2xl font-black text-white">₹1,40,000</span>
                                </div>
                                <span class="text-xs text-slate-300">EMI options starting at ~₹3,889/month*</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center pt-2">
                        <button class="DownloadBrochure w-full py-3.5 px-6 rounded-xl font-bold text-sm bg-blue-600 hover:bg-blue-700 text-white shadow-lg transition">
                            Apply & Request EMI Options
                        </button>
                        <span class="text-[11px] text-slate-400 block mt-2">
                            *Installment terms subject to partner bank approval.
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Career Advisor Contact Section -->
    <section id="contact" class="py-16 md:py-24 bg-gradient-to-br from-brand-950 via-slate-900 to-blue-950 text-white relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-500/20 text-blue-300 border border-blue-400/30 mb-4">
                Tech Career Guidance
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">
                Have Questions About the Online MCA?
            </h2>
            <p class="text-slate-300 max-w-2xl mx-auto text-sm sm:text-base mb-8">
                Connect directly with a dedicated Career Advisor for curriculum consultation, eligibility check, and enrollment support.
            </p>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3">
                <button class="DownloadBrochure w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-blue-600 hover:bg-blue-700 text-white shadow-lg transition active:scale-[0.98]">
                    <i class="fas fa-file-arrow-down mr-2"></i> Download Full Brochure
                </button>
                <button type="button" class="DownloadBrochure w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-white/10 hover:bg-white/20 text-white border border-white/20 transition flex items-center justify-center cursor-pointer active:scale-[0.98]">
                    <i class="fas fa-comment-dots mr-2"></i> Message Career Advisor
                </button>
            </div>
        </div>
    </section>

    <!-- Professional Footer (With Mandatory Emeritus Directory Disclaimer) -->
    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-slate-900">
                
                <div class="md:col-span-1 space-y-3">
                    <img src="images/vit_logo.png" alt="VIT Logo" class="h-10 w-auto object-contain brightness-200 vit-logo" />
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Vellore Institute of Technology • Centre for Distance & Online Education (CDOE). Advanced Tech Degrees for Working Professionals.
                    </p>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-3">Available Programs</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="index.php" class="text-slate-300 hover:text-white transition flex items-center gap-1.5"><i class="fas fa-th-large text-blue-400 text-[10px]"></i> All Master's Programs</a></li>
                        <li><a href="MBA.php" id="mbaLink" class="hover:text-white transition">Online MBA (2 Years)</a></li>
                        <li><a href="MCA.php" id="mcaLink" class="text-blue-400 font-semibold hover:underline">Online MCA (2 Years)</a></li>
                        <li><a href="MsDS.php" id="msDsLink" class="hover:text-white transition">Online M.Sc. Data Science</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-3">Student Support</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="tel:+918748034720" class="hover:text-white transition">Admission Helpline</a></li>
                        <li><a href="#admission" class="hover:text-white transition">Eligibility Verification</a></li>
                        <li><a href="#curriculum" class="hover:text-white transition">Curriculum & Syllabus</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-3">Contact Support</h4>
                    <p class="text-xs text-slate-400 mb-2">Admissions & Inquiries Helpline:</p>
                    <a href="tel:+918748034720" class="text-xs font-bold text-white hover:text-blue-400 transition block mb-2">
                        <i class="fas fa-phone-alt mr-1.5 text-blue-500"></i> +91 87480 34720
                    </a>
                </div>

            </div>

            <!-- Mandatory Emeritus Policy Directory / Aggregator Disclaimer (Verbatim) -->
            <div class="pt-8 text-[11px] text-slate-400 leading-relaxed text-justify space-y-3">
                <p>
                    <strong>Disclaimer:</strong> We are a listing platform that aggregates and displays information about various institutions and their programs. The program details featured on our website are sourced from the respective institution's official website and brochure. Please note that institutions reserve the right to change program details, including fees, eligibility, and curriculum, at any time. All logos, brand names, and trademarks are the property of their respective owners. These names, logos, and brands are used solely for the purpose of providing relevant information to our visitors and do not imply any affiliation or endorsement.
                </p>
                <div class="flex flex-col sm:flex-row justify-between items-center text-slate-400 pt-3 border-t border-slate-900/60">
                    <div>&copy; 2026 All Rights Reserved.</div>
                    <div class="mt-2 sm:mt-0 flex gap-4 text-xs">
                        <span>Online Degree Information Portal</span>
                        <span>•</span>
                        <span>UGC Entitled Programs</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Client-Side Form Validation & Script Handlers -->
    <script>
        $(document).ready(function() {
            // Smooth scroll to lead form on any CTA button click
            $(document).on('click', '.DownloadBrochure', function(e) {
                e.preventDefault();
                const target = document.getElementById('form-container');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Highlight form
                    $('#fullname').focus();
                } else {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            // Mobile hamburger menu toggle handler
            $('#mobileMenuBtn').on('click', function(e) {
                e.stopPropagation();
                $('#mobileMenu').slideToggle(200);
                const $icon = $('#menuToggleIcon');
                if ($icon.hasClass('fa-bars')) {
                    $icon.removeClass('fa-bars').addClass('fa-xmark');
                } else {
                    $icon.removeClass('fa-xmark').addClass('fa-bars');
                }
            });

            // Auto-close mobile menu on link click
            $('.mobile-nav-link, #mobileMenu .DownloadBrochure').on('click', function() {
                $('#mobileMenu').slideUp(200);
                $('#menuToggleIcon').removeClass('fa-xmark').addClass('fa-bars');
            });

            // Close mobile menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('header').length) {
                    $('#mobileMenu').slideUp(200);
                    $('#menuToggleIcon').removeClass('fa-xmark').addClass('fa-bars');
                }
            });

            // Dynamic links setup
            if (typeof mbaOnlineUrl !== 'undefined' && mbaOnlineUrl) $('#mbaLink').attr('href', mbaOnlineUrl);
            if (typeof mcaOnlineUrl !== 'undefined' && mcaOnlineUrl) $('#mcaLink').attr('href', mcaOnlineUrl);
            if (typeof msDsOnlineUrl !== 'undefined' && msDsOnlineUrl) $('#msDsLink').attr('href', msDsOnlineUrl);

            // Optional helpline number handler
            if (typeof contactNumber !== 'undefined' && contactNumber.trim() !== '') {
                $('#helplineLink').text(contactNumber).attr('href', 'tel:' + contactNumber);
                $('#helplineBlock').removeClass('hidden');
            }

            // Client-side Form Validation
            const form = document.getElementById('requestForm');
            if (form) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const phoneRegex = /^[0-9]{10}$/;

                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    $(form).find('.error-message').addClass('hidden').text('');
                    $(form).find('input, select').removeClass('border-rose-500');

                    // Full Name
                    const fullname = form.fullname.value.trim();
                    if (!fullname) {
                        showError(form.fullname, 'Please enter your full name.');
                        isValid = false;
                    }

                    // Email
                    const email = form.email.value.trim();
                    if (!email || !emailRegex.test(email)) {
                        showError(form.email, 'Please enter a valid email address.');
                        isValid = false;
                    }

                    // Phone
                    const phone = form.phone.value.trim();
                    if (!phone || !phoneRegex.test(phone)) {
                        showError(form.phone, 'Please enter a valid 10-digit mobile number.');
                        isValid = false;
                    }

                    // Education Level
                    if (!form.educationLevel.value) {
                        showError(form.educationLevel, 'Please select your highest qualification.');
                        isValid = false;
                    }

                    // Work Experience
                    if (!form.workExperience.value) {
                        showError(form.workExperience, 'Please select your work experience.');
                        isValid = false;
                    }

                    // Specialisation
                    if (form.specialisation && !form.specialisation.value) {
                        showError(form.specialisation, 'Please select your preferred specialisation track.');
                        isValid = false;
                    }

                    if (!isValid) {
                        e.preventDefault();
                    }
                });

                function showError(element, message) {
                    const $err = $(element).closest('div').parent().find('.error-message');
                    $err.text(message).removeClass('hidden');
                    $(element).addClass('border-rose-500');
                    $(element).focus();
                }
            }
        });
    </script>
</body>
</html>