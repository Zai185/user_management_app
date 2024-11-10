<?php
require '../../bootstrap.php';
require_login();
require_permission($_SESSION['email'], 'users', 'view', 'index.php');
require ROOT_DIR . '/layouts/header.php';
$users = users_all();
?>
<div class="min-h-screen flex flex-auto flex-shrink-0 antialiased bg-white text-black ">

    <?php require ROOT_DIR . '/components/sidebar.php' ?>
    <div
        class="relative flex flex-col w-full h-full overflow-y-auto text-gray-700 bg-white shadow-md rounded-xl bg-clip-border p-4">
        <h2 class="text-2xl font-medium">Users</h2>
        <p class="text-lg">User List</p>

        <?php if (count($users) > 0): ?>

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
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Email
                            </p>
                        </th>
                        <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                            <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">Actions</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    <?= $index + 1 ?>
                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    <?= $user['name'] ?>

                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50">
                                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    <?= $user['email'] ?>

                                </p>
                            </td>
                            <td class="p-4 border-b border-blue-gray-50 w-48">
                                <?php if (require_permission($_SESSION['email'], 'users', 'edit')): ?>
                                    <a href="<?= 'edit.php?id=' . $user['id'] ?>" class="inline-block mx-2 font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                        Edit
                                    </a>
                                <?php endif ?>
                                <?php if (require_permission($_SESSION['email'], 'users', 'delete')): ?>
                                    <button data-user-id="<?= $user['id'] ?>" class="btn_user_delete inline-block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
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
        $('.btn_user_delete').click(function() {
            if (confirm("Are you sure to delete this user?")) {
                let base_url = "<?= BASE_DIR;?>";
                let user_id = $(this).data('user-id');
                console.log(user_id)
                $.ajax({
                    method: 'post',
                    url: `/${base_url}/func/users/delete.php`,
                    data: {
                        id: user_id
                    },
                    success: function(res) {
                        location.reload();
                    }
                })
            }
        })
    })
</script>

<?php require ROOT_DIR . '/layouts/footer.php'; ?>