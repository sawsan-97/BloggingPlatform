<x-app-layout>
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($posts)
            <header class="text-center py-5 mt-5 mb-3">
                <h2 class="text-2xl font-medium dark:text-white">Latest Blog Posts</h2>
            </header>

            <livewire:latest-blog-posts />

            @else
            <header class="text-center py-5 mt-5 mb-3">
                <h2 class="text-2xl font-medium dark:text-white">There are no posts here!</h2>
            </header>
            @endif
        </section>
    </div>
</x-app-layout>
