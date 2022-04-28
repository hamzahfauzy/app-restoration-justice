<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Pengguna Kantor : <?=$data->name?></h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen data pengguna</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="<?=routeTo('offices/index')?>" class="btn btn-warning btn-round">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="user_office[office_id]" value="<?=$data->id?>">
                                <div class="form-group">
                                    <label for="">Pengguna</label>
                                    <select name="user_office[user_id]" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php foreach($users as $user): ?>
                                        <option value="<?=$user->id?>"><?=$user->name?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if($success_msg): ?>
                            <div class="alert alert-success"><?=$success_msg?></div>
                            <?php endif ?>
                            <div class="table-responsive table-hover table-sales">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="20px">#</th>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                            <th class="text-right"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($data->users)): ?>
                                        <tr>
                                            <td colspan="4" style="text-align:center"><i>Tidak ada data</i></td>
                                        </tr>
                                        <?php endif ?>
                                        <?php foreach($data->users as $index => $user): ?>
                                        <tr>
                                            <td>
                                                <?=$index+1?>
                                            </td>
                                            <td><?=$user->user->name?></td>
                                            <td><?=get_role($user->user_id)->name?></td>
                                            <td>
                                                <a href="<?=routeTo('offices/delete-user',['id'=>$user->id])?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>