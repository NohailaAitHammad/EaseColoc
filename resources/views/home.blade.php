<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Colocation - Find Your Perfect Place</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex justify-around items-center ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM264 320C264 289.1 289.1 264 320 264C350.9 264 376 289.1 376 320C376 350.9 350.9 376 320 376C289.1 376 264 350.9 264 320zM208 496C208 451.8 243.8 416 288 416L352 416C396.2 416 432 451.8 432 496C432 504.8 424.8 512 416 512L224 512C215.2 512 208 504.8 208 496z"/></svg>
            <a
                class="ml-6  text-lg font-bold text-indigo-600 dark:text-gray-200" style="font-size: 35px;"
                href="/"
            >EaseColoc
            </a>
        </div>
        <div class="space-x-6">
            <a href="#" class="text-gray-700 hover:text-indigo-600">Home</a>
            <a href=" {{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Register</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="bg-indigo-600 text-white py-20">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-6">Find Your Perfect Colocation</h2>
        <p class="text-lg mb-8">Discover shared apartments that match your lifestyle and budget.</p>

        <!-- Search Bar -->
        <div class="max-w-3xl mx-auto bg-white rounded-lg p-4 flex shadow-lg">
            <input type="text" placeholder="City..." class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none">
            <input type="number" placeholder="Max Price" class="flex-1 px-4 py-2 border-t border-b focus:outline-none">
            <button class="bg-indigo-600 text-white px-6 rounded-r-lg hover:bg-indigo-700">
                Search
            </button>
        </div>
    </div>
</section>

<!-- Latest Colocations -->
<section class="py-16">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12">Latest Colocations</h3>

        <div class="grid md:grid-cols-3 gap-8">

            <!-- Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="https://source.unsplash.com/400x250/?apartment" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h4 class="text-xl font-bold mb-2">Modern Apartment - Casablanca</h4>
                    <p class="text-gray-600 mb-4">2 rooms • 1 bathroom • Near city center</p>
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-600 font-bold">2500 MAD / month</span>
                        <a href="#" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="https://source.unsplash.com/400x250/?room" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h4 class="text-xl font-bold mb-2">Shared Flat - Rabat</h4>
                    <p class="text-gray-600 mb-4">3 roommates • Close to university</p>
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-600 font-bold">1800 MAD / month</span>
                        <a href="#" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="https://source.unsplash.com/400x250/?house" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h4 class="text-xl font-bold mb-2">Cozy Room - Marrakech</h4>
                    <p class="text-gray-600 mb-4">1 room available • Calm neighborhood</p>
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-600 font-bold">1500 MAD / month</span>
                        <a href="#" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            View
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-6">
    <div class="container mx-auto px-6 text-center">
        <p>© 2026 ColocFinder. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
