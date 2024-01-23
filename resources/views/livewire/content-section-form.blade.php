<div>
    <h2 class="text-xl w-full bg-gray-100 px-3 py-2 mb-5">Content Section Layout</h2>
    <div class="flex justify-start">

        <div>
            <div>
                <h2 class="text-lg bg-gray-100 px-3 py-2">General</h2>
                <label for="csType">Choose a type:</label>
                <select wire:model="csType" name="csType" id="csType" class="border py-1 px-2">
                    <option value="list">List</option>
                    <option value="custom">Custom</option>
                </select>
            </div>

            <div>
                <label for="templatePath">Template Path:</label>
                <input wire:model="templatePath" type="text" name="templatePath" id="templatePath" class="border py-1 px-2">
            </div>
        </div>

        <div class="">
            <h2 class="text-lg bg-gray-100 px-3 py-2">Attributes</h2>
            <div >
                <h3>Tabs</h3>

                @foreach($elements as $elementKey => $value)
                    <fieldset>
                        @if(is_array($value))
                            <div class="ml-12">
                                <div class="flex justify-between">
                                    <label class="bg-gray-100 p-2">{{$loop->iteration}}. Tab:</label>
                                    <button class="border-2 border-red-700 p-2 text-red-700 font-bold" wire:click="removeElement('{{ $elementKey }}')">Delete Tab</button>
                                </div>
                                
                                <div class="ml-12">
                                @foreach($value as $nestedKey => $nestedValue)
                                    @if(is_array($nestedValue))
                                        <div class="ml-12">
                                            {{-- group input fields --}}

                                            <label> {{ ucfirst($nestedKey) }}:</label>

                                            @foreach($nestedValue as $innerKey => $innerValue)
                                            <div class="ml-12 border-b-2 py-5">
                                                <div class="flex justify-between">
                                                    <h2 class="bg-gray-100 p-2">{{$loop->iteration}}. Group:</h2>
                                                    <button class="border-2 border-red-700 p-2 text-red-700 font-bold" wire:click="removeGroup('{{ $elementKey }}', '{{ $innerKey }}')">Delete Group</button>
                                                </div>

                                                <div>
                                                    @foreach($innerValue as $secondInnerKey => $secondInnerValue)
                                                        <label>{{ ucfirst($secondInnerKey) }}:</label>
                                                        @if(!is_array($secondInnerValue))
                                                            <input type="text" wire:model="elements.{{ $elementKey }}.{{ $nestedKey }}.{{ $innerKey }}.{{$secondInnerKey}}" class="border py-1 px-2">
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </div>


                                                {{-- input input fields --}}
                                                <div class="ml-12">
                                                @foreach($innerValue['inputs'] as $inputKey => $inputValue)
                                                        <h2 class="bg-gray-100 p-2">{{$loop->iteration}}. Input:</h2>
                                                        <div class="ml-12 border-b-2 py-5 flex">
                                                            <div>
                                                                @foreach($inputValue as $secondInnerKey => $secondInnerValue)
                                                                    @if ($secondInnerKey == 'type')
                                                                    
                                                                        <label> {{ ucfirst($secondInnerKey) }}:</label>
                                                                        <select wire:model="elements.{{ $elementKey }}.{{ $nestedKey }}.{{ $innerKey }}.inputs.{{ $inputKey }}.{{$secondInnerKey}}" class="border py-1 px-2">
                                                                            
                                                                            @foreach ($inputFieldDropdownValues as $typeValue )
                                                                                <option value="{{$typeValue}}">{{$typeValue}}</option>
                                                                            @endforeach

                                                                        </select>
                                                                        <br>

                                                                    {{-- options if select type  --}}
                                                                    @elseif (is_array($secondInnerValue))
                                                                        <label class="bg-gray-100 p-2"> {{ ucfirst($secondInnerKey) }}:</label>
                                                                        <br>
                                                                        <div class="ml-12">

                                                                            @foreach($secondInnerValue as $thirdInnerKey => $thirdInnerValue)
                                                                                @if(is_array($thirdInnerValue))
                                                                                    @foreach ($thirdInnerValue as $fourthInnerKey => $fourthInnerValue )
                                                                                        <div>
                                                                                            <label> {{ ucfirst($fourthInnerKey) }}:</label>
                                                                                            <input type="text" wire:model="elements.{{ $elementKey }}.{{ $nestedKey }}.{{ $innerKey }}.inputs.{{ $inputKey }}.{{$secondInnerKey}}.{{$thirdInnerKey}}.{{$fourthInnerKey}}" class="border py-1 px-2">
                                                                                            <br>
                                                                                        </div>
                                                                                    @endforeach

                                                                                    <button class="border border-2 p-2" wire:click="removeOption('{{$elementKey}}', '{{$innerKey}}', '{{$inputKey}}', '{{$thirdInnerKey}}')">Remove option</button>
                                                                                    <br>
                                                                                @endif                                                                            
                                                                            @endforeach
                                                                            
                                                                            <button class="border border-2 p-2 border-gray-700" wire:click="addOption('{{$elementKey}}', '{{$innerKey}}', '{{$inputKey}}')">Add Option</button>
                                                                        
                                                                        </div>
                                                                    @else
                                                                        <label> {{ ucfirst($secondInnerKey) }}:</label>
                                                                        <input type="text" wire:model="elements.{{ $elementKey }}.{{ $nestedKey }}.{{ $innerKey }}.inputs.{{ $inputKey }}.{{$secondInnerKey}}" class="border py-1 px-2">
                                                                        <br> 
                                                                        
                                                                    @endif
                                                                    
                                                                @endforeach
                                                            </div>
                                                        
                                                            <button class="border border-red-600 p-3 font-bold mt-5 text-red-600 self-end" wire:click="removeInput('{{$elementKey}}', '{{$innerKey}}', '{{$inputKey}}')">Remove Input</button>
                                                        </div>
                                                @endforeach
                                                </div>
                                                
                                                <button class="border border-black p-3 font-bold mt-5" wire:click="addInput('{{$elementKey}}', '{{$innerKey}}')">Add Input</button>

                                            </div>
                                            @endforeach
                                        </div>
                                        
                                        <button  class="border border-black p-3 font-bold mt-5" wire:click="addGroup('{{ $elementKey }}')">Add Group</button>

                                    @else
                                    {{-- element input fields --}}
                                        <label>{{ ucfirst($nestedKey) }}:</label>
                                        <input type="text" wire:model="elements.{{ $elementKey }}.{{ $nestedKey }}" class="border py-1 px-2">
                                        <br>
                                    @endif
                                @endforeach
                                </div>
                            </div>
                        @else
                       
                            <label for="{{ $elementKey }}"> {{ ucfirst($elementKey) }}:</label>
                            <input type="text" wire:model="elements.{{ $elementKey }}" class="border py-1 px-2">
                            <br>
                        @endif
                    </fieldset>
                @endforeach

                <button wire:click="addElement()" class="border border-black p-3 font-bold mt-5">Another Tab</button>

            </div>
       
        </div>
    </div>

    <button class="border-4 p-5 border-green-700 text-green-700 font-bold" wire:click="createJson">create new json</button>

</div>
