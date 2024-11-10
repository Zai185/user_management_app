<?php
require '../../bootstrap.php';
require  ROOT_DIR . '/layouts/header.php';
require_login();
require_permission($_SESSION['email'], 'roles', 'edit', 'index.php');

$permissions = features_permissions();
$role_id = $_GET['id'];
$allowed_roles = role_permissions_get($role_id);

if(!$allowed_roles){
    session_flash('error', "Invalid Role");
    redirect('features/roles/index.php');
}
$results = [];
foreach ($permissions as $p) {
    $results[$p['feature_name']][] = $p;
}

?>

<div>
    <div class="min-h-screen flex flex-auto flex-shrink-0 antialiased bg-white text-black ">

        <?php require ROOT_DIR . '/components/sidebar.php' ?>

        <form id="roleForm" action="<?= '/' . BASE_DIR . '/func/roles/edit.php' ?>" method="post" class="py-2 px-4 flex-1">
            <input type="hidden" name="role_id" value="<?= $role_id?>">
            <h2 class="text-2xl font-medium">Roles</h2>
            <div>
                <p class="text-lg">Edit User Role</p>
                <input type="text" placeholder="Role Name" name="role" class="border py-2 px-4" required value="<?= $allowed_roles['name'] ?>">
            </div>

            <?php if (isset($flash['role_permission'])): ?>
                <p class="text-xs text-red-700"><?= $flash['role_permission'] ?> </p>
            <?php endif ?>
            <?php foreach ($results as $feature => $permissions) : ?>
                <div class="flex items-center my-2 bg-gray-100 py-1 px-2">
                    <h4 class="capitalize w-24"><?= $feature ?></h4>

                    <div class="flex gap-4 items-center">
                        <div class="flex items-center gap-1">

                            <input
                                type="checkbox"
                                class="btn-all"
                                data-feature-all="<?= $feature ?>">
                            <label for="">
                                All
                            </label>
                        </div>
                        <?php foreach ($permissions as $p): ?>
                            <div class=" flex items-center gap-1">

                                <input
                                    class="checkbox "
                                    type="checkbox"
                                    name="role_permission[]"
                                    data-feature="<?= $feature ?>"
                                    value="<?= $p['id'] ?>"
                                    <?= in_array($p['id'], $allowed_roles['permissions']) ? "checked" : '' ?>>
                                <label class="capitalize">
                                    <?= $p['name']  ?> 
                                </label>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach ?>

            <button type="submit" class="py-1 rounded-lg px-4 border bg-blue-700 text-white hover:bg-blue-900">submit</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-all').click(function() {
            let feature = $(this).data('feature-all');
            let datas = $(`[data-feature = ${feature}]`)
            let is_checked = $(this).prop('checked')
            for (let i = 0; i < datas.length; i++) {
                $(datas[i]).prop('checked', is_checked)
            }
        })

        $('.checkbox').click(function() {
            let feature = $(this).data('feature');
            let btn_all = $(`[data-feature-all = ${feature}]`)
            let datas = $(`[data-feature = ${feature}]`)
            for (let i = 0; i < datas.length; i++) {
                if (!$(datas[i]).prop('checked')) {
                    btn_all.prop('checked', false)
                    return
                }
            }
            btn_all.prop('checked', true)
        })
    })
</script>

<?php require 'layouts/footer.php'; ?>