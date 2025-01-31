<?php
// Controllers/SettingsController.php

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../Models/SettingsModel.php';

class SettingsController
{
    private $staffModel;

    public function __construct($pdo)
    {
        $this->staffModel = new SettingsModel($pdo);
    }

    public function changePassword($staffId, $currentPassword, $newPassword, $confirmPassword)
    {
        $existingPassword = $this->staffModel->getPasswordById($staffId);

        // Şifre doğrulama (düz metin karşılaştırma)
        if ($existingPassword !== $currentPassword) {
            return [
                'success' => false,
                'message' => 'Mevcut şifre hatalı.'
            ];
        }

        if ($newPassword !== $confirmPassword) {
            return [
                'success' => false,
                'message' => 'Yeni şifreler eşleşmiyor.'
            ];
        }

        if (strlen($newPassword) < 6) {
            return [
                'success' => false,
                'message' => 'Yeni şifre en az 6 karakter olmalıdır.'
            ];
        }

        $updateSuccess = $this->staffModel->updatePassword($staffId, $newPassword);

        return [
            'success' => $updateSuccess,
            'message' => $updateSuccess ? 'Şifre başarıyla güncellendi.' : 'Şifre güncellenemedi.',
            'redirectUrl' => 'Index.php'
        ];
    }

    public function handlePasswordChangeRequest()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];
            $staffId = $_SESSION['_staffId'];

            $response = $this->changePassword($staffId, $currentPassword, $newPassword, $confirmPassword);

            // JSON yanıtını döndür
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        return null;
    }
}
