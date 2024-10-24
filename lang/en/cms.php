<?php

declare(strict_types=1);

return [
    'Category' => 'Category',
    'article' => 'Article',
    'tag' => 'Tag',
    'created_at' => 'Created at',
    'updated_at' => 'Updated at',
    'category' => [
        'name' => 'Name',
        'count' => 'Count',
        'description' => 'Description',
        'additionalParamsName' => 'Additional Parameters',
        'additionalParams' => [
            'name' => 'Name',
            'typeName' => 'Type',
            'type' => [
                'TextInput' => 'Text Input',
                'Textarea' => 'Textarea',
            ],
        ],
    ],
    'articleFields' => [
        'title' => 'Title',
        'content' => 'Content',
        'cover' => 'Cover',
        'category' => 'Category',
        'tag' => 'Tags',
        'additional_params' => 'Additional Params',
    ],
];
