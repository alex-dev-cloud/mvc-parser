<div class="content-container">
    <?php if(!empty($data['users'])):?>
        <div class="card center table-responsive-md">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Login</th>
                    <th scope="col">Email</th>
                    <th scope="col">Activated</th>
                    <th scope="col">Signed</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['users'] as $user):?>
                    <tr>
                        <td><?=$user->id?></td>
                        <td><?=$user->login;?></td>
                        <td><?=$user->email?></td>
                        <td><?=$user->is_active?></td>
                        <td><?=$user->reg_date?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <?php endif;?>
</div>