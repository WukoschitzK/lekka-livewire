<div>
    <nav>
        <ul class="flex justify-center my-8">
            <li class="mx-4">
            </li>
            <li class="mx-4">
                {{-- TODO: add to presentation, navigation without loading page --}}
                <a href="{{ route('recipes') }}" wire:navigate>All Recipes</a>
            </li>
            <li>
                <a href="{{ route('my-recipes') }}" wire:navigate>My Recipes</a>
            </li>
        </ul>
    </nav>
</div>
