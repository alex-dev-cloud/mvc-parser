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
                        <td><?=$user->is_active ? 'activated' : 'not activated' ?></td>
                        <td><?=$user->reg_date?></td>
                        <?php if(!empty($_SESSION['user']) && $_SESSION['user']->role == 1):?>
                            <th scope="col"><?=$user->reg_ip?></th>
                            <th scope="col"><?=$user->reg_uagent?></th>
                        <?php endif;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-secondary btn-block" href="<?= URL . 'user/download'?>">Download all</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-info btn-block" href="<?= URL . 'user/download/activated'?>">Download activated</a>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>