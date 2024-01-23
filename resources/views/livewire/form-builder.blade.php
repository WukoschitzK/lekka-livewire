<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <button wire:click="openFormBuilder">form builder</button>

    @if ($openFormBuilderModal)
        <div class="shadow-sm p-8">
            <h2>test</h2>

            <livewire:content-section-form />
            
        </div>
    @endif
</div>
