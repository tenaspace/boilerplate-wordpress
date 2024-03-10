<?php

return [
  'notFound' => [
    'title' => 'OOOps! Không tìm thấy nội dung này',
    'description' => 'Xin lỗi vì sự bất tiện này! Vui lòng quay về trang chủ để tiếp tục điều hướng.',
    'backToHome' => 'Quay về trang chủ',
  ],
  'components' => [
    'forms' => [
      'contact' => [
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
          'phoneNumber' => [
            'label' => 'Số điện thoại',
            'message' => [
              'required' => 'Số điện thoại là bắt buộc.',
              'min' => 'Số điện thoại không hợp lệ.',
              'max' => 'Số điện thoại không hợp lệ.',
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