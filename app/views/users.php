<div class="content-container">
    <?php if(!empty($data['users'])):?>
        <div class="card users-block table-responsive-md">
            <table class="table users-table">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Login</th>
                    <th scope="col">Email</th>
                    <th scope="col">Activated</th>
                    <th scope="col">Signed</th>
                    <?php if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1):?>
                        <th scope="col">Ip</th>
                        <th scope="col">Device</th>
                    <?php endif;?>
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
                        <?php if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1):?>
                            <th scope="col"><?=$user->reg_ip?></th>
                            <th scope="col"><?=$user->reg_uagent?></th>
                        <?php endif;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a class="btn btn-secondary" href="<?= URL . 'user/download'?>">Download</a>
        </div>
    <?php endif;?>
</div>