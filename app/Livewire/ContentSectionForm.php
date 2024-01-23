<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;


class ContentSectionForm extends Component
{

    

    // levels of contentsection

    // If type is `list` the following definitions, will be used to create a form to edit this Block
    // The array is nested in multiple levels
    // level 1: tabs (content, styling, config)
    // level 2: groups (heading, more details, settings)
    // level 3: input fields (the real input fields)
    

    // blueprint:

    // public $elements = [
    //     [
    //         'tabIdName' => 'content',
    //         'label' => 'Content',
    //         'rank' => 0,
    //         'groups' => [
    //             [
    //                 'idName' => 'teaser',
    //                 'label' => 'Teaser',
    //                 'rank' => 0,
    //                 'inputs' => [
    //                     [
    //                         'key' => 'headline',
    //                         'label' => 'Headline',
    //                         'rank' => 0,
    //                         'description' => 'This is at the top',
    //                         'hint' => 'Use something cool here',
    //                         'type' => 'text', // Default type
    //                         // 'defaultValue' => '...',
    //                         // 'options' => [
    //                         //     ['value' => 'val1', 'label' => 'title 1'],
    //                         //     ['value' => 'val2', 'label' => 'title 2'],
    //                         // ],
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ],
    // ];
    


    public $csType = 'list';
    public $templatePath = 'blocks/my_block/adminform';
    // public $values = [
    //     'content1' => 'string',
    //     'content2' => 'numeric',
    //     'content3' => 'string',
    // ];

    public $inputFieldDropdownValues = ['text', 'textarea', 'wysiwyg', 'select', 'radio', 'switch', 'checkbox'];

    // #[Reactive] 
    public $elements = [
        [
            'elementIdName' => 'headerElement',
            'label' => 'Header',
            'rank' => 0,
            'groups' => [
                [
                    'groupIdName' => 'firstGroupId',
                    'label' => 'Textfields in Header',
                    'rank' => 0,
                    'inputs' => [
                        [
                            'key' => 'firstInput',
                            'label' => '',
                            'rank' => 0,
                            'description' => '',
                            'hint' => '',
                            'type' => 'select',
                        ],
                        [
                            'key' => 'secondInput',
                            'label' => '',
                            'rank' => 0,
                            'description' => '',
                            'hint' => '',
                            'type' => 'text',
                        ]
                    ],
                ],
                [
                    'groupIdName' => 'secondGroupId',
                    'label' => '',
                    'rank' => 0,
                    'inputs' => [
                        [
                            'key' => 'second group input key',
                            'label' => '',
                            'rank' => 0,
                            'description' => '',
                            'hint' => '',
                            'type' => 'text',
                        ]
                    ],
                ]
            ],
        ],
        [
            'elementIdName' => 'contentElement',
            'label' => 'Content',
            'rank' => 1,
            'groups' => [
                [
                    'groupIdName' => 'gggroup',
                    'label' => '',
                    'rank' => 0,
                    'inputs' => [
                        [
                            'key' => '2nd element first group first input',
                            'label' => '',
                            'rank' => 0,
                            'description' => '',
                            'hint' => '',
                            'type' => 'select',
                            'options' => [
                                ['value' => 'val1', 'label' => 'title 1'],
                                ['value' => 'val2', 'label' => 'title 2'],
                            ]
                        ]
                    ],
                ]
            ],
        ]
    ];

     public $newElement = [];
     public $newGroup = [];
     public $newInput = [];


    public function render()
    {
        return view('livewire.content-section-form');
    }

    public function createJson()
    {
        $jsonObject = [
            'csType' => $this->csType,
            'template_path' => $this->templatePath,
            // 'values' => $this->values,
            'elements' => $this->elements,
        ];

        $encoded = json_encode($jsonObject);

        dd($encoded);
    }

    public function addElement()
    {
        $newElement = 
            [
                'elementIdName' => 'new',
                'label' => '',
                'rank' => 0,
                'groups' => [
                    [
                        'groupIdName' => 'firstGroupId',
                        'label' => '',
                        'rank' => 0,
                        'inputs' => [
                            [
                                'key' => 'firstInput',
                                'label' => '',
                                'rank' => 0,
                                'description' => '',
                                'hint' => '',
                                'type' => 'text',
                            ]
                        ],
                    ]
                ]
            ];

        $this->elements[] = $newElement;

    }

    public function removeElement($elementKey)
    {
        unset($this->elements[$elementKey]);
    }

    public function addGroup($elementKey)
    {
        $newNestedArray = [
            'groupIdName' => '',
            'label' => '',
            'rank' => 0,
            'inputs' => [
                [
                    'key' => '',
                    'label' => '',
                    'rank' => 0,
                    'description' => '',
                    'hint' => '',
                    'type' => 'text',
                ]
            ],
        ];


        array_push($this->elements[$elementKey]['groups'], $newNestedArray);
    }

    public function addInput($elementKey, $groupKey)
    {
        $newNestedInputArray = [
            'key' => '',
            'label' => '',
            'rank' => 0,
            'description' => '',
            'hint' => '',
            'type' => 'text',
        ];

        array_push($this->elements[$elementKey]['groups'][$groupKey]['inputs'], $newNestedInputArray);
    }

    public function removeInput($elementKey, $groupKey, $inputKey)
    {
        unset($this->elements[$elementKey]['groups'][$groupKey]['inputs'][$inputKey]);
    }

    public function removeGroup($elementKey, $groupKey)
    {
        unset($this->elements[$elementKey]['groups'][$groupKey]);
    }

    public function addOption($elementKey, $groupKey, $inputKey)
    {
        $newNestedOptionArray = [
            'value' => '',
            'label' => '',
        ];

        array_push($this->elements[$elementKey]['groups'][$groupKey]['inputs'][$inputKey]['options'], $newNestedOptionArray);
    }

    public function removeOption($elementKey, $groupKey, $inputKey, $optionKey)
    {
        unset($this->elements[$elementKey]['groups'][$groupKey]['inputs'][$inputKey]['options'][$optionKey]);
    }
}
