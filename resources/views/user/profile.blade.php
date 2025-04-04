<x-app-layout>
    <div class="relative" style="max-width: 1200px; margin: auto;">
        <!-- Cover Image Section -->
            <div class="bg-black flex items-center justify-center" style="height: 200px; border-radius: 0 0 20px 20px; overflow: hidden;">
                @if ($cover_image)
                    <img src="{{ asset('storage/'.$user->cover_image) }}" alt="user cover image" class="w-full h-full object-cover">
                @else
                    <img src='https://t3.ftcdn.net/jpg/04/67/96/14/360_F_467961418_UnS1ZAwAqbvVVMKExxqUNi0MUFTEJI83.jpg' alt="user cover image" class="w-full h-full object-cover">
                @endif
            </div>

            @auth
                @if (Auth::user()->id === $user_id)
                    <!-- Edit Button -->
                    <button class="absolute top-4 right-4 bg-transparent p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                @endif
            @endauth

            <!-- Profile Picture and User Info Section -->
            <div class="flex flex-col items-center bg-gray-700 pb-6 px-4 text-center dark:text-white" style="transform: translateY(-35%);">
                <div class="w-32 h-32 border-white flex items-center justify-center mb-4" style="width: 200px; height: 200px; border-radius: 50%; border: 4px solid white; overflow: hidden;">
                    @if($profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="user profile picture" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img src='https://i.ibb.co/sddfSJ9L/user.png' alt="user profile picture" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>

                <h2 class="text-xl font-semibold">{{ $user->name ?? 'User Full Name' }}</h2>

                <p class="text-sm">{{ $bio }}</p>

                @if (Auth::check() && Auth::user()->id != $user_id)
                <form action="{{ route('users.follow', $user->id) }}" method="POST" class="mt-1">
                    @csrf
                    <button type="submit" class="px-3 py-1 rounded-full transition duration-300" style="background-color: {{ $isFollowing ? '#FF1919' : '#1DA1F2' }}; color: white; border-radius: 5px;">
                        @if ($isFollowing)
                            Unfollow
                        @else
                            Follow
                        @endif
                    </button>
                </form>
                @else
                    <div class="mt-2">
                        <a href="{{ route('user.edit', ['user' => $user]) }}" class="px-3 py-1 rounded-full transition duration-300" style="background-color: #1DA1F2; color: white; border-radius: 5px;">
                            Edit Profile
                        </a>
                    </div>
                @endif

                <div class="flex justify-center space-x-8 mt-2 text-sm text-gray-300">
                    <!-- Followers Link -->
                    <a href="#" onclick="toggleModal('followersModal')">{{ $user->followers->count() ?? '0' }} Followers</a>
                    <!-- Following Link -->
                    <a href="#" onclick="toggleModal('followingModal')">{{ $user->following->count() ?? '0' }} Following</a>
                </div>

                <!-- Followers Modal -->
                <div id="followersModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" style="opacity:0.97">
                    <div class="bg-white rounded-lg shadow-lg w-100 p-4" style="min-width: 600px;">
                        <h3 class="text-lg font-semibold mb-4 dark:text-black">Followers</h3>
                        <ul>
                            @foreach ($user->followers as $follower)
                                <li class="flex justify-between items-center mb-2">
                                    <div class="flex items-center space-x-2">
                                        <img src="
                                        @if ($follower->profile_image)
                                            {{ asset('storage/'.$follower->profile_image) }}
                                        @else
                                            https://i.ibb.co/sddfSJ9L/user.png
                                        @endif
                                        " alt="user profile picture" style="width: 50px; height: 50px; object-fit: cover; border-radius:50%;">
                                        <span class="dark:text-black">{{ $follower->name }}</span>
                                    </div>
                                    <form action="{{ route('users.follow', $follower->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm px-2 py-1 rounded-full transition duration-300" style="background-color: {{ Auth::check() && Auth::user()->isFollowing($follower) ? '#FF1919' : '#1DA1F2' }}; color: white; border-radius: 5px;">
                                            {{ Auth::check() && Auth::user()->isFollowing($follower) ? 'Unfollow' : 'Follow' }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <button onclick="toggleModal('followersModal')" class="mt-4 px-4 py-2 bg-gray-300 rounded">Close</button>
                    </div>
                </div>

                <!-- Following Modal -->
                <div id="followingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" style="opacity:0.97;">
                    <div class="bg-white rounded-lg shadow-lg w-100 p-5" style="min-width: 600px;">
                        <h3 class="text-lg font-semibold mb-4 dark:text-black">Following</h3>
                        <ul>
                            @foreach ($user->following as $following)
                                <li class="flex justify-between items-center mb-2">
                                    <div class="flex items-center ">
                                        <img src="
                                        @if ($following->profile_image)
                                            {{ asset('storage/'.$following->profile_image) }}
                                        @else
                                            https://i.ibb.co/sddfSJ9L/user.png
                                        @endif
                                        " alt="user profile picture" style="width: 50px; height: 50px; object-fit: cover; border-radius:50%;" class="mr-2">
                                        <span class="dark:text-black">{{ $following->name }}</span>
                                    </div>
                                    <form action="{{ route('users.follow', $following->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm px-2 py-1 rounded-full transition duration-300" style="background-color: {{Auth::check() && Auth::user()->isFollowing($following) ? '#FF1919' : '#1DA1F2' }}; color: white; border-radius: 5px;">
                                            {{ Auth::check() && Auth::user()->isFollowing($following) ? 'Unfollow' : 'Follow' }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <button onclick="toggleModal('followingModal')" class="mt-4 px-4 py-2 bg-gray-300 rounded">Close</button>
                    </div>
                </div>

                <script>
                    function toggleModal(modalId) {
                        const modal = document.getElementById(modalId);
                        modal.classList.toggle('hidden');
                    }
                </script>
            </div>

        <!-- Main Content Section -->
        <div class="flex flex-col md:flex-row">
            <!-- Left Side - Posts -->
            <div class="w-full md:w-2/3 p-4">
                <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">{{ $user->name }} Posts</h3>

                @if(isset($user->posts) && $user->posts->count() > 0)
                    <div class="flex flex-row flex-wrap justify-start">
                        @foreach ($posts as $post)
                            <x-post-card :post="$post" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
