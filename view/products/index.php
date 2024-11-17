<?php
require '../../bootstrap.php';
require_login();
require_permission($_SESSION['email'], 'products', 'view', 'index.php');
require ROOT_DIR . '/layouts/header.php';

?>

<div class="min-h-screen flex flex-auto flex-shrink-0 antialiased bg-white text-black ">

    <?php require ROOT_DIR . '/components/sidebar.php' ?>

    <div
        class="p-4 relative flex flex-col w-full h-full overflow-y-auto text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
        <h2 class="text-2xl font-medium">Products</h2>
        <p class="text-lg">View Product List</p>
        <table class="border border-gray-400 shadow-lg w-full text-left table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            No.
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Product Name
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Created On
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">Actions</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            1
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            Example Product 1
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                            23/04/18
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50 w-48">
                        <?php if (require_permission($_SESSION['email'], 'products', 'edit')): ?>
                            <a href="#" class="inline-block mx-2 font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                Edit
                            </a>
                        <?php endif ?>
                        <?php if (require_permission($_SESSION['email'], 'products', 'delete')): ?>
                            <button class="btn_role_delete inline-block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                Delete
                            </button>
                        <?php endif ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>