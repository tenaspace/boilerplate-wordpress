<?php

return [
  'notFound' => [
    'title' => 'OOOps! Page not found',
    'description' => 'Sorry about that! Please visit our home page to get where you need to go.',
    'backToHome' => 'Back to home page',
  ],
  'components' => [
    'forms' => [
      'contact' => [
        'inputs' => [
          'fullName' => [
            'label' => 'Full name',
            'message' => [
              'required' => 'Full name is required.',
            ],
          ],
          'email' => [
            'label' => 'E-Mail',
            'message' => [
              'required' => 'E-Mail is required.',
              'pattern' => 'E-Mail is not valid.',
            ],
          ],
          'phoneNumber' => [
            'label' => 'Phone number',
            'message' => [
              'required' => 'Phone number is required.',
              'min' => 'Phone number is not valid.',
              'max' => 'Phone number is not valid.',
            ],
          ],
          'message' => [
            'label' => 'Message',
          ],
        ],
        'submit' => [
          'label' => 'Submit',
        ],
        'pending' => 'Processing',
        'responses' => [
          'success' => 'Submitted successfully!',
          'error' => 'Error occurred!',
        ],
        'mailTemplates' => [
          'admin' => [
            'subject' => 'Contact request',
          ],
          'user' => [
            'subject' => 'Thank you for contacting us',
          ],
        ],
      ]
    ]
  ]
];

?>