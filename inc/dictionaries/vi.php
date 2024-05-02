<?php
return [
  'pages' => [
    'notFound' => [
      'title' => 'OOOps! Không tìm thấy nội dung này',
      'description' => 'Xin lỗi vì sự bất tiện này! Vui lòng quay về trang chủ để tiếp tục điều hướng.',
      'backToHome' => 'Quay về trang chủ',
    ],
    'search' => [
      'searchForKeywords' => 'Tìm kiếm cho từ khóa',
    ],
  ],
  'templates' => [],
  'breadcrumb' => [
    'home' => 'Trang chủ'
  ],
  'components' => [
    'forms' => [
      'sample' => [
        'inputs' => [
          'fullName' => [
            'label' => 'Họ và tên',
            'message' => [
              'required' => 'Họ và tên là bắt buộc.',
            ],
          ],
          'email' => [
            'label' => 'E-Mail',
            'message' => [
              'required' => 'E-Mail là bắt buộc.',
              'pattern' => 'E-Mail không hợp lệ.',
            ],
          ],
          'telephone' => [
            'label' => 'Số điện thoại',
            'message' => [
              'required' => 'Số điện thoại là bắt buộc.',
            ],
          ],
          'message' => [
            'label' => 'Lời nhắn',
          ],
        ],
        'submit' => [
          'label' => 'Gửi',
        ],
        'pending' => 'Đang xử lý',
        'responses' => [
          'success' => 'Gửi thành công!',
          'error' => 'Đã có lỗi xảy ra!',
        ],
        'mailTemplates' => [
          'admin' => [
            'subject' => 'Yêu cầu liên hệ',
          ],
          'user' => [
            'subject' => 'Cảm ơn vì đã liên hệ với chúng tôi',
          ],
        ],
      ]
    ]
  ]
];
?>