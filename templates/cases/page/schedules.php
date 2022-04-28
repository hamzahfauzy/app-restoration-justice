<div class="content mt-3">
    <a href="<?=routeTo('case-schedules/create',['case_id'=>$data->id])?>" class="btn btn-primary">Buat Jadwal</a>
    <p></p>
    <div class="table-responsive">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->schedules as $index => $schedule): ?>
                <tr>
                    <td><?= $index+1 ?></td>
                    <td><?= $schedule->date ?></td>
                    <td><?= $schedule->place ?></td>
                    <td><a href="<?= $schedule->meeting_url ?>"><?= $schedule->meeting_url ?></a></td>
                    <td>
                        <?php if($schedule->status == null): ?>
                            <a href="<?=routeTo('case-schedules/finish',['id'=>$schedule->id])?>" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Selesaikan</a>
                        <?php else: ?>
                            <?= $schedule->status ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="<?=routeTo('case-schedules/edit',['id'=>$schedule->id])?>" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="<?=routeTo('case-schedules/delete',['id'=>$schedule->id])?>" onclick="if(confirm('apakah anda yakin akan menghapus data ini ?')){return true}else{return false}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>