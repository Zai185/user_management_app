<div class="min-h-screen flex flex-auto flex-shrink-0 antialiased bg-white text-black ">

    <?php require view_path('/components/sidebar') ?>
    <div
        class="relative flex flex-col w-full h-screen overflow-y-auto text-gray-700 bg-white shadow-md rounded-xl bg-clip-border p-4">
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
                                <?php if (User::hasPermission('roles', 'edit')): ?>
                                    <a href="<?= "/roles/edit?id={$role['id']}" ?>" class="inline-block mx-2 font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                        Edit
                                    </a>
                                <?php endif ?>
                                <?php if (User::hasPermission('roles', 'delete')): ?>
                                    <button data-role-id="<?= $role['id'] ?>" class="btn_role_delete inline-block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900 cursor-pointer">
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


<div class="fixed inset-0 bg-gray-500/75 transition-opacity opacity-0 pointer-events-none closeDialogue" aria-hidden="true"></div>
<form action="/roles/delete" method="post" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 overflow-y-auto opacity-0 pointer-events-none" id="dialogue">
    <input type="hidden" name="id" id="role_id">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                        <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-900" id="modal-title">Delete account</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to Delete your account? All of your data will be permanently removed. This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                <button type="button" class="closeDialogue mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
            </div>
        </div>
    </div>
</form>
</div>


<script>
    $(document).ready(function() {
        $('.btn_role_delete').click(function() {
            $('#dialogue').removeClass('pointer-events-none opacity-0')
            $('.closeDialogue').removeClass('opacity-0 pointer-events-none')
            $('#role_id').val($(this).data('role-id'))
        })

        $('.closeDialogue').click(function() {
            $('#dialogue').addClass('opacity-0 pointer-events-none')
            $('.closeDialogue').addClass('opacity-0 pointer-events-none')
            $('#role_id').val('')
        })


    })
</script>