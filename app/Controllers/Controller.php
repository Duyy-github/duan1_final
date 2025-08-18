<?php
namespace App\Controllers;

class Controller
{
    public function validate($validator, $data, $rules)
    {
        $validation = $validator->make($data, $rules);

        // then validate
        $validation->validate();

        if ($validation->fails()) {
            return $validation->errors()->firstOfAll();
        }

        return [];
    }

    public function logError($message)
    {
        $date = date('d-m-Y');

        $message = date('d-m-Y H:i:s') . ' - ' . $message . PHP_EOL;

        // Type: 3 - Ghi vào file
        error_log($message, 3, "storage/logs/$date.log");
    }

    public function uploadFile(array $file, $folder = null)
    {
        $fileTmpPath = $file['tmp_name'];
        $fileName = time() . '-' . $file['name'];

        // Thay đổi đường dẫn upload vào thư mục public
        $uploadDir = 'public/uploads/' . $folder . '/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Trả về đường dẫn tương đối từ thư mục public
            return 'public/uploads/' . $folder . '/' . $fileName;
        }

        throw new \Exception('Lỗi upload file!');
    }
}
