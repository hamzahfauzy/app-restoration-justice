<div class="content mt-3">
    <div class="table-responsive">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>WA</th>
                    <th>Sebagai</th>
                    <th>Status</th>
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
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>