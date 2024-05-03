<?php
return [
  'pages' => [
    'notFound' => [
      'title' => 'OOOps! Page not found',
      'description' => 'Sorry about that! Please visit our home page to get where you need to go.',
      'backToHome' => 'Back to home page',
    ],
    'search' => [
      'searchForKeywords' => 'Search for keywords',
    ],
  ],
  'templates' => [],
  'breadcrumb' => [
    'home' => 'Home',
    'searchForKeywords' => 'Search for keywords',
    'notFound' => 'Page not found',
  ],
  'components' => [
    'forms' => [
      'sample' => [
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
          'telephone' => [
            'label' => 'Telephone',
            'message' => [
              'required' => 'Telephone is required.',
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