<div class="content mt-3">
    <a href="<?=routeTo('case-agreements/create',['case_id'=>$data->id])?>" class="btn btn-primary">Buat Persetujuan</a>
    <p></p>
    <div class="table-responsive">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>WA</th>
                    <th>Sebagai</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->agreements as $index => $agreement): ?>
                <tr>
                    <td><?= $index+1 ?></td>
                    <td><?= $agreement->name ?></td>
                    <td><?= $agreement->phone ?></td>
                    <td><?= $agreement->agreement_as ?></td>
                    <td><?= $agreement->status ?? 'Belum Verifikasi' ?></td>
                    <td>
                        <a href="<?=routeTo('case-agreements/edit',['id'=>$agreement->id])?>" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="<?=routeTo('case-agreements/delete',['id'=>$agreement->id])?>" onclick="if(confirm('apakah anda yakin akan menghapus data ini ?')){return true}else{return false}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>