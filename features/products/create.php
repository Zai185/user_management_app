<?php
require '../../bootstrap.php';
require  ROOT_DIR . '/layouts/header.php';
require_login();
require_permission($_SESSION['email'], 'products', 'create');

?>

<div>
    <div class="min-h-screen flex flex-auto flex-shrink-0 antialiased bg-white text-black ">

        <?php require ROOT_DIR . '/components/sidebar.php' ?>

        <div class="flex-1 flex items-center justify-center text-4xl font-bold">

            Product Create Form
        </div>
    </div>
</div>

<?php require 'layouts/footer.php'; ?>