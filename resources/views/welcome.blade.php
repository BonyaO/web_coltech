<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Coltech application</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  @vite('resources/css/app.css')
</head>

<body class="font-sans antialiased bg-white dark:bg-black dark:text-white/50">
  <x-navbar />

  <header class="relative overflow-hidden">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="max-w-2xl text-center mx-auto">
        <h1 class="block text-3xl font-black text-gray-800 sm:text-4xl md:text-5xl dark:text-white">The College of
          Technology <span class="text-lime-500 block">COLTECH</span></h1>
        <p class="mt-3 text-gray-800 dark:text-neutral-400 leading-loose">Applications into Year 1, Year 3 and Year 4 for the 2025/2026 academic year are now open. </p>
      </div>
        <div class="mt-8 flex flex-col items-center gap-4">
          <a href="/guest/register" class="inline-block px-8 py-4 bg-white text-lime-600 font-semibold rounded-lg shadow hover:bg-gray-50 transition">
          Start Application
          </a>

          <p class="text-gray-700 dark:text-neutral-300 text-sm">
            Have questions? Email us at
            <a href="mailto:coltech@uniba.cm" class="text-lime-600 underline hover:text-lime-500">coltech@uniba.cm</a>
          </p>
        
      </div>
    </div>
      <div class="mt-10 relative max-w-5xl mx-auto">
        <div class="w-full object-cover h-96 sm:h-[480px] bg-[url('https://images.pexels.com/photos/4560083/pexels-photo-4560083.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-no-repeat bg-center bg-cover rounded-xl"></div>
        <div class="absolute inset-0 size-full">
          <div class="flex flex-row justify-center items-center size-full space-x-4">
            <a class="animate-bounce py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
              href="{{ asset('images/userguide.pdf') }}" download="User guide">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
              </svg>
              {{ __("Download application guide") }}
            </a>
            <a class="animate-bounce py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
              href="{{ asset('images/communique.pdf') }}" download="Communique">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
              </svg>
              {{ __("Download communique") }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Application Process Timeline -->
  <section class="py-16 bg-gray-50 dark:bg-neutral-900">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Application Process</h2>
        <p class="text-gray-600 dark:text-neutral-400">Follow these simple steps to complete your application</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-5 gap-8 items-center">
        <!-- Step 1 -->
        <div class="text-center">
          <div class="w-16 h-16 bg-lime-500 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">1</div>
          <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Pay Registration Fee</h3>
          <p class="text-sm text-gray-600 dark:text-neutral-400">Pay 20,000 FCFA via bank transfer</p>
        </div>
        
        <!-- Arrow -->
        <div class="hidden md:flex justify-center">
          <svg class="w-8 h-8 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </div>
        
        <!-- Step 2 -->
        <div class="text-center">
          <div class="w-16 h-16 bg-lime-500 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">2</div>
          <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Complete Online Form</h3>
          <p class="text-sm text-gray-600 dark:text-neutral-400">Pay a platform charge of 1,000 FCFA. Fill out personal information and upload documents</p>
        </div>
        
        <!-- Arrow -->
        <div class="hidden md:flex justify-center">
          <svg class="w-8 h-8 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </div>
        
        <!-- Step 3 -->
        <div class="text-center">
          <div class="w-16 h-16 bg-lime-500 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">3</div>
          <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Submit & Print</h3>
          <p class="text-sm text-gray-600 dark:text-neutral-400">Submit application and download your printout</p>
        </div>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12 items-center">
        <!-- Step 4 -->
        <div class="text-center">
          <div class="w-16 h-16 bg-lime-500 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">4</div>
          <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Bring to Exam Centre</h3>
          <p class="text-sm text-gray-600 dark:text-neutral-400">Bring printed form and required documents to your examination center</p>
        </div>
        
        <!-- Step 5 -->
        <div class="text-center">
          <div class="w-16 h-16 bg-lime-500 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">5</div>
          <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Take Examination</h3>
          <p class="text-sm text-gray-600 dark:text-neutral-400">Complete your entrance examination</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Quick Requirements Checklist -->
  <section class="py-16 bg-white dark:bg-black">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Required Documents Checklist</h2>
        <p class="text-gray-600 dark:text-neutral-400">Ensure you have all these documents ready before starting your application</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Document 1 -->
        <div class="bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg border border-gray-200 dark:border-neutral-700">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Birth Certificate</h3>
              <p class="text-sm text-gray-600 dark:text-neutral-400">Certified copy, dated not more than 6 months old</p>
            </div>
          </div>
        </div>
        
        <!-- Document 2 -->
        <div class="bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg border border-gray-200 dark:border-neutral-700">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Academic Certificates</h3>
              <p class="text-sm text-gray-600 dark:text-neutral-400">GCE A/L, Baccalaureate, or equivalent (certified copy, less than 6 months old)</p>
            </div>
          </div>
        </div>
        
        <!-- Document 3 -->
        <div class="bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg border border-gray-200 dark:border-neutral-700">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Bank Payment Receipt</h3>
              <p class="text-sm text-gray-600 dark:text-neutral-400">Receipt showing payment of 20,000 FCFA non-refundable registration fee</p>
            </div>
          </div>
        </div>
        
        <!-- Document 4 -->
        <div class="bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg border border-gray-200 dark:border-neutral-700">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Passport Photograph</h3>
              <p class="text-sm text-gray-600 dark:text-neutral-400">4x4 passport-size photograph (max 500KB for online upload)</p>
            </div>
          </div>
        </div>
        
        <!-- Document 5 -->
        <div class="bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg border border-gray-200 dark:border-neutral-700">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Self-Addressed Envelope</h3>
              <p class="text-sm text-gray-600 dark:text-neutral-400">One A4 size, self-addressed stamped envelope</p>
            </div>
          </div>
        </div>
        
        <!-- Document 6 -->
        <div class="bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg border border-gray-200 dark:border-neutral-700">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Additional Photos</h3>
              <p class="text-sm text-gray-600 dark:text-neutral-400">Four additional passport-size photographs</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Payment Information Section -->
  <section class="py-16 bg-lime-50 dark:bg-neutral-800">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Payment Information</h2>
      </div>
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Bank Transfer -->
        <div class="bg-white dark:bg-neutral-900 p-8 rounded-lg shadow-md border border-gray-200 dark:border-neutral-700">
          <div class="flex items-center mb-6">
            <svg class="w-8 h-8 text-lime-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Registration Fee (Bank Transfer)</h3>
          </div>
          <div class="space-y-4">
            <div>
              <p class="text-sm font-medium text-gray-600 dark:text-neutral-400">Bank Account Number</p>
              <p class="text-lg font-mono text-gray-800 dark:text-white">10025 00030 16401043842 53</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-600 dark:text-neutral-400">Bank</p>
              <p class="text-lg text-gray-800 dark:text-white">NFC Bank</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-600 dark:text-neutral-400">Amount</p>
              <p class="text-2xl font-bold text-lime-600">20,000 FCFA</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4">
              <p class="text-sm text-red-700 dark:text-red-400">
                <strong>Important:</strong> This is a non-refundable registration fee. No other form of payment will be accepted.
              </p>
            </div>
          </div>
        </div>
        
        <!-- Mobile Money -->
        <div class="bg-white dark:bg-neutral-900 p-8 rounded-lg shadow-md border border-gray-200 dark:border-neutral-700">
          <div class="flex items-center mb-6">
            <svg class="w-8 h-8 text-lime-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Platform Fee (Online)</h3>
          </div>
          <div class="space-y-4">
            <div>
              <p class="text-sm font-medium text-gray-600 dark:text-neutral-400">Platform Charge</p>
              <p class="text-2xl font-bold text-lime-600">1,000 XAF</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-600 dark:text-neutral-400">Payment Method</p>
              <p class="text-lg text-gray-800 dark:text-white">Mobile Money via Online Platform</p>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Examination Information -->
  <section class="py-16 bg-white dark:bg-black">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Examination Information</h2>
        <p class="text-gray-600 dark:text-neutral-400">Everything you need to know about the entrance examination</p>
      </div>
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Exam Structure -->
        <div>
          <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Examination Structure</h3>
          <div class="space-y-4">
            <div class="flex items-center p-4 bg-gray-50 dark:bg-neutral-900 rounded-lg">
              <div class="w-12 h-12 bg-lime-500 text-white rounded-full flex items-center justify-center font-bold mr-4">
                30%
              </div>
              <div>
                <h4 class="font-semibold text-gray-800 dark:text-white">Study of Files</h4>
                <p class="text-sm text-gray-600 dark:text-neutral-400">Assessment of your academic documents and qualifications</p>
              </div>
            </div>
            
            <div class="flex items-center p-4 bg-gray-50 dark:bg-neutral-900 rounded-lg">
              <div class="w-12 h-12 bg-lime-500 text-white rounded-full flex items-center justify-center font-bold mr-4">
                70%
              </div>
              <div>
                <h4 class="font-semibold text-gray-800 dark:text-white">Written Papers</h4>
                <p class="text-sm text-gray-600 dark:text-neutral-400">Two written examination papers</p>
              </div>
            </div>
          </div>
          
          <div class="mt-8">
            <h4 class="font-semibold text-gray-800 dark:text-white mb-4">Language Options</h4>
            <div class="flex space-x-4">
              <div class="flex-1 p-4 bg-lime-50 dark:bg-lime-900/20 border border-lime-200 dark:border-lime-700 rounded-lg text-center">
                <h5 class="font-semibold text-lime-700 dark:text-lime-400">English</h5>
              </div>
              <div class="flex-1 p-4 bg-lime-50 dark:bg-lime-900/20 border border-lime-200 dark:border-lime-700 rounded-lg text-center">
                <h5 class="font-semibold text-lime-700 dark:text-lime-400">French</h5>
              </div>
            </div>
          </div>
        </div>
        
        <!-- What to Bring -->
        <div>
          <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">What to Bring to Exam Center</h3>
          <div class="space-y-3">
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-lime-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
              <p class="text-gray-700 dark:text-neutral-300">Printed application form (downloaded from website)</p>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-lime-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
              <p class="text-gray-700 dark:text-neutral-300">All required documents listed in the checklist above</p>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-lime-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
              <p class="text-gray-700 dark:text-neutral-300">Valid identification document</p>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-lime-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
              </svg>
              <p class="text-gray-700 dark:text-neutral-300">Writing materials (pens, pencils, etc.)</p>
            </div>
          </div>
          
          <div class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg">
            <h4 class="font-semibold text-yellow-800 dark:text-yellow-400 mb-2">Examination Centres</h4>
            <p class="text-sm text-yellow-700 dark:text-yellow-300">
              Your examination centre will be specified in your application form. Please ensure you arrive at the correct location on time.
            </p>
           
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>