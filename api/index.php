<?php
    // Preserve query parameters across redirects (UTM tracking, partner source)
    $rawQuery = !empty($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] : "";
    $queryString = $rawQuery ? '?' . htmlspecialchars($rawQuery, ENT_QUOTES, 'UTF-8') : "";
    $mbaUrl = 'vit-online-mba.php' . $queryString;
    $mcaUrl = 'vit-online-mca.php' . $queryString;
    $msdsUrl = 'vit-online-mcds.php' . $queryString;
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <title>VIT Online Master's Programs | MBA, MCA & M.Sc Data Science</title>
    <meta name="description" content="Explore UGC-entitled Online Master's Degrees from VIT University (Top 14 NIRF). Discover Online MBA, MCA, and M.Sc. Data Science designed for working professionals." />

    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2388881821850373');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=2388881821850373&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->

    <!-- Google Fonts & Tailwind CSS CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    screens: {
                        'xs': '480px',
                    },
                    colors: {
                        brand: {
                            50: '#eef6ff',
                            100: '#d9eaff',
                            200: '#bbd9fe',
                            300: '#8cc2fd',
                            400: '#56a0fa',
                            500: '#2f7df6',
                            600: '#1a5ee9',
                            700: '#154ac7',
                            800: '#163ea1',
                            900: '#0b192c',
                            950: '#070f1d'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        .vit-logo {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
        }
        .program-card-hover {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .program-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(11, 25, 44, 0.12);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white font-sans overflow-x-hidden">

    <!-- Top Announcement Bar (Mobile-Optimized) -->
    <div class="bg-gradient-to-r from-brand-950 via-blue-900 to-brand-900 text-white text-[11px] sm:text-xs py-2 px-3 sm:px-4 text-center font-medium border-b border-blue-800/40">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-1.5 sm:gap-2 flex-wrap">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
            <span>Admissions Open • <span class="hidden xs:inline">UGC-Entitled Master's • </span>Top 14 NIRF • </span>
            <a href="tel:+918748034720" class="underline text-blue-200 hover:text-white transition font-semibold inline-flex items-center gap-1">
                <i class="fas fa-phone-alt text-[10px]"></i> +91 87480 34720
            </a>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-2 sm:gap-4">
                
                <!-- University Logo (VIT Standalone, No Co-branding) -->
                <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                    <a href="vit.php" class="flex items-center gap-2 group">
                        <img src="images/vit_logo.png" alt="VIT University" class="h-9 sm:h-12 w-auto object-contain vit-logo transition-transform duration-200 group-hover:scale-[1.02]" />
                    </a>
                    <div class="hidden xl:block border-l border-slate-200 pl-3 py-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block leading-tight">Centre for Online Education</span>
                        <span class="text-xs text-blue-700 font-semibold block leading-tight">UGC Entitled Master's Degrees</span>
                    </div>
                </div>

                <!-- Desktop Navigation Links (Clean, No Wrapping) -->
                <nav class="hidden lg:flex items-center gap-5 xl:gap-7 text-xs xl:text-sm font-semibold text-slate-700 whitespace-nowrap">
                    <a href="#programs" class="hover:text-blue-600 transition whitespace-nowrap">All Programs</a>
                    <a href="#mba-section" class="hover:text-blue-600 transition whitespace-nowrap">Online MBA</a>
                    <a href="#mca-section" class="hover:text-blue-600 transition whitespace-nowrap">Online MCA</a>
                    <a href="#msds-section" class="hover:text-blue-600 transition whitespace-nowrap">Online M.Sc. DS</a>
                    <a href="#why-vit" class="hover:text-blue-600 transition whitespace-nowrap">Why VIT</a>
                    <a href="#contact" class="hover:text-blue-600 transition whitespace-nowrap">Career Advisor</a>
                </nav>

                <!-- Header CTA & Mobile Hamburger Button -->
                <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                    <a href="#programs" class="inline-flex items-center justify-center px-3 py-1.5 sm:px-5 sm:py-2.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all duration-200 whitespace-nowrap">
                        <i class="fas fa-graduation-cap sm:mr-2"></i>
                        <span class="hidden sm:inline">Explore </span><span>Programs</span>
                    </a>
                    <!-- Hamburger Toggle Button (Mobile & Tablet) -->
                    <button id="mobileMenuBtn" aria-label="Toggle navigation menu" class="lg:hidden p-2 rounded-xl text-slate-700 hover:text-blue-600 hover:bg-slate-100 transition focus:outline-none shrink-0">
                        <i class="fas fa-bars text-lg sm:text-xl" id="menuToggleIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown Navigation Menu -->
        <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-200/80 bg-white/98 backdrop-blur-lg px-4 pt-3 pb-6 shadow-2xl transition-all duration-200 max-h-[85vh] overflow-y-auto">
            <div class="space-y-1 mb-4">
                <a href="#programs" class="mobile-nav-link flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition active:bg-blue-100">
                    <span class="flex items-center gap-2.5">
                        <i class="fas fa-th-large text-blue-600 text-xs"></i>
                        All Master's Programs
                    </span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#mba-section" class="mobile-nav-link flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition active:bg-blue-100">
                    <span class="flex items-center gap-2.5">
                        <i class="fas fa-briefcase text-blue-600 text-xs"></i>
                        Online MBA (2 Years)
                    </span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#mca-section" class="mobile-nav-link flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition active:bg-blue-100">
                    <span class="flex items-center gap-2.5">
                        <i class="fas fa-code text-indigo-600 text-xs"></i>
                        Online MCA (2 Years)
                    </span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#msds-section" class="mobile-nav-link flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition active:bg-blue-100">
                    <span class="flex items-center gap-2.5">
                        <i class="fas fa-chart-line text-teal-600 text-xs"></i>
                        Online M.Sc. Data Science
                    </span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#why-vit" class="mobile-nav-link flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition active:bg-blue-100">
                    <span class="flex items-center gap-2.5">
                        <i class="fas fa-award text-amber-500 text-xs"></i>
                        Why Choose VIT Online
                    </span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
                <a href="#contact" class="mobile-nav-link flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition active:bg-blue-100">
                    <span class="flex items-center gap-2.5">
                        <i class="fas fa-headset text-emerald-600 text-xs"></i>
                        Career Advisor Channel
                    </span>
                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                </a>
            </div>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <a href="#programs" class="mobile-nav-link w-full py-3.5 rounded-xl font-bold text-sm bg-blue-600 text-white text-center shadow-md hover:bg-blue-700 transition">
                    <i class="fas fa-list-check mr-2"></i> Browse All 3 Degrees
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section (Mobile-Refined with Natural Proportions) -->
    <section class="relative bg-gradient-to-br from-brand-950 via-slate-900 to-blue-950 text-white overflow-hidden py-10 sm:py-16 lg:py-24">
        <!-- Background subtle tech grid effect -->
        <div class="absolute inset-0 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:24px_24px] opacity-15 pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Hero Left: Value Proposition & Degree Highlights -->
                <div class="lg:col-span-7 space-y-5 sm:space-y-7 text-center sm:text-left">
                    <!-- Badges -->
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-blue-500/20 text-blue-300 border border-blue-400/30">
                            <i class="fas fa-award text-blue-400"></i> Top 14 NIRF
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            <i class="fas fa-check-double text-emerald-400"></i> NAAC A++ (3.66/4)
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-400/30">
                            <i class="fas fa-graduation-cap text-amber-400"></i> UGC Entitled
                        </span>
                    </div>

                    <!-- Main Portal Headline -->
                    <div>
                        <h1 class="text-2xl xs:text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                            Advance Your Career with <br class="hidden xs:inline" />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-blue-200 to-white">
                                UGC-Entitled Master's
                            </span> <br class="hidden sm:inline" />
                            Degrees from VIT
                        </h1>
                        <p class="mt-3.5 sm:mt-5 text-sm sm:text-lg text-slate-300 max-w-2xl mx-auto sm:mx-0 leading-relaxed">
                            Vellore Institute of Technology brings India's top-ranked postgraduate education 100% online. Choose between Online MBA, Online MCA, and Online M.Sc. Data Science designed for working professionals.
                        </p>
                    </div>

                    <!-- Action CTAs (Stacked Full-Width on Mobile) -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center sm:justify-start gap-3 pt-2">
                        <a href="#programs" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-7 py-3.5 sm:py-4 rounded-xl font-bold text-sm sm:text-base text-white bg-blue-600 hover:bg-blue-700 shadow-xl shadow-blue-600/30 transition-all duration-200 group active:scale-[0.98]">
                            <span>Explore All 3 Programs</span>
                            <i class="fas fa-arrow-down ml-2 text-xs transition-transform group-hover:translate-y-1"></i>
                        </a>
                        <a href="tel:+918748034720" class="w-full sm:w-auto inline-flex items-center justify-center px-5 sm:px-6 py-3.5 sm:py-4 rounded-xl font-bold text-sm sm:text-base text-white bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 active:scale-[0.98]">
                            <i class="fas fa-phone-alt mr-2 text-blue-300"></i>
                            <span>Call +91 87480 34720</span>
                        </a>
                    </div>

                    <!-- Mobile Quick Jump Pills (Visible on mobile only to jump straight down) -->
                    <div class="lg:hidden pt-2">
                        <span class="text-[11px] uppercase tracking-wider text-slate-400 font-bold block mb-2 text-center sm:text-left">
                            Quick Jump to Program:
                        </span>
                        <div class="grid grid-cols-3 gap-2">
                            <a href="#mba-section" class="py-2.5 px-2 text-center rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white font-bold text-xs transition flex flex-col items-center">
                                <i class="fas fa-briefcase text-blue-300 mb-1 text-sm"></i>
                                <span>MBA</span>
                            </a>
                            <a href="#mca-section" class="py-2.5 px-2 text-center rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white font-bold text-xs transition flex flex-col items-center">
                                <i class="fas fa-code text-indigo-300 mb-1 text-sm"></i>
                                <span>MCA</span>
                            </a>
                            <a href="#msds-section" class="py-2.5 px-2 text-center rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white font-bold text-xs transition flex flex-col items-center">
                                <i class="fas fa-chart-line text-teal-300 mb-1 text-sm"></i>
                                <span>M.Sc DS</span>
                            </a>
                        </div>
                    </div>

                    <!-- Trust Stats Bar -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-4 pt-5 sm:pt-6 border-t border-white/10 text-center sm:text-left">
                        <div class="p-2.5 sm:p-0 bg-white/5 sm:bg-transparent rounded-xl">
                            <div class="text-xl sm:text-3xl font-extrabold text-white">Top 14</div>
                            <div class="text-[11px] sm:text-xs text-slate-400 font-medium">NIRF Ranking</div>
                        </div>
                        <div class="p-2.5 sm:p-0 bg-white/5 sm:bg-transparent rounded-xl">
                            <div class="text-xl sm:text-3xl font-extrabold text-blue-400">100%</div>
                            <div class="text-[11px] sm:text-xs text-slate-400 font-medium">Online & Flexible</div>
                        </div>
                        <div class="p-2.5 sm:p-0 bg-white/5 sm:bg-transparent rounded-xl">
                            <div class="text-xl sm:text-3xl font-extrabold text-emerald-400">A++</div>
                            <div class="text-[11px] sm:text-xs text-slate-400 font-medium">NAAC Accredited</div>
                        </div>
                        <div class="p-2.5 sm:p-0 bg-white/5 sm:bg-transparent rounded-xl">
                            <div class="text-xl sm:text-3xl font-extrabold text-amber-400">Equal</div>
                            <div class="text-[11px] sm:text-xs text-slate-400 font-medium">On-Campus Value</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Right: Visual Portal Showcase Card (Visible on Desktop) -->
                <div class="hidden lg:block lg:col-span-5">
                    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 sm:p-8 shadow-2xl relative space-y-6">
                        
                        <!-- Header badge -->
                        <div class="flex items-center justify-between border-b border-white/10 pb-4">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-300 block">Postgraduate Degrees</span>
                                <h3 class="text-lg font-bold text-white">Online Master's Programs</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                                Admissions Open
                            </span>
                        </div>

                        <!-- 3 Program Cards for Quick Jump -->
                        <div class="space-y-3.5">
                            
                            <!-- MBA Card -->
                            <a href="#mba-section" class="flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/15 border border-white/10 transition group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-blue-600/30 text-blue-300 flex items-center justify-center text-lg shrink-0">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white group-hover:text-blue-300 transition">Online MBA</h4>
                                        <p class="text-xs text-slate-300">Finance • Marketing • HR • Analytics</p>
                                    </div>
                                </div>
                                <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs text-slate-300 group-hover:bg-blue-600 group-hover:text-white transition">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </a>

                            <!-- MCA Card -->
                            <a href="#mca-section" class="flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/15 border border-white/10 transition group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-indigo-600/30 text-indigo-300 flex items-center justify-center text-lg shrink-0">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white group-hover:text-indigo-300 transition">Online MCA</h4>
                                        <p class="text-xs text-slate-300">Cloud Computing • Cyber Security • AI</p>
                                    </div>
                                </div>
                                <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs text-slate-300 group-hover:bg-indigo-600 group-hover:text-white transition">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </a>

                            <!-- MsDS Card -->
                            <a href="#msds-section" class="flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/15 border border-white/10 transition group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-teal-600/30 text-teal-300 flex items-center justify-center text-lg shrink-0">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white group-hover:text-teal-300 transition">Online M.Sc. Data Science</h4>
                                        <p class="text-xs text-slate-300">Machine Learning • Big Data • Python/R</p>
                                    </div>
                                </div>
                                <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs text-slate-300 group-hover:bg-teal-600 group-hover:text-white transition">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </a>

                        </div>

                        <!-- Footer note inside card -->
                        <div class="pt-2 text-center text-xs text-slate-300 border-t border-white/10">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fas fa-shield-halved text-blue-400"></i> Degrees Conferred Exclusively by VIT University
                            </span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION TITLE BAR: All 3 Master's Programs -->
    <div id="programs" class="bg-white py-10 sm:py-14 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-blue-100 text-blue-800 mb-2 sm:mb-3">
                Featured Online Programs
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Select Your Degree Program
            </h2>
            <p class="text-slate-600 text-xs sm:text-base mt-2 sm:mt-3 leading-relaxed">
                Explore our three UGC-entitled Master’s degrees designed for modern corporate and technology leaders. Review brief highlights and click through to the dedicated program page for full details.
            </p>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- PROGRAM SECTION 1: Online MBA (Responsive: Natural Ratio Image)  -->
    <!-- ================================================================= -->
    <section id="mba-section" class="py-12 sm:py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Left: Program Image & Visual Badges -->
                <div class="lg:col-span-6">
                    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-white group">
                        <img src="images/1.png" alt="Online MBA Degree - VIT University" class="w-full aspect-[16/10] sm:aspect-video lg:h-96 object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                        
                        <div class="absolute bottom-3 sm:bottom-5 left-3 sm:left-5 right-3 sm:right-5 flex flex-col xs:flex-row items-start xs:items-center justify-between gap-1.5 sm:gap-2 text-white">
                            <div>
                                <span class="text-[10px] sm:text-xs uppercase tracking-wider font-extrabold text-blue-300 block">Master of Business Administration</span>
                                <h3 class="text-base sm:text-xl font-black">Online MBA</h3>
                            </div>
                            <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-blue-600/90 text-white shadow-md">
                                2 Years • 4 Semesters
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Minimal Information & Redirect Button -->
                <div class="lg:col-span-6 space-y-4 sm:space-y-5">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-blue-100 text-blue-800">
                            Management & Leadership
                        </span>
                        <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-emerald-100 text-emerald-800">
                            UGC Entitled
                        </span>
                    </div>

                    <h3 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Online Master of Business Administration (MBA)
                    </h3>

                    <p class="text-slate-600 text-xs sm:text-base leading-relaxed">
                        Transform into an agile corporate leader. The VIT Online MBA equips professionals with holistic decision-making capabilities, modern business acumen, and cross-functional management skills.
                    </p>

                    <!-- Key Minimal Information Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3.5 pt-1">
                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-graduation-cap text-blue-600 mr-1.5"></i> Specialisations
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Finance, Marketing, HR, Business Analytics, General Management</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-user-check text-blue-600 mr-1.5"></i> Eligibility
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Bachelor's Degree in any discipline with minimum 50% aggregate marks.</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-clock text-blue-600 mr-1.5"></i> Learning Format
                            </span>
                            <p class="text-xs font-semibold text-slate-800">100% Online • Weekend Live Masterclasses • Recorded Access</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-briefcase text-blue-600 mr-1.5"></i> Target Roles
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Business Manager, Financial Consultant, Product Lead, Strategy Head</p>
                        </div>
                    </div>

                    <!-- Redirect Button to MBA Landing Page (Full-Width on Mobile) -->
                    <div class="pt-3 sm:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <a href="<?= $mbaUrl ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-7 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/25 transition-all duration-200 group active:scale-[0.98]">
                            <span>Explore MBA</span>
                            <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                        <a href="<?= $mbaUrl ?>#curriculum" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 transition active:scale-[0.98]">
                            <i class="fas fa-book-open mr-1.5 text-blue-600"></i> View MBA Curriculum
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- PROGRAM SECTION 2: Online MCA (Responsive: Natural Ratio Image)  -->
    <!-- ================================================================= -->
    <section id="mca-section" class="py-12 sm:py-16 lg:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Left: Minimal Information (Desktop Left, Mobile Second) -->
                <div class="lg:col-span-6 space-y-4 sm:space-y-5 order-2 lg:order-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-indigo-100 text-indigo-800">
                            Advanced Computing & Tech
                        </span>
                        <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-blue-100 text-blue-800">
                            AICTE Approved
                        </span>
                    </div>

                    <h3 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Online Master of Computer Applications (MCA)
                    </h3>

                    <p class="text-slate-600 text-xs sm:text-base leading-relaxed">
                        Step into senior software engineering and technical architecture roles. Gain hands-on mastery over full-stack development, cloud architecture, and cybersecurity with industry labs.
                    </p>

                    <!-- Key Minimal Information Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3.5 pt-1">
                        <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-laptop-code text-indigo-600 mr-1.5"></i> Specialisation Tracks
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Cloud Computing, Cyber Security, Artificial Intelligence, DevOps</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-user-check text-indigo-600 mr-1.5"></i> Eligibility
                            </span>
                            <p class="text-xs font-semibold text-slate-800">BCA / B.Sc (CS/IT) or any Bachelor's degree with Mathematics (min 50%).</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-microchip text-indigo-600 mr-1.5"></i> Hands-on Labs
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Cloud Sandbox • Enterprise Java/Python • Docker & Kubernetes</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-briefcase text-indigo-600 mr-1.5"></i> Target Roles
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Software Architect, Cloud Engineer, Full Stack Lead, DevOps Engineer</p>
                        </div>
                    </div>

                    <!-- Redirect Button to MCA Landing Page (Full-Width on Mobile) -->
                    <div class="pt-3 sm:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <a href="<?= $mcaUrl ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-7 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-600/25 transition-all duration-200 group active:scale-[0.98]">
                            <span>Explore MCA</span>
                            <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                        <a href="<?= $mcaUrl ?>#curriculum" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 transition active:scale-[0.98]">
                            <i class="fas fa-book-open mr-1.5 text-indigo-600"></i> View MCA Curriculum
                        </a>
                    </div>
                </div>

                <!-- Right: Program Image (Desktop Right, Mobile First) -->
                <div class="lg:col-span-6 order-1 lg:order-2">
                    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-white group">
                        <img src="images/2.png" alt="Online MCA Degree - VIT University" class="w-full aspect-[16/10] sm:aspect-video lg:h-96 object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                        
                        <div class="absolute bottom-3 sm:bottom-5 left-3 sm:left-5 right-3 sm:right-5 flex flex-col xs:flex-row items-start xs:items-center justify-between gap-1.5 sm:gap-2 text-white">
                            <div>
                                <span class="text-[10px] sm:text-xs uppercase tracking-wider font-extrabold text-indigo-300 block">Master of Computer Applications</span>
                                <h3 class="text-base sm:text-xl font-black">Online MCA</h3>
                            </div>
                            <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-indigo-600/90 text-white shadow-md">
                                2 Years • 4 Semesters
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- PROGRAM SECTION 3: Online MsDS (Responsive: Natural Ratio Image) -->
    <!-- ================================================================= -->
    <section id="msds-section" class="py-12 sm:py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Left: Program Image & Visual Badges -->
                <div class="lg:col-span-6">
                    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-white group">
                        <img src="images/3.png" alt="Online M.Sc Data Science Degree - VIT University" class="w-full aspect-[16/10] sm:aspect-video lg:h-96 object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                        
                        <div class="absolute bottom-3 sm:bottom-5 left-3 sm:left-5 right-3 sm:right-5 flex flex-col xs:flex-row items-start xs:items-center justify-between gap-1.5 sm:gap-2 text-white">
                            <div>
                                <span class="text-[10px] sm:text-xs uppercase tracking-wider font-extrabold text-teal-300 block">Master of Science</span>
                                <h3 class="text-base sm:text-xl font-black">M.Sc. in Data Science</h3>
                            </div>
                            <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-teal-600/90 text-white shadow-md">
                                2 Years • 4 Semesters
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Minimal Information & Redirect Button -->
                <div class="lg:col-span-6 space-y-4 sm:space-y-5">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-teal-100 text-teal-800">
                            AI, ML & Big Data Analytics
                        </span>
                        <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-blue-100 text-blue-800">
                            High Demand STEM
                        </span>
                    </div>

                    <h3 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Online M.Sc. in Data Science (MsDS)
                    </h3>

                    <p class="text-slate-600 text-xs sm:text-base leading-relaxed">
                        Become a high-caliber data scientist. Master mathematical foundations, machine learning algorithms, deep learning, and big data architectures with industry-standard toolkits.
                    </p>

                    <!-- Key Minimal Information Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3.5 pt-1">
                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-chart-pie text-teal-600 mr-1.5"></i> Core Technologies
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Python, R, TensorFlow, PyTorch, SQL, Spark & Tableau</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-user-check text-teal-600 mr-1.5"></i> Eligibility
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Bachelor's Degree with Mathematics / Statistics / CS background (min 50%).</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-brain text-teal-600 mr-1.5"></i> Advanced Curriculum
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Deep Learning, Natural Language Processing, Computer Vision & Big Data</p>
                        </div>

                        <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                <i class="fas fa-briefcase text-teal-600 mr-1.5"></i> Target Roles
                            </span>
                            <p class="text-xs font-semibold text-slate-800">Data Scientist, ML Engineer, Quantitative Analyst, AI Research Associate</p>
                        </div>
                    </div>

                    <!-- Redirect Button to MsDS Landing Page (Full-Width on Mobile) -->
                    <div class="pt-3 sm:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <a href="<?= $msdsUrl ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-7 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-teal-600 hover:bg-teal-700 shadow-lg shadow-teal-600/25 transition-all duration-200 group active:scale-[0.98]">
                            <span>Explore M.Sc Data Science</span>
                            <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                        <a href="<?= $msdsUrl ?>#curriculum" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 transition active:scale-[0.98]">
                            <i class="fas fa-book-open mr-1.5 text-teal-600"></i> View Data Science Curriculum
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Why VIT Online Section (Pillars of Excellence - Mobile Optimized) -->
    <section id="why-vit" class="py-12 sm:py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-16">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-blue-100 text-blue-800 mb-2 sm:mb-3">
                    Academic Heritage & Recognition
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Why Pursue Your Master’s at VIT Online?
                </h2>
                <p class="text-slate-600 text-xs sm:text-base mt-2 sm:mt-3 leading-relaxed">
                    VIT is recognized nationally and globally for educational excellence, cutting-edge research, and unmatched career outcomes.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Pillar 1 -->
                <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:shadow-lg transition">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg sm:text-xl mb-3.5 sm:mb-4">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5 sm:mb-2">Top 14 NIRF</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Ranked among the top 14 institutions in India by NIRF, Ministry of Education, Government of India.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:shadow-lg transition">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-lg sm:text-xl mb-3.5 sm:mb-4">
                        <i class="fas fa-stamp"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5 sm:mb-2">UGC & AICTE Entitled</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Online degrees hold 100% equivalence to regular on-campus master’s degrees as per official UGC regulations.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:shadow-lg transition">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg sm:text-xl mb-3.5 sm:mb-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5 sm:mb-2">Weekend Flexibility</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Self-paced video modules combined with live interactive faculty sessions on weekends so you never miss work.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:shadow-lg transition">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-lg sm:text-xl mb-3.5 sm:mb-4">
                        <i class="fas fa-users-gear"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5 sm:mb-2">Career Advisory</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Benefit from 1-on-1 counseling, profile analysis, resume review, and interview preparation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Career Advisor Contact Section (Mobile Optimized) -->
    <section id="contact" class="py-12 sm:py-16 md:py-20 bg-gradient-to-br from-brand-950 via-slate-900 to-blue-950 text-white relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-500/20 text-blue-300 border border-blue-400/30 mb-3 sm:mb-4">
                Personalized Career Guidance
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight mb-3 sm:mb-4">
                Still Deciding Which Degree Matches Your Ambitions?
            </h2>
            <p class="text-slate-300 text-xs sm:text-base max-w-2xl mx-auto mb-6 sm:mb-8 leading-relaxed">
                Connect with our dedicated Career Advisors for free profile evaluation, specialization matching, and step-by-step admission guidance.
            </p>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3">
                <a href="#programs" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-blue-600 hover:bg-blue-700 text-white shadow-lg transition flex items-center justify-center gap-2 active:scale-[0.98]">
                    <i class="fas fa-list-check"></i>
                    <span>Select a Degree to Apply</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Professional Footer (Mobile Optimized) -->
    <footer class="bg-slate-950 text-slate-400 py-10 sm:py-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 pb-8 sm:pb-10 border-b border-slate-900">
                
                <div class="sm:col-span-2 lg:col-span-1 space-y-3">
                    <img src="images/vit_logo.png" alt="VIT Logo" class="h-9 sm:h-10 w-auto object-contain brightness-200 vit-logo" />
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Vellore Institute of Technology • Centre for Distance & Online Education (CDOE). Higher Education for the Global Workforce.
                    </p>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-2 sm:mb-3">Available Programs</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="<?= $mbaUrl ?>" class="hover:text-white transition block py-0.5">Online MBA (2 Years)</a></li>
                        <li><a href="<?= $mcaUrl ?>" class="hover:text-white transition block py-0.5">Online MCA (2 Years)</a></li>
                        <li><a href="<?= $msdsUrl ?>" class="hover:text-white transition block py-0.5">Online M.Sc. Data Science</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-2 sm:mb-3">Program Portals</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="<?= $mbaUrl ?>" class="hover:text-white transition block py-0.5">MBA Application Page</a></li>
                        <li><a href="<?= $mcaUrl ?>" class="hover:text-white transition block py-0.5">MCA Application Page</a></li>
                        <li><a href="<?= $msdsUrl ?>" class="hover:text-white transition block py-0.5">M.Sc. DS Application Page</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-2 sm:mb-3">Contact Information</h4>
                    <a href="tel:+918748034720" class="text-xs font-bold text-white hover:text-blue-400 transition block mb-2">
                        <i class="fas fa-phone-alt mr-1.5 text-blue-500"></i> +91 87480 34720
                    </a>
                    <span class="text-xs text-slate-500 block leading-tight">
                        Admissions Open
                    </span>
                </div>

            </div>

            <!-- Mandatory Emeritus Policy Directory / Aggregator Disclaimer (Verbatim) -->
            <div class="pt-6 sm:pt-8 text-xs text-slate-500 space-y-4">
                <p class="leading-relaxed text-[11px] sm:text-xs">
                    <strong>Disclaimer:</strong> We are a listing platform that aggregates and displays information about various institutions and their programs. The program details featured on our website are sourced from the respective institution's official website and brochure. Please note that institutions reserve the right to change program details, including fees, eligibility, and curriculum, at any time. All logos, brand names, and trademarks are the property of their respective owners. These names, logos, and brands are used solely for the purpose of providing relevant information to our visitors and do not imply any affiliation or endorsement.
                </p>

                <div class="flex flex-col sm:flex-row justify-between items-center text-slate-400 pt-3 border-t border-slate-900/60 gap-2 sm:gap-0 text-center sm:text-left">
                    <div>&copy; 2026 All Rights Reserved.</div>
                    <div class="flex gap-4 text-xs">
                        <span>Online Master's Portal</span>
                        <span>•</span>
                        <span>UGC Entitled Programs</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script Handlers -->
    <script>
        $(document).ready(function() {
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
            $('.mobile-nav-link').on('click', function() {
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
        });
    </script>
</body>
</html>
