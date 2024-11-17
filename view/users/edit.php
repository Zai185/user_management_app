<?php
require '../../bootstrap.php';
require ROOT_DIR . '/layouts/header.php';
require_login();
require_permission($_SESSION['email'], 'users', 'edit', 'index.php');
$user_id = $_GET['id'];
$user = user_get('id', $user_id);
if(!$user){
    session_flash('error', "Invalid User");
    redirect('features/users/index.php');
}
$roles = roles_all();


?>

<div>
    <div class="min-h-screen flex flex-auto flex-shrink-0 antialiased bg-white text-black ">

        <?php require ROOT_DIR . '/components/sidebar.php' ?>

        <form id="roleForm" action="<?= '/' . BASE_DIR . '/func/users/edit.php' ?>" method="post" class="py-2 px-4 flex-1">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <h2 class="text-2xl font-medium">Users</h2>
            <div>
                <p class="text-lg">Edit User</p>
                <div>
                    <div class="grid grid-cols-2 gap-4">

                        <fieldset class=" space-y-2 w-full border border-gray-800 px-2 mb-4 pb-2">
                            <legend>Personal Information</legend>
                            <div>
                                <label class="text-sm font-medium block">Name:</label>
                                <input type="text" placeholder="Name" name="name" class="border w-full py-2 px-4" required value="<?= $user['name'] ?>">
                                <?php if (isset($flash['name'])): ?>
                                    <p class="text-xs text-red-700"><?= $flash['name'] ?></p>
                                <?php endif ?>
                            </div>

                            <div>
                                <label class="text-sm font-medium block">Username:</label>
                                <input type="text" placeholder="@username" value="<?= $user['username'] ?>" name="username" class="border w-full py-2 px-4" required>
                            </div>

                            <div>
                                <label class="text-sm font-medium block">Phone:</label>
                                <input type="text" placeholder="+123456789" value="<?= $user['phone'] ?>" name="phone" class="border w-full py-2 px-4" required>
                            </div>

                            <div>
                                <label class="text-sm font-medium block">Address:</label>
                                <input type="text" placeholder="No.2, John San st." value="<?= $user['address'] ?>" name="address" class="w-full border py-2 px-4 " required>
                                <?php if (isset($flash['address'])): ?>
                                    <p class="text-xs text-red-700"><?= $flash['address'] ?> </p>
                                <?php endif ?>
                            </div>

                        </fieldset>
                        <fieldset class="space-y-2 w-full border border-gray-800 px-2 pb-2 mb-4">
                            <legend>Account Information</legend>
                            <div>
                                <label class="text-sm font-medium block">Email:</label>
                                <input type="email" placeholder="user@example.com" value="<?= $user['email'] ?>" name="email" class="w-full border py-2 px-4" required>
                                <?php if (isset($flash['email'])): ?>
                                    <p class="text-xs text-red-700"><?= $flash['email'] ?> </p>
                                <?php endif ?>
                            </div>

                            <div>
                                <label class="text-sm font-medium block">Password:</label>
                                <input type="password" placeholder="********" name="password" class="w-full border py-2 px-4">
                                <?php if (isset($flash['password'])): ?>
                                    <p class="text-xs text-red-700"><?= $flash['password'] ?> </p>
                                <?php endif ?>
                            </div>

                            <div>
                                <label class="text-sm font-medium block">Role:</label>
                                <select name="role_id" class="w-full border py-2 px-4" required>
                                <option value="" disabled selected>Select a role</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                                            <?= $role['name'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <?php if (isset($flash['role_id'])): ?>
                                    <p class="text-xs text-red-700"><?= $flash['role_id'] ?> </p>
                                <?php endif ?>
                            </div>

                        </fieldset>
                    </div>

                </div>
                <div>
                    <input type="radio" name="gender" value="0" <?= $user['gender'] == 0 ? 'checked' :  '' ?>>
                    <label>Male</label>
                    <input type="radio" name="gender" value="1" <?= $user['gender'] == 1 ? 'checked' :  '' ?>>
                    <label>Female</label>
                    <?php if (isset($flash['gender'])): ?>
                        <p class="text-xs text-red-700"><?= $flash['gender'] ?> </p>
                    <?php endif ?>
                </div>
                <input type="checkbox" name="is_active" <?= $user['is_active'] ? 'checked' : '' ?>>
                <label>Is Active</label>
            </div>
            <button type="submit" class="py-1 rounded-lg px-4 border bg-blue-700 text-white hover:bg-blue-900">submit</button>
        </form>



    </div>
</div>

<!-- <script>
    $(document).ready(function(){
        $('#roleForm').submit(function(e){
            e.preventDefault();
            var data = $(this).serializeArray();
            console.log(data)
        })
    })
</script> -->

<?php require ROOT_DIR . '/layouts/footer.php'; ?>