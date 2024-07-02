@props(["image", "color", "alt"])

<div class="relative w-24 h-fit">
    <img class="w-28 h-fit rounded-full" src="{{$image}}" alt="{{$alt}}">
    <span style="background:{{$color}};}" class="bottom-0 left-16 absolute w-3.5 h-3.5 border-2 border-white dark:border-gray-800 rounded-full"></span>
</div>
