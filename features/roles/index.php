<?php
require '../../bootstrap.php';
require_login();
require_permission($_SESSION['email'], 'roles', 'view', 'index.php');
require ROOT_DIR . '/layouts/header.php';
$roles = roles_all();
?>
<div class="min-h-screen flex flex-auto flex-shrink-0 antialiased bg-white text-black ">

    <?php require ROOT_DIR . '/components/sidebar.php' ?>
    <div
        class="relative flex flex-col w-full h-full overflow-y-auto text-gray-700 bg-white shadow-md rounded-xl bg-clip-border p-4">
        <h2 class="text-2xl font-medium">Roles</h2>
        <p class="text-lg">Role List</p>

        <?php if (count($roles) > 0): ?>

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
                                Name
                            </p>
                        </th>
                        <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">Actions</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $index => $role): ?>
                        <tr>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    <?= $index + 1 ?>
                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    <?= $role['name'] ?>

                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50 w-48">
                                <?php if (require_permission($_SESSION['email'], 'roles', 'edit')): ?>
                                    <a href="<?= 'edit.php?id=' . $role['id'] ?>" class="inline-block mx-2 font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                        Edit
                                    </a>
                                <?php endif ?>
                                <?php if (require_permission($_SESSION['email'], 'roles', 'delete')): ?>
                                    <button data-role-id="<?= $role['id'] ?>" class="btn_role_delete inline-block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                        Delete
                                    </button>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        <?php else: ?>
            <h2 class="text-3xl text-center">No role yet!</h2>
        <?php endif ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn_role_delete').click(function() {
            if (confirm("Are you sure to delete this role?")) {
                let base_url = "user_management"
                let role_id = $(this).data('role-id');
                $.ajax({
                    method: 'post',
                    url: `/${base_url}/func/roles/delete.php`,
                    data: {
                        id: role_id
                    },
                    success: function(res) {
                        location.reload();
                    }
                })
            }
        })
    })
</script>

<?php require ROOT_DIR . "/layouts/footer.php"; ?>