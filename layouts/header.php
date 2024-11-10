<?php
$flash = [];
if (isset($_SESSION['FLASH'])) {
    $flash = $_SESSION['FLASH'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .animate-fade-out {
            animation: fade-out 8s ease forwards;
        }

        @keyframes fade-out {
            from {
                opacity: 0;

            }

            5%,
            80% {
                opacity: 1;
                transform: translateY(0);
            }

            from,
            90% {
                opacity: 0;
                transform: translateY(-24px);

            }

            to {
                display: none;
                opacity: 0;
                transform: translateY(-24px);
            }

        }
    </style>
</head>

<body>

    <?php if (isset($flash['error'])): ?>
        <div class="fixed top-2 right-4 rounded-lg z-[100] bg-red-800 text-white py-1 px-4 border border-red-400 animate-fade-out translate-y-6">
            <?= $flash['error'] ?>
        </div>
    <?php endif ?>
    <?php if (isset($flash['success'])): ?>
        <div class="fixed top-2 right-4 rounded-lg z-[100] bg-green-800 text-white py-1 px-4 border border-green-400 animate-fade-out translate-y-6">
            <?= $flash['success'] ?>
        </div>
    <?php endif ?>