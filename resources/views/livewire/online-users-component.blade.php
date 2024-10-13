<div>

{{--    <div class="flex flex-col space-y-4">--}}
{{--        @foreach($users as $user)--}}
{{--        <div class="flex flex-row items-center p-2  rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">--}}
{{--            <img--}}
{{--                class="w-14 h-14 rounded-lg shadow-md"--}}
{{--                src="https://avatars.githubusercontent.com/u/57622665?s=460&u=8f581f4c4acd4c18c33a87b3e6476112325e8b38&v=4"--}}
{{--                alt="Ahmed Kamel"--}}
{{--            />--}}
{{--            <div class="flex flex-col pl-3"> <!-- Increased padding for better spacing -->--}}
{{--                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
    @foreach($users as $user)
    <div class="flex flex-row py-4 px-2 items-center border-b-2">
        <div class="w-1/4">
            <img
                src="https://avatars.githubusercontent.com/u/57622665?s=460&u=8f581f4c4acd4c18c33a87b3e6476112325e8b38&v=4"
                class="object-cover h-12 w-12 rounded-full"
                alt=""
            />
        </div>
        <div class="w-full">
            <div class="text-lg font-semibold">{{ $user->name }}</div>
        </div>
    </div>
    @endforeach
</div>
