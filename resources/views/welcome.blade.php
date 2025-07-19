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
        <p class="mt-3 text-gray-800 dark:text-neutral-400 leading-loose">Application into COLTECH is now open. Start your application
          process today to gurantee your admission and kickstart your education.</p>
      </div>

      <div class="mt-10 relative max-w-5xl mx-auto">
        <div class="w-full object-cover h-96 sm:h-[480px] bg-[url('https://images.pexels.com/photos/4560083/pexels-photo-4560083.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-no-repeat bg-center bg-cover rounded-xl"></div>

        <div class="absolute inset-0 size-full">
          <div class="flex flex-col justify-center items-center size-full">
            <a class="animate-bounce py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
              href="{{ asset('images/userguide.pdf') }}" download="User guide">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
              </svg>
              {{__("Download application guide")}}
            </a>
          </div>
        </div>

        <div class="absolute bottom-12 -start-20 -z-[1] size-48 bg-gradient-to-b from-orange-500 to-white p-px rounded-lg dark:to-neutral-900">
          <div class="bg-white size-48 rounded-lg dark:bg-neutral-900"></div>
        </div>

        <div class="absolute -top-12 -end-20 -z-[1] size-48 bg-gradient-to-t from-blue-600 to-cyan-400 p-px rounded-full">
          <div class="bg-white size-48 rounded-full dark:bg-neutral-900"></div>
        </div>
      </div>
    </div>
  </header>
</body>

</html>